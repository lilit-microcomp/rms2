/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 50);
/******/ })
/************************************************************************/
/******/ ({

/***/ 11:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {
    $("#datepicker-start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#datepicker-end").datepicker({ dateFormat: 'yy-mm-dd' });

    CKEDITOR.replace('description');
    CKEDITOR.replace('access_data');
});

/***/ }),

/***/ 12:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {

    $('select[name="user_id"]').on('change', function () {
        var userId = $(this).val();
        window.location.href = '/admin/support/' + userId + '/user';
    });
});

/***/ }),

/***/ 13:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {
    $("#datepicker-start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#datepicker-end").datepicker({ dateFormat: 'yy-mm-dd' });

    CKEDITOR.replace('description');

    if ($('select[name="client_id"]').val()) {
        var clientId = $('select[name="client_id"]').val();
        if (clientId) {
            $.ajax({
                url: '/projects/get/' + clientId,
                type: "GET",
                dataType: "json",
                beforeSend: function beforeSend() {
                    $('#loader').css("visibility", "visible");
                },
                success: function success(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function (key, value) {
                        $('select[name="project_id"]').append('<option value="' + key + '">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function complete() {
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }
    }

    $('select[name="client_id"]').on('change', function () {
        var clientId = $(this).val();
        if (clientId) {
            $.ajax({
                url: '/projects/get/' + clientId,
                type: "GET",
                dataType: "json",
                beforeSend: function beforeSend() {
                    $('#loader').css("visibility", "visible");
                },
                success: function success(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function (key, value) {
                        $('select[name="project_id"]').append('<option value="' + key + '">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function complete() {
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }
    });
});

/***/ }),

/***/ 14:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {

    $('select[name="user_id"]').on('change', function () {
        var userId = $(this).val();
        window.location.href = '/admin/tasks/' + userId + '/user';
        // alert(userId);
        // if(userId) {
        //     $.ajax({
        //         url: '/tasks/get/'+userId,
        //         type:"GET",
        //         dataType:"json",
        //         beforeSend: function(){
        //             $('#loader').css("visibility", "visible");
        //         },
        //         success:function(data) {
        //             $('select[name="project_id"]').empty();
        //             $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
        //             $.each(data, function(key, value){
        //                 $('select[name="project_id"]').append('<option value="'+ key +'">' + value + '</option>').removeAttr("disabled");;
        //             });
        //         },
        //         complete: function(){
        //             $('#loader').css("visibility", "hidden");
        //         }
        //     });
        // } else {
        //     $('select[name="project_id"]').empty();
        // }
    });
});

/***/ }),

/***/ 15:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {
    $("#datepicker-start").datepicker({ dateFormat: 'yy-mm-dd' });
    $("#datepicker-end").datepicker({ dateFormat: 'yy-mm-dd' });

    CKEDITOR.replace('description');

    if ($('select[name="client_id"]').val()) {
        var clientId = $('select[name="client_id"]').val();
        if (clientId) {
            $.ajax({
                url: '/projects/get/' + clientId,
                type: "GET",
                dataType: "json",
                beforeSend: function beforeSend() {
                    $('#loader').css("visibility", "visible");
                },
                success: function success(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function (key, value) {
                        $('select[name="project_id"]').append('<option value="' + key + '">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function complete() {
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }
    }

    $('select[name="client_id"]').on('change', function () {
        var clientId = $(this).val();
        if (clientId) {
            $.ajax({
                url: '/projects/get/' + clientId,
                type: "GET",
                dataType: "json",
                beforeSend: function beforeSend() {
                    $('#loader').css("visibility", "visible");
                },
                success: function success(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function (key, value) {
                        $('select[name="project_id"]').append('<option value="' + key + '">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function complete() {
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }
    });
});

/***/ }),

/***/ 16:
/***/ (function(module, exports, __webpack_require__) {

"use strict";


jQuery(document).ready(function ($) {
    $(".show-comment-box").click(function () {
        if ($(this).hasClass('active-for-submit')) {
            $('.clone-comment form').submit();
            console.log('submit');
        } else {
            $('.clone-comment').remove();
            $('.show-comment-box').removeClass('active-for-submit');
            $(this).addClass('active-for-submit');

            var divCommentBox = $("#add-new-comment").find(".comment-box").clone().addClass('clone-comment').removeClass("d-none");
            var commentId = $(this).parent('div').data('comment-id');

            $(divCommentBox).find("[name='comment_parent_id']").val(commentId);

            console.log(commentId);

            $(divCommentBox).insertBefore(this);
            $(".clone-comment .comment-collapse-box").ckeditor();
        }
    });

    // $(".comment-body .comment-meta").ckeditor();

});

/***/ }),

/***/ 50:
/***/ (function(module, exports, __webpack_require__) {

(function webpackMissingModule() { throw new Error("Cannot find module \"/Users/lilit/Projects/tms/resources/assets/js-test/admin\""); }());
__webpack_require__(11);
__webpack_require__(11);
__webpack_require__(12);
__webpack_require__(13);
__webpack_require__(13);
__webpack_require__(12);
__webpack_require__(14);
__webpack_require__(15);
__webpack_require__(15);
__webpack_require__(14);
(function webpackMissingModule() { throw new Error("Cannot find module \"/Users/lilit/Projects/tms/resources/assets/js-test/comments\""); }());
__webpack_require__(16);
module.exports = __webpack_require__(16);


/***/ })

/******/ });