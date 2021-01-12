!function(e,t){"object"==typeof exports&&"undefined"!=typeof module?t(exports,require("jquery"),require("popper.js")):"function"==typeof define&&define.amd?define(["exports","jquery","popper.js"],t):t((e=e||self).bootstrap={},e.jQuery,e.Popper)}(this,function(e,t,n){"use strict";function i(e,t){for(var n=0;n<t.length;n++){var i=t[n];i.enumerable=i.enumerable||!1,i.configurable=!0,"value"in i&&(i.writable=!0),Object.defineProperty(e,i.key,i)}}function r(e,t,n){return t&&i(e.prototype,t),n&&i(e,n),e}function o(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);t&&(i=i.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,i)}return n}function s(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?o(Object(n),!0).forEach(function(t){var i,r,o;i=e,o=n[r=t],r in i?Object.defineProperty(i,r,{value:o,enumerable:!0,configurable:!0,writable:!0}):i[r]=o}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):o(Object(n)).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}t=t&&t.hasOwnProperty("default")?t.default:t,n=n&&n.hasOwnProperty("default")?n.default:n;var a="transitionend";var l={TRANSITION_END:"bsTransitionEnd",getUID:function(e){for(;e+=~~(1e6*Math.random()),document.getElementById(e););return e},getSelectorFromElement:function(e){var t=e.getAttribute("data-target");if(!t||"#"===t){var n=e.getAttribute("href");t=n&&"#"!==n?n.trim():""}try{return document.querySelector(t)?t:null}catch(e){return null}},getTransitionDurationFromElement:function(e){if(!e)return 0;var n=t(e).css("transition-duration"),i=t(e).css("transition-delay"),r=parseFloat(n),o=parseFloat(i);return r||o?(n=n.split(",")[0],i=i.split(",")[0],1e3*(parseFloat(n)+parseFloat(i))):0},reflow:function(e){return e.offsetHeight},triggerTransitionEnd:function(e){t(e).trigger(a)},supportsTransitionEnd:function(){return Boolean(a)},isElement:function(e){return(e[0]||e).nodeType},typeCheckConfig:function(e,t,n){for(var i in n)if(Object.prototype.hasOwnProperty.call(n,i)){var r=n[i],o=t[i],s=o&&l.isElement(o)?"element":(a=o,{}.toString.call(a).match(/\s([a-z]+)/i)[1].toLowerCase());if(!new RegExp(r).test(s))throw new Error(e.toUpperCase()+': Option "'+i+'" provided type "'+s+'" but expected type "'+r+'".')}var a},findShadowRoot:function(e){if(!document.documentElement.attachShadow)return null;if("function"!=typeof e.getRootNode)return e instanceof ShadowRoot?e:e.parentNode?l.findShadowRoot(e.parentNode):null;var t=e.getRootNode();return t instanceof ShadowRoot?t:null},jQueryDetection:function(){if(void 0===t)throw new TypeError("Bootstrap's JavaScript requires jQuery. jQuery must be included before Bootstrap's JavaScript.");var e=t.fn.jquery.split(" ")[0].split(".");if(e[0]<2&&e[1]<9||1===e[0]&&9===e[1]&&e[2]<1||4<=e[0])throw new Error("Bootstrap's JavaScript requires at least jQuery v1.9.1 but less than v4.0.0")}};l.jQueryDetection(),t.fn.emulateTransitionEnd=function(e){var n=this,i=!1;return t(this).one(l.TRANSITION_END,function(){i=!0}),setTimeout(function(){i||l.triggerTransitionEnd(n)},e),this},t.event.special[l.TRANSITION_END]={bindType:a,delegateType:a,handle:function(e){if(t(e.target).is(this))return e.handleObj.handler.apply(this,arguments)}};var u="alert",c="bs.alert",h="."+c,f=t.fn[u],d={CLOSE:"close"+h,CLOSED:"closed"+h,CLICK_DATA_API:"click"+h+".data-api"},_=function(){function e(e){this._element=e}var n=e.prototype;return n.close=function(e){var t=this._element;e&&(t=this._getRootElement(e)),this._triggerCloseEvent(t).isDefaultPrevented()||this._removeElement(t)},n.dispose=function(){t.removeData(this._element,c),this._element=null},n._getRootElement=function(e){var n=l.getSelectorFromElement(e),i=!1;return n&&(i=document.querySelector(n)),i||t(e).closest(".alert")[0]},n._triggerCloseEvent=function(e){var n=t.Event(d.CLOSE);return t(e).trigger(n),n},n._removeElement=function(e){var n=this;if(t(e).removeClass("show"),t(e).hasClass("fade")){var i=l.getTransitionDurationFromElement(e);t(e).one(l.TRANSITION_END,function(t){return n._destroyElement(e,t)}).emulateTransitionEnd(i)}else this._destroyElement(e)},n._destroyElement=function(e){t(e).detach().trigger(d.CLOSED).remove()},e._jQueryInterface=function(n){return this.each(function(){var i=t(this),r=i.data(c);r||(r=new e(this),i.data(c,r)),"close"===n&&r[n](this)})},e._handleDismiss=function(e){return function(t){t&&t.preventDefault(),e.close(this)}},r(e,null,[{key:"VERSION",get:function(){return"4.4.1"}}]),e}();t(document).on(d.CLICK_DATA_API,'[data-dismiss="alert"]',_._handleDismiss(new _)),t.fn[u]=_._jQueryInterface,t.fn[u].Constructor=_,t.fn[u].noConflict=function(){return t.fn[u]=f,_._jQueryInterface};var m="carousel",v="bs.carousel",p="."+v,g=".data-api",E=t.fn[m],y={interval:5e3,keyboard:!0,slide:!1,pause:"hover",wrap:!0,touch:!0},S={interval:"(number|boolean)",keyboard:"boolean",slide:"(boolean|string)",pause:"(string|boolean)",wrap:"boolean",touch:"boolean"},I="next",T="prev",b={SLIDE:"slide"+p,SLID:"slid"+p,KEYDOWN:"keydown"+p,MOUSEENTER:"mouseenter"+p,MOUSELEAVE:"mouseleave"+p,TOUCHSTART:"touchstart"+p,TOUCHMOVE:"touchmove"+p,TOUCHEND:"touchend"+p,POINTERDOWN:"pointerdown"+p,POINTERUP:"pointerup"+p,DRAG_START:"dragstart"+p,LOAD_DATA_API:"load"+p+g,CLICK_DATA_API:"click"+p+g},O="active",D=".active.carousel-item",C=".carousel-indicators",w={TOUCH:"touch",PEN:"pen"},A=function(){function e(e,t){this._items=null,this._interval=null,this._activeElement=null,this._isPaused=!1,this._isSliding=!1,this.touchTimeout=null,this.touchStartX=0,this.touchDeltaX=0,this._config=this._getConfig(t),this._element=e,this._indicatorsElement=this._element.querySelector(C),this._touchSupported="ontouchstart"in document.documentElement||0<navigator.maxTouchPoints,this._pointerEvent=Boolean(window.PointerEvent||window.MSPointerEvent),this._addEventListeners()}var n=e.prototype;return n.next=function(){this._isSliding||this._slide(I)},n.nextWhenVisible=function(){!document.hidden&&t(this._element).is(":visible")&&"hidden"!==t(this._element).css("visibility")&&this.next()},n.prev=function(){this._isSliding||this._slide(T)},n.pause=function(e){e||(this._isPaused=!0),this._element.querySelector(".carousel-item-next, .carousel-item-prev")&&(l.triggerTransitionEnd(this._element),this.cycle(!0)),clearInterval(this._interval),this._interval=null},n.cycle=function(e){e||(this._isPaused=!1),this._interval&&(clearInterval(this._interval),this._interval=null),this._config.interval&&!this._isPaused&&(this._interval=setInterval((document.visibilityState?this.nextWhenVisible:this.next).bind(this),this._config.interval))},n.to=function(e){var n=this;this._activeElement=this._element.querySelector(D);var i=this._getItemIndex(this._activeElement);if(!(e>this._items.length-1||e<0))if(this._isSliding)t(this._element).one(b.SLID,function(){return n.to(e)});else{if(i===e)return this.pause(),void this.cycle();var r=i<e?I:T;this._slide(r,this._items[e])}},n.dispose=function(){t(this._element).off(p),t.removeData(this._element,v),this._items=null,this._config=null,this._element=null,this._interval=null,this._isPaused=null,this._isSliding=null,this._activeElement=null,this._indicatorsElement=null},n._getConfig=function(e){return e=s({},y,{},e),l.typeCheckConfig(m,e,S),e},n._handleSwipe=function(){var e=Math.abs(this.touchDeltaX);if(!(e<=40)){var t=e/this.touchDeltaX;(this.touchDeltaX=0)<t&&this.prev(),t<0&&this.next()}},n._addEventListeners=function(){var e=this;this._config.keyboard&&t(this._element).on(b.KEYDOWN,function(t){return e._keydown(t)}),"hover"===this._config.pause&&t(this._element).on(b.MOUSEENTER,function(t){return e.pause(t)}).on(b.MOUSELEAVE,function(t){return e.cycle(t)}),this._config.touch&&this._addTouchEventListeners()},n._addTouchEventListeners=function(){var e=this;if(this._touchSupported){var n=function(t){e._pointerEvent&&w[t.originalEvent.pointerType.toUpperCase()]?e.touchStartX=t.originalEvent.clientX:e._pointerEvent||(e.touchStartX=t.originalEvent.touches[0].clientX)},i=function(t){e._pointerEvent&&w[t.originalEvent.pointerType.toUpperCase()]&&(e.touchDeltaX=t.originalEvent.clientX-e.touchStartX),e._handleSwipe(),"hover"===e._config.pause&&(e.pause(),e.touchTimeout&&clearTimeout(e.touchTimeout),e.touchTimeout=setTimeout(function(t){return e.cycle(t)},500+e._config.interval))};t(this._element.querySelectorAll(".carousel-item img")).on(b.DRAG_START,function(e){return e.preventDefault()}),this._pointerEvent?(t(this._element).on(b.POINTERDOWN,function(e){return n(e)}),t(this._element).on(b.POINTERUP,function(e){return i(e)}),this._element.classList.add("pointer-event")):(t(this._element).on(b.TOUCHSTART,function(e){return n(e)}),t(this._element).on(b.TOUCHMOVE,function(t){return function(t){t.originalEvent.touches&&1<t.originalEvent.touches.length?e.touchDeltaX=0:e.touchDeltaX=t.originalEvent.touches[0].clientX-e.touchStartX}(t)}),t(this._element).on(b.TOUCHEND,function(e){return i(e)}))}},n._keydown=function(e){if(!/input|textarea/i.test(e.target.tagName))switch(e.which){case 37:e.preventDefault(),this.prev();break;case 39:e.preventDefault(),this.next()}},n._getItemIndex=function(e){return this._items=e&&e.parentNode?[].slice.call(e.parentNode.querySelectorAll(".carousel-item")):[],this._items.indexOf(e)},n._getItemByDirection=function(e,t){var n=e===I,i=e===T,r=this._getItemIndex(t),o=this._items.length-1;if((i&&0===r||n&&r===o)&&!this._config.wrap)return t;var s=(r+(e===T?-1:1))%this._items.length;return-1==s?this._items[this._items.length-1]:this._items[s]},n._triggerSlideEvent=function(e,n){var i=this._getItemIndex(e),r=this._getItemIndex(this._element.querySelector(D)),o=t.Event(b.SLIDE,{relatedTarget:e,direction:n,from:r,to:i});return t(this._element).trigger(o),o},n._setActiveIndicatorElement=function(e){if(this._indicatorsElement){var n=[].slice.call(this._indicatorsElement.querySelectorAll(".active"));t(n).removeClass(O);var i=this._indicatorsElement.children[this._getItemIndex(e)];i&&t(i).addClass(O)}},n._slide=function(e,n){var i,r,o,s=this,a=this._element.querySelector(D),u=this._getItemIndex(a),c=n||a&&this._getItemByDirection(e,a),h=this._getItemIndex(c),f=Boolean(this._interval);if(o=e===I?(i="carousel-item-left",r="carousel-item-next","left"):(i="carousel-item-right",r="carousel-item-prev","right"),c&&t(c).hasClass(O))this._isSliding=!1;else if(!this._triggerSlideEvent(c,o).isDefaultPrevented()&&a&&c){this._isSliding=!0,f&&this.pause(),this._setActiveIndicatorElement(c);var d=t.Event(b.SLID,{relatedTarget:c,direction:o,from:u,to:h});if(t(this._element).hasClass("slide")){t(c).addClass(r),l.reflow(c),t(a).addClass(i),t(c).addClass(i);var _=parseInt(c.getAttribute("data-interval"),10);_?(this._config.defaultInterval=this._config.defaultInterval||this._config.interval,this._config.interval=_):this._config.interval=this._config.defaultInterval||this._config.interval;var m=l.getTransitionDurationFromElement(a);t(a).one(l.TRANSITION_END,function(){t(c).removeClass(i+" "+r).addClass(O),t(a).removeClass(O+" "+r+" "+i),s._isSliding=!1,setTimeout(function(){return t(s._element).trigger(d)},0)}).emulateTransitionEnd(m)}else t(a).removeClass(O),t(c).addClass(O),this._isSliding=!1,t(this._element).trigger(d);f&&this.cycle()}var v=null,p=document.getElementsByClassName("li active");p.length>0&&(v=p[0].getAttribute("data-slide-to"));var g=document.getElementById("number"),E=Number(v);g.textContent=E+1},e._jQueryInterface=function(n){return this.each(function(){var i=t(this).data(v),r=s({},y,{},t(this).data());"object"==typeof n&&(r=s({},r,{},n));var o="string"==typeof n?n:r.slide;if(i||(i=new e(this,r),t(this).data(v,i)),"number"==typeof n)i.to(n);else if("string"==typeof o){if(void 0===i[o])throw new TypeError('No method named "'+o+'"');i[o]()}else r.interval&&r.ride&&(i.pause(),i.cycle())})},e._dataApiClickHandler=function(n){var i=l.getSelectorFromElement(this);if(i){var r=t(i)[0];if(r&&t(r).hasClass("carousel")){var o=s({},t(r).data(),{},t(this).data()),a=this.getAttribute("data-slide-to");a&&(o.interval=!1),e._jQueryInterface.call(t(r),o),a&&t(r).data(v).to(a),n.preventDefault()}}},r(e,null,[{key:"VERSION",get:function(){return"4.4.1"}},{key:"Default",get:function(){return y}}]),e}();t(document).on(b.CLICK_DATA_API,"[data-slide], [data-slide-to]",A._dataApiClickHandler),t(window).on(b.LOAD_DATA_API,function(){for(var e=[].slice.call(document.querySelectorAll('[data-ride="carousel"]')),n=0,i=e.length;n<i;n++){var r=t(e[n]);A._jQueryInterface.call(r,r.data())}}),t.fn[m]=A._jQueryInterface,t.fn[m].Constructor=A,t.fn[m].noConflict=function(){return t.fn[m]=E,A._jQueryInterface}});