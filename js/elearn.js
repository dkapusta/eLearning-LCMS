$("#checkDBInfo").on("click", function() {
	var dbHost = document.getElementById("dbHost").value;
	var dbUser = document.getElementById("dbUser").value;
	var dbPass = document.getElementById("dbPass").value;
	var dbName = document.getElementById("dbName").value;

	$.post("/?act=ajax", {dbHost: dbHost, dbUser: dbUser, dbPass: dbPass, dbName: dbName}, function(data) {
		if(data == "success")
		{
			$("#checkDBInfo").css("display", "none");

			$("#dbHost").attr("disabled", "disabled");
			$("#dbUser").attr("disabled", "disabled");
			$("#dbPass").attr("disabled", "disabled");
			$("#dbName").attr("disabled", "disabled");

			$("#installLMS").removeAttr("disabled");
		}
		else 
		{
			$("#checkDBInfo").addClass("btn-danger").html("Проверьте данные для доступа к БД и попробуйте снова.");
		}
	});
});

$("#installLMS").on("click", function() {
	var adminLogin = document.getElementById("adminLogin").value;
	var adminEmail = document.getElementById("adminLogin").value;
	var adminPass = document.getElementById("adminLogin").value;
	var siteName = document.getElementById("siteName").value;
	var adminControl = document.getElementById("adminControl").value;

	if(!adminLogin || !adminEmail || !adminPass || !siteName || !adminControl || adminControl.length<12)
	{
		$("#installLMS").html("Заполните все поля и попробуйте снова.").addClass("btn-danger");
	}
	else
	{
		$("#dbHost").removeAttr("disabled");
		$("#dbUser").removeAttr("disabled");
		$("#dbPass").removeAttr("disabled");
		$("#dbName").removeAttr("disabled");

		$("#installForm").submit();
	}
});

$("#doAuth").on("click", function() {
	var authLogin = document.getElementById("authLogin").value;
	var authPass = document.getElementById("authPass").value;

	if(!authLogin || !authPass)
	{
		$("#doAuth").removeClass("btn-primary").addClass("btn-danger").html("Проверьте заполнение полей и попробуйте снова.");
	}
	else
	{
		$.post("/?act=ajax&mode=auth", {authLogin: authLogin, authPass: authPass}, function(data) {
			if(data == "success")
			{
				window.location = "/";
			}
			else
			{
				$("#doAuth").removeClass("btn-primary").addClass("btn-danger").html("Проверьте правильность данных и попробуйте снова.");
			}
		});
	}
});

$("#doReg").on("click", function() {
	var regLogin = document.getElementById("regLogin").value;
	var regEmail = document.getElementById("regEmail").value;
	var regPass = document.getElementById("regPass").value;
	var regControl = document.getElementById("regControl").value;

	if(!regLogin || !regEmail || !regPass || !regControl || regControl.length<12)
	{
		$("#doReg").removeClass("btn-primary").addClass("btn-danger").html("Проверьте заполнение полей и попробуйте снова.");
	}
	else
	{
		$.post("/?act=ajax&mode=reg", {regLogin: regLogin, regEmail: regEmail, regPass: regPass, regControl: regControl}, function(data) {
			if(data == "success")
			{
				window.location = "/";
			}
			else
			{
				$("#doReg").removeClass("btn-primary").addClass("btn-danger").html("Такой логин занят. Попробуйте снова.");
			}
		});
	}
});

$("#logoutBtn").on("click", function() {
	$.post("/profile?act=ajax", function(data) {
		if(data=="success")
		{
			window.location = "/";
		}
	});
});

$("#saveUserData").on("click", function() {
	var userFirstName = document.getElementById("userFirstName").value;
	var userLastName = document.getElementById("userLastName").value;
	var userPass = document.getElementById("userPass").value;

	if(1)
	{
		var scope = {
			first_name: userFirstName,
			last_name: userLastName,
			pass: userPass
		};
		$.post("/edit?act=ajax&type=save_user", scope, function(data) {
			if(data=="success")
			{
				window.location = "/edit";
			}
		});
	}
});

