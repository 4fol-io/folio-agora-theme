/*!
  * domready (c) Dustin Diaz 2014 - License MIT
  */
!function (name, definition) {

  if (typeof module != 'undefined') module.exports = definition()
  else if (typeof define == 'function' && typeof define.amd == 'object') define(definition)
  else this[name] = definition()

}('domready', function () {

  var fns = [], listener
    , doc = typeof document === 'object' && document
    , hack = doc && doc.documentElement.doScroll
    , domContentLoaded = 'DOMContentLoaded'
    , loaded = doc && (hack ? /^loaded|^c/ : /^loaded|^i|^c/).test(doc.readyState)


  if (!loaded && doc)
    doc.addEventListener(domContentLoaded, listener = function () {
      doc.removeEventListener(domContentLoaded, listener)
      loaded = 1
      while (listener = fns.shift()) listener()
    })

  return function (fn) {
    loaded ? setTimeout(fn, 0) : fns.push(fn)
  }

});
// https://tc39.github.io/ecma262/#sec-array.prototype.includes
if (!Array.prototype.includes) {
  Object.defineProperty(Array.prototype, 'includes', {
    value: function(searchElement, fromIndex) {

      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      // 1. Let O be ? ToObject(this value).
      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If len is 0, return false.
      if (len === 0) {
        return false;
      }

      // 4. Let n be ? ToInteger(fromIndex).
      //    (If fromIndex is undefined, this step produces the value 0.)
      var n = fromIndex | 0;

      // 5. If n ≥ 0, then
      //  a. Let k be n.
      // 6. Else n < 0,
      //  a. Let k be len + n.
      //  b. If k < 0, let k be 0.
      var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

      function sameValueZero(x, y) {
        return x === y || (typeof x === 'number' && typeof y === 'number' && isNaN(x) && isNaN(y));
      }

      // 7. Repeat, while k < len
      while (k < len) {
        // a. Let elementK be the result of ? Get(O, ! ToString(k)).
        // b. If SameValueZero(searchElement, elementK) is true, return true.
        if (sameValueZero(o[k], searchElement)) {
          return true;
        }
        // c. Increase k by 1.
        k++;
      }

      // 8. Return false
      return false;
    }
  });
}

// https://tc39.github.io/ecma262/#sec-array.prototype.findindex
if (!Array.prototype.findIndex) {
  Object.defineProperty(Array.prototype, 'findIndex', {
    value: function(predicate) {
      // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return k.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return k;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return -1.
      return -1;
    },
    configurable: true,
    writable: true
  });
}

// Production steps of ECMA-262, Edition 5, 15.4.4.18
// Reference: http://es5.github.io/#x15.4.4.18
if (!Array.prototype.forEach) {

  Array.prototype.forEach = function(callback/*, thisArg*/) {

    var T, k;

    if (this == null) {
      throw new TypeError('this is null or not defined');
    }

    // 1. Let O be the result of calling toObject() passing the
    // |this| value as the argument.
    var O = Object(this);

    // 2. Let lenValue be the result of calling the Get() internal
    // method of O with the argument "length".
    // 3. Let len be toUint32(lenValue).
    var len = O.length >>> 0;

    // 4. If isCallable(callback) is false, throw a TypeError exception.
    // See: http://es5.github.com/#x9.11
    if (typeof callback !== 'function') {
      throw new TypeError(callback + ' is not a function');
    }

    // 5. If thisArg was supplied, let T be thisArg; else let
    // T be undefined.
    if (arguments.length > 1) {
      T = arguments[1];
    }

    // 6. Let k be 0.
    k = 0;

    // 7. Repeat while k < len.
    while (k < len) {

      var kValue;

      // a. Let Pk be ToString(k).
      //    This is implicit for LHS operands of the in operator.
      // b. Let kPresent be the result of calling the HasProperty
      //    internal method of O with argument Pk.
      //    This step can be combined with c.
      // c. If kPresent is true, then
      if (k in O) {

        // i. Let kValue be the result of calling the Get internal
        // method of O with argument Pk.
        kValue = O[k];

        // ii. Call the Call internal method of callback with T as
        // the this value and argument list containing kValue, k, and O.
        callback.call(T, kValue, k, O);
      }
      // d. Increase k by 1.
      k++;
    }
    // 8. return undefined.
  };
}

// https://tc39.github.io/ecma262/#sec-array.prototype.find
if (!Array.prototype.find) {
  Object.defineProperty(Array.prototype, 'find', {
    value: function(predicate) {
      // 1. Let O be ? ToObject(this value).
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);

      // 2. Let len be ? ToLength(? Get(O, "length")).
      var len = o.length >>> 0;

      // 3. If IsCallable(predicate) is false, throw a TypeError exception.
      if (typeof predicate !== 'function') {
        throw new TypeError('predicate must be a function');
      }

      // 4. If thisArg was supplied, let T be thisArg; else let T be undefined.
      var thisArg = arguments[1];

      // 5. Let k be 0.
      var k = 0;

      // 6. Repeat, while k < len
      while (k < len) {
        // a. Let Pk be ! ToString(k).
        // b. Let kValue be ? Get(O, Pk).
        // c. Let testResult be ToBoolean(? Call(predicate, T, « kValue, k, O »)).
        // d. If testResult is true, return kValue.
        var kValue = o[k];
        if (predicate.call(thisArg, kValue, k, o)) {
          return kValue;
        }
        // e. Increase k by 1.
        k++;
      }

      // 7. Return undefined.
      return undefined;
    },
    configurable: true,
    writable: true
  });
}

// Utility scripts
// 1. matches polyfill
// 2. closest polyfill
// 3. addEventListener
// 4. DelegateListener
// 5. MouseEvent
// 6. dispatchEvent
// 7. classList methods

// 1. matches polyfill
if (!Element.prototype.matches) {
  Element.prototype.matches =
    Element.prototype.matchesSelector ||
    Element.prototype.mozMatchesSelector ||
    Element.prototype.msMatchesSelector ||
    Element.prototype.oMatchesSelector ||
    Element.prototype.webkitMatchesSelector ||
    function(s) {
      var matches = (this.document || this.ownerDocument).querySelectorAll(s),
        i = matches.length;
      while (--i >= 0 && matches.item(i) !== this) {
        ;
      }
      return i > -1;
    };
}

// 2. closest polyfill
if (!Element.prototype.closest) {
  Element.prototype.closest = function(s) {
    var el = this;
    if (!document.documentElement.contains(el)) return null;
    do {
      if (el.matches(s)) return el;
      el = el.parentElement || el.parentNode;
    } while (el !== null && el.nodeType === 1);
    return null;
  };
}


// 3- addEventListener polyfill 1.0 / Eirik Backer / MIT Licence
(function(win, doc){
  if(win.addEventListener)return;		//No need to polyfill

  function docHijack(p){
    var old = doc[p];
    doc[p] = function(v){
      return addListen(old(v))
    }
  }
  function addEvent(on, fn, self){
    return (self = this).attachEvent('on' + on, function(ev){
      var e = ev || win.event;
      e.preventDefault  = e.preventDefault  || function(){e.returnValue = false}
      e.stopPropagation = e.stopPropagation || function(){e.cancelBubble = true}
      fn.call(self, e);
    });
  }
  function addListen(obj, i){
    if(i = obj.length)while(i--)obj[i].addEventListener = addEvent;
    else obj.addEventListener = addEvent;
    return obj;
  }

  addListen([doc, win]);
  if('Element' in win)win.Element.prototype.addEventListener = addEvent;			//IE8
  else{																			//IE < 8
    doc.attachEvent('onreadystatechange', function(){addListen(doc.all)});		//Make sure we also init at domReady
    docHijack('getElementsByTagName');
    docHijack('getElementById');
    docHijack('createElement');
    addListen(doc.all);
  }
})(window, document);


// 4. DelegateListener
// allows adding listeners to dinamically added elements
// Use: document.querySelector("body").addDelegateListener("click", "li", function(e){});
Element.prototype.addDelegateListener = function( type, selector, fn ) {
  this.addEventListener( type, function(e){
    var target = e.target;
    while( target && target !== this && !target.matches(selector) ) {
      target = target.parentNode;
    }
    if( target && target !== this ) {
      return fn.call( target, e );
    }
  }, false );
};

// 5. MouseEvent
// Allows to make click from javascript file creating MouseEvents
// Use:
//     var fakeClick = new MouseEvent('click', {
//         'view': window,
//         'bubbles': true,
//         'cancelable': true
//     });
//     elementToClick.dispatchEvent(fakeClick);
//     eventReceivingEventClick(fakeClick);
(function (window) {
  try {
    new MouseEvent('test');
    return false; // No need to polyfill
  } catch (e) {
    // Need to polyfill - fall through
  }

  // Polyfills DOM4 MouseEvent

  var MouseEvent = function (eventType, params) {
    params = params || { bubbles: false, cancelable: false };
    var mouseEvent = document.createEvent('MouseEvent');
    mouseEvent.initMouseEvent(eventType, params.bubbles, params.cancelable, window, 0, 0, 0, 0, 0, false, false, false, false, 0, null);

    return mouseEvent;
  };

  MouseEvent.prototype = Event.prototype;

  window.MouseEvent = MouseEvent;
})(window);

// 6. dispatchEvent
// Allows to trigger an event for an element
// Use: buttonElement.dispatchEvent('click');
!window.addEventListener && (function (WindowPrototype, DocumentPrototype, ElementPrototype, dispatchEvent) {
  WindowPrototype[dispatchEvent] = DocumentPrototype[dispatchEvent] = ElementPrototype[dispatchEvent] = function (eventObject) {
    return this.fireEvent("on" + eventObject.type, eventObject);
  };
})(Window.prototype, HTMLDocument.prototype, Element.prototype, "dispatchEvent");

// 7. classList methods
// Polyfill: Element.prototype.classList for IE8/9, Safari.
// Source: https://gist.github.com/k-gun/c2ea7c49edf7b757fe9561ba37cb19ca
(function() {
  // helpers
  var regExp = function(name) {
    return new RegExp('(^| )'+ name +'( |$)');
  };
  var forEach = function(list, fn, scope) {
    for (var i = 0; i < list.length; i++) {
      fn.call(scope, list[i]);
    }
  };

  // class list object with basic methods
  function ClassList(element) {
    this.element = element;
  }

  ClassList.prototype = {
    add: function() {
      forEach(arguments, function(name) {
        if (!this.contains(name)) {
          this.element.className += this.element.className.length > 0 ? ' ' + name : name;
        }
      }, this);
    },
    remove: function() {
      forEach(arguments, function(name) {
        this.element.className =
          this.element.className.replace(regExp(name), '');
      }, this);
    },
    toggle: function(name) {
      if(this.contains(name)){
        this.remove(name);
        return false;
      }else{
        this.add(name);
        return true;
      }
    },
    contains: function(name) {
      return regExp(name).test(this.element.className);
    },
    // bonus..
    replace: function(oldName, newName) {
      this.remove(oldName);
      this.add(newName);
    }
  };

  // IE8/9, Safari
  if (!('classList' in Element.prototype)) {
    Object.defineProperty(Element.prototype, 'classList', {
      get: function() {
        return new ClassList(this);
      }
    });
  }

  // replace() support for others
  if (window.DOMTokenList && DOMTokenList.prototype.replace == null) {
    DOMTokenList.prototype.replace = ClassList.prototype.replace;
  }
})();

var fw_BrowserDetect = {};
fw_BrowserDetect = {
  "EXPLORER": "Explorer",
  "MS_EDGE": "MS Edge",
  "FIREFOX": "Firefox",
  "OPERA": "Opera",
  "CHROME": "Chrome",
  "SAFARI": "Safari",
  init: function () {
    this.browser = this.searchString(this.dataBrowser) || "Other";
    this.version = this.searchVersion(navigator.userAgent) || this.searchVersion(navigator.appVersion) || "Unknown";
  },
  searchString: function (data) {
    for (var i = 0; i < data.length; i++) {
      var dataString = data[i].string;
      this.versionSearchString = data[i].subString;

      if (dataString.indexOf(data[i].subString) !== -1) {
        return data[i].identity;
      }
    }
  },
  searchVersion: function (dataString) {
    var index = dataString.indexOf(this.versionSearchString);
    if (index === -1) {
      return;
    }

    var rv = dataString.indexOf("rv:");
    if (this.versionSearchString === "Trident" && rv !== -1) {
      return parseFloat(dataString.substring(rv + 3));
    } else {
      return parseFloat(dataString.substring(index + this.versionSearchString.length + 1));
    }
  },

  /***
   * @description Detects if any of the passed browserNames are equal to the current browser
   * @param browserNames {array} It is suggested to use the variables fw_BrowserDetect.[browserName] for making comparison
   * @returns {boolean}
   */
  checkBrowsers: function (browserNames) {
    for(var i = browserNames.length;i--;){
      if(browserNames[i] === fw_BrowserDetect.browser){
        return true;
      }
    }
    return false;
  },

  dataBrowser: [
    {string: navigator.userAgent, subString: "Edge", identity: "MS Edge"},
    {string: navigator.userAgent, subString: "MSIE", identity: "Explorer"},
    {string: navigator.userAgent, subString: "Trident", identity: "Explorer"},
    {string: navigator.userAgent, subString: "Firefox", identity: "Firefox"},
    {string: navigator.userAgent, subString: "Opera", identity: "Opera"},
    {string: navigator.userAgent, subString: "OPR", identity: "Opera"},
    {string: navigator.userAgent, subString: "Chrome", identity: "Chrome"},
    {string: navigator.userAgent, subString: "Safari", identity: "Safari"}
  ]
};

function getElemFullHeight(elem) {
  return elem.clientHeight;
}

function getScreenFullHeight() {
  var d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0];
  return window.innerHeight|| e.clientHeight|| g.clientHeight;
}

function getScreenFullWidth() {
  var d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0];
  return window.innerWidth|| e.clientWidth|| g.clientWidth;
}

function screenWidthBetween(minWidth, maxWidth) {
  var screenSize = window.innerWidth;
  return screenSize > minWidth &&  screenSize <= maxWidth;
}

function guid() {
  function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
  }

  return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}

function parseNodeList(nodeList){
  return [].slice.call(nodeList);
}

function triggerFakeClickTo(element){
  var fakeClick = new MouseEvent('click', {
    'view': window,
    'bubbles': true,
    'cancelable': true
  });
  fakeClick.data = {
    isFakeEvent: "true"
  };
  element.dispatchEvent(fakeClick);
}

function fw_accesibilityInit() {
	"use strict";

	// ARIA attributes
	var attrRole = 'role',
		ariaHidden = 'aria-hidden',
		ariaControls = 'aria-controls',
		ariaRequired = 'aria-required',
		ariaInvalid = 'aria-invalid',
		ariaSelected = 'aria-selected',
		ariaLabelledBy = 'aria-labelledby';

	// Helper attributes for ARIA
	var dataSwitcher = 'data-switcher';

	function buildAttribute(attribute) {
		return '['+attribute+']';
	}

	// Form accesibility
	// Input tips (aria-hidden)
	document.querySelector('body').addDelegateListener('mouseover', '.form-tip ' + buildAttribute(ariaControls), function(e) {
		var target = document.getElementById(e.target.getAttribute(ariaControls));
		if(target != null) {
			target.setAttribute(ariaHidden, 'false');
		}
	});
	document.querySelector('body').addDelegateListener('mouseout', '.form-tip ' + buildAttribute(ariaControls), function(e) {
		var target = document.getElementById(e.target.getAttribute(ariaControls));
		if(target != null) {
			target.setAttribute(ariaHidden, 'true');
		}
	});
	// Required fields (aria-required/aria-invalid)
	document.querySelector('body').addDelegateListener('focusout', buildAttribute(ariaRequired), function(e) {
		if(e.target.value === '') {
			e.target.setAttribute(ariaInvalid, 'true');
		}
		else {
			e.target.setAttribute(ariaInvalid, 'false');
		}
	});
	// Selected fields (aria-selected)
	document.querySelector('body').addDelegateListener('click', buildAttribute(ariaSelected), function() {
		var parent = null,
			control = null;

		if(this.getAttribute(attrRole) === "tab") {
			parent = this.parentNode;
			while(parent != null && parent.getAttribute(attrRole) !== "tablist") {
				parent = parent.parentNode;
			}
		}
		else {
			parent = this.parentNode.parentNode;
		}

		if(parent) {
			var childs = parent.querySelectorAll(buildAttribute(ariaSelected));
			for (var i = 0; i < childs.length; i++) {
				childs[i].setAttribute(ariaSelected, 'false');
				control = document.getElementById(childs[i].getAttribute(ariaControls));
				if(control != null) {
					control.setAttribute(ariaHidden, 'true');
				}
			}
		}

		this.setAttribute(ariaSelected, 'true');
		control = document.getElementById(this.getAttribute(ariaControls));
		if(control != null) {
			control.setAttribute(ariaHidden, 'false');
		}
	});
	// Switcher button (ara-labelledby)
	document.querySelector('body').addDelegateListener('click', buildAttribute(dataSwitcher), function() {
		var id = this.getAttribute(ariaLabelledBy),
			el = document.getElementById(id);

		if(el) {
			if(el.previousElementSibling) {
				this.setAttribute(ariaLabelledBy, el.previousElementSibling.getAttribute('id'));
			}
			else {
				this.setAttribute(ariaLabelledBy, el.nextElementSibling.getAttribute('id'));
			}
		}
	});
}

// Vanilla (no-jQuery) appendAround
// Source: https://github.com/davidrapson/vanillaAppendAround
// Original jQuery plugin: https://github.com/filamentgroup/AppendAround

/* eslint-env browser, amd */
(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define([], factory);
    } else if (typeof module === 'object' && module.exports) {
        module.exports = factory();
    } else {
        root.appendAround = factory();
    }
})(this, function () {
    var settings = {};

    function debounce(func, wait, immediate) {
        var timeout;
        return function () {
            var context = this;
            var args = arguments;
            var later = function () {
                timeout = null;
                if (!immediate) {
                    func.apply(context, args);
                }
            };
            var callNow = immediate && !timeout;
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
            if (callNow) {
                func.apply(context, args);
            }
        };
    }

    function isHidden(elem) {
        return window.getComputedStyle(elem, null).getPropertyValue('display') === 'none';
    }

    function appendToVisibleContainer(el) {
        var parent = el.parentNode;
        var attVal = parent.getAttribute(settings.attribute);
        var attSelector = '[' + settings.attribute + '="' + attVal + '"]';
        var sets = document.querySelectorAll(attSelector);

        if (isHidden(parent) && sets.length) {
            var found = 0;
            [].forEach.call(sets, function (set) {
                if (!isHidden(set) && !found) {
                    set.appendChild(el);
                    found++;
                    parent = el;
                }
            });
        }
    }

    function run(els) {
        [].forEach.call(els, function (el) {
            appendToVisibleContainer(el);
            window.addEventListener('resize', debounce(function () {
                appendToVisibleContainer(el);
            }), settings.debounceDuration);
        });
    }

    return function (o) {
        var canRun = (
            'querySelector' in document &&
            'getComputedStyle' in window
        );

        if (!canRun) {
            return false;
        }

        settings = {
            selector: o && o.selector || '.js-append',
            attribute: o && o.attribute || 'data-set',
            debounceDuration: o && o.debounceDuration || 66
        };
        var els = document.querySelectorAll(settings.selector);
        if (els.length) {
            run(els);
        }
    };
});


