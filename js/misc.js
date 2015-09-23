if ( !Array.prototype.last ) {
    Array.prototype.last = function() {
        return this[this.length - 1];
    };
};

if ( !Array.prototype.first ) {
    Array.prototype.first = function() {
        return this[0];
    };
};

if ( !Array.prototype.find ) {
    var find = function(predicate) {
        var list = Object(this);
        var length = list.length < 0 ? 0 : list.length >>> 0; // ES.ToUint32;
        
        if ( length === 0 ) return undefined;
        if ( typeof predicate !== 'function' || Object.prototype.toString.call(predicate) !== '[object Function]') {
            throw new TypeError('Array#find: predicate must be a function');
        }
    
        var thisArg = arguments[1];

        for ( var i = 0, value; i < length; i++ ) {
            value = list[i];
            
            if ( predicate.call(thisArg, value, i, list) ) return value;
        }

        return undefined;
    };

    if ( Object.defineProperty ) {
        try {
            Object.defineProperty(Array.prototype, 'find', {
                value: find, configurable: true, enumerable: false, writable: true
            });
        } catch(e) {}
    }

    Array.prototype.find = find;
}

if (!Date.now) {
    Date.now = function() {
        return new Date().getTime();
    }
}

function clone(obj) {
    if (null == obj || "object" != typeof obj) return obj;
    var copy = obj.constructor();
    for (var attr in obj) {
        if (obj.hasOwnProperty(attr)) copy[attr] = obj[attr];
    }
    return copy;
}