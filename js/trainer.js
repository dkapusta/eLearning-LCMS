window.trainer = function() {
    'use strict';

    function KeyEvent(keyCode, timestamp) {
        this.keyCode = keyCode;
        this.timestamp = timestamp;
    }

    function KeyEventsStorage() {
        this.data = {
            keydown: [],
            keyup  : []
        }
    }

    KeyEventsStorage.prototype.addEvent = function(event) {
        var keyEvent = new KeyEvent(event.which, event.timeStamp);
        this.data[event.type].push(keyEvent);
    }

    KeyEventsStorage.prototype.getEvents = function() {
        return this.data;
    }

    KeyEventsStorage.prototype.clear = function(event) {
        this.data = {
            keydown: [],
            keyup  : []
        }
    }

    function Keystroke(keyCode, timeDown, timeUp) {
        this.keyCode  = keyCode;
        this.timeDown = timeDown;
        this.timeUp   = timeUp;
    }

    function Keystrokes(keyEvents, phrase) {
        this.keystrokes = [];

        var keyEvents = keyEvents;

        while (keyEvents.keydown.length !== 0) {
            var keydown          = keyEvents.keydown.shift();
            var keyup            = undefined;
            var indexOfDeletable = undefined;
            var keystroke        = undefined;

            keyup = keyEvents.keyup.find(function(keyup, index) {
                if (keyup.keyCode === keydown.keyCode) {
                    indexOfDeletable = index;

                    return true;
                }

                return false;
            });

            if (indexOfDeletable === undefined) {
                throw new Error('Phrase: ' + phrase + '. Unable to find the corresponding keyup event.');
            }

            keyEvents.keyup.splice(indexOfDeletable, 1);
            this.keystrokes.push(new Keystroke(keydown.keyCode, keydown.timestamp, keyup.timestamp));
        }

        return this.keystrokes;
    }

    /* --------------------------------- */

    function App(fields, options) {
        this.keyEventsStorage  = undefined; // Поле для хранения отдельных событий нажатий клавиш
        this.keystrokesStorage = undefined; // Поле для хранения нажатий клавиш

        this.options = options;

        this.fields     = {}; // Отслеживаемые поля
        this.attempts   = {}; // Успешно введенные контрольные фразы, ассоциированные с
        this.sendButton = undefined;

        for (var field in fields) {
            if (!fields.hasOwnProperty(field)) {
                continue;
            }

            var id = fields[field].attributes.id.value;
            this.fields[id] = {
                obj: fields[field],
                currentAttemptNumber: 0,
                totalNumberOfAttempts: 15,
                phrase: ''
            }

            this.attempts[id] = {};
        }

        /* Коды, разрещенных к нажатию клавиш. */
        this.ALLOWED_KEYS_CODES   = [16, 32, 48, 49, 50, 51, 52, 53, 54, 55,
                                     56, 57, 58, 59, 60, 61, 62, 63, 64, 65,
                                     66, 67, 68, 69, 70, 71, 72, 73, 74, 75,
                                     76, 77, 78, 79, 80, 81, 82, 83, 84, 85,
                                     86, 87, 88, 89, 90, 96, 97, 98, 99,
                                     100, 101, 102, 103, 104, 105, 173, 186,
                                     188, 189, 190, 191, 219, 221];
        /*
         * Объект, содержащий коды клавиш и соответствующие им
         * инструкции управления приложением.
         */
        this.CONTROL_FLOW = { 13: 'next' };

        for (var i = 0, l = this.ALLOWED_KEYS_CODES.length; i < l; i++) {
            this.CONTROL_FLOW[this.ALLOWED_KEYS_CODES[i]] = 'allowed';
        }

        this.init();
    }

    /*
     * Инициализация функции логирования. Для успешной
     * инициализации требуется при создании нового объекта
     * типа App передать ему новый объект типа KeyEventStorage
     * и DOM-объект отслеживаемое поля ввода.
     */
    App.prototype.init = function () {
        var self = this;

        for (var field in this.fields) {
            if (!this.fields.hasOwnProperty[field]) continue;
            this.fields[field].obj.value = ''
        }

        this.keyEventsStorage = new KeyEventsStorage();

        /*
         * Callback, вызываемый при нажатии клавиши в отслеживаемых
         * элементах типа input.
         */
        var addEventCallback = function(event) {
            /*
             * Так как целью являются диграфы, набранные в потоке набора
             * последовательной фразы, состоящей из букв алфавита, цифр
             * и одной модифицирующей клавиши, перед регистрированием нажатия
             * клавиши требуется проверить её код. В противном случае начать
             * новый массив потока нажатий.
             */
            if ( event.which === 9 || event.type == 'blur' ) {
                self.reset(event);
                return;
            }

            switch (self.CONTROL_FLOW[event.which]) {
                case 'allowed':
                    self.keyEventsStorage.addEvent(event);
                    break;
                case 'next':
                    if (event.type === 'keydown') {
                        self.next(event);
                    }
                    break;
                default:
                    self.reset(event, true, 'Используйте только буквы латинского алфавита, цифры и клавишу SHIFT');
                    break;
            }
        }

        for (var field in this.fields) {
            this.fields[field].obj.addEventListener('keydown', addEventCallback);
            this.fields[field].obj.addEventListener('keyup', addEventCallback);
            this.fields[field].obj.addEventListener('blur', addEventCallback);
        }

        this.render();
    }

    /*
     * Сброс значения в переданной форме и удаление предыдущей попытки в связи
     * с непринятым кодом клавиши. В параметр error передается true или false
     * соответственно для вызова предупреждения и для тихого сброса.
     */
    App.prototype.reset = function(event, error, text) {
        error = typeof error !== 'undefined' ? error : false;
        text  = typeof text  !== 'undefined' ? text  : undefined;

        if (error === true) {
            alert(text);
        }

        event.target.value = '';
        this.keyEventsStorage.clear(event);
    }

    App.prototype.render = function() {
        var self = this;

        for(var field in this.fields) {
            if (!this.fields.hasOwnProperty(field)) {
                continue;
            }

            var id = this.fields[field].obj.attributes.id.value;
            var phraseContainer = document.querySelector('#' + id + '-phrase');
            var phraseProgress  = document.querySelector('#' + id + '-progress');

            this.fields[field].phraseContainer = phraseContainer;
            this.fields[field].phraseProgress  = phraseProgress;
            this.fields[field].obj.removeAttribute('disabled');

            this.getFieldValue(id);
        }

        var sendButton = document.querySelector('#send_data');

        sendButton.addEventListener('click', function () {
            self.send();
        });

        this.sendButton = sendButton;
    }

    App.prototype.increaseProgress = function(id, score) {
        this.fields[id].phraseProgress.style.width = (score * 100) + "%";
    }

    App.prototype.next = function(event) {
        event.preventDefault();

        var id          = event.target.attributes.id.value;
        var eventPhrase = event.target.value

        if (this.fields[id].phrase !== eventPhrase) {
            this.reset(event, true, 'Предложенная и введённая фразы не совпадают.');
            return;
        }

        this.fields[id].currentAttemptNumber += 1;
        var score = this.fields[id].currentAttemptNumber / this.fields[id].totalNumberOfAttempts;

        this.increaseProgress(id, score);

        var attempt = clone(this.keyEventsStorage.getEvents());

        var phrase = this.attempts[id][eventPhrase];
        if (typeof phrase === 'undefined') {
            this.attempts[id][eventPhrase] = [];
        }

        this.attempts[id][eventPhrase].push( new Keystrokes(attempt, eventPhrase) );

        if ( score === 1.0 ) {
            this.fields[id].obj.setAttribute('disabled', 'disabled');
        }

        if (id === 'captcha') {
            this.getFieldValue(id);
        }

        try {
            this.checkCompletenes();
            this.reset(event);
        } catch (e) {
            this.reset(event, true, 'Что-то пошло не так, попробуйте еще раз.');
        }

    }

    App.prototype.getAttempts = function() {
        return this.attempts;
    }

    App.prototype.checkCompletenes = function() {
        var completeness = true;

        for (var field in this.fields) {
            completeness = completeness && ( this.fields[field].currentAttemptNumber >= this.fields[field].totalNumberOfAttempts );
        }

        if (completeness) {
            this.sendButton.removeAttribute('disabled');
            this.timestamp = Date.now;
        }
    }

    App.prototype.updateField = function(id, value) {
        var node  = this.fields[id].phraseContainer;

        while (node.lastChild) {
            node.removeChild(node.lastChild);
        }

        node.appendChild(document.createTextNode(value))
        this.fields[id].phrase = value;
    }

    App.prototype.getFieldValue = function(id) {
        var self  = this;
        var value = undefined;

        try {
            $.ajax({
                method: 'POST',
                url: '/biometrics?act=ajax&type=get_phrase',
                data: {
                    type: 'get_phrase',
                    field: id,
                    userId: self.options['userId'],
                    courseId: self.options['courseId']
                },
                success: function(data, textStatus) {
                    self.updateField(id, data);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    throw new Error('Unexpected error: ' + textStatus);
                    console.log('Unexpected error: ', textStatus, errorThrown);
                }
            });
        } catch(error) {
            alert('Unexpected error: ' + error);
            throw new Error('Unexpected error: ' + error);
            console.log(error);
        }
    }

    App.prototype.getData = function() {
        return JSON.stringify(this.getAttempts());
    }

    App.prototype.send = function() {
        event.preventDefault();

        var self = this;

        try {
            $.ajax({
                method: 'POST',
                url: '/biometrics?act=ajax',
                data: {
                    type: 'save_data',
                    timestamp: self.timestamp,
                    data: self.getData(),
                    userId: self.options['userId'],
                    courseId: self.options['courseId'],
                },
                success: function(data, textStatus) {
                    console.log(data);

                    $.ajax({
                        method: 'POST',
                        url: '/course/' + self.options['courseId'] +'?act=ajax&type=apply',
                        success: function(data) {
                            window.location = "/course/" + self.options['courseId'];
                        },
                        error: function(data) {
                            console.log('Unexpected error');
                        }
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Что-то пошло нет так. Перезагрузите страницу и попытайтесь снова.');
                    console.log('Unexpected error on ajax:\n', textStatus, errorThrown);
                }
            });
        } catch(error) {
            console.log(error);
        }
    }

    var fields = [];
    var options = {};

    options['courseId'] = document.querySelector('#courseId').value;
    options['userId']   = document.querySelector('#userId').value;

    fields.push(document.querySelector('#secretCode'));
    fields.push(document.querySelector('#captcha'));

    var app = new App(fields, options);
}