$("#settingsTitle").on("change", function() {
	var settingsTitle = document.getElementById("settingsTitle").value;

	if(settingsTitle)
	{
		$.post("/settings?act=ajax&var=site_name", {value: settingsTitle}, function(data) {
			if(data=="success")
			{
				$("#settingsTitleHelper").html('<div class="label label-success">Информация сохранена</div>');
				setTimeout(removeSettingsTitleHelper, 1500);
			}
		});
	}
});

function removeSettingsTitleHelper() {
	$("#settingsTitleHelper").html('');
}

$("#settingsReg").on("change", function() {
	var settingsReg = document.getElementById("settingsReg").value;

	if(settingsReg)
	{
		$.post("/settings?act=ajax&var=free_register", {value: settingsReg}, function(data) {
			if(data=="success")
			{
				$("#settingsRegHelper").html('<div class="label label-success">Информация сохранена</div>');
				setTimeout(removeSettingsRegHelper, 1500);
			}
		});
	}
});

function removeSettingsRegHelper() {
	$("#settingsRegHelper").html('');
}

$("#settingsRole").on("change", function() {
	var settingsRole = document.getElementById("settingsRole").value;

	if(settingsRole)
	{
		$.post("/settings?act=ajax&var=reg_role", {value: settingsRole}, function(data) {
			if(data=="success")
			{
				$("#settingsRoleHelper").html('<div class="label label-success">Информация сохранена</div>');
				setTimeout(removeSettingsRoleHelper, 1500);
			}
		});
	}
});

function removeSettingsRoleHelper() {
	$("#settingsRoleHelper").html('');
}

$("#settingsEdit").on("change", function() {
	var settingsEdit = document.getElementById("settingsEdit").value;

	if(settingsEdit)
	{
		$.post("/settings?act=ajax&var=student_edit_rights", {value: settingsEdit}, function(data) {
			if(data=="success")
			{
				$("#settingsEditHelper").html('<div class="label label-success">Информация сохранена</div>');
				setTimeout(removeSettingsEditHelper, 1500);
			}
		});
	}
});

function removeSettingsEditHelper() {
	$("#settingsEditHelper").html('');
}

$("#newCategoryBtn").on("click", function() {
	var categoryTitle = document.getElementById("categoryTitle").value;
	var categoryDescr = document.getElementById("categoryDescr").value;

	if(categoryTitle && categoryDescr)
	{
		$.post("/categories?act=ajax&type=new_category", {title: categoryTitle, descr: categoryDescr}, function(data) {
			if(data=="success")
			{
				window.location = "/categories";
			}
		});
	}
});

$(".catEditBtn").on("click", function() {
	var cat_id = $(this).attr("category-id");

	$.post("/categories?act=ajax&type=get_category", {id: cat_id}, function(data) {
		var json = $.parseJSON(data);

		document.getElementById("editCat_id").value = cat_id;
		document.getElementById("editCat_title").value = json.title;
		document.getElementById("editCat_descr").value = json.descr;
	});

	$("#editCatModal").modal();
});

$("#editCat_saveBtn").on("click", function() {
	var id = document.getElementById("editCat_id").value;
	var title = document.getElementById("editCat_title").value;
	var descr = document.getElementById("editCat_descr").value;

	if(id && title && descr)
	{
		$.post("/categories?act=ajax&type=edit_category", {id: id, title: title, descr: descr}, function(data) {
			if(data=="success")
			{
				window.location = "/categories";
			}
		});
	}
});

$(".catDeleteBtn").on("click", function() {
	var cat_id = $(this).attr("category-id");

	$.post("/categories?act=ajax&type=get_category", {id: cat_id}, function(data) {
		var json = $.parseJSON(data);

		document.getElementById("delCat_id").value = cat_id;
		$("#delCat_title").html(json.title);
	});

	$("#deleteCatModal").modal();
});

$("#delCat_btn").on("click", function() {
	var id = document.getElementById("delCat_id").value;

	if(id)
	{
		$.post("/categories?act=ajax&type=delete_category", {id: id}, function(data) {
			if(data=="success")
			{
				window.location = "/categories";
			}
		});
	}
});