//Init function

function fw_appendAroundInit(){
	appendAround({
		// Selector to use for appendAround elements. [Default '.js-append']
		selector: '[data-append]',
		// Attribute to use for sets. [Default 'data-set']
		attribute: 'data-append-container',
		// Amount to debounce resize listener (ms). [Default 66]
		debounceDuration: 66
	});
}

var mobileBreakpoint = 544;
var tabletBreakpoint = 768;
var desktopBreakpoint1 = 992;
var desktopBreakpoint = 1200;

var CollapseManager = (function () {
    "use strict";

    var instance;

    function createInstance() {
        instance = new Object("Collapse Manager instance");
        instance.fw_collapseInit = fw_collapseInit;
        instance.fw_collapseUpdateHeight = fw_collapseUpdateHeight;
        instance.fw_clickCollapseTrigger = fw_clickCollapseTrigger;
        return instance;
    }

    //Main vars
    var collapseSystem = "[data-collapse-system]",
        collapseSystemMode = "[data-collapse-system-mode]",
        collapseSystemExcluded = "[data-collapse-system-excluded]",
        collapseSystemElement = "[data-collapse-system-trigger]",
        collapseElement = "[data-collapse]",
        collapseTrigger = "[data-collapse-trigger]",
        collapseContent = "[data-collapse-content]",
        collapseInner = "[data-collapse-inner]",
        triggerActiveClass = "is-trigger-active",
        uncollapsedClass = "uncollapsed",
        uncollapsedMobileClass = "uncollapsed-sm",
        uncollapsedTabletClass = "uncollapsed-md",
        uncollapsedDesktopClass = "uncollapsed-lg",
        ariaExpanded = "aria-expanded",
        ariaHidden = "aria-hidden";

    var collapseSystemModeConstants = {
        NORMAL: 'normal',
        CUSTOM: 'custom'
    };


    //Main vars collapse-flip-flap
    var collapseFlipFlapElement = "[data-collapse-flipflap]",
        collapseFlipFlapTrigger = "[data-collapse-flipflap-trigger]",
        flapActiveClass = "is-flap-active";
        //collapseFlipContent = "[data-collapse-flip]",
        //collapseFlapContent = "[data-collapse-flap]",
        //targetFlipFlapElements;

    //Main slidetoggle function
    function fw_collapse(e) {

        var elTrigger = e.target,
            parentCollapse,
            parentCollapseSystem,
            subfinalHeight,
            targetSlide,
            systemElCollapse,
            i,
            grandParentCollapse,
            grandParentCollapseContent,
            grandParentCollapseInner;

        e.preventDefault();

        //check if elTrigger matches collapseTrigger
        while (!elTrigger.matches(collapseTrigger)) {
            elTrigger = elTrigger.parentNode;
        }

        //change trigger active class
        elTrigger.classList.toggle(triggerActiveClass);
        elTrigger.setAttribute(ariaExpanded, !(elTrigger.getAttribute(ariaExpanded) === "true"));

        // Check if the Collapse element is part of a system
        if (elTrigger.matches(collapseSystemElement)) {

            parentCollapseSystem = elTrigger.parentNode;

            while (!parentCollapseSystem.matches(collapseSystem) && (parentCollapseSystem.tagName !== "BODY")) {
                parentCollapseSystem = parentCollapseSystem.parentNode;
            }
            if (parentCollapseSystem.tagName === "BODY") {
                parentCollapseSystem = false;
            }
        }

        //Find target container
        parentCollapse = elTrigger.parentNode;
        while (!parentCollapse.matches(collapseElement)) {
            parentCollapse = parentCollapse.parentNode;
        }

        // Change collapse status to uncollapsed or not
        parentCollapse.classList.toggle(uncollapsedClass);

        /*If internet Explorer is detected, the overflow is modified with javascript instead of css animate*/
        if(fw_BrowserDetect.checkBrowsers([fw_BrowserDetect.EXPLORER, fw_BrowserDetect.MS_EDGE])){
            var isCollapsed = parentCollapse.classList.contains(uncollapsedClass);
            if(isCollapsed){
                setTimeout(function (args) {
                    parentCollapse.querySelector(collapseContent).style.overflow = 'visible';
                }, 200);
            }else{
                parentCollapse.querySelector(collapseContent).style.overflow = 'hidden';
            }
        }
        //Close open slideToggles if in a system
        if (parentCollapseSystem) {
            var dataMode = parentCollapseSystem.getAttribute('data-collapse-system-mode');
            systemElCollapse = parentCollapseSystem.querySelectorAll(collapseElement);
            collapseSystemMode = dataMode !== null ? dataMode : collapseSystemModeConstants.CUSTOM;

            var parentCollapseIsExcluded = parentCollapse.matches(collapseSystemExcluded);
            for (i = 0; i < systemElCollapse.length && !parentCollapseIsExcluded; i++) {
                var currentCollapse = systemElCollapse[i];
                var isNotCollapseSystemExcluded = !currentCollapse.matches(collapseSystemExcluded);
                if (currentCollapse !== parentCollapse && isNotCollapseSystemExcluded) {
                    if (collapseSystemMode === collapseSystemModeConstants.NORMAL) {
                        currentCollapse.classList.remove(uncollapsedClass);
                    }
                    if (collapseSystemMode === collapseSystemModeConstants.CUSTOM) {
                        var isDataCollapseChildren = findAttrAncestor(currentCollapse, "data-collapse") !== null;
                        var isNotDataCollapseParent = currentCollapse.querySelectorAll(collapseElement).length === 0;
                        if (isDataCollapseChildren || isNotDataCollapseParent) {
                            currentCollapse.classList.remove(uncollapsedClass);
                        }
                    }
                    currentCollapse.querySelector(collapseContent).style.maxHeight = 0;
                    currentCollapse.querySelector(collapseTrigger).classList.remove(triggerActiveClass);
                    currentCollapse.querySelector(collapseTrigger).setAttribute(ariaExpanded, 'false');
                    currentCollapse.querySelector(collapseContent).setAttribute(ariaHidden, 'true');

                    /*If internet Explorer is detected, the overflow is modified with javascript instead of css animate*/
                    if(fw_BrowserDetect.checkBrowsers([fw_BrowserDetect.EXPLORER, fw_BrowserDetect.MS_EDGE])){
                        currentCollapse.querySelector(collapseContent).style.overflow = 'hidden';
                    }
                }
            }
        }

        targetSlide = parentCollapse.querySelector(collapseContent);

        //If the user interacts with elements inside each collapse, the height is updated before 300 ms
        /*if(parentCollapse.parentElement.getAttribute('data-collapse-system') !== ''){
            targetSlide.addEventListener('click', function () {
                if (parentCollapse.classList.contains(uncollapsedClass)) {
                    setTimeout(function () {
                        targetSlide.style.maxHeight = getElemFullHeight(parentCollapse.querySelector(collapseInner)) + "px";
                    }, 300);
                }
            });
        }*/

        //Open or close current collapse element depending on uncollapsed class
        if (targetSlide.closest(collapseElement).classList.contains(uncollapsedClass)) {
            fw_collapseUpdateHeight(parentCollapse);
            targetSlide.setAttribute(ariaHidden, 'false');
            targetSlide.setAttribute('tabindex', -1);
            if(typeof e.data === 'undefined' || !e.data.isFakeEvent ){
                targetSlide.focus();
            }
        } else {
            targetSlide.setAttribute(ariaHidden, 'true');
            targetSlide.removeAttribute('tabindex');
            targetSlide.style.maxHeight = 0;
        }

        //Find parents containers
        grandParentCollapse = parentCollapse.parentNode;
        while (typeof grandParentCollapse.matches !== "undefined" && !grandParentCollapse.matches(collapseElement)) {
            grandParentCollapse = grandParentCollapse.parentNode;
        }

        if (typeof grandParentCollapse.matches === "undefined") {
            grandParentCollapse = null;
        }

        if (grandParentCollapse) {
            grandParentCollapseContent = grandParentCollapse.querySelector(collapseContent);
            grandParentCollapseInner = grandParentCollapse.querySelector(collapseInner);

            if (grandParentCollapseContent && grandParentCollapseInner) {
                //grandParentCollapseContent.style.maxHeight = grandParentCollapseInner.offsetHeight + "px";
                subfinalHeight = 0;
                var firstLevelChilds = getChildNodes(grandParentCollapseInner);
                var subCollapseInner = null;
                var subCollapseTrigger = null;

                for (var j = 0; j < firstLevelChilds.length ; j++) {
                    if ((subCollapseInner = firstLevelChilds[j].querySelector(collapseInner)) === null) {
                        subfinalHeight += getElemFullHeight(firstLevelChilds[j]);
                    } else {
                        subfinalHeight += getElemFullHeight(subCollapseInner);

                        if ((subCollapseTrigger = firstLevelChilds[j].querySelector(collapseTrigger)) !== null) {
                            subfinalHeight += getElemFullHeight(subCollapseTrigger) + 21;
                        }
                    }
                }

                if(grandParentCollapseContent.getAttribute(collapseSystem) !== ''){
                    grandParentCollapseContent.style.maxHeight = subfinalHeight + "px";
                }
            }
        }
    }

    //Main slidetoggle flip-flap function
    function fw_collapseFlipFlap(e) {
        var elTrigger = e.target,
            parentCollapse;

        e.preventDefault();

        //check if elTrigger matches collapseTrigger
        while (!elTrigger.matches(collapseFlipFlapTrigger)) {
            elTrigger = elTrigger.parentNode;
        }

        //change trigger active class
        elTrigger.classList.toggle(triggerActiveClass);
        elTrigger.setAttribute(ariaExpanded, !(elTrigger.getAttribute(ariaExpanded) === "true"));
        if(elTrigger.children[0].getAttribute(ariaHidden) === "true"){
            elTrigger.children[0].setAttribute(ariaHidden,"false");
            elTrigger.children[1].setAttribute(ariaHidden,"true");
        }
        else{
            elTrigger.children[1].setAttribute(ariaHidden,"false");
            elTrigger.children[0].setAttribute(ariaHidden,"true");
        }

        //Find target container
        parentCollapse = elTrigger.parentNode;
        while (!parentCollapse.matches(collapseFlipFlapElement)) {
            parentCollapse = parentCollapse.parentNode;
        }

        parentCollapse.classList.toggle(flapActiveClass);
    }

    /* Start helper functions */

    function fw_collapseInit() {
        //Event Listeners
        document.querySelector("body").addDelegateListener("click", collapseTrigger, function(e) {
            fw_collapse(e);
        });

        document.querySelector("body").addDelegateListener("click", collapseFlipFlapTrigger, function(e) {
            fw_collapseFlipFlap(e);
        });

        //Function to set collapse items displayed by default
        fw_checkUncollapsed();

        // The height of each collapse is reseted on window resize
        window.onresize = fw_resetCollapseHeights;
    }

    function findAttrAncestor(el, attr) {
        while ((el = el.parentElement) && el.getAttribute(attr) == null);
        return el;
    }

    function fw_checkUncollapsed() {
        var uncollapsed = document.querySelectorAll(collapseElement+"."+uncollapsedClass);

        //if trigger is-trigger-active
        var len = uncollapsed.length;
        while (len--) {
            var current = uncollapsed[len];
            var displayOnload = false;

            if (screenWidthBetween(0, mobileBreakpoint) && current.classList.contains(uncollapsedMobileClass)) {
                displayOnload = true;
            }

            if (screenWidthBetween(mobileBreakpoint, tabletBreakpoint) && current.classList.contains(uncollapsedTabletClass)) {
                displayOnload = true;
            }

            if (screenWidthBetween(tabletBreakpoint, 99999) &&  current.classList.contains(uncollapsedDesktopClass)) {
                displayOnload = true;
            }

            if (!current.classList.contains(uncollapsedMobileClass) && !current.classList.contains(uncollapsedTabletClass) && !current.classList.contains(uncollapsedDesktopClass)) {
                displayOnload = true;
            }

            if(displayOnload){
                fw_clickCollapseTrigger(current);
            }else{
                current.classList.remove(uncollapsedClass);
            }
        }
    }

    function fw_clickCollapseTrigger(collapse) {
        collapse.classList.toggle(uncollapsedClass);
        var triggerButton = collapse.querySelector(collapseTrigger);
        triggerFakeClickTo(triggerButton);
    }

    function fw_collapseUpdateHeight(collapse){
        var targetSlide = collapse.querySelector(collapseContent);
        if(collapse.classList.contains(uncollapsedClass)){
            setTimeout(function () {
                targetSlide.style.maxHeight = getElemFullHeight(collapse.querySelector(collapseInner))+ "px";
            }, 200);
        }
    }

    function fw_resetCollapseHeights(){
        var collapses = document.querySelectorAll(collapseElement);
        var fastIterator = collapses.length;
        for(var i = fastIterator; i-- ; ){
            fw_collapseUpdateHeight(collapses[i]);
        }
    }

    function getChildNodes(node) {
        var children = [];
        for (var child in node.childNodes) {
            if (node.childNodes[child].nodeType === 1) {
                children.push(node.childNodes[child]);
            }
        }
        return children;
    }

    /* End helper functions */

	return {
        getInstance: function () {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
	}
})();

function fw_dropDownInit() {
	"use strict";

	//Main vars
	var dropDownTrigger = "[data-dropdown-trigger]",
		dropDownElement = "[data-dropdown]",
		dropDownOpenClass = "is-open",
		triggerActiveClass = "is-trigger-active",
		collapseTrigger = "[data-collapse-trigger]",
		ariaExpanded = "aria-expanded";

	//Main dropdown function
	function fw_dropDown(e) {
		e.preventDefault();
		var parentDropDown = e.target.parentNode,
			targetElements,
			triggerElement,
			i;
		while (!parentDropDown.matches(dropDownElement)) {
			parentDropDown = parentDropDown.parentNode;
		}

		parentDropDown.classList.toggle(triggerActiveClass);
		triggerElement = parentDropDown.querySelector(dropDownTrigger);

		//Close open dropDowns
		targetElements = document.querySelectorAll(dropDownElement);

		for (i = 0; i < targetElements.length; i++) {
			if (targetElements[i] !== parentDropDown) {
				targetElements[i].classList.remove(dropDownOpenClass);

				var triggerElementAux = targetElements[i].querySelector(dropDownTrigger);
				triggerElementAux.setAttribute(ariaExpanded, "false");
			}
		}

		//Open or close current dropDown
		parentDropDown.classList.toggle(dropDownOpenClass);
		triggerElement.setAttribute(ariaExpanded, !(triggerElement.getAttribute(ariaExpanded) == "true"));
	}

	//If user clicks out of a dropDown
	function fw_dropDownClickOut(e) {
		var targetElements,
			targetTriggers,
			triggerElement,
			i;

		if (!e.target.closest(dropDownElement)) {
			targetElements = document.querySelectorAll(dropDownElement);

			for (i = 0; i < targetElements.length; i++) {
				targetElements[i].classList.remove(dropDownOpenClass);
				targetElements[i].classList.remove(triggerActiveClass);

				triggerElement = targetElements[i].querySelector(dropDownTrigger);
				triggerElement.setAttribute(ariaExpanded, "false");
			}

		}
	}

	//Event Listeners
	document.querySelector("body").addDelegateListener("click", dropDownTrigger, function(e) {
		fw_dropDown(e);
	});
	document.addEventListener("click", fw_dropDownClickOut);


	//Find elements with the attribute <attribute>
	function getAllElementsWithAttribute(set, attribute) {
		var matchingElements = [];
		var allElements = set.getElementsByTagName('*');
		for (var i = 0, n = allElements.length; i < n; i++) {
			if (allElements[i].getAttribute(attribute) !== null) {
				matchingElements.push(allElements[i]);
			}
		}
		return matchingElements;
	}

	//Find child nodes of first level
	function getChildNodes(node) {
		var children = new Array();
		for (var i = 0; i < node.childNodes.length; i++) {
			if (node.childNodes[i].nodeType == 1) {
				children.push(node.childNodes[i]);
			}
		}
		return children;
	}

	//Find nearest parent by class
	function findAncestor(el, cls) {
		while ((el = el.parentElement) && !el.classList.contains(cls) && !el.classList.contains("location__sub-section"));
		return el;
	}

	//Find nearest parent by data-attribute
	function findAttrAncestor(el, attr) {
		while ((el = el.parentElement) && el.getAttribute(attr) == null);
		return el;
	}

	//Helper function
	function hasClass(el, className) {
		if (el.classList)
			return el.classList.contains(className)
		else
			return !!el.className.match(new RegExp('(\\s|^)' + className + '(\\s|$)'))
	}

	//Helper function
	function addClass(el, className) {
		if (el.classList)
			el.classList.add(className)
		else if (!hasClass(el, className)) el.className += " " + className
	}

	//Helper function
	function removeClass(el, className) {
		if (el.classList)
			el.classList.remove(className)
		else if (hasClass(el, className)) {
			var reg = new RegExp('(\\s|^)' + className + '(\\s|$)')
			el.className = el.className.replace(reg, ' ')
		}
	}

	var dropDownSecondaryTrigger = "data-dropdown-secondary-trigger",
		dropDownSecondaryElement = "data-dropdown-secondary",
		cCollapseInner = "data-collapse-inner",
		dropDownSecondaryContent = "data-dropdown-secondary-content",
		dropDownSecondaryItemHeight = 0;

	//Main dropDownsSecondary function
	function dropDownsSecondary() {
		var elems = getAllElementsWithAttribute(document, dropDownSecondaryElement);

		if (elems != null) {
			for (var i = 0; i < elems.length; i++) {
				var triggerElem = getAllElementsWithAttribute(elems[i], dropDownSecondaryTrigger);

				if (triggerElem != null) {
					if (triggerElem.length > 0) {
						triggerElem = triggerElem[0];
					}

					triggerElem.onclick = function() {
						var contentElem = this.nextElementSibling;

						//Calculate height of element to expand/collapse
						if (contentElem != null) {
							if (contentElem.length > 0) {
								contentElem = contentElem[0];
							}

							//Expand
							if (parseInt(contentElem.style.maxHeight, 10) == 0 || contentElem.style.maxHeight == "") {
								var ulMaxHeight = 1000;
								var liChilds = getChildNodes(contentElem);

								if (liChilds != null) {
									ulMaxHeight = 0;
									for (var j = 0; j < liChilds.length; j++) {
										if (dropDownSecondaryItemHeight == 0) {
											dropDownSecondaryItemHeight = liChilds[j].offsetHeight;
										}
										ulMaxHeight += dropDownSecondaryItemHeight;
									}
								}

								contentElem.style.maxHeight = (ulMaxHeight + 200) + "px";

								if (!hasClass(this, triggerActiveClass)) {
									addClass(this, triggerActiveClass);
									this.setAttribute(ariaExpanded, "true");
								}
							}
							//Collapse
							else {
								contentElem.style.maxHeight = "0px";

								var ulChilds = contentElem.getElementsByClassName('dropdown-secondary-content');

								if (ulChilds != null) {
									for (var j = 0; j < ulChilds.length; j++) {
										ulChilds[j].style.maxHeight = "0px";

										var trigger = ulChilds[j].previousElementSibling;
										if (hasClass(trigger, triggerActiveClass)) {
											removeClass(trigger, triggerActiveClass);
											trigger.setAttribute(ariaExpanded, "false");
										}
									}
								}

								if (hasClass(this, triggerActiveClass)) {
									removeClass(this, triggerActiveClass);
									this.setAttribute(ariaExpanded, "false");
								}
							}
						}

						//Recalculate height of parents
						var parent = contentElem;
						while ((parent = findAncestor(parent, 'dropdown-secondary-content')) != null) {
							var ulMaxHeight = parent.offsetHeight;
							var liChilds = getChildNodes(parent);

							if (liChilds != null) {
								//ulMaxHeight = 0;
								for (var j = 0; j < liChilds.length; j++) {
									ulMaxHeight += dropDownSecondaryItemHeight;
								}
							}

							if (parent.style.maxHeight != "0px") {
								parent.style.maxHeight = (ulMaxHeight + 200) + "px";
							}
						}
					};
				}
			}
		}
	}

	//Refresh dropDownsSecondary function when dropDownSecondary and collapse work together
	function updateCDropDowns(e) {
		var elTrigger = e.target,
			elParentCDropDown;

		if (elTrigger != null) {
			elParentCDropDown = findAttrAncestor(elTrigger, dropDownSecondaryElement);

			if (elParentCDropDown != null) {
				var contentElem = elParentCDropDown;

				//Recalculate height of parents
				var parent = contentElem;
				while ((parent = findAncestor(parent, "dropdown-secondary-content")) !== null) {
					var ulMaxHeight = 1000;
					var liChilds = getChildNodes(parent);

					if (liChilds != null) {
						ulMaxHeight = 0;
						for (var j = 0; j < liChilds.length; j++) {
							ulMaxHeight += liChilds[j].offsetHeight;

							var sm = getAllElementsWithAttribute(liChilds[j], cCollapseInner);

							for (var k = 0; k < sm.length; k++) {
								ulMaxHeight += sm[k].offsetHeight;
							}
						}
					}

					parent.style.maxHeight = ulMaxHeight + "px";
				}
			}
		}
	}

	//Init dropDownsSecondary
	dropDownsSecondary();

	//Listen collapse trigger event to refresh associate dropDownSecondary
	document.querySelector("body").addDelegateListener("click", collapseTrigger, function(e) {
		updateCDropDowns(e);
	});
}

var FileManager = (function () {
  'use strict';

  var instance;

  var fileElement = 'data-file',
    fileInput = '[data-file-input]',
    fileFakeInput = '[data-file-fake-input]',
    fileDelete = '[data-file-delete]',
    classInputFilled = 'is-input-filled';

  function createInstance () {
    instance = new Object('File Input Manager instance');
    instance.fw_fileInit = fw_fileInit;
    return instance;
  }

  /**
   * Initialize proper event listeners for required behaviours
   */
  function fw_fileInit () {
    var fileElements = document.querySelectorAll(buildAttribute(fileElement));
    var fastIterator = fileElements.length;
    for (var i = fastIterator; i--;) {
      var currentFileElement = fileElements[i];

      var currentFileElementInput = currentFileElement.querySelector(fileInput);
      var currentFileElementFakeInput = currentFileElement.querySelector(fileFakeInput);

      currentFileElementInput.addEventListener('change',
        updateFakeInput.bind(null, currentFileElementInput, currentFileElementFakeInput), false);
      currentFileElementInput.addEventListener('change',
        updateFileElementStatus.bind(null, currentFileElement, currentFileElementFakeInput), false);
    }

    fw_addListeners();
  }

  /**
   * Updates the fake input filename with the original filename
   * @param realInput {object} The element marked as [data-file-input] inside each [data-file]
   * @param fakeInput {object} The element marked as [data-file-fake-input] inside each [data-file]
   */
  function updateFakeInput (realInput, fakeInput) {
    fakeInput.value = formatUrlString(realInput.value);
  }

  /**
   * Toggles the fileElement status class(is-inputfilled) depending on fakeinput value
   * @param currentFileElement {object} The [data-file] element to inspect
   * @param fakeInput {object} The [data-file-fake-input] element to check
   */
  function updateFileElementStatus (currentFileElement, fakeInput) {
    if (fakeInput.value && fakeInput.value !== '') {
      currentFileElement.classList.add(classInputFilled);
    } else {
      currentFileElement.classList.remove(classInputFilled);
    }
  }

  function findAttrAncestor(el, attr) {
    var finalEl = null;

    while(el.parentElement){
      if(el.parentElement.getAttribute(attr) !== null){
        finalEl = el.parentElement;
      }
      el = el.parentElement;
    }

    return finalEl;
  }

  function buildAttribute(name) {
    return "[" + name + "]";
  }

  /**
   * Function for resetting the status passed inputs
   * @param event
   */
  function resetFileElement (event) {
    var currentFileElement = findAttrAncestor(event.target, fileElement);
    var realInput = currentFileElement.querySelector(fileInput);
    var fakeInput = currentFileElement.querySelector(fileFakeInput);

    realInput.value = '';
    fakeInput.value = '';
    updateFileElementStatus(currentFileElement, fakeInput);
  }

  function fw_addListeners(){
    document.querySelector("body").addDelegateListener('click', fileDelete, function (e) {
      e.preventDefault();
      resetFileElement(e);
    });
  }

  /**
   * This function return the file path without typical fakepath url
   * @param url
   * @returns {*|void|string}
   */
  function formatUrlString (url) {
    return url.replace(/^.*\\/, '');
  }

  return {
    getInstance: function () {
      if (!instance) {
        instance = createInstance();
      }
      return instance;
    }
  };
})();

function fw_headerSearchInit() {
	"use strict";
	
	//Main vars
	var headerSearch = "[data-form-search]",
		headerSearchOpen = "[data-form-search-open]",
		headerSearchClose = "[data-form-search-close]",
		headerSearchOpenClass = "is-open";


	//Main header search function
	function fw_headerSearch(e) {
		e.preventDefault();
		var parentHeaderSearch = e.target.parentNode,
			targetElements,
			i;
		while (!parentHeaderSearch.matches(headerSearch)) {
			parentHeaderSearch = parentHeaderSearch.parentNode;
		}

		//Open or close current header search
		parentHeaderSearch.classList.toggle(headerSearchOpenClass);
		
		//Focus if needed
		if (parentHeaderSearch.classList.contains(headerSearchOpenClass)){
			parentHeaderSearch.querySelector("input").focus();
		}
	}

	//If user clicks out of the header search
	function fw_headerSearchClickOut(e) {
		var targetElements,
			i;
		
		if (!e.target.closest(headerSearch)) {
			targetElements = document.querySelectorAll(headerSearch);
			for (i = 0; i < targetElements.length; i++) {
				targetElements[i].classList.remove(headerSearchOpenClass);
			}
		}
	}

	//Event Listeners
	document.querySelector("body").addDelegateListener("click", headerSearchOpen, function (e) {fw_headerSearch(e); });
	document.querySelector("body").addDelegateListener("click", headerSearchClose, function (e) {fw_headerSearch(e); });
	document.addEventListener("click", fw_headerSearchClickOut);

}



var LocaleManager  = (function () {
  var instance;

  var messagesStore;
  var currentLocale;

  function createInstance() {
    instance = new Object("Locale Manager instance");
    instance.defineLocale = defineLocale;
    instance.t = t;
    instance.translate = t;
    instance.setCurrentLocale = setCurrentLocale;
    return instance;
  }

  function getMessageStore(name){
    var result = null;
    if(messagesStore && messagesStore[name]){
      result = messagesStore[name];
    }
    return result;
  }

  function setCurrentLocale(name){
    if(currentLocale !== null && currentLocale !== '' && name && name !== '' && getMessageStore(name)){
      currentLocale = name;
    }else{
      currentLocale = 'en';
    }
  }

  function defineLocale(name, config){
    if(!messagesStore){
      messagesStore = {};
    }
    if(name && config){
      messagesStore[name] = config;
    }
  }

  function getCurrentLocale(){
    if(currentLocale){
      return currentLocale;
    }else{
      return 'en';
    }
  }

  function t(string){
    var finalString = string;
    var currentLocale = getCurrentLocale();
    var currentMessageStore = getMessageStore(currentLocale);
    if(string !== null && string !== '' && currentLocale && currentMessageStore){
      var currentMessages = currentMessageStore['messages'];
      var keyMessage = currentMessages[string];
      if(keyMessage){
        finalString = keyMessage;
      }
    }
    return finalString;
  }

  return {
    getInstance: function () {
      if (!instance) {
        instance = createInstance();
      }
      return instance;
    }
  };
})();

function fw_mainNavInit() {
	"use strict";
	
	//Main vars
	var mainNav = "[data-nav]",
		mainNavOpen = "[data-nav-open]",
		mainNavClose = "[data-nav-close]",
		mainNavOpenClass = "is-nav-open";


	//Main nav function
	function fw_mainNav(e) {
		e.preventDefault();
		
		//Open or close nav
		document.querySelector(mainNav).classList.toggle(mainNavOpenClass);
	}

	//Event Listeners
	document.querySelector("body").addDelegateListener("click", mainNavOpen, function (e) {fw_mainNav(e); });
	document.querySelector("body").addDelegateListener("click", mainNavClose, function (e) {fw_mainNav(e); });
}



var ModalManager = (function () {
	"use strict";

	var instance;

	//Main vars
	var modalTrigger = "[data-modal-trigger]",
			modalClose = "[data-modal-close]",
			modalAction = "[data-modal-action]",
			modalElement = "[data-modal]",
			modalDialog = "[data-modal-dialog]",
			clickOutBlock = "[data-modal-blocked]",
    	modalHref = "data-modal-href",
			modalScrollEnabled = "data-modal-scroll-enabled",
			modalOpenClass = "is-modal-open",
			modalBigClass = "is-modal-big",
			scrollBlockedClass = "is-blocked-scroll",
			ariaHidden = "aria-hidden",
			lastFocus = "";

	function createInstance() {
		instance = new Object("Modal Manager instance");
		instance.fw_modalInit = fw_modalInit;
		instance.fw_addListeners = fw_addListeners;
		return instance;
	}

	function fw_modalInit() {

		document.onkeydown = function (e) {
			e = e || window.event;
			var isEscape = false;
			if ("key" in e) {
				isEscape = (e.key == "Escape" || e.key == "Esc");
			}
			else {
				isEscape = (e.keyCode == 27);
			}
			if (isEscape) {
				var modalOpen = document.querySelector('.' + modalOpenClass);
				if (modalOpen) {
					fw_modalClickOut(e, modalOpen);
					if (document.activeElement) {
						document.activeElement.blur();
					}
				}
			}


			var modalOpened = document.querySelector('.' + modalOpenClass);
			if (modalOpened) {
				if (modalOpened.querySelector('.tab-block-last')) {
					modalOpened.querySelector('.tab-block-last').onkeydown = function (e) {
						if (e.which === 9 && e.shiftKey === false) {
							if (this.nextElementSibling === null) {
								modalOpened.querySelector('.tab-block-first').focus();
							}
							else {
								this.nextElementSibling.focus();
							}
						}
						else if (e.which === 9 && e.shiftKey === true) {
							this.previousElementSibling.focus();
						}
						e.preventDefault();
					};

					modalOpened.querySelector('.tab-block-first').onkeydown = function (e) {
						if (e.which === 9) {
							if (this.nextElementSibling !== null) {
								this.nextElementSibling.focus();
							}
						}
						e.preventDefault();
					};

				}
			}

		};

		document.addEventListener("focus", function (event) {
			var dialog = document.querySelector('.' + modalOpenClass);
			if (dialog && !dialog.contains(event.target)) {
				event.stopPropagation();
				dialog.focus();
			}
		}, true);

    	fw_addListeners();
	}

	//Modal open
	function fw_modalOpen(e) {
		e.preventDefault();
		var modalTarget = e.target,
				modalId,
				modalEl,
				modalDialogEl;
		while (!modalTarget.matches(modalTrigger)) {
			modalTarget = modalTarget.parentNode;
		}

		modalId = modalTarget.getAttribute("href") || modalTarget.getAttribute(modalHref);
		modalEl = document.querySelector(modalId);
		if (modalEl !== null) {
			modalEl.classList.add(modalOpenClass);
			modalDialogEl = modalEl.querySelector(modalDialog);

			if (modalDialogEl !== null) {
				modalDialogEl.setAttribute(ariaHidden, "false");

				//We set a custom max-width for image modals
				var bannerImage = modalDialogEl.querySelector(".modal-image-banner");
				if (bannerImage != null) {
					//Max size of modal with images;
					var modalImageMaxWidth = 690;
					//Original image width
					var imageWidth = bannerImage.naturalWidth;
					//If the image is bigger than modal image limit, the limit is the
					// size of the modal.
					var maxWidth = imageWidth > modalImageMaxWidth || imageWidth === 0 ? modalImageMaxWidth : imageWidth;
					modalDialogEl.style.maxWidth = maxWidth + "px";
				}
			}

      if(fw_isModalScrollEnabled(modalEl)){
        document.querySelector("body").classList.add(scrollBlockedClass);
      }
		}

		lastFocus = document.activeElement;
		document.querySelector(modalId).querySelector(modalDialog).setAttribute("aria-hidden", "false");
		document.querySelector(modalId).setAttribute('tabindex', '-1');
		document.querySelector(modalId).focus();

		fw_checkModalSize(modalEl)

	}

	function fw_isModalScrollEnabled(modalEl){
    var isEnabled = true;
    if(!modalEl || modalEl.matches(buildAttribute(modalScrollEnabled)) && modalEl.getAttribute(modalScrollEnabled) === 'false'){
      isEnabled = false;
		}
		return isEnabled;
	}

	//modal close function
	function fw_modalClose() {
		var targetElements,
				modalDialogEl,
				i;

		targetElements = document.querySelectorAll(modalElement);
		for (i = 0; i < targetElements.length; i++) {
			targetElements[i].classList.remove(modalOpenClass);

			modalDialogEl = targetElements[i].querySelector(modalDialog);
			if (modalDialogEl !== null) {
				modalDialogEl.setAttribute(ariaHidden, "true");
			}
		}
		document.querySelector("body").classList.remove(scrollBlockedClass);
		setTimeout(function () {
			lastFocus.focus();
		}, 0);
		fw_modalManageVideo("close");
	}

	//modal close button
	function fw_modalCloseButton(e) {
		e.preventDefault();
		fw_modalClose();
	}

	//modal action button (no preventDefault)
	function fw_modalActionButton(e) {
		fw_modalClose();
	}

	//If user clicks out of a modal
	function fw_modalClickOut(e, t) {
		var finalTarget = e.target;

		if (t) {
			finalTarget = t;
		}

		if (!finalTarget.closest(modalDialog) && !finalTarget.closest(clickOutBlock)) {
			e.preventDefault();
			fw_modalClose();
		}
	}

	//Check if the modal window have a video, and manage it
	function fw_modalManageVideo(action) {
		var mainplayer = PlayerManager.getInstance().getMainPlayer();
		if (typeof mainplayer !== 'undefined' && mainplayer !== null) {
			if (action === "close") {
        mainplayer.stopVideo();
			}
			else if (action === "open") {
        mainplayer.seekTo(0);
        mainplayer.playVideo();
			}
		}

	}

	function fw_checkModalSize(modal){
		if(modal.classList.contains(modalOpenClass)){
			var modalDialogEl = modal.querySelector(modalDialog);
			if(modalDialogEl){
        var dialogHeight = parseInt(window.getComputedStyle(modalDialogEl).height, 10);
        var screenHeight = getScreenFullHeight();
        if(screenHeight <= dialogHeight){
          modal.classList.add(modalBigClass);
        }else{
          modal.classList.remove(modalBigClass);
        }
			}
		}
	}

    function fw_resizeEvents() {
		var openModals = document.querySelectorAll('.'+modalOpenClass);
		for(var i = 0; i < openModals.length ; i++){
			var currentModal = openModals[i];
            fw_checkModalSize(currentModal);
		}
    }

    //Event Listeners
	function fw_addListeners() {
		document.querySelector("body").addDelegateListener("click", modalTrigger, function (e) {
			fw_modalOpen(e);
		});

		document.querySelector("body").addDelegateListener("click", modalAction, function (e) {
			fw_modalActionButton(e);
		});

		document.querySelector("body").addDelegateListener("click", modalClose, function (e) {
			fw_modalCloseButton(e);
		});

		document.querySelector("body").addDelegateListener("touchend", modalClose, function (e) {
			fw_modalCloseButton(e);
		});

		document.querySelector("body").addDelegateListener("click", modalElement, function (e) {
			fw_modalClickOut(e);
		});

		//Bugfix for iPhone
		document.querySelector("body").addDelegateListener("touchend", modalElement, function (e) {
			fw_modalClickOut(e);
		});

        window.addEventListener("resize", fw_resizeEvents);
	}

	return {
		getInstance: function () {
			if (!instance) {
				instance = createInstance();
			}
			return instance;
		}
	}
})();

var PlayerManager = (function() {

    var instance;

    function createInstance() {
        instance = new Object("Player Manager instance");
        instance.mainplayer = null;
        instance.setMainPlayer = setMainPlayer;
        instance.getMainPlayer = getMainPlayer;
        instance.setInitFunction = setInitFunction;
        instance.loadInitFunction = loadInitFunction;

        return instance;
    }

    function setInitFunction(func){
        instance.initFunction = func;
    }

    function loadInitFunction(){
      instance.initFunction();
    }

    function setMainPlayer(player){
        instance.mainplayer = player;
    }

    function getMainPlayer(){
        return instance.mainplayer;
    }

    // Return the object that is assigned to Module
    return {
        getInstance: function () {
            if (!instance) {
                instance = createInstance();
            }
            return instance;
        }
    };
}());

// Data attributes
var selectElement = "data-select",
    selectLazyLoad = "data-lazy-load",
    selectValue = "data-select-value",
    selectTrigger = "data-select-trigger",
    selectText = "data-select-text",
    selectList = "data-select-list",
    selectListItem = "data-select-list-item",
    selectId = "data-select-id",
    selectDependent = "data-dependent",
    dataBinded = "data-bind",

    //Roles
    selectRoleListbox = "listbox",
    selectRoleOption = "option",

    // Classes
    selectOpenClass = "is-select-open",
    selectLoadedClass = "is-select-loaded",
    selectHintClass = "hint",
    selectSelectedClass = "selected",
    selectItemClass = "select--custom--dropdown__item",
    selectContentClass = "select--custom--dropdown__content",
    selectValuesClass = "select--custom--dropdown__values",
    selectSelectedValueClass = "select--custom--dropdown__selected-value",
    selectFormItemClass = "form-item",
    selectAttrSend = "data-send";

function fw_customSelectsInit() {
	"use strict";

	//select open
	function fw_selectOpen(e) {
		e.preventDefault();
		var selectTarget = e.target;

		while (!selectTarget.matches(buildAttribute(selectElement))) {
			selectTarget = selectTarget.parentNode;
		}

		if (selectTarget != null) {
			selectTarget.classList.toggle(selectOpenClass);
			var select = selectTarget.querySelector(buildAttribute(selectValue));

			if (select != null) {
				select.focus();
			}
		}
	}

	//select close function
	function fw_selectClose() {
		var targetElements, i;

		targetElements = document.querySelectorAll(buildAttribute(selectElement));
		for (i = 0; i < targetElements.length; i++) {
			targetElements[i].classList.remove(selectOpenClass);
		}
	}

	//If user clicks out of a select
	function fw_selectClickOut(e) {
		if (!e.target.closest(buildAttribute(selectElement))) {
			fw_selectClose();
		}
	}

	function fw_selectSelection(e) {
		var selectedText = "",
			selectItemTarget = e.target,
			//selectedItemClick = selectItemTarget,
			selectTarget = selectItemTarget.closest(buildAttribute(selectElement));

		if (selectTarget != null) {
			var selectControl = selectTarget.querySelector(buildAttribute(selectValue)),
				selectContorlText = selectTarget.querySelector(buildAttribute(selectText));

			if (selectControl != null) {
				var selectedIndex = getElementIndex(selectItemTarget),
					selectedText = selectItemTarget.innerHTML;

				if (selectedIndex >= 0) {
					selectControl.options[selectedIndex].selected = true;

					if (selectedIndex == 0) {
						selectTarget.classList.add(selectHintClass);
					} else {
						selectTarget.classList.remove(selectHintClass);
					}

					fw_setSelectedOption(selectTarget, selectedIndex);
				}
			}

			selectTarget.classList.remove(selectOpenClass);
			selectContorlText.innerHTML = selectedText;

			if(typeof window.jQuery !== "undefined") {
				$(selectControl).trigger("change");
			}
		}
	}

	function getElementIndex(child_element) {
		var parent_element = child_element.parentNode;
		return Array.prototype.indexOf.call(parent_element.children, child_element);
	}

	//Event Listeners
	document.querySelector("body").addDelegateListener("click", buildAttribute(selectTrigger), function(e) {
        //We close the other selectors before opening the current one
        fw_selectClose();
		fw_selectOpen(e);
	});

	document.addEventListener("click", function(e) {
		fw_selectClickOut(e);
	});

	document.querySelector("body").addDelegateListener("click", buildAttribute(selectListItem), function(e) {
		fw_selectSelection(e);
	});

    var selects = document.querySelectorAll(buildAttribute(selectElement));
	fw_initializeSelects(selects);
}

function buildAttribute(name) {
    return "[" + name + "]";
}

function isLazyLoadSelect(selectLabel){
    return selectLabel.getAttribute(selectLazyLoad) !== null && selectLabel.getAttribute(selectLazyLoad) !== 'false';
}

function fw_isSelectLoaded(selectLabel){
    return selectLabel.classList.contains(selectLoadedClass);
}

function findAncestorByTag(el, tn) {
    while ((el = el.parentElement) && el.tagName != tn.toUpperCase());
    return el;
}

//initialize all custom selects

function fw_setSelectedOption(selectParentTarget, index) {
    var dropdownItems = selectParentTarget.querySelectorAll(buildAttribute(selectListItem));
    for (var i = 0; i < dropdownItems.length; i++) {
        if (i == index) {
            dropdownItems[i].classList.add(selectSelectedClass);
        } else {
            dropdownItems[i].classList.remove(selectSelectedClass);
        }
    }
}

//We pass the label element that contains the data-select which contains the select with data-select-value
function fw_initLazyLoadSelect(selectLabel){
    var select = selectLabel.querySelector("select");
	if(select != null && isLazyLoadSelect(selectLabel)) {
	    fw_initializeSelect(selectLabel);
	}
}

function fw_initAllLazyLoadSelects(){
    var selects = document.querySelectorAll(buildAttribute(selectLazyLoad));
    if (selects != null) {
        for (var i = 0; i < selects.length; i++) {
            var selectLabel = selects[i];
            if (selectLabel != null && isLazyLoadSelect(selectLabel)) {
                fw_initializeSelect(selects[i]);
            }
        }
    }
}

function fw_initializeSelects(selects) {
    if (selects != null) {
        for (var i = 0; i < selects.length; i++) {
            var selectLabel = selects[i];
            if (selectLabel != null && !isLazyLoadSelect(selectLabel)) {
                fw_initializeSelect(selects[i]);
            }
        }
    }
}

function fw_initializeSelect(selectLabel) {
    if(!fw_isSelectLoaded(selectLabel)){
        var select = selectLabel.querySelector("select");

        //Hide select
        select.setAttribute('aria-hidden', "true");

        //Trigger element
        var selectContentEl = document.createElement('div');
        selectContentEl.classList.add(selectContentClass);
        selectContentEl.classList.add(selectFormItemClass);
        selectContentEl.setAttribute(selectTrigger, "");

        //Text of trigger element
        var selectedValueEl = document.createElement('div');
        selectedValueEl.classList.add(selectSelectedValueClass);
        selectedValueEl.setAttribute(selectText, "");

        if (selectContentEl != null && selectedValueEl != null) {
            var initSelectedText = "";

            for (var j = 0; j < select.options.length; j++) {
                if (select.options[j].selected) {
                    initSelectedText = select.options[j].text;
                }
            }

            //Text node default option
            var textnode = document.createTextNode(initSelectedText);
            selectedValueEl.appendChild(textnode);

            //Assign trigger and text selected
            selectContentEl.appendChild(selectedValueEl);
            selectLabel.appendChild(selectContentEl);
            selectLabel.classList.add(selectLoadedClass);
        }

        //Custom elements
        var selectValuesEl = document.createElement('div');
        var selectIsDependent = select.getAttribute(selectDependent);

        selectValuesEl.classList.add(selectValuesClass);
        selectValuesEl.setAttribute(selectList, "");
        selectValuesEl.setAttribute('role', selectRoleListbox);

        if (selectValuesEl != null) {
            selectValuesEl.setAttribute(selectId, select.id);
            //Lo de los options del bucle hay que ponerlo bien, asi no va
            for (var j = 0; j < select.options.length; j++) {
                var selectItemEl = document.createElement('div');
                selectItemEl.setAttribute('role', selectRoleOption);

                selectItemEl.classList.add(selectItemClass);
                if(selectIsDependent != null){
                    var optionClass = select.options[j].className;
                    selectItemEl.setAttribute(dataBinded, optionClass);
                }
                selectItemEl.setAttribute(selectListItem, select.options[j].value);
                if(j == 0) {
                    selectItemEl.classList.add(selectSelectedClass);
                }

                if (selectItemEl != null) {
                    //Text node option
                    var textnode = document.createTextNode(select.options[j].text);
                    selectItemEl.appendChild(textnode);
                    selectValuesEl.appendChild(selectItemEl);
                }
            }

            selectLabel.appendChild(selectValuesEl);
            selectLabel.classList.add(selectLoadedClass);
        }

        select.onchange = function(e) {
            var selectedText = "",
                selectItemTarget = e.target,
                selectTarget = selectItemTarget.closest(buildAttribute(selectElement)),
                tagName = "FORM";

            if (selectTarget != null) {
                var selectControl = selectTarget.querySelector(buildAttribute(selectValue)),
                    selectContorlText = selectTarget.querySelector(buildAttribute(selectText));

                if (selectControl != null) {
                    var selectedValue = selectItemTarget.options[selectItemTarget.selectedIndex].value;
                    //selectedText = selectedItemClick.innerHTML;
                    var dropdownItems = selectTarget.querySelectorAll(buildAttribute(selectListItem));

                    if (dropdownItems != null) {
                        var updatedValue = false;
                        for (var j = 0; j < dropdownItems.length && !updatedValue; j++) {
                            if (dropdownItems[j].getAttribute(selectListItem) && selectedValue == dropdownItems[j].getAttribute(selectListItem)) {
                                selectedText = dropdownItems[j].childNodes[0].nodeValue;
                                updatedValue = true;
                            }
                        }

                        if (!updatedValue) {
                            selectedText = selectItemTarget.options[0].childNodes[0].nodeValue;
                        }
                    }

                    if (!updatedValue) {
                        selectTarget.classList.add(selectHintClass);
                    } else {
                        selectTarget.classList.remove(selectHintClass);
                    }

                    fw_setSelectedOption(selectTarget, selectItemTarget.selectedIndex);
                }

                //selectTarget.classList.remove(selectOpenClass);
                selectContorlText.innerHTML = selectedText;

                var form = findAncestorByTag(selectTarget, tagName);
                if(typeof form !== "undefined" && selectItemTarget.getAttribute(selectAttrSend) !== null) {
                    form.submit();
                }
            }
        };

        select.onkeydown = function(e) {
            var selectTarget = e.target;
            var key = event.which || event.keyCode;

            if (key == 32) {
                var selectTarget = select.closest(buildAttribute(selectElement));

                if (selectTarget != null) {
                    selectTarget.classList.toggle(selectOpenClass);
                }
            }
        };
    }
}

var StickyScrollManager = (function(){

  domready(initialize);

  function initialize() {
    var sticky = document.getElementsByClassName("sticky-scroll");
    if(sticky.length > 0){
      window.onscroll = function() {setSticky()};
      addStickyListener();
    }
  }

  function setSticky() {
    //check if the scroll reach middle of the page. if so, enable the sticky button. else hide it.
    var html = document.documentElement,
      sticky = document.getElementsByClassName("sticky-scroll");

    var height = Math.max( window.innerHeight, html.clientHeight);
    var scrollingElement = document.scrollingElement || document.documentElement;
    var scrollTop = scrollingElement.scrollTop;

    if (scrollTop > height){
      sticky[0].style.display = 'block';
    }else{
      sticky[0].style.display = 'none';
    }
  }

  function addStickyListener() {
    var sticky = document.querySelector(".sticky-scroll");
    var goToElement = sticky.getAttribute('data-goto');
    sticky.addEventListener("click", function(e){
      var finalPosition = 0;
      if(goToElement && goToElement !== ''){
        var element = document.querySelector(goToElement);
        e.preventDefault();
        if(element){
          var divOffset = offset(element);
          finalPosition = divOffset.top;
        }
      }

      scrollTo(document.body, finalPosition, 200);
    });
  }

  function offset(el) {
    var rect = el.getBoundingClientRect(),
      scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
      scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
  }
})();

function fw_stickyInit() {
     "use strict";

     //Main vars
     var stickyElementClass = "sticky", //classname with no '.'
          stickyActiveClass = "sticky--stuck",
          /*stickyRightClass = "-right",
          stickyLeftClass = "-left",*/
          totalStickyElements = document.getElementsByClassName(stickyElementClass),
          stickyElementTops = [],
          stickyElementLefts = [],
          currentStickyElement,
          maxDocumentHeight = document.body.clientHeight * 2;

     for (currentStickyElement = 0; currentStickyElement < totalStickyElements.length; currentStickyElement++) {
          stickyElementTops[currentStickyElement] = findPos(totalStickyElements[currentStickyElement]).top;
          stickyElementLefts[currentStickyElement] = findPos(totalStickyElements[currentStickyElement]).left;
     }
  
     //Main function
     var nextEleTop = 10;
     function makeSticky() {
          var scroll = window.pageYOffset;

          for (currentStickyElement = 0; currentStickyElement < stickyElementTops.length; currentStickyElement++) {
               var thisEleTop = stickyElementTops[currentStickyElement];

               //console.log(thisEleTop-10+","+stickyElementLefts[currentStickyElement]+"||"+scroll);

               if (scroll > thisEleTop - nextEleTop) {
                    if(!totalStickyElements[currentStickyElement].classList.contains(stickyActiveClass)) {
                         totalStickyElements[currentStickyElement].classList.add(stickyActiveClass);
                         totalStickyElements[currentStickyElement].style.left = stickyElementLefts[currentStickyElement] + "px";
                         totalStickyElements[currentStickyElement].style.top = nextEleTop + "px";
                         nextEleTop = nextEleTop + totalStickyElements[currentStickyElement].offsetHeight + 10;
                    }
               } else {
                    if(totalStickyElements[currentStickyElement].classList.contains(stickyActiveClass)) {
                         nextEleTop = nextEleTop - totalStickyElements[currentStickyElement].offsetHeight - 10;
                         totalStickyElements[currentStickyElement].style.left = "auto";
                         totalStickyElements[currentStickyElement].style.top = "auto";
                         totalStickyElements[currentStickyElement].classList.remove(stickyActiveClass);
                    }
               }
          }
     }

     function findPos(obj) {
          var curleft = 0,
               curtop = 0;

          if (obj.offsetParent) {
               do {
                    curleft += obj.offsetLeft;
                    curtop += obj.offsetTop;
               } while (obj = obj.offsetParent);

               return {
                    top: curtop,
                    left: curleft
               };
          }
     }

     var stickyElementClass = "sticky",
          stickyActiveClass = "sticky--stuck",
          stickyRightClass = "-right",
          stickyLeftClass = "-left",
          totalStickyElements = document.getElementsByClassName(stickyElementClass);

     //Event Listeners
     document.addEventListener("scroll", makeSticky);
}

var TableFilters = (function () {
  var instance;
  var tableFiltersStore;

  var getTableFilters = function () {
    if (!tableFiltersStore) {
      tableFiltersStore = [];
    }
    return tableFiltersStore;
  };

  var getTableFiltersFor = function (dataTableId) {
    var tableFilters = getTableFilters();
    return tableFilters[dataTableId];
  };

  var getFiltersFromColumnIndex = function (dataTableId, columnIndex) {
    var result = null;
    var currentFilters = getTableFiltersFor(dataTableId);
    if (currentFilters) {
      var arr = currentFilters.find(function (filter) {
        return filter[columnIndex];
      });
      if (arr) {
        result = arr[columnIndex];
      }
    }
    return result;
  };

  var getFilterIndex = function (dataTableId, columnIndex) {
    var index;
    var currentFilters = getTableFiltersFor(dataTableId);
    if (currentFilters) {
      index = currentFilters.findIndex(function (filter) {
        return typeof filter[columnIndex] !== 'undefined';
      });
    }
    return index;
  };

  var setNewTableFilterFor = function (tableId, columnIndex, values) {
    var tableFilters = getTableFilters();
    var tableFilterObject = {};

    tableFilterObject[columnIndex] = values;

    if (!tableFilters[tableId]) {
      tableFilters[tableId] = [];
    }
    var filterIndex = getFilterIndex(tableId, columnIndex);
    if (filterIndex === -1) {
      tableFilters[tableId].push(tableFilterObject);
    } else {
      tableFilters[tableId][filterIndex] = tableFilterObject;
    }
  };

  function createInstance() {
    instance = new Object("Table filters instance");
    instance.setNewFilterFor = setNewTableFilterFor;
    instance.getTableFiltersFor = getTableFiltersFor;
    instance.getFiltersFromColumnIndex = getFiltersFromColumnIndex;
    instance.getFilterIndex = getFilterIndex;
    return instance;
  }

  return {
    getInstance: function () {
      if (!instance) {
        instance = createInstance();
      }
      return instance;
    }
  };
})();

var TableManager = (function (LocaleManager, TableFilters) {
  /**
   * TODO minimize the use of isValidTable
   *      by going to higher functions for doing
   *      the check
   */

  /**
   * TODO search and delete aislated usage of classes, for example
   *      create a variable classModalDialog instead of using modal__dialog directly
   */

  /**
   * TODO checkboxes should be gray if any filter is applied about them
   */

  /**
   * TODO add the possibility of changing
   *      the class for hidding rows
   */

  /**
   * TODO refactor tableorders object for merging it with TableFilters
   *      Improve the way we add sort classes and accesibility by separating the logic
   *      Review last code created for improvements
   * */

  /**
   * TODO documentar la función customizeTableRowHeaderCell
   *      explicando que los eventos en las celdas del header
   *      solo se mantendrán si se utiliza la estructura estipulada
   */

  var t = LocaleManager.getInstance().t;

  var instance;

  var tableElementID = 'data-table-id';
  var tableWrapperElement = 'data-dynamic-table-wrapper';
  var tableColumnKey = 'data-table-column-key';
  var tableModalTarget = 'data-table-modal-target';
  var tableSelectAll = 'data-table-select-all';
  var tableOrderTrigger = 'data-table-order-trigger';
  var tableFilterTrigger = 'data-table-filter-trigger';
  var tableOnlySortEnabled = 'data-only-sort-enabled';
  var tableFiltersEnabled = 'data-filters-enabled';
  var tableSpanValuesEnabled = 'data-span-values-enabled';

  var classTableRowHidden = 'hidden';
  var classTableHeader = 'table__header';
  var classTableCellWrapper = 'table__cell-wrapper';
  var classTableButtonOrder = 'btn--order';
  var classTableButtonOrderDesc = 'btn--desc';
  var classTableButtonOrderAsc = 'btn--asc';
  var classTableIconFilterListOff = 'icon--filter-list-off';
  var classTableIconFilterListOn = 'icon--filter-list-on';

  var modalElement = 'data-modal';
  var modalHref = 'data-modal-href';
  var modalTrigger = 'data-modal-trigger';
  var modalTableTrigger = 'data-table-modal-trigger';
  var modalScrollEnabled = 'data-modal-scroll-enabled';
  var modalDialog = 'data-modal-dialog';
  var modalClose = 'data-modal-close';
  var modalAction = 'data-modal-action';

  var classModalFilter = 'modal--filter';
  var classModalBody = 'modal__body';
  var classModalFooter = 'modal__footer';
  var classModalStatusOpen = 'is-modal-open';

  var checkboxSelector = 'input[type="checkbox"]';

  var tableAdditionalClasses = [
    'table',
    'table--borders',
    'table--dynamic'
  ];

  var ariaSort = 'aria-sort';
  var roleColumnHeader = 'columnheader';
  var tableOrders = {};

  var propFix = {
    'cellPadding': 'cellpadding',
    'cellSpacing': 'cellspacing',
    'className': 'class',
    "colSpan": "colspan",
    "contentEditable": "contenteditable",
    "htmlFor": "for",
    "frameBorder": "frameborder",
    "maxLength": "maxlength",
    "readOnly": "readonly",
    "rowSpan": "rowspan",
    "tabIndex": "tabindex",
    "useMap": "usemap"
  };

  function createInstance() {
    instance = new Object("Dynamic Table Manager instance");
    instance.fw_dynamicTableInit = dynamicTableInit;
    //instance.fw_registerOnRenderFinishEvent = registerRenderEvent;
    return instance;
  }

  var createElement = function (tagName, attrsObject, children) {
    var element = document.createElement(tagName);
    if (attrsObject) {
      var attrs = Object.keys(attrsObject);
      for (var i = 0; i < attrs.length; i++) {
        var currentAttr = attrs[i];
        if(currentAttr in propFix){
          element.setAttribute(propFix[currentAttr], attrsObject[currentAttr]);
        }else{
          element.setAttribute(currentAttr, attrsObject[currentAttr]);
        }
      }
    }
    for (var j = 0; children && j < children.length; j++) {
      var currentChildren = children[j];
      if (currentChildren instanceof Element) {
        element.insertAdjacentElement('beforeend', currentChildren);
      } else {
        var textNode = document.createTextNode(currentChildren);
        element.appendChild(textNode);
      }
    }
    return element;
  };

  function buildAttribute(name) {
    return "[" + name + "]";
  }

  function findAttrAncestor(el, attr) {
    while ((el = el.parentElement) && el.getAttribute(attr) === null) {
      ;
    }

    if (typeof el === "undefined") {
      el = null;
    }

    return el;
  }

  var getElementLocation = function (element) {
    var finalLocation = {
      top: element.offsetTop,
      left: element.offsetLeft
    };
    if (typeof Element.prototype.getBoundingClientRect !== 'undefined') {
      var bounding = element.getBoundingClientRect();
      var scrollTop = document.documentElement.scrollTop;
      finalLocation.top = scrollTop + bounding.top;
    }
    return finalLocation;
  };

  var getEventLocation = function (event) {
    var targetElement = event.target;
    var location;
    // If it's a keyboard event or mouse event, different values are used for setting the modal position
    if (event.pageX !== 0) {
      location = {
        top: event.pageY + targetElement.clientHeight,
        left: event.pageX + targetElement.clientWidth
      };
    } else {
      location = {
        top: targetElement.offsetTop + targetElement.clientHeight,
        left: targetElement.offsetLeft + targetElement.clientWidth
      };
    }
    return location;
  };

  var addClassesTo = function (element, classes) {
    for (var i = 0; i < classes.length; i++) {
      var currentClass = classes[i];
      element.classList.add(currentClass);
    }
  };

  var sanitizeString = function (string) {
    if(String.prototype.normalize){
      return string && string.normalize('NFKD').replace(/[^\w]/g, '').trim();
    }else{
      return string.trim();
    }
  };

  var sanitizeEmptyValues = function (values) {
    return values.map(function (currentValue) {
      return currentValue.trim() !== '' ? currentValue : t('(Empty)');
    });
  };

  var parseHTMLListToArray = function (nodeList) {
    return [].slice.call(nodeList);
  };

  var parseHTMLToString = function (html) {
    var regex = /(<([^>]+)>)/ig;
    return html.replace(regex, "");
  };

  var isValidTable = function (table) {
    return table && table.matches('table');
  };

  var isImmediateChild = function (tolerance, child, element) {
    var i = 0;
    var temp = child;
    var isImmediateChildren = false;
    while (i < tolerance || !isImmediateChildren) {
      if (temp.parentElement === element) {
        isImmediateChildren = true;
      } else {
        temp = temp.parentElement;
      }
      i++;
    }
    return isImmediateChildren;
  };

  var isSpanValuesEnabledFor = function (cell) {
    var result = false;
    var columnIndex = cell.cellIndex;
    var table = findAttrAncestor(cell, tableElementID);
    var tableHeader = getTableRowHead(table);
    var tableHeaderCell = tableHeader.children[columnIndex];
    if (tableHeaderCell.matches(buildAttribute(tableSpanValuesEnabled))) {
      result = true;
    }
    return result;
  };

  var isModeShowSelectedEnabled = function () {
    return true;
  };

  var isCheckedInputFor = function (checkBoxElement) {
    return checkBoxElement.querySelector(checkboxSelector).checked || checkBoxElement.checked;
  };

  var sortArrayComparedWith = function (messyArray, arrayToCompare) {
    var reversedArray = arrayToCompare.reverse();
    reversedArray.forEach(function (currentCompareArrayItem) {
      var found = false;
      for (var i = 0; i < messyArray.length && !found; i++) {
        var currentMessyArrayItem = messyArray[i];
        if (currentMessyArrayItem === currentCompareArrayItem) {
          var firstMessyArrayItem = currentCompareArrayItem.parentElement.children[0];
          currentCompareArrayItem.parentElement.insertBefore(currentMessyArrayItem, firstMessyArrayItem);
          found = true;
        }
      }
    });
  };

  var sortTableByColumnIndex = function (table, columnIndex, isAscendingMode) {
    var tableRowsArray = getTableRowsContent(table);
    var sortedArray = tableRowsArray.sort(sortTableRow.bind(this, columnIndex, isAscendingMode));
    sortArrayComparedWith(tableRowsArray, sortedArray);
  };

  var fitAllFilters = function (currentTableRow, columnExceptionIndex, activeFilter) {
    var fitAllFiltersBool = false;
    var currentFilterKey = Object.keys(activeFilter)[0];
    var currentFilter = activeFilter[currentFilterKey];

    if(parseInt(currentFilterKey) === parseInt(columnExceptionIndex)){
      fitAllFiltersBool = true;
    }else{
      fitAllFiltersBool = currentTableRow.every(function (currentColumn, currentColumnIndex) {
        if (currentColumnIndex !== parseInt(currentFilterKey)) {
          return true;
        } else {
          return currentFilter.some(function (filter) {
            return currentColumn.includes(filter);
          });
        }
      });
    }
    return fitAllFiltersBool;
  };

  var filterRows = function (tableIdValue, currentColumnIndex, currentTableRow) {
    var filters = TableFilters.getInstance().getTableFiltersFor(tableIdValue);
    var ignoreIfFirstFilter = false;
    if( filters && filters.length > 0){
      var firstFilter = filters[0];
      var firstFilterKey =  Object.keys(firstFilter)[0];
      if(parseInt(firstFilterKey) === parseInt(currentColumnIndex)){
        ignoreIfFirstFilter = true;
      }
    }
    return !filters || ignoreIfFirstFilter?
      true
      : filters.every(fitAllFilters.bind(this, currentTableRow, currentColumnIndex));
  };

  var getPossibleValuesFromColumnIndex = function (tableIdValue, currentColumnIndex) {
    var tableData = getTableData(tableIdValue);
    var filtered = tableData.filter(filterRows.bind(this, tableIdValue, currentColumnIndex));

    var possibleValues = [];
    filtered.forEach(function (currentValue) {
      currentValue[currentColumnIndex].forEach(function (val) {
        var cleanVal = val.trim();
        if (!possibleValues.includes(cleanVal)) {
          possibleValues.push(cleanVal);
        }
      });
    });

    return possibleValues;
  };

  var getTableData  = function (tableId) {
    var table = getTableById(tableId);
    var tableObject = [];
    var tableRows = getTableRowsContent(table);
    tableRows.forEach(function (tableRow) {
      var tableCells = getImmediateChildrenArrayBySelector(tableRow, 'td');
      tableObject.push(tableCells.map(getCellValues));
    });
    return tableObject;
  };

  var getTableRows = function (table) {
    var result = null;
    if (isValidTable(table)) {
      result = getImmediateChildrenArrayBySelector(table, 'tr');
    }
    return result;
  };

  var getTableRowHead = function (table) {
    var result = null;
    if (isValidTable(table)) {
      var tableRows = getTableRows(table);
      result = tableRows.shift();
    }
    return result;
  };

  var getTableRowsContent = function (table) {
    var result = null;
    if (isValidTable(table)) {
      var rowsContent = getTableRows(table);
      rowsContent.shift();
      result = rowsContent;
    }
    return result;
  };

  var getImmediateChildrenArrayBySelector = function (element, selector) {
    var result = null;
    var childrenNodeList = element.querySelectorAll(selector);
    var toleranceLevels = selector !== 'tr' ? 1 : 2;
    if (childrenNodeList) {
      var childrenArray = parseHTMLListToArray(childrenNodeList);
      result = childrenArray.filter(function (child) {
        return isImmediateChild(toleranceLevels, child, element);
      });
    }
    return result;
  };

  var getTableColumnKey = function (cell){
    var result = cell.textContent || null;
    var tableColumnKeyAttr = cell.getAttribute(tableColumnKey);
    if(tableColumnKeyAttr !== null){
      result = tableColumnKeyAttr.trim();
    }
    return result;
  };

  var getCellValues = function (cell) {
    var result = [];
    if (cell) {
      var cellValuesNodeList = cell.querySelectorAll('span');
      if (cellValuesNodeList.length > 0 && isSpanValuesEnabledFor(cell)) {
        var cellValuesArray = parseHTMLListToArray(cellValuesNodeList);
        result = cellValuesArray.map(function (value) {
          return value.textContent.trim();
        });
      } else {
        result = [cell.textContent.trim()];
      }
    }
    return result;
  };

  var setCheckboxChecked = function (checkbox) {
    var finalCheckbox = checkbox.matches(checkboxSelector) ? checkbox : checkbox.querySelector(checkboxSelector);
    if (finalCheckbox) {
      finalCheckbox.setAttribute('checked', '');
    }
  };

  /**
   * Function to swap TRs if a some
   * conditions are true.
   * @param row1
   * @param row2
   * @param colIndex
   * @param {boolean} isAscendingMode=true
   */
  var sortTableRow = function (colIndex, isAscendingMode, row1, row2) {
    var result = 0;
    if (isAscendingMode === true || isAscendingMode === false) {
      var var1 = sanitizeString(parseHTMLToString(row1.children[colIndex].innerHTML));
      var var2 = sanitizeString(parseHTMLToString(row2.children[colIndex].innerHTML));

      var isGreaterThan = var1 > var2;
      var isLowerThan = var1 < var2;

      if (isAscendingMode === false) {
        var tmp = isGreaterThan;
        isGreaterThan = isLowerThan;
        isLowerThan = tmp;
      }

      if (isLowerThan) {
        result = -1;
      }
      if (isGreaterThan) {
        result = 1;
      }
    }
    return result;
  };

  var sortCheckboxesAlphabetically = function (a, b) {
    var realA = sanitizeString(a.querySelector(checkboxSelector).value);
    var realB = sanitizeString(b.querySelector(checkboxSelector).value);
    if (realA < realB) {
      return -1;
    }
    if (realA > realB) {
      return 1;
    }
    return 0;
  };

  var sortCheckboxesCheckedUp = function (a, b) {
    var result = 0;
    var realA = a.querySelector(checkboxSelector);
    var realB = b.querySelector(checkboxSelector);
    if (realA.checked && !realB.checked) {
      result = -1;
    } else if (!realA.checked && realB.checked) {
      result = 1;
    }
    return result;
  };

  var removeClassHidden = function (element) {
    element.classList.remove(classTableRowHidden);
  };

  var applyFilters = function (dataTableId, table) {
    var tableRowsContent = getTableRowsContent(table);
    var filters = TableFilters.getInstance().getTableFiltersFor(dataTableId);

    tableRowsContent.forEach(function (currentRow) {
      var tableCells = getImmediateChildrenArrayBySelector(currentRow, 'td');
      var isARowMatch = filters.some(function (currentFilter) {
        return tableCells.every(function (currentCell, cellIndex) {
          var isACellMatch = true;
          if (currentFilter[cellIndex]) {
            var cellValues = getCellValues(currentCell);
            isACellMatch = cellValues.every(function (value) {
              return isModeShowSelectedEnabled() ?
                !currentFilter[cellIndex].includes(value)
                : currentFilter[cellIndex].includes(value);
            });
          }
          return isACellMatch;
        });
      });
      if (isARowMatch) {
        currentRow.classList.add(classTableRowHidden);
      }
    });
  };

  var getOrderIcons = function (isAscending, isIconEnabled) {
    var iconClasses = null;
    var iconText = null;
    var iconLabel = null;

    if (isAscending) {
      iconClasses = ['icon', 'icon--smal', 'icon--arrow-drop-up'];
      iconText = t('Order from A -> Z');
      iconLabel = t('Ascending order');
    } else {
      iconClasses = ['icon', 'icon--smal', 'icon--arrow-drop-down'];
      iconText = t('Order from Z -> A');
      iconLabel = t('Descending order');
    }

    var spanVisible = null;
    var spanVisibleAttrs = {};
    spanVisibleAttrs['aria-hidden'] = 'true';

    if (isIconEnabled) {
      spanVisibleAttrs.className = iconClasses.join(' ');
      spanVisible = createElement('span', spanVisibleAttrs);
    } else {
      spanVisible = createElement('span', spanVisibleAttrs, [iconText]);
    }

    var spanHiddenAttrs = {};
    spanHiddenAttrs.className = ['visually-hidden'].join(' ');
    var spanHidden = createElement('span', spanHiddenAttrs, [iconLabel]);
    return {
      visible: spanVisible,
      hidden: spanHidden
    };
  };

  var getOrderButtons = function (dataTableId, isIconEnabled, columnIndex) {
    var ascOrderIcons = getOrderIcons(true, isIconEnabled);
    var descOrderIcons = getOrderIcons(false, isIconEnabled);

    var buttonOrderAscendantAttrs = {};
    buttonOrderAscendantAttrs.className = ['btn', classTableButtonOrder, classTableButtonOrderAsc].join(' ');
    buttonOrderAscendantAttrs.type = 'button';
    if (!isIconEnabled) {
      buttonOrderAscendantAttrs[modalAction] = '';
    }
    buttonOrderAscendantAttrs[tableOrderTrigger] = columnIndex;

    var buttonOrderAscendant = createElement('button', buttonOrderAscendantAttrs, [
      ascOrderIcons.hidden,
      ascOrderIcons.visible
    ]);

    var buttonOrderDescendantAttrs = {};
    buttonOrderDescendantAttrs.className = ['btn', classTableButtonOrder, classTableButtonOrderDesc].join(' ');
    buttonOrderDescendantAttrs.type = 'button';
    if (!isIconEnabled) {
      buttonOrderDescendantAttrs[modalAction] = '';
    }
    buttonOrderDescendantAttrs[tableOrderTrigger] = columnIndex;

    var buttonOrderDescendant = createElement('button', buttonOrderDescendantAttrs, [
      descOrderIcons.hidden,
      descOrderIcons.visible
    ]);

    var orderButtonBoxAttrs = {};
    orderButtonBoxAttrs.className = ['btn-group'].join(' ');
    var orderButtonsBox = createElement('div', orderButtonBoxAttrs);

    orderButtonsBox.insertAdjacentElement('beforeend', buttonOrderAscendant);
    orderButtonsBox.insertAdjacentElement('beforeend', buttonOrderDescendant);

    if (tableOrders) {
      var tableOrder = tableOrders[dataTableId];
      if (tableOrder && parseInt(tableOrder.orderBy) === columnIndex) {
        var orderDirection = tableOrder.direction;
        if (orderDirection === 'asc') {
          orderButtonsBox.classList.add('btn-group--asc');
        }
        if (orderDirection === 'desc') {
          orderButtonsBox.classList.add('btn-group--desc');
        }
      }
    }

    return orderButtonsBox;
  };

  var getModalButton = function (dataTableId) {
    var filterIconAttrs = {};
    filterIconAttrs.className = ['icon', 'icon--small', classTableIconFilterListOff].join(' ');
    var filterIcon = createElement('span', filterIconAttrs);

    var modalBtnAttrs = {};
    modalBtnAttrs.className = ['btn'].join(' ');
    modalBtnAttrs.title = t('Filter');
    modalBtnAttrs[modalTrigger] = '';
    modalBtnAttrs[modalTableTrigger] = '';
    modalBtnAttrs[modalHref] = dataTableId ? '#modal-' + dataTableId : '';
    return createElement('button', modalBtnAttrs, [filterIcon]);
  };

  var getTableID = function (table) {
    return table.getAttribute(tableElementID) || null;
  };

  var getTableById = function (tableId) {
    return document.querySelector('[' + tableElementID + '="' + tableId + '"]');
  };

  var customizeTableRowHeaderCell = function (dataTableId, tableCell) {
    var oldContent = null;
    var customConfigValue = '';
    var columnKeyContainer = tableCell.querySelector(buildAttribute(tableColumnKey));
    tableCell.setAttribute('role', roleColumnHeader);
    tableCell.setAttribute(tableColumnKey, getTableColumnKey(tableCell));
    if (tableCell.getAttribute(tableFiltersEnabled) !== null) {
      customConfigValue = tableFiltersEnabled;
    } else if (tableCell.getAttribute(tableOnlySortEnabled) !== null) {
      customConfigValue = tableOnlySortEnabled;
    }

    if (customConfigValue !== '') {
      if (!columnKeyContainer) {
        columnKeyContainer = createElement('div', null);

        oldContent = tableCell.innerHTML;
        tableCell.innerHTML = '';

        columnKeyContainer.classList.add(classTableCellWrapper);
        columnKeyContainer.insertAdjacentHTML('beforeend', oldContent);
        tableCell.insertAdjacentElement('beforeend', columnKeyContainer);
      }
    }

    switch (customConfigValue) {
      case tableOnlySortEnabled:
        var orderButtons = getOrderButtons(dataTableId, true, tableCell.cellIndex);
        columnKeyContainer.insertAdjacentElement('beforeend', orderButtons);
        break;
      case tableFiltersEnabled:
        var modalButton = getModalButton(dataTableId);
        columnKeyContainer.insertAdjacentElement('beforeend', modalButton);
        break;
    }
  };

  var setTableRowHeaderClassFor = function (table) {
    if (isValidTable(table)) {
      var currentTableHeader = table.getElementsByClassName(classTableHeader)[0];
      if (!currentTableHeader) {
        var tableHeader = table.querySelector('thead');
        if (!tableHeader) {
          tableHeader = getTableRowHead(table);
        }
        tableHeader.classList.add(classTableHeader);
      }
    }
  };

  var getModalHeader = function (modalTitle) {
    var closeIconAttrs = {};
    closeIconAttrs.className = ['icon', 'icon--close', 'icon--small'].join(' ');
    closeIconAttrs['aria-hidden'] = 'true';
    var closeIcon = createElement('span', closeIconAttrs);

    var closeButtonLabelAttrs = {};
    closeButtonLabelAttrs.className = ['visually-hidden'].join(' ');
    var closeButtonsLabel = createElement('span', closeButtonLabelAttrs, [t('Close modal window')]);

    var closeButtonAttrs = {};
    closeButtonAttrs.type = 'button';
    closeButtonAttrs.className = ['btn', 'btnlink'].join(' ');
    closeButtonAttrs[modalClose] = '';
    closeButtonAttrs[modalAction] = '';
    var closeButton = createElement('button', closeButtonAttrs, [closeIcon, closeButtonsLabel]);

    var modalHeaderAttrs = {};
    modalHeaderAttrs.className = ['modal__header'].join(' ');
    return createElement('div', modalHeaderAttrs, [modalTitle, closeButton]);
  };

  var getCheckbox = function (value) {
    var inputId = 'input-' + guid();

    var iconElementAttrs = {};
    iconElementAttrs['aria-hidden'] = 'true';
    iconElementAttrs.className = ['icon', 'icon--checkbox-off', 'icon--small'].join(' ');
    var iconElement = createElement('span', iconElementAttrs);

    var inputElementAttrs = {};
    inputElementAttrs.type = 'checkbox';
    inputElementAttrs.value = value !== t('(Empty)') ? value : '';
    inputElementAttrs.id = inputId;
    var inputElement = createElement('input', inputElementAttrs);

    var labelElementAttrs = {};
    labelElementAttrs.htmlFor = inputId;
    var labelElement = createElement('label', labelElementAttrs, [value, inputElement, iconElement]);

    var formCheckAttrs = {};
    formCheckAttrs.className = ['form-check', 'form__check'].join(' ');
    return createElement('div', formCheckAttrs, [labelElement]);
  };

  var setCheckedSelectedValues = function (dataTableId, checkboxes, columnKeyIndex) {
    var currentFilters = TableFilters.getInstance().getFiltersFromColumnIndex(dataTableId, columnKeyIndex);
    checkboxes.forEach(function (currentCheckboxElement) {
      var currentCheckboxElementValue = currentCheckboxElement.querySelector(checkboxSelector).value;
      if(currentFilters && currentFilters.includes(currentCheckboxElementValue)){
        currentCheckboxElement.classList.add('is-active');
      }
      if (!currentFilters || currentFilters.includes(currentCheckboxElementValue)) {
        setCheckboxChecked(currentCheckboxElement);
      }
    });
    return checkboxes.every(isCheckedInputFor);
  };

  var getModalBody = function (tableIdValue, columnKeyIndex) {
    var possibleColumnValues = getPossibleValuesFromColumnIndex(tableIdValue, columnKeyIndex);

    var checkboxes = sanitizeEmptyValues(possibleColumnValues).map(getCheckbox);
    var finalChecks = checkboxes;
    finalChecks.sort(sortCheckboxesAlphabetically);

    var areAllChecked = setCheckedSelectedValues(tableIdValue, checkboxes, columnKeyIndex);

    finalChecks.sort(sortCheckboxesCheckedUp);

    var selectAllCheckbox = getCheckbox(t('Select all'));
    selectAllCheckbox.querySelector('label').setAttribute(tableSelectAll, '');
    if (areAllChecked) {
      setCheckboxChecked(selectAllCheckbox);
    }

    finalChecks.unshift(selectAllCheckbox);

    var modalBodyElementAttrs = {};
    modalBodyElementAttrs.className = [classModalBody].join(' ');
    return createElement('div', modalBodyElementAttrs, finalChecks);
  };

  var getModalFooterButtons = function (columnKeyIndex) {
    var applyButtonAttrs = {};
    applyButtonAttrs.title = t('Apply');
    applyButtonAttrs.type = 'button';
    applyButtonAttrs.className = ['btn', 'btn--primary', 'form__button'].join(' ');
    applyButtonAttrs[tableFilterTrigger] = columnKeyIndex;
    applyButtonAttrs[modalAction] = '';
    var applyButton = createElement('button', applyButtonAttrs, [t('Apply')]);

    var cancelButtonAttrs = {};
    cancelButtonAttrs.title = t('Cancel');
    cancelButtonAttrs.type = 'button';
    cancelButtonAttrs.className = ['btn', 'btn--primary', 'form__button'].join(' ');
    cancelButtonAttrs[modalClose] = '';
    cancelButtonAttrs[modalAction] = '';
    var cancelButton = createElement('button', cancelButtonAttrs, [t('Cancel')]);

    var modalFooterAttrs = {};
    modalFooterAttrs.className = classModalFooter;
    return createElement('div', modalFooterAttrs, [applyButton, cancelButton]);
  };

  var modalClickOutHandler = function (ev) {
    var modal = findAttrAncestor(ev.target, modalElement);
    var filterTrigger = findAttrAncestor(ev.target, modalTrigger) || event.target;
    if (filterTrigger === null && modal === null) {
      var modalFiltersNodelist = document.querySelectorAll('.' + classModalFilter);
      var modalFilters = parseHTMLListToArray(modalFiltersNodelist);
      modalFilters.forEach(function (currentModalFilter) {
        if (currentModalFilter.classList.contains(classModalStatusOpen)) {
          var closeTrigger = currentModalFilter.querySelector(buildAttribute(modalClose));
          triggerFakeClickTo(closeTrigger);
        }
      });
    }
  };

  var orderTriggerHandler = function (event) {
    var target = event.target;
    var columnIndex = null;
    var tableId;

    var orderTriggerButton = findAttrAncestor(target, tableOrderTrigger) || target;
    var orderTriggerButtonValue = orderTriggerButton.getAttribute(tableOrderTrigger);
    if (orderTriggerButton !== null && orderTriggerButton !== '') {
      columnIndex = orderTriggerButtonValue;
    }

    var tableTarget = findAttrAncestor(target, tableElementID);

    if (tableTarget === null) {
      var modal = findAttrAncestor(target, modalElement);
      tableId = modal.getAttribute(tableModalTarget);
      tableTarget = getTableById(tableId);
    } else {
      tableId = tableTarget.getAttribute(tableElementID);
    }

    var isAscendingMode = orderTriggerButton.classList.contains(classTableButtonOrderAsc) ||
      !orderTriggerButton.classList.contains(classTableButtonOrderDesc);

    if (tableTarget !== null && columnIndex !== null) {
      sortTableByColumnIndex(tableTarget, columnIndex, isAscendingMode);

      var finalOrder = {
        orderBy: columnIndex
      };
      if (isAscendingMode) {
        finalOrder.direction = 'asc';
      } else {
        finalOrder.direction = 'desc';
      }
      tableOrders[tableId] = finalOrder;

      var chosenBtnGroup = orderTriggerButton.parentElement;
      var btnGroupsNodeList = tableTarget.querySelectorAll('.btn-group');
      var btnGroupsArray = parseHTMLListToArray(btnGroupsNodeList);
      btnGroupsArray.forEach(function (curBtnGroup) {
        curBtnGroup.classList.remove('btn-group--desc');
        curBtnGroup.classList.remove('btn-group--asc');
        var tableHeader = findAncestorByTag(curBtnGroup, 'th');
        if (tableHeader) {
          tableHeader.removeAttribute(ariaSort);
        }
      });

      var chosenTableHeader = findAncestorByTag(chosenBtnGroup, 'th');
      if (isAscendingMode) {
        chosenBtnGroup.classList.add('btn-group--asc');
        chosenBtnGroup.classList.remove('btn-group--desc');
        if(chosenTableHeader) {
          chosenTableHeader.setAttribute(ariaSort, 'ascending');
        }
      } else {
        chosenBtnGroup.classList.add('btn-group--desc');
        chosenBtnGroup.classList.remove('btn-group--asc');
        if(chosenTableHeader){
          chosenTableHeader.setAttribute(ariaSort, 'descending');
        }
      }
    }
  };

  var filterTriggerHandler = function (event) {
    var target = findAttrAncestor(event.target, tableFilterTrigger) || event.target;
    var columnIndex = target.getAttribute(tableFilterTrigger);
    var dataTableModalTarget = findAttrAncestor(target, tableModalTarget);
    var dataTableId = dataTableModalTarget.getAttribute(tableModalTarget);
    var table = getTableById(dataTableId);
    var modalDialogElement = findAttrAncestor(target, modalDialog);
    var checkedInputsNodeList = modalDialogElement.querySelectorAll(checkboxSelector + ':checked');
    var checkedInputsArray = parseNodeList(checkedInputsNodeList);
    var values = checkedInputsArray.map(function (currentCheckbox) {
      return currentCheckbox.value;
    });

    TableFilters.getInstance().setNewFilterFor(dataTableId, columnIndex, values);

    var filters = TableFilters.getInstance().getTableFiltersFor(dataTableId);
    if (filters) {
      var currentColumnFilter = filters.find(function (filter) {
        var filterKey = Object.keys(filter)[0];
        if(parseInt(filterKey) === parseInt(columnIndex)){
          return true;
        }
      });
      var currentColumnHasFilterEnabled = typeof currentColumnFilter !== 'undefined';
      var tableRowHead = getTableRowHead(table);
      var tableRowHeadCells = getImmediateChildrenArrayBySelector(tableRowHead, 'th');
      var currentCellIndex = tableRowHeadCells[columnIndex];
      var iconSelector = buildAttribute(modalTrigger) + ' .icon';
      var currentCellIndexFilterButton = currentCellIndex.querySelector(iconSelector);
      if (currentColumnHasFilterEnabled) {
        currentCellIndexFilterButton.classList.add(classTableIconFilterListOn);
        currentCellIndexFilterButton.classList.remove(classTableIconFilterListOff);
      } else {
        currentCellIndexFilterButton.classList.add(classTableIconFilterListOff);
        currentCellIndexFilterButton.classList.remove(classTableIconFilterListOn);
      }
    }

    var tableContent = getTableRowsContent(table);
    tableContent.forEach(removeClassHidden);
    applyFilters(dataTableId, table);
  };

  var toggleInputsHandler = function (event) {
    var selectAllLabel = findAttrAncestor(event.target, tableSelectAll) || event.target;
    var selectAllCheckbox = selectAllLabel.querySelector(checkboxSelector);
    var modalDialogElement = findAttrAncestor(selectAllLabel, modalDialog);
    var inputsNodeList = modalDialogElement.querySelectorAll(checkboxSelector);
    var inputsArray = parseHTMLListToArray(inputsNodeList);

    if (selectAllCheckbox.checked) {
      inputsArray.forEach(function (input) {
        input.setAttribute('checked', '');
      });
    } else {
      inputsArray.forEach(function (input) {
        input.removeAttribute('checked');
      });
    }
  };

  var showModalHandler = function (event) {
    var target = findAttrAncestor(event.target, modalTrigger) || event.target;

    if(target.getAttribute(modalTableTrigger) === null){
      return;
    }

    var columnKey = findAttrAncestor(target, tableColumnKey);
    var tableHeaderCell = findAncestorByTag(target, 'th') || findAncestorByTag(target, 'td');


    var modalTarget = target.getAttribute(modalHref) || null;
    var modalWrapper = modalTarget !== null ? document.querySelector(modalTarget) : null;
    var modalDialogElement = modalWrapper !== null ? modalWrapper.querySelector(buildAttribute(modalDialog)) : null;
    var tableElement = findAttrAncestor(target, tableElementID);
    var tableIdValue = tableElement ? tableElement.getAttribute(tableElementID) : null;

    var eventLocation = getEventLocation(event);
    setModalLocation(modalWrapper, eventLocation);
    if (columnKey && modalDialogElement && tableHeaderCell && tableIdValue) {
      modalDialogElement.innerHTML = '';
      var columnKeyValue = columnKey.getAttribute(tableColumnKey) || null;
      if (columnKeyValue !== null && columnKeyValue !== '') {
        var columnKeyIndex = tableHeaderCell.cellIndex;
        showModal(tableIdValue, modalDialogElement, columnKeyIndex, columnKeyValue);
      }
    }
  };

  var showModal = function (tableIdValue, modalDialog, columnKeyIndex, columnKeyValue) {
    var modalHeader = getModalHeader(columnKeyValue);
    modalDialog.appendChild(modalHeader, null);

    var orderButtons = getOrderButtons(tableIdValue, false, columnKeyIndex);
    modalDialog.appendChild(orderButtons, null);

    var modalBody = getModalBody(tableIdValue, columnKeyIndex);
    modalDialog.appendChild(modalBody, null);

    var footerButtons = getModalFooterButtons(columnKeyIndex);
    modalDialog.appendChild(footerButtons, null);
  };

  var setModalWrapperFor = function (table) {
    var dataTableID = getTableID(table);

    var modalDialogAttrs = {};
    modalDialogAttrs.className = ['form', 'form--filters', 'modal__dialog'].join(' ');
    modalDialogAttrs['aria-hidden'] = 'true';
    modalDialogAttrs[modalDialog] = '';
    var modalDialogElement = createElement('form', modalDialogAttrs);

    var modalWrapperAttrs = {};
    modalWrapperAttrs[tableModalTarget] = dataTableID;
    modalWrapperAttrs.id = 'modal-' + dataTableID;
    modalWrapperAttrs.className = ['modal', classModalFilter].join(' ');
    modalWrapperAttrs[modalElement] = '';
    modalWrapperAttrs[modalScrollEnabled] = 'false';
    var modalWrapper = createElement('div', modalWrapperAttrs, [modalDialogElement]);

    document.querySelector('body').appendChild(modalWrapper);

    window.addEventListener('load', setModalInitialLocation.bind(this, modalWrapper, table));
  };

  var setModalInitialLocation = function (modalWrapper, elementReference) {
    var location = getElementLocation(elementReference);
    setModalLocation(modalWrapper, location);
  };

  var getAdjustedHorizontalPosition = function(leftPoint){
    var finalLeftLocation = leftPoint;
    var modalWidth = 320;
    var minimalMargin = 12;
    var screenWidth = getScreenFullWidth();
    if(screenWidth - leftPoint < modalWidth - minimalMargin){
      finalLeftLocation = screenWidth - modalWidth - minimalMargin;
    }else if(leftPoint < 332){
      finalLeftLocation = minimalMargin;
    }

    return finalLeftLocation;
  };

  function setModalLocation(modalWrapper, location) {
    var finalX = '0';
    var finalY = '0';
    var screenWidth = getScreenFullWidth();
    if(modalWrapper){
      if (screenWidth > 767) {
        location.left = getAdjustedHorizontalPosition(location.left);

        finalX = location.left + 'px';
        finalY = location.top + 'px';
      }
      modalWrapper.style.top = finalY;
      modalWrapper.style.left = finalX;
    }
  }

  var customizeTableHeaderRow = function (table) {
    var tableRowFirst = getTableRowHead(table);
    var dataTableId = getTableID(table);
    var children = getImmediateChildrenArrayBySelector(tableRowFirst, 'th');
    children.forEach(customizeTableRowHeaderCell.bind(this, dataTableId));

    setTableRowHeaderClassFor(table);
  };

  var stylishTable = function (table) {
    if (isValidTable(table)) {
      // TODO remove using addClassesTo and tableAdditionalClasses
      addClassesTo(table, tableAdditionalClasses);
      customizeTableHeaderRow(table);
    }
  };

  var dynamicTableInit = function () {

    var wrappers = document.querySelectorAll(buildAttribute(tableWrapperElement));
    for (var i = 0; i < wrappers.length; i++) {
      var currentWrapper = wrappers[i];
      var currentTable = currentWrapper.querySelector('table');
      currentTable.setAttribute(tableElementID, guid());
      stylishTable(currentTable);
      setModalWrapperFor(currentTable);
    }

    setTableListeners();
  };

  var setTableListeners = function () {
    document.querySelector('body').addDelegateListener('click',
      buildAttribute(modalTrigger), showModalHandler);

    document.querySelector('body').addDelegateListener('click',
      buildAttribute(tableOrderTrigger), orderTriggerHandler);

    document.querySelector('body').addDelegateListener('click',
      buildAttribute(tableFilterTrigger), filterTriggerHandler);

    document.querySelector('body').addDelegateListener('click',
      buildAttribute(tableSelectAll), toggleInputsHandler);

    document.addEventListener('click', modalClickOutHandler);
  };

  return {
    getInstance: function () {
      if (!instance) {
        instance = createInstance();
      }
      return instance;
    }
  };
})(LocaleManager, TableFilters);

function fw_tabsInit() {
	"use strict";
	
	//Main vars
	var tabsSystem = "[data-tab-system]",
		tabTrigger = "[data-tab-trigger]",
		tabContent = "[data-tab-content]",
		activeClass = "is-active",
		activeElement = "." + activeClass;
	
	
	//Main tabs function
	function fw_tabs(e) {
		
		var elTrigger = e.target,
			targetTab,
			parentTabSystem;
		
		e.preventDefault();

		//check if elTrigger matches tabTrigger
		while (!elTrigger.matches(tabTrigger)) {
			elTrigger = elTrigger.parentNode;
		}	
		
		targetTab = document.querySelector(elTrigger.getAttribute("href"));

		// Look for the parent tab system
		parentTabSystem = e.target.parentNode;

		while (!parentTabSystem.matches(tabsSystem) && (parentTabSystem.tagName !== "BODY")) {
			parentTabSystem = parentTabSystem.parentNode;
		}
		if (parentTabSystem.tagName === "BODY") {
			parentTabSystem = false;
		}

		//Remove active classes	if they exist
		if (parentTabSystem.querySelector(tabContent + activeElement)) {
			parentTabSystem.querySelector(tabContent + activeElement).classList.remove(activeClass);
		}
		if (parentTabSystem.querySelector(tabTrigger + activeElement)) {
			parentTabSystem.querySelector(tabTrigger + activeElement).classList.remove(activeClass);
		}
		
		//Add active classes to target block and trigger
		targetTab.classList.add(activeClass);
		elTrigger.classList.add(activeClass);
	}

	
	//Event Listeners
	document.querySelector("body").addDelegateListener("click", tabTrigger, function (e) {fw_tabs(e); });

	
}

var YoutubeManager = (function (PlayerManager) {
  "use strict";

  var instance;

  var cnParent = "data-video",
      cnPlayButton = "[data-video-play]",
      cnPlayOnLoad = "data-video-playonload",
      cnHiddens = "[data-video-hidden]",
      cnImage = "[data-video-img]",
      cnContainerText = "[data-video-container]",
      cnLock = "data-video-lock",
      cnVideoTime = "data-video-time",
      cnVideoPreview = "data-video-preview",
      cnSubtitleLanguage = "data-subtitle-language",
      cnIframe = "[data-video-id]",
      attrVideoId = "data-video-id",
      attrVideoAuto = "data-video-autoplay",
      attrLoopMode = "data-loop-mode",
      attrModalTrigger = "data-modal-trigger",
      attrPlayHidden = "data-play-hidden",
      attrModal = "data-modal",
      attrSrc = 'data-src',
      classCardEmbeddedVideo = ".card__embedded-video",
      classTint = ".banner-full__tint",
      classCard = '.card',
      classWrapperImage = '.img-wpr__cover',
      classCardText = '.card-text',
      classCardContents = '.img-wpr__contents',
      classTestimoniVideos = '.testimoni-videos',
      classVideoIframe = '.embedded-video__iframe',
      classVideoTime = '.card__video__time',
      testimoniSmall = "small-video",
      switchVideo = false,
      volume = 100;

  function buildAttribute(name) {
    return "[" + name + "]";
  }

  function findAttrAncestor(el, attr) {
    var finalEl = null;

    while(el.parentElement){
      if(el.parentElement.getAttribute(attr) !== null){
        finalEl = el.parentElement;
      }
      el = el.parentElement;
    }

    return finalEl;
  }

  function createInstance() {
    instance = new Object("Modal Manager instance");
    return instance;
  }

  if (document.querySelectorAll(buildAttribute(cnParent)) !== null) {
    //Find nearest parent by data-attribute


    // Load the IFrame Player API code asynchronously.
    var tag = document.createElement('script');

    tag.src = "https://www.youtube.com/iframe_api";
    var firstScriptTag = document.getElementsByTagName('script')[0];
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

    var mainplayer = PlayerManager.getInstance().getMainPlayer();

    // Adding listeners for document ready
    domready(fw_addListeners);

    // Adding listeners for lazy loading with PlayerManager
    PlayerManager.getInstance().setInitFunction(initVideo);
  }

  function fw_addListeners() {
    initVideo();
    window.addEventListener("load", enablePlayButtons);
    document.querySelector('body').addDelegateListener('click', cnPlayButton, function (event) {
      event.preventDefault();
      createIframe(this);
    });
  }

  function initVideo(){
    var sw = document.getElementsByClassName(testimoniSmall);
    for (var x = 0; x < sw.length; x++) {
      var switchButton = sw[x];
      if (switchButton !== null) {
        switchButton.onclick = switchVideos;
      }
    }
  }

  //Detect when players are ready
  function onPlayerReady(event) {
    var player = event.target || null,
        iframe = null;
    if (player && player.getPlayerState() != 1) {
      player.setVolume(volume);
      iframe = player.getIframe();

      if (iframe !== null) {
        if (iframe.getAttribute(attrVideoAuto) !== null) {
          if (iframe.getAttribute(cnVideoTime) !== null) {
            if (switchVideo == false) {
              player.seekTo(parseInt(iframe.getAttribute(cnVideoTime)));
            }
          }
          switchVideo = false;
          player.playVideo();
        }
      }
    }
  }

  //Detect when player change his own state (play, stop, pause...)
  function onPlayerStateChange(event) {
    //When video ends is checked and reset, and its associated HTML redisplays
    var player = event.target || null;
    if (player !== null) {
      // All modifiers are deleted by default
      document.documentElement.classList.remove('is-video-playing');
      switch (event.data) {
        case YT.PlayerState.ENDED:
        case YT.PlayerState.PAUSED:
          setTimeout(function () {
            showElements(player);
          }.bind(event, player), 100);
          break;
        case YT.PlayerState.PLAYING:
          // Custom state class is added
          document.documentElement.classList.add('is-video-playing');
          break;
      }

    }
  }

  function enablePlayButtons() {
    var listPlays = document.querySelectorAll(cnPlayButton);

    if (listPlays !== null) {
      for (var i = 0; i < listPlays.length; i++) {
        var playButton = listPlays[i];

        if (playButton !== null) {
          playButton.classList.remove("invisible");

          if (playButton.getAttribute(cnPlayOnLoad) !== null) {
            previewIframe(playButton);
          }
        }
      }
    }
  }

  function stopVideos(preview) {
    if (mainplayer != null && typeof mainplayer.getCurrentTime === "function" && typeof mainplayer.getIframe === "function") {
      if (!preview) {
        mainplayer.getIframe().setAttribute(cnVideoTime, mainplayer.getCurrentTime());
      }
      else {
        mainplayer.getIframe().setAttribute(cnVideoTime, 0);
      }
    }

    var iframePlayers = document.querySelectorAll("iframe.embedded-video__iframe");
    if (iframePlayers.length > 0) {
      for (var i = 0; i < iframePlayers.length; i++) {
        cleanElements(iframePlayers[i]);
      }

      mainplayer = null;
      PlayerManager.getInstance().setMainPlayer(null);
    }
  }

  function createPreVideo(iframe) {
    var html = '<div class="embedded-video__iframe" id="ID1" ' + attrVideoId + '="ID2" ' + attrVideoAuto + '="AUTOPLAY" ' + cnVideoTime + '="TIME"></div>';
    html = html.replace("ID2", iframe.getAttribute(attrVideoId)).replace("AUTOPLAY", iframe.getAttribute(attrVideoAuto)).replace("ID1", iframe.getAttribute("id")).replace("TIME", iframe.getAttribute(cnVideoTime));
    var div = document.createElement('div');
    div.innerHTML = html;
    iframe.parentNode.replaceChild(div.childNodes[0], iframe);
  }

  function previewIframe(playButton) {
    var parentNode = findAttrAncestor(playButton, cnParent);
    var replaced = null;

    if (parentNode !== null) {
      replaced = parentNode.querySelector(cnIframe);

      if (replaced != null) {
        var subLangAttr = replaced.getAttribute(cnSubtitleLanguage);
        // Youtube API iframe doesn't allow to check if requested subtitles
        // exists, so we always show the subtitles if subLangAttr variable is
        // valid
        var subtitlesEnabled = isValidLangCode(subLangAttr) ? 1 : 0;
        var favoriteLang = subtitlesEnabled ? subLangAttr : 'ca';

        var loopMode = replaced.getAttribute(attrLoopMode) === '1' ? 1 : 0;
        replaced.setAttribute(cnVideoPreview, 1);
        stopVideos(true);
        volume = 0;

        mainplayer = new YT.Player(replaced.getAttribute('id'), {
          height: '390',
          width: '640',
          videoId: replaced.getAttribute(attrVideoId),
          playerVars: {
              'controls': 0,
              'showinfo': 0,
              'modestbranding': 1,
              'autohide': 0,
              'cc_load_policy': subtitlesEnabled,
              'cc_lang_pref': favoriteLang,
              'loop': loopMode,
              'rel': 0,
              'playlist': loopMode ===1 ? replaced.getAttribute(attrVideoId) : ''
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });

        PlayerManager.getInstance().setMainPlayer(mainplayer);

        hideElements(playButton, true);
      }
    }
  }

  function isValidLangCode(chosenLang) {
    var allowedLangs = ['ca', 'es', 'en', 'fr'];
    return allowedLangs.indexOf(chosenLang) !== -1;
  }

  function createIframe(playButtonElement) {
    var parentNode = findAttrAncestor(playButtonElement, cnParent);
    var replaced = null;

    if (parentNode !== null) {
      replaced = parentNode.querySelector(cnIframe);
      if (replaced != null) {
        replaced = parentNode.querySelector(cnIframe);
        var loopMode = replaced.getAttribute(attrLoopMode) === '1' ? 1 : 0;
        var preview = replaced.getAttribute(cnVideoPreview);

        var subLangAttr = replaced.getAttribute(cnSubtitleLanguage);
        // Youtube API iframe doesn't allow to check if requested subtitles
        // exists, so we always show the subtitles if subLangAttr variable is
        // valid
        var subtitlesEnabled = isValidLangCode(subLangAttr) ? 1 : 0;
        var favoriteLang = subtitlesEnabled ? subLangAttr : 'ca';

        stopVideos(false);
        volume = 100;
        mainplayer = new YT.Player(replaced.getAttribute('id'), {
          height: '390',
          width: '640',
          videoId: replaced.getAttribute(attrVideoId),
          playerVars: {
            'controls': 1,
            'showinfo': 0,
            'modestbranding': 1,
            'autohide': 1,
            'cc_load_policy': subtitlesEnabled,
            'cc_lang_pref': favoriteLang,
            'rel': 0,
            'loop': loopMode,
            'playlist': loopMode ===1 ? replaced.getAttribute(attrVideoId) : ''
          },
          events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
          }
        });

        PlayerManager.getInstance().setMainPlayer(mainplayer);

        hideElements(playButtonElement, false);

        replaced = parentNode.querySelector(cnIframe);

        if (preview != null && preview == "1") {
          replaced.setAttribute(cnVideoPreview, 0);
          replaced.setAttribute(cnVideoTime, 0);
        }
      }
    }
  }

  function cleanElements(iframe) {
    if (typeof iframe !== "undefined" && iframe !== null) {
      //Elements to show
      var parentNode = findAttrAncestor(iframe, cnParent),
          playButton = parentNode.querySelector(cnPlayButton),
          imageEl = null,
          containerTextEl = null,
          hiddenEls = null,
          tintEl = null;

      if (playButton.getAttribute(attrModalTrigger) === null) {
        playButton.classList.remove("invisible");
      }

      if (parentNode) {
        tintEl = parentNode.querySelector(classTint);
        imageEl = parentNode.querySelector(cnImage);
        containerTextEl = parentNode.querySelector(cnContainerText);
        hiddenEls = parentNode.querySelectorAll(cnHiddens);

        if (tintEl !== null) {
          tintEl.classList.remove("invisible");
        }

        if (imageEl !== null) {
          imageEl.classList.remove("invisible");
        }

        if (containerTextEl !== null) {
          containerTextEl.classList.remove("invisible");
        }

        if (hiddenEls !== null) {
          for (var i = 0; i < hiddenEls.length; i++) {
            hiddenEls[i].classList.remove("invisible");
          }
        }
      }

      if (parentNode) {
        var cardEmbeddedVideo = parentNode.querySelector(classCardEmbeddedVideo);
        if (cardEmbeddedVideo !== null) {
          cardEmbeddedVideo.classList.remove("visible");
          cardEmbeddedVideo.setAttribute("aria-hidden", true);
        }
      }

      mainplayer = null;
      PlayerManager.getInstance().setMainPlayer(null);
      createPreVideo(iframe);
    }
  }

  function showElements(player) {
    if (player.getPlayerState() == 0 || player.getPlayerState() == 2) {
      var iframe = player.getIframe();

      if (iframe != null) {
        var parentNode = findAttrAncestor(iframe, cnParent),
            existsModal = null,
            modalBack = null;

        if (parentNode) {
          existsModal = parentNode.querySelector(buildAttribute(attrModalTrigger));
        }

        if (player.getPlayerState() == 2) {
          iframe.setAttribute(cnVideoTime, player.getCurrentTime());
        }
        else {
          iframe.setAttribute(cnVideoTime, 0);

          if (existsModal) {
            modalBack = parentNode.querySelector(buildAttribute(attrModal));

            if (modalBack !== null) {
              modalBack.click();
            }
          }
        }

        if (existsModal === null) {
          cleanElements(iframe);
        }
      }
    }
  }

  function loadPropertiesFrom(elem){
    var obj = {};
    var time = elem.querySelector(classVideoTime);
    var cardContent = elem.querySelector(classCardText);
    obj.cardImage= elem.querySelector(classWrapperImage);
    obj.src= obj.cardImage.getAttribute('src') || obj.cardImage.getAttribute(attrSrc);
    obj.vidId= elem.querySelector(classVideoIframe).getAttribute(attrVideoId);
    obj.time= time ? time.innerText : null;

    if(!cardContent){
      cardContent = elem.querySelector(classCardContents);
    }
    obj.content= cardContent.innerHTML;

    return obj;
  }

  function setPropertiesTo(elem, properties){
    var videoTime = elem.querySelector(classVideoTime);
    var cardContent = elem.querySelector(classCardText);
    elem.querySelector(classVideoIframe).setAttribute(attrVideoId, properties.vidId);
    if(properties.cardImage){
      switchElements(elem.querySelector(classWrapperImage), properties.cardImage)
    }
    if(videoTime){
      videoTime.innerText = properties.time !== null ? properties.time : '';
    }
    if(!cardContent){
      cardContent = elem.querySelector(classCardContents);
    }
    cardContent.innerHTML = properties.content;
  }

  function switchElements(dom1, dom2){
    var parent1 = dom1.parentElement;
    var parent2 = dom2.parentElement;
    parent1.appendChild(dom2);
    parent2.appendChild(dom1);
  }

  function switchVideos(e) {
    e.preventDefault();
    switchVideo = true;
    var cardVideoSecondary = this.closest(classCard);
    var cardVideoMain = cardVideoSecondary.closest(classTestimoniVideos).previousElementSibling;

    var videoObjectMain = loadPropertiesFrom(cardVideoMain);
    var videoObjectSecondary = loadPropertiesFrom(cardVideoSecondary);

    setPropertiesTo(cardVideoMain, videoObjectSecondary);
    setPropertiesTo(cardVideoSecondary, videoObjectMain);

    var playButton = cardVideoMain.querySelector('[data-video-play]');
    triggerFakeClickTo(playButton);
  }

  function hideElements(playButton, preview) {
    //Elements to hide
    var parentNode = findAttrAncestor(playButton, cnParent),
        imageEl = null,
        containerTextEl = null,
        hiddenEls = null,
        tintEl = null;

    var hidePlayMode = parentNode.getAttribute(attrPlayHidden);

    if((playButton.getAttribute(attrModalTrigger) === null && playButton.getAttribute(cnLock) === null && !preview) || hidePlayMode === "1") {
      playButton.classList.add("invisible");
    }

    if (parentNode) {
      tintEl = parentNode.querySelector(classTint);
      imageEl = parentNode.querySelector(cnImage);
      containerTextEl = parentNode.querySelector(cnContainerText);
      hiddenEls = parentNode.querySelectorAll(cnHiddens);

      if (imageEl !== null) {
        imageEl.classList.add("invisible");
      }
      if (preview) {
        if (tintEl !== null) {
          tintEl.classList.remove("invisible");
        }
      }
      if (!preview) {
        if (tintEl !== null) {
          tintEl.classList.add("invisible");
        }

        if (containerTextEl !== null && containerTextEl.getAttribute(cnLock) === null) {
          containerTextEl.classList.add("invisible");
        }

        if (hiddenEls !== null) {
          for (var i = 0; i < hiddenEls.length; i++) {
            if (hiddenEls[i].getAttribute(cnLock) === null) {
              hiddenEls[i].classList.add("invisible");
            }
          }
        }
      }
    }

    if (parentNode && !preview) {
      var iframe = parentNode.querySelector("iframe");
      var cardEmbeddedVideo = parentNode.querySelector(classCardEmbeddedVideo);

      if (iframe !== null) {
        if (cardEmbeddedVideo !== null) {
          if (parentNode.offsetWidth > parentNode.offsetHeight) {
            cardEmbeddedVideo.classList.add("horizontal");
            iframe.parentNode.style.height = parseInt(cardEmbeddedVideo.offsetHeight) + "px";
            iframe.style.height = parseInt(cardEmbeddedVideo.offsetHeight) + "px";
          }
          cardEmbeddedVideo.classList.add("visible");
          cardEmbeddedVideo.setAttribute("aria-hidden", false);
        }
      }

      var existsModal = parentNode.querySelector(buildAttribute(attrModalTrigger));

      if (existsModal === null) {
        if (cardEmbeddedVideo !== null) {
          cardEmbeddedVideo.classList.add("visible");
          cardEmbeddedVideo.setAttribute("aria-hidden", false);
        }
      }
    }
  }

  return {
    getInstance: function () {
      if (!instance) {
        instance = createInstance();
      }
      return instance;
    }
  }
})(PlayerManager);

(function vimeoVideo(PlayerManager){

    var vimeoParent = "data-video-vimeo",
        vimeoPlayButton = "[data-vimeo-play]",
        vimeoHiddens = "[data-vimeo-hidden]",
        vimeoImage = "[data-vimeo-img]",
        vimeoContainerText = "[data-vimeo-container]",
        vimeoLock = "data-vimeo-lock",
        vimeoVideoTime = "data-vimeo-time",
        vimeoVideoPreview = "data-vimeo-preview",
        vimeoIframe = "[vimeo-id]",
        attrVimeoId = "vimeo-id",
        attrVimeoAuto = "data-vimeo-autoplay",
        attrModalTriggerVimeo = "data-modal-trigger-vimeo",
        classCardEmbeddedVimeo = ".card__embedded-video",
        classIframeEmbeddedVimeo = "embedded-video__iframe",
        classTintVimeo = ".banner-full__tint",
        currentIframeVimeo = null,
        volumeVimeo = 1;

    function buildAttribute(name) {
        return "[" + name + "]";}

//VIMEO PLAYER
    if (document.querySelectorAll(buildAttribute(vimeoParent)) !== null) {
        function findAttrAncestor(el, attr) {
            while ((el = el.parentElement) && el.getAttribute(attr) === null);

            if(typeof el === "undefined")
                el = null;

            return el;
        }

        var tagVimeo = document.createElement('script');
        tagVimeo.src = "https://player.vimeo.com/api/player.js";
        var firstScripttagVimeoTag = document.getElementsByTagName('script')[0];
        firstScripttagVimeoTag.parentNode.insertBefore(tagVimeo, firstScripttagVimeoTag);

        var vimeoplayer =  PlayerManager.getInstance().getMainPlayer();

        window.addEventListener("load", function(event){
            var v = document.getElementsByClassName(classIframeEmbeddedVimeo);
            for (var n = 0; n < v.length; n++) {
                var parentNode = findAttrAncestor(v[n], vimeoParent);
                if(parentNode !== null) {
                    var playButton = parentNode.querySelector(vimeoPlayButton);
                    playButton.onclick = createVimeoIframe;
                }
            }
            enablePlayButtons();
        }, false);

        function enablePlayButtons() {
            var listPlays = document.querySelectorAll(vimeoPlayButton);
            var wWidth = window.innerWidth;
            if (listPlays !== null && listPlays !== 'undefined') {
                for (var i = 0; i < listPlays.length; i++) {
                    var playButton = listPlays[i];
                    if (playButton !== null) {
                        playButton.classList.remove("invisible");

                        var parentNode = findAttrAncestor(playButton, vimeoParent);
                        currentIframeVimeo = parentNode.querySelector(vimeoIframe);

                        var playOnLoadAttr = currentIframeVimeo.getAttribute(attrVimeoAuto);
                        var playOnloadEnabled = playOnLoadAttr !== "" && playOnLoadAttr !== null ? playOnLoadAttr : 0;
                        if(playOnloadEnabled == 1 && wWidth >= desktopBreakpoint){
                            createVimeoIframe(playButton);
                        }

                        var previewEnabledAttr = currentIframeVimeo.getAttribute(vimeoVideoPreview);
                        var previewEnabled = previewEnabledAttr !== "" && previewEnabledAttr !== null ? previewEnabledAttr : 0;
                        if(previewEnabled == 1 && wWidth >= desktopBreakpoint){
                            previewIframe(playButton);
                        }
                    }
                }
            }
        }

        function onPlayerPause(player){
            player.off('pause', function(data) {
                onPlayerPause();
            });
            showElements(player);
        }

        function onPlayerEnded(player){
            player.off('pause', function(data) {
                onPlayerEnded();
            });

            showElements(player);
        }

        function previewIframe(playButton) {
            var parentNode = findAttrAncestor(playButton, vimeoParent);
            var replaced = null;
            if(parentNode !== null) {
                replaced = parentNode.querySelector(vimeoIframe);
                if(replaced != null) {
                    replaced.setAttribute(vimeoVideoPreview, 1);
                    //stopVideos(true, replaced);
                    volumeVimeo = 0;
                    var vidId = replaced.getAttribute(attrVimeoId);

                    vimeoplayer = new Vimeo.Player(replaced.getAttribute('id'), {
                        height: '390',
                        width: '640',
                        title: false,
                        id: vidId,
                        byline: false,
                        playbar: false,
                        autoplay: true
                    });
                    vimeoplayer.setVolume(volumeVimeo);
                    vimeoplayer.ready().then(function() {
                        // the player is ready
                        var vidIframe = parentNode.querySelector(vimeoIframe).firstElementChild;
                        $(vidIframe).addClass('full-vimeo');

                        onPlayerReady(vimeoplayer);
                    });
                    vimeoplayer.on('pause', function(data) {
                        onPlayerPause(vimeoplayer);
                    });
                    vimeoplayer.on('ended', function(data) {
                        onPlayerEnded(vimeoplayer);
                    });

                    PlayerManager.getInstance().setMainPlayer(vimeoplayer);

                    hideElements(playButton, true);
                }
            }
        }

        function createVimeoIframe(e) {

            var parentNode = null;
            var self = this;

            if(e.type == "click"){
                e.preventDefault();
                parentNode = findAttrAncestor(self, vimeoParent);
            }else{
                parentNode = findAttrAncestor(e, vimeoParent);
                self = e;
            }

            var replaced = null;

            if(parentNode !== null) {
                replaced = parentNode.querySelector(vimeoIframe);
                if(replaced != null) {
                    replaced = parentNode.querySelector(vimeoIframe);
                    var preview = replaced.getAttribute(vimeoVideoPreview);
                    var vidId = replaced.getAttribute(attrVimeoId);
                    // stopVideos(false);
                    volumeVimeo = 1;
                    vimeoplayer = new Vimeo.Player(replaced.getAttribute('id'), {
                        height: '390',
                        width: '640',
                        title: false,
                        id: vidId,
                        byline: false,
                        loop: true
                    });
                    vimeoplayer.setVolume(volumeVimeo);
                    vimeoplayer.ready().then(function() {
                        // the player is ready
                        onPlayerReady(vimeoplayer);
                        var vidIframe = parentNode.querySelector(vimeoIframe).firstElementChild;
                        vimeoplayer.play();
                        vimeoplayer.setCurrentTime(0).then(function(seconds) {
                            // seconds = the actual time that the player seeked to
                        });
                        $(vidIframe).addClass('full-vimeo');
                    });

                    PlayerManager.getInstance().setMainPlayer(vimeoplayer);

                    hideElements(self, false);
                    replaced = parentNode.querySelector(vimeoIframe);
                    if(preview != null && preview == "1") {
                        replaced.setAttribute(vimeoVideoPreview, 0);
                        replaced.setAttribute(vimeoVideoTime, 0);
                    }
                }
            }
        }



        function onPlayerReady(player) {
            //var	iframe = null;

            if(player){
                player.getPaused().then(function(ispaused){
                    if(ispaused === true){
                        player.setVolume(volumeVimeo);
                        //iframe = player.parentNode;
                    }
                })
            }
        }

        function hideElements(playbutton, preview) {
            //Elements to hide
            var parentNode = findAttrAncestor(playbutton, vimeoParent),
                imageEl = null,
                containerTextEl = null,
                hiddenEls = null,
                tintEl = null;

            if(playbutton.getAttribute(attrModalTriggerVimeo) === null && playbutton.getAttribute(vimeoLock) === null && !preview) {
                playbutton.classList.add("invisible");
            }

            if (parentNode) {
                tintEl = parentNode.querySelector(classTintVimeo);
                imageEl = parentNode.querySelector(vimeoImage);
                containerTextEl = parentNode.querySelector(vimeoContainerText);
                hiddenEls = parentNode.querySelectorAll(vimeoHiddens);

                if (imageEl !== null) {
                    imageEl.classList.add("invisible");
                }
                if (tintEl !== null) {
                    tintEl.classList.remove("invisible");
                }
                if(!preview) {
                    if (tintEl !== null) {
                        tintEl.classList.add("invisible");
                    }

                    if (containerTextEl !== null && containerTextEl.getAttribute(vimeoLock) === null) {
                        containerTextEl.classList.add("invisible");
                    }

                    if (hiddenEls !== null) {
                        for (var i = 0; i < hiddenEls.length; i++) {
                            if(hiddenEls[i].getAttribute(vimeoLock) === null) {
                                hiddenEls[i].classList.add("invisible");
                            }
                        }
                    }
                }
            }

            if(typeof parentNode !== "undefined" && !preview) {
                var iframe = parentNode.querySelector("iframe");
                var cardEmbeddedVideo = parentNode.querySelector(classCardEmbeddedVimeo);

                if(iframe !== null) {
                    if(cardEmbeddedVideo !== null) {
                        if(parentNode.offsetWidth > parentNode.offsetHeight) {
                            cardEmbeddedVideo.classList.add("horizontal");
                            iframe.parentNode.style.height = parseInt(cardEmbeddedVideo.offsetHeight)+"px";
                            iframe.style.height = parseInt(cardEmbeddedVideo.offsetHeight)+"px";
                        }
                        cardEmbeddedVideo.classList.add("visible");
                    }
                }

                var existsModal = parentNode.querySelector(buildAttribute(attrModalTriggerVimeo));

                if(existsModal === null) {
                    if(cardEmbeddedVideo !== null) {
                        cardEmbeddedVideo.classList.add("visible");
                    }
                }
                else {
                  if(iframe !== null) {
                    currentIframeVimeo = iframe;
                  }
                }
            }
        }


        function cleanElements(iframe, player) {
            if(typeof iframe !== "undefined" && iframe !== null) {
                //Elements to show

                player.getVideoId().then(function(id) {

                    var parentNode = document.querySelector(buildAttribute(vimeoParent));

                    var	playButton = parentNode.querySelector(vimeoPlayButton);
                    var	imageEl = null,
                        containerTextEl = null,
                        hiddenEls = null,
                        tintEl = null;

                    if(playButton.getAttribute(attrModalTriggerVimeo) === null) {
                        playButton.classList.remove("invisible");
                    }

                    if (parentNode) {

                        tintEl = parentNode.querySelector(classTintVimeo);
                        imageEl = parentNode.querySelector(vimeoImage);
                        containerTextEl = parentNode.querySelector(vimeoContainerText);
                        hiddenEls = parentNode.querySelectorAll(vimeoHiddens);
                        if (tintEl !== null) {
                            tintEl.classList.remove("invisible");
                        }

                        if (imageEl !== null) {
                            imageEl.classList.remove("invisible");
                        }

                        if (containerTextEl !== null) {
                            containerTextEl.classList.remove("invisible");
                        }

                        if (hiddenEls !== null) {
                            for (var i = 0; i < hiddenEls.length; i++) {
                                hiddenEls[i].classList.remove("invisible");
                            }
                        }
                    }

                    if(parentNode) {
                        var cardEmbeddedVideo = parentNode.querySelector(classCardEmbeddedVimeo);
                        if(cardEmbeddedVideo !== null) {
                            cardEmbeddedVideo.classList.remove("visible");
                        }
                    }

                    vimeoplayer = null;
                    PlayerManager.getInstance().setMainPlayer(null);

                    createPreVideo(iframe);

                }).catch(function(error) {
                    // an error occurred
                });
            }
        }

        function showElements(player) {
            player.getVideoEmbedCode().then(function(iframe) {

                if(iframe != null) {
                    var parentNode = findAttrAncestor(iframe, vimeoParent);
                    var existsModal= null;

                    if(parentNode){
                      existsModal = parentNode.querySelector(buildAttribute(attrModalTriggerVimeo));
                    }

                    if(existsModal === null) {
                        cleanElements(iframe, player);

                    }
                }

            })
        }


        function createPreVideo(iframe) {

            var html = '<div class="embedded-video__iframe" id="ID1" '+attrVideoId+'="ID2" '+attrVideoAuto+'="AUTOPLAY" '+cnVideoTime+'="TIME"></div>';
            html = html.replace("ID2", iframe.getAttribute(attrVideoId)).replace("AUTOPLAY", iframe.getAttribute(attrVideoAuto)).replace("ID1", iframe.getAttribute("id")).replace("TIME", iframe.getAttribute(cnVideoTime));
            var div = document.createElement('div');
            div.innerHTML = html;
            iframe.parentNode.replaceChild(div.childNodes[0], iframe);
        }

    }
///// END VIMEO VIDEO PLAYER

})(PlayerManager);

function fw_init() {

  //JS is active
  document.querySelector("body").classList.add("fw-is-js");

  //Function call
  fw_BrowserDetect.init();
  fw_dropDownInit();
  fw_headerSearchInit();
  fw_mainNavInit();
  CollapseManager.getInstance().fw_collapseInit();
  fw_tabsInit();
  fw_appendAroundInit();
  ModalManager.getInstance().fw_modalInit();
  fw_stickyInit();
  fw_customSelectsInit();
  fw_accesibilityInit();
  FileManager.getInstance().fw_fileInit();
  TableManager.getInstance().fw_dynamicTableInit();

  //full-width.js se carga sin llamar a ninguna función ya que necesita estar de forma global
}

//Only load JS for capable browsers
if ('querySelector' in document
  //&& 'localStorage' in window //Only if we want to prevent Opera Mini from loading JS.
  && 'addEventListener' in window) {

  domready(fw_init);
}

/*! modernizr 3.3.1 (Custom Build) | MIT *
 * https://new.modernizr.com/download/?-fontface-objectfit-touchevents-setclasses !*/
!function(e,n,t){function r(e,n){return typeof e===n}function o(){var e,n,t,o,s,i,a;for(var f in y)if(y.hasOwnProperty(f)){if(e=[],n=y[f],n.name&&(e.push(n.name.toLowerCase()),n.options&&n.options.aliases&&n.options.aliases.length))for(t=0;t<n.options.aliases.length;t++)e.push(n.options.aliases[t].toLowerCase());for(o=r(n.fn,"function")?n.fn():n.fn,s=0;s<e.length;s++)i=e[s],a=i.split("."),1===a.length?Modernizr[a[0]]=o:(!Modernizr[a[0]]||Modernizr[a[0]]instanceof Boolean||(Modernizr[a[0]]=new Boolean(Modernizr[a[0]])),Modernizr[a[0]][a[1]]=o),g.push((o?"":"no-")+a.join("-"))}}function s(e){var n=w.className,t=Modernizr._config.classPrefix||"";if(x&&(n=n.baseVal),Modernizr._config.enableJSClass){var r=new RegExp("(^|\\s)"+t+"no-js(\\s|$)");n=n.replace(r,"$1"+t+"js$2")}Modernizr._config.enableClasses&&(n+=" "+t+e.join(" "+t),x?w.className.baseVal=n:w.className=n)}function i(e){return e.replace(/([a-z])-([a-z])/g,function(e,n,t){return n+t.toUpperCase()}).replace(/^-/,"")}function a(){return"function"!=typeof n.createElement?n.createElement(arguments[0]):x?n.createElementNS.call(n,"http://www.w3.org/2000/svg",arguments[0]):n.createElement.apply(n,arguments)}function f(){var e=n.body;return e||(e=a(x?"svg":"body"),e.fake=!0),e}function l(e,t,r,o){var s,i,l,u,c="modernizr",p=a("div"),d=f();if(parseInt(r,10))for(;r--;)l=a("div"),l.id=o?o[r]:c+(r+1),p.appendChild(l);return s=a("style"),s.type="text/css",s.id="s"+c,(d.fake?d:p).appendChild(s),d.appendChild(p),s.styleSheet?s.styleSheet.cssText=e:s.appendChild(n.createTextNode(e)),p.id=c,d.fake&&(d.style.background="",d.style.overflow="hidden",u=w.style.overflow,w.style.overflow="hidden",w.appendChild(d)),i=t(p,e),d.fake?(d.parentNode.removeChild(d),w.style.overflow=u,w.offsetHeight):p.parentNode.removeChild(p),!!i}function u(e,n){return!!~(""+e).indexOf(n)}function c(e,n){return function(){return e.apply(n,arguments)}}function p(e,n,t){var o;for(var s in e)if(e[s]in n)return t===!1?e[s]:(o=n[e[s]],r(o,"function")?c(o,t||n):o);return!1}function d(e){return e.replace(/([A-Z])/g,function(e,n){return"-"+n.toLowerCase()}).replace(/^ms-/,"-ms-")}function m(n,r){var o=n.length;if("CSS"in e&&"supports"in e.CSS){for(;o--;)if(e.CSS.supports(d(n[o]),r))return!0;return!1}if("CSSSupportsRule"in e){for(var s=[];o--;)s.push("("+d(n[o])+":"+r+")");return s=s.join(" or "),l("@supports ("+s+") { #modernizr { position: absolute; } }",function(e){return"absolute"==getComputedStyle(e,null).position})}return t}function h(e,n,o,s){function f(){c&&(delete R.style,delete R.modElem)}if(s=r(s,"undefined")?!1:s,!r(o,"undefined")){var l=m(e,o);if(!r(l,"undefined"))return l}for(var c,p,d,h,v,g=["modernizr","tspan","samp"];!R.style&&g.length;)c=!0,R.modElem=a(g.shift()),R.style=R.modElem.style;for(d=e.length,p=0;d>p;p++)if(h=e[p],v=R.style[h],u(h,"-")&&(h=i(h)),R.style[h]!==t){if(s||r(o,"undefined"))return f(),"pfx"==n?h:!0;try{R.style[h]=o}catch(y){}if(R.style[h]!=v)return f(),"pfx"==n?h:!0}return f(),!1}function v(e,n,t,o,s){var i=e.charAt(0).toUpperCase()+e.slice(1),a=(e+" "+T.join(i+" ")+i).split(" ");return r(n,"string")||r(n,"undefined")?h(a,n,o,s):(a=(e+" "+z.join(i+" ")+i).split(" "),p(a,n,t))}var g=[],y=[],C={_version:"3.3.1",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,n){var t=this;setTimeout(function(){n(t[e])},0)},addTest:function(e,n,t){y.push({name:e,fn:n,options:t})},addAsyncTest:function(e){y.push({name:null,fn:e})}},Modernizr=function(){};Modernizr.prototype=C,Modernizr=new Modernizr;var w=n.documentElement,x="svg"===w.nodeName.toLowerCase(),_=C.testStyles=l,b=function(){var e=navigator.userAgent,n=e.match(/applewebkit\/([0-9]+)/gi)&&parseFloat(RegExp.$1),t=e.match(/w(eb)?osbrowser/gi),r=e.match(/windows phone/gi)&&e.match(/iemobile\/([0-9])+/gi)&&parseFloat(RegExp.$1)>=9,o=533>n&&e.match(/android/gi);return t||o||r}();b?Modernizr.addTest("fontface",!1):_('@font-face {font-family:"font";src:url("https://")}',function(e,t){var r=n.getElementById("smodernizr"),o=r.sheet||r.styleSheet,s=o?o.cssRules&&o.cssRules[0]?o.cssRules[0].cssText:o.cssText||"":"",i=/src/i.test(s)&&0===s.indexOf(t.split(" ")[0]);Modernizr.addTest("fontface",i)});var S="Moz O ms Webkit",T=C._config.usePrefixes?S.split(" "):[];C._cssomPrefixes=T;var E=function(n){var r,o=N.length,s=e.CSSRule;if("undefined"==typeof s)return t;if(!n)return!1;if(n=n.replace(/^@/,""),r=n.replace(/-/g,"_").toUpperCase()+"_RULE",r in s)return"@"+n;for(var i=0;o>i;i++){var a=N[i],f=a.toUpperCase()+"_"+r;if(f in s)return"@-"+a.toLowerCase()+"-"+n}return!1};C.atRule=E;var z=C._config.usePrefixes?S.toLowerCase().split(" "):[];C._domPrefixes=z;var j={elem:a("modernizr")};Modernizr._q.push(function(){delete j.elem});var R={style:j.elem.style};Modernizr._q.unshift(function(){delete R.style}),C.testAllProps=v;var P=C.prefixed=function(e,n,t){return 0===e.indexOf("@")?E(e):(-1!=e.indexOf("-")&&(e=i(e)),n?v(e,n,t):v(e,"pfx"))};Modernizr.addTest("objectfit",!!P("objectFit"),{aliases:["object-fit"]});var N=C._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""];C._prefixes=N,Modernizr.addTest("touchevents",function(){var t;if("ontouchstart"in e||e.DocumentTouch&&n instanceof DocumentTouch)t=!0;else{var r=["@media (",N.join("touch-enabled),("),"heartz",")","{#modernizr{top:9px;position:absolute}}"].join("");_(r,function(e){t=9===e.offsetTop})}return t}),o(),s(g),delete C.addTest,delete C.addAsyncTest;for(var k=0;k<Modernizr._q.length;k++)Modernizr._q[k]();e.Modernizr=Modernizr}(window,document);