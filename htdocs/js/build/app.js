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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

(function () {
    var deleteLinks = Array.from(document.querySelectorAll(".delete"));

    deleteLinks.forEach(function (element) {
        element.addEventListener("click", function (event) {
            event.preventDefault();
            if (confirm(event.target.getAttribute("data-confirm"))) {
                window.location.href = event.target.getAttribute("href");
            }
        });
    });

    var setupTarget = function setupTarget(toggler) {
        var dataTargetId = toggler.getAttribute("data-target");
        var dataTarget = document.getElementById(dataTargetId);
        var dataCloseId = toggler.getAttribute("data-close");
        var dataClose = document.getElementById(dataCloseId);

        toggler.addEventListener("click", function (event) {
            event.preventDefault();
            dataTarget.classList.toggle("noshow");
            dataClose.classList.add("noshow");
        });
    };

    var commentReplyTogglers = Array.from(document.querySelectorAll(".comment-edit-reply-toggler"));

    commentReplyTogglers.forEach(setupTarget);

    // const commentEditTogglers = Array.from(document.querySelectorAll(".comment-edit-toggler"));

    // commentEditTogglers.forEach(setupTarget);

    var commentCancelTogglers = Array.from(document.querySelectorAll(".comment-cancel"));

    commentCancelTogglers.forEach(function (cancel) {
        var dataCloseId = cancel.getAttribute("data-close");
        var dataClose = document.getElementById(dataCloseId);

        cancel.addEventListener("click", function (event) {
            event.preventDefault();
            dataClose.classList.add("noshow");
        });
    });
})();

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);