$("#applyFilterBtn").on("click", function() {
	var cat = document.getElementById("filterCategory").value;

	if(cat && cat!="none")
	{
		window.location = "/courses?categoryId="+cat;
	}
	else
	{
		window.location = "/courses";
	}
});

$("#newCourseBtn").on("click", function() {
	var courseTitle = document.getElementById("courseTitle").value;
	var courseDescr = document.getElementById("courseDescr").value;
	var courseCategory = document.getElementById("courseCategory").value;
	var courseSecure = document.getElementById("courseSecure").value;
	var courseLimit = document.getElementById("courseLimit").value;
	var coursePrivacy = document.getElementById("coursePrivacy").value;

	if(courseTitle && courseDescr && courseCategory && courseSecure)
	{
		$.post("/my_courses?act=ajax&type=new_course", {title: courseTitle, descr: courseDescr, category: courseCategory, secure: courseSecure, limit: courseLimit, privacy: coursePrivacy}, function(data) {
			
			if(data=="success")
			{
				window.location = "/my_courses";
			}
		});
	}
});

$("#newUserBtn").on("click", function() {
	var userLogin = document.getElementById("userLogin").value;
	var userEmail = document.getElementById("userEmail").value;
	var userPass = document.getElementById("userPass").value;
	var userFirstName = document.getElementById("userFirstName").value;
	var userLastName = document.getElementById("userLastName").value;
	var userRole = document.getElementById("userRole").value;
	var userControl = document.getElementById("userControl").value;

	if(userLogin && userEmail && userPass && userControl.length>11)
	{
		$.post("/users?act=ajax&type=new_user", {login: userLogin, email: userEmail, pass: userPass, first_name: userFirstName, last_name: userLastName, role: userRole, control: userControl}, function(data) {
			if(data=="success")
			{
				window.location = "/users";
			}
		});
	}
});

$(".userDeleteBtn").on("click", function() {
	var user_id = $(this).attr("user-id");

	$.post("/users?act=ajax&type=delete_user", {id: user_id}, function(data) {
		if(data=="success")
		{
			window.location = "/users";
		}
	});
});

$(".userEditBtn").on("click", function() {
	var user_id = $(this).attr("user-id");

	$.post("/users?act=ajax&type=edit_user", {id: user_id}, function(data) {
		if(data)
		{
			var json = $.parseJSON(data);

			$("#saveUserBtn").attr("user-id", json.id);
			document.getElementById("userEdEmail").value = json.email;
			document.getElementById("userEdFirstName").value = json.first_name;
			document.getElementById("userEdLastName").value = json.last_name;
			document.getElementById("userEdRole").value = json.role;

			$("#userEditModal").modal('toggle');
		}
	});
});

$("#saveUserBtn").on("click", function() {
	var id = $(this).attr("user-id");
	var email = document.getElementById("userEdEmail").value;
	var first_name = document.getElementById("userEdFirstName").value;
	var last_name = document.getElementById("userEdLastName").value;
	var role = document.getElementById("userEdRole").value;
	var pass = document.getElementById("userEdPass").value;

	if(email) 
	{
		$.post("/users?act=ajax&type=update_user", {id: id, email: email, first_name: first_name, last_name: last_name, role: role, pass: pass}, function(data) {
			if(data=="success")
			{
				window.location = "/users";
			}
		});
	}
});

$(".courseEditBtn").on("click", function() {
	var course_id = $(this).attr("course-id");

	window.location = "/edit_course?id="+course_id;
});

$("#saveCourseBtn").on("click", function() {
	var courseTitle = document.getElementById("courseTitle").value;
	var courseDescr = document.getElementById("courseDescr").value;
	var courseCategory = document.getElementById("courseCategory").value;
	var coursePrivacy = document.getElementById("coursePrivacy").value;
	var course_id = $(this).attr("course-id");

	$.post("/edit_course?id="+course_id+"&act=ajax&type=save_course", {title: courseTitle, descr: courseDescr, category: courseCategory, privacy: coursePrivacy}, function(data) {
		if(data=="success")
		{
			window.location = "/edit_course?id="+course_id;
		}
	});
});

$("#applyForCourseBtn").on("click", function() {
	var secure = $(this).attr("secure-data");
	var user_id = $(this).attr("user-id");
	var course_id = $(this).attr("course-id");

	if(secure == "1")
	{
		$.post("/biometrics?act=ajax", {type: 'user-has-dmod', userId: user_id}, function(data) {
			if(data==1)
			{
				$.post("/course/"+course_id+"?act=ajax&type=apply", {}, function(data) {
					if(data=="success")
					{
						window.location = "/course/"+course_id;
					}
				});
			}
			else
			{
				$.post("/biometrics?act=ajax", {type: 'view', mode: 'train', userId: user_id, courseId: course_id}, function(data) {
					$("#applyForCourseContent").html(data);
					$("#applyForCourseModal").modal('toggle');
					window.trainer();
				});
			}
		});
	}
	else
	{
		$.post("/course/"+course_id+"?act=ajax&type=apply", {}, function(data) {
			if(data=="success")
			{
				window.location = "/course/"+course_id;
			}
		});
	}
});

$("#addLessonBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lessonTitle = document.getElementById("lessonTitle").value;
	var lessonDescr = document.getElementById("lessonDescr").value;

	if(lessonTitle && lessonDescr)
	{
		$.post("/edit_course?act=ajax&type=add_lesson", {id: course_id, title: lessonTitle, descr: lessonDescr}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$(".editLessonBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$("#saveLessonBtn").attr("course-id", course_id);
	$("#saveLessonBtn").attr("lesson-id", lesson_id);

	$.post("/edit_course?act=ajax&type=get_lesson_info", {course_id: course_id, lesson_id: lesson_id}, function(data) {
		if(data)
		{
			var json = $.parseJSON(data);

			document.getElementById("lessonEdTitle").value = json.title;
			document.getElementById("lessonEdDescr").value = json.descr;

			$("#editLessonModal").modal('toggle');
		}
	});
});

$("#saveLessonBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");
	var title = document.getElementById("lessonEdTitle").value;
	var descr = document.getElementById("lessonEdDescr").value; 

	if(title && descr)
	{
		$.post("/edit_course?act=ajax&type=update_lesson", {course_id: course_id, lesson_id: lesson_id, title: title, descr: descr}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$(".deleteLessonBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$.post("/edit_course?act=ajax&type=delete_lesson", {course_id: course_id, lesson_id: lesson_id}, function(data) {
		if(data=="success")
		{
			window.location = "/edit_course?id="+course_id;
		}
	});
});

$(".addMaterialTextModalBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$("#addMaterialTextBtn").attr("course-id", course_id);
	$("#addMaterialTextBtn").attr("lesson-id", lesson_id);

	tinymce.init({
      selector: 'textarea.tinymce',
      language: 'ru',
      relative_urls: false,
      plugins: ["advlist autolink charmap code contextmenu fullscreen image link paste preview searchreplace table textcolor visualblocks textcolor"],
      toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor"
    }); 

	$("#addLessonMaterialTextModal").modal('toggle');
});

$(".addMaterialDocumentModalBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$("#addMaterialDocumentBtn").attr("course-id", course_id);
	$("#addMaterialDocumentBtn").attr("lesson-id", lesson_id);

	$("#addLessonMaterialDocumentModal").modal('toggle');
});

$(".addMaterialVideoModalBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$("#addMaterialVideoBtn").attr("course-id", course_id);
	$("#addMaterialVideoBtn").attr("lesson-id", lesson_id);

	$("#addLessonMaterialVideoModal").modal('toggle');
});

$("#addMaterialTextBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	var title = document.getElementById("textMaterialTitle").value;
	var descr = document.getElementById("textMaterialDescr").value;
	var content = tinyMCE.activeEditor.getContent();

	if(title && descr && content)
	{
		$.post("/edit_course?act=ajax&type=add_text_material", {course_id: course_id, lesson_id: lesson_id, title: title, descr: descr, content: content}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$("#addMaterialDocumentBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	var title = document.getElementById("documentMaterialTitle").value;
	var descr = document.getElementById("documentMaterialDescr").value;
	var content = document.getElementById("documentMaterialContent").value;

	if(title && descr && content)
	{
		$.post("/edit_course?act=ajax&type=add_embed_material", {type: 'document', course_id: course_id, lesson_id: lesson_id, title: title, descr: descr, content: content}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$("#addMaterialVideoBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	var title = document.getElementById("videoMaterialTitle").value;
	var descr = document.getElementById("videoMaterialDescr").value;
	var content = document.getElementById("videoMaterialContent").value;

	if(title && descr && content)
	{
		$.post("/edit_course?act=ajax&type=add_embed_material", {type: 'video', course_id: course_id, lesson_id: lesson_id, title: title, descr: descr, content: content}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$(".viewMaterialBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");
	var material_id = $(this).attr("material-id");

	$.post("/edit_course?act=ajax&type=get_material_info", {course_id: course_id, lesson_id: lesson_id, material_id: material_id}, function(data) {
		var json = $.parseJSON(data);

		$("#viewLessonMaterialTitle").html(json.title);
		$("#viewLessonMaterialContent").html(json.content);

		$("#viewLessonMaterialModal").modal('toggle');
	});
});

$("#viewMaterialBtnClose").on("click", function() {
	$("#viewLessonMaterialTitle").html("");
	$("#viewLessonMaterialContent").html("");
	$("#viewLessonMaterialModal").modal('toggle');
});

$(".editMaterialBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");
	var material_id = $(this).attr("material-id");
	var material_type = $(this).attr("material-type");

	$.post("/edit_course?act=ajax&type=get_material_info", {course_id: course_id, lesson_id: lesson_id, material_id: material_id}, function(data) {
		var json = $.parseJSON(data);

		if(material_type=="text")
		{
			document.getElementById("textMaterialEdTitle").value=json.title;
			document.getElementById("textMaterialEdDescr").value=json.descr;
			document.getElementById("textMaterialEdContent").value=json.content;

			$("#saveMaterialTextBtn").attr("course-id", course_id);
			$("#saveMaterialTextBtn").attr("material-id", material_id);

			tinymce.init({
      		  selector: 'textarea.tinymce',
      		  language: 'ru',
      		  relative_urls: false,
      		  plugins: ["advlist autolink charmap code contextmenu fullscreen image link paste preview searchreplace table textcolor visualblocks textcolor"],
      		  toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor"
    		}); 

			$("#editLessonMaterialTextModal").modal('toggle');
		}
		else
		{
			document.getElementById("embedMaterialTitle").value=json.title;
			document.getElementById("embedMaterialDescr").value=json.descr;
			document.getElementById("embedMaterialContent").value=json.content;

			$("#saveMaterialEmbedBtn").attr("course-id", course_id);
			$("#saveMaterialEmbedBtn").attr("material-id", material_id);

			$("#editLessonMaterialEmbedModal").modal('toggle');
		}
	});
});

$("#saveMaterialEmbedBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var material_id = $(this).attr("material-id");

	var title = document.getElementById("embedMaterialTitle").value;
	var descr = document.getElementById("embedMaterialDescr").value;
	var content = document.getElementById("embedMaterialContent").value;

	if(title && descr && content)
	{
		$.post("/edit_course?act=ajax&type=save_embed", {course_id: course_id, material_id: material_id, title: title, descr: descr, content: content}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$("#saveMaterialTextBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var material_id = $(this).attr("material-id");

	var title = document.getElementById("textMaterialEdTitle").value;
	var descr = document.getElementById("textMaterialEdDescr").value;
	var content = tinyMCE.activeEditor.getContent();

	if(title && descr && content)
	{
		$.post("/edit_course?act=ajax&type=save_embed", {course_id: course_id, material_id: material_id, title: title, descr: descr, content: content}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_course?id="+course_id;
			}
		});
	}
});

$(".deleteMaterialBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var material_id = $(this).attr("material-id");

	$.post("/edit_course?act=ajax&type=delete_material", {course_id: course_id, material_id: material_id}, function(data) {
		if(data=="success")
		{
			window.location = "/edit_course?id="+course_id;
		}
	});
});

$(".addTestModalBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	$("#addTestBtn").attr("course-id", course_id);
	$("#addTestBtn").attr("lesson-id", lesson_id);

	$("#addTestModal").modal('toggle');
});

$("#addTestBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var lesson_id = $(this).attr("lesson-id");

	var title = document.getElementById("testTitle").value;
	var descr = document.getElementById("testDescr").value;

	if(title && descr)
	{
		$.post("/edit_course?act=ajax&type=add_test", {course_id: course_id, lesson_id: lesson_id, title: title, descr: descr}, function(data) {
			var json = $.parseJSON(data);

			window.location = "/edit_test?id="+json.id+"&course_id="+course_id;
		});
	}
});

$(".deleteTestBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");

	$.post("/edit_course?act=ajax&type=delete_test", {course_id: course_id, test_id: test_id}, function(data) {
		if(data=="success")
		{
			window.location = "/edit_course?id="+course_id;
		}
	});
});

$("#saveTestBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");

	var title = document.getElementById("testTitle").value;
	var descr = document.getElementById("testDescr").value;

	if(title || descr)
	{
		$.post("/edit_test?act=ajax&type=save_test", {course_id: course_id, test_id: test_id, title: title, descr: descr}, function(data) {
			if(data=="success")
			{
				window.location = "/edit_test?id="+test_id+"&course_id="+course_id;
			}
		});
	}
});

$("#addQuestionBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");

	var text = document.getElementById("questionText").value;
	var type = document.getElementById("questionType").value;
	var var1 = document.getElementById("questionVar1").value;
	var var2 = document.getElementById("questionVar2").value;
	var var3 = document.getElementById("questionVar3").value;
	var var4 = document.getElementById("questionVar4").value;
	var answer = document.getElementById("questionAnswer").value;

	var scope = {
		course_id: course_id,
		test_id: test_id,
		text: text,
		type: type,
		var1: var1,
		var2: var2,
		var3: var3,
		var4: var4,
		answer: answer
	};

	if(text && answer)
	{
		$.post("/edit_test?act=ajax&type=add_question", scope, function(data) {
			if(data=="success")
			{
				window.location = "/edit_test?id="+test_id+"&course_id="+course_id;
			}
		});
	}
});

$(".deleteQuestionBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");
	var question_id = $(this).attr("question-id");

	$.post("/edit_test?act=ajax&type=delete_question", {course_id: course_id, test_id: test_id, question_id: question_id}, function(data) {
		if(data=="success")
		{
			window.location = "/edit_test?id="+test_id+"&course_id="+course_id;
		}
	});
});

$(".editQuestionBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");
	var question_id = $(this).attr("question-id");

	$.post("/edit_test?act=ajax&type=get_question", {course_id: course_id, test_id: test_id, question_id: question_id}, function(data) {
		if(data)
		{
			var json = $.parseJSON(data);

			document.getElementById("questionEdText").value = json.question;
			document.getElementById("questionEdVar1").value = json.var1;
			document.getElementById("questionEdVar2").value = json.var2;
			document.getElementById("questionEdVar3").value = json.var3;
			document.getElementById("questionEdVar4").value = json.var4;
			document.getElementById("questionEdAnswer").value = json.answer;

			if(json.type == "select")
			{
				$("#blockVar1").css("display", "block");
				$("#blockVar2").css("display", "block");
				$("#blockVar3").css("display", "block");
				$("#blockVar4").css("display", "block");
			}
			else
			{
				$("#blockVar1").css("display", "none");
				$("#blockVar2").css("display", "none");
				$("#blockVar3").css("display", "none");
				$("#blockVar4").css("display", "none");
			}

			$("#saveQuestionBtn").attr("course-id", course_id);
			$("#saveQuestionBtn").attr("test-id", test_id);
			$("#saveQuestionBtn").attr("question-id", question_id);

			$("#editQuestionModal").modal('toggle');
		}
	});
});

$("#saveQuestionBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");
	var question_id = $(this).attr("question-id");

	var text = document.getElementById("questionEdText").value;
	var var1 = document.getElementById("questionEdVar1").value;
	var var2 = document.getElementById("questionEdVar2").value;
	var var3 = document.getElementById("questionEdVar3").value;
	var var4 = document.getElementById("questionEdVar4").value;
	var answer = document.getElementById("questionEdAnswer").value;

	if(text && answer)
	{
		var scope = {
			course_id: course_id,
			test_id: test_id,
			question_id: question_id,
			text: text,
			var1: var1,
			var2: var2,
			var3: var3,
			var4: var4,
			answer: answer
		};

		$.post("/edit_test?act=ajax&type=save_question", scope, function(data) {
			if(data=="success")
			{
				window.location = "/edit_test?id="+test_id+"&course_id="+course_id;
			}
		});
	}
});

$(".viewMaterialBtn2").on("click", function() {
	var course_id = $(this).attr("course-id");
	var material_id = $(this).attr("material-id");

	$.post("/edit_course?act=ajax&type=get_material_info", {course_id: course_id, material_id: material_id}, function(data) {
		var json = $.parseJSON(data);

		$("#viewMaterialTitle").html(json.title);
		$("#viewMaterialContent").html(json.content);

		$("#viewMaterialModal").modal('toggle');
	});
});

$("#viewMaterialBtn2Close").on("click", function() {
	$("#viewMaterialTitle").html("");
	$("#viewMaterialContent").html("");
	$("#viewMaterialModal").modal('toggle');
});

$(".openTestBtn").on("click", function() {
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");
	var secure = $(this).attr("secure");
	var user_id = $(this).attr("user-id");

	if(secure==1)
	{
		$.post("/biometrics?act=ajax", {type: 'view', mode: 'authenticate', testId: test_id, userId: user_id, courseId: course_id}, function(data) {
			$("#applyForTestContent").html(data);
			$("#applyForTestModal").modal('toggle');
			window.authenticator();
		});
	}
	else
	{
		elearn_start_test(course_id, test_id, 100);
	}
});

var elearn_test = {
	current_question: 0,
	secure: "",
	secure_result: 0,
	course_id: 0,
	test_id: 0,
	questions: {},
	answers: {}
};

function elearn_start_test(course_id, test_id, secure_result)
{
	elearn_test.secure_result = secure_result;
	elearn_test.course_id = course_id;
	elearn_test.test_id = test_id;

	elearn_test.answers = {};
	elearn_test.questions = {};

	$.post("/course?act=ajax&type=get_course", {course_id: course_id}, function(data) {
		var course = $.parseJSON(data);
		elearn_test.secure = course.secure;

		$.post("/course?act=ajax&type=get_test", {course_id: course_id, test_id: test_id}, function(data) {
			var test = $.parseJSON(data);
			$("#passTestLabel").html(test.title);

			$.post("/course?act=ajax&type=load_questions", {course_id: course_id, test_id: test_id}, function(data) {
				var questions = $.parseJSON(data);
				elearn_test.questions = questions;

				document.getElementById("testNavigation").innerHTML = "";
				for(i=0; i<questions.length; i++)
				{
					var temp = '<button id="test_q'+i+'" class="btn btn-default btn-sm" onclick="elearn_load_question('+i+');">'+(i+1)+'</button>&nbsp;';
					document.getElementById("testNavigation").innerHTML += temp;
				}

				$("#passTestModal").modal('toggle');

				elearn_load_question(0);
			});
		});
	});
}

function elearn_load_question(id)
{
	$("#test_q"+elearn_test.current_question).removeAttr("disabled");
	$("#test_q"+id).attr("disabled", "disabled");
	elearn_test.current_question = id;

	$("#testTitle").html("Вопрос №"+(id+1));
	$("#testQuestion").html(elearn_test.questions[id]["question"]);

	if(elearn_test.questions[id]["type"] == "select")
	{
		$("#testVar1").html(elearn_test.questions[id]["var1"]);
		$("#testVar2").html(elearn_test.questions[id]["var2"]);
		$("#testVar3").html(elearn_test.questions[id]["var3"]);
		$("#testVar4").html(elearn_test.questions[id]["var4"]);
		$("#testVariants").css("display", "block");
		$("#testAnswerInput").css("display", "none");
	}
	else
	{
		$("#testVariants").css("display", "none");
		$("#testAnswerInput").css("display", "block");
	}

	document.getElementById("testAnswerEnter").value = "";
	$('input[name="testAnswer"]:checked').removeAttr('checked');
}

$("#saveAnswerBtn").on("click", function() {
	if(elearn_test.questions[elearn_test.current_question]["type"] == "select")
	{
		var ans = $('input[name="testAnswer"]:checked').val();
		elearn_test.answers[elearn_test.current_question] = ans;
	}
	else
	{
		elearn_test.answers[elearn_test.current_question] = document.getElementById("testAnswerEnter").value;
	}

	$("#test_q"+elearn_test.current_question).removeClass("btn-default").addClass("btn-success");
})

$("#checkTestBtn").on("click", function() {
	var scope = {
		secure: elearn_test.secure,
		secure_result: elearn_test.secure_result,
		course_id: elearn_test.course_id,
		test_id: elearn_test.test_id,
		questions: elearn_test.questions,
		answers: elearn_test.answers
	};
	$.post("/course?act=ajax&type=send_results", scope, function(data) {
		if(data)
		{
			var json = $.parseJSON(data);
			window.location = "/results?id="+json.id;
		}
	});
});

$("#captcha").ready(function() {
	var course_id = $("#captcha").attr("course-id");
	var user_id = $("#captcha").attr("user-id");

	if(!user_id) return false;

	$.post("/biometrics?act=ajax", {type: 'users-need-negatives', userId: user_id}, function(data) {
		if(data==1)
		{
			$.post("/biometrics?act=ajax", {type: 'view', mode: 'captcha', courseId: course_id, userId: user_id}, function(data) {
				$("#captchaContent").html(data);
				$("#captchaModal").modal('toggle');
				window.captcha();
			});
		}
	});
});

$(".deleteResultBtn").on("click", function() {
	var result_id = $(this).attr("result-id");

	$.post("/marks?act=ajax&type=delete_result", {id: result_id}, function(data) {
		if(data=="success")
		{
			window.location = "/marks";
		}
	});
});

$("#deleteMark").on("click", function() {
	var result_id = $(this).attr("result-id");
	var course_id = $(this).attr("course-id");

	$.post("/marks?act=ajax&type=delete_result", {id: result_id}, function(data) {
		if(data=="success")
		{
			window.location = "/course/"+course_id;
		}
	});
});

$(".approveResultBtn").on("click", function() {
	var result_id = $(this).attr("result-id");

	$.post("/marks?act=ajax&type=approve_result", {id: result_id}, function(data) {
		if(data=="success")
		{
			window.location = "/marks";
		}
	});
});

$(".secureTryAgain").on("click", function() {
	var result_id = $(this).attr("result-id");
	var course_id = $(this).attr("course-id");
	var test_id = $(this).attr("test-id");
	var user_id = $(this).attr("user-id");

	$.post("/biometrics?act=ajax", {type: 'get_score', courseId: course_id, userId: user_id, testId: test_id}, function(data) {
		if(Number(data) > -1)
		{
			$.post("/marks?act=ajax&type=update_result", {id: result_id, secure: data}, function(data) {
				if(data=="success")
				{
					window.location = "/marks";
				}
			});
		}
	});
});

$(".courseDeleteBtn").on("click", function() {
	var course_id = $(this).attr("course-id");

	$.post("/my_courses?act=ajax&type=delete_course", {id: course_id}, function(data) {
		if(data=="success")
		{
			window.location = "/my_courses";
		}
	});
});