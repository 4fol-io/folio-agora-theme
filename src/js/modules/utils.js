/**
  * Debounce ES6 implementation
  * https://gist.github.com/beaucharman/1f93fdd7c72860736643d1ab274fee1a
  */
export const debounce = function (callback, wait, immediate = false) {
    let timeout = null;
    return function() {
      const callNow = immediate && !timeout;
      const next = () => callback.apply(this, arguments);

      clearTimeout(timeout);
      timeout = setTimeout(next, wait);

      if (callNow) {
        next();
      }
    }
};

/**
 * Mobile devices detection
 */
export const isMobile = {
    Android: function() {
        return navigator.userAgent.match(/Android/i);
    },
    BlackBerry: function() {
        return navigator.userAgent.match(/BlackBerry/i);
    },
    iOS: function() {
        return navigator.userAgent.match(/iPhone|iPad|iPod/i);
    },
    Opera: function() {
        return navigator.userAgent.match(/Opera Mini/i);
    },
    Windows: function() {
        return navigator.userAgent.match(/IEMobile/i);
    },
    any: function() {
        return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
    }
};


/**
 * Go to Behaviour
 */
export const goTo = function (elm, behavior, offset, callback) {
  behavior = behavior || 'smooth';
  offset = offset || 0;

  const top = (elm.getBoundingClientRect().top + (window.scrollY || document.documentElement.scrollTop) - offset).toFixed();

  const onScrollTo = function () {
    if (window.pageYOffset.toFixed() === top) {
      window.removeEventListener('scroll', onScrollTo)
      if (callback) callback()
    }
  }

  window.addEventListener('scroll', onScrollTo)
  onScrollTo()

  window.scrollTo({
    top: top,
    behavior: behavior
  })

};


/**
 * Aux method object length
 *
 * @param {object} obj
 */
export const count = function(obj){
  if( $.isPlainObject(obj) || Array.isArray(obj) )
    return $.map(obj, function() { return 1; }).length;
  return 0;
};


/**
  * Replace querystring parameter or add it
  * @param {string} url 
  * @param {string} paramName 
  * @param {string} paramValue 
  * @returns 
  */
export const replaceUrlParam = function (url, paramName, paramValue) {
    if (paramValue == null) {
        paramValue = '';
    }
    var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
    if (url.search(pattern)>=0) {
        url = url.replace(pattern,'$1' + paramValue + '$2');
    } else {
      url = url.replace(/[?#]$/,'');
      url = url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
    }
    if(history){
      history.replaceState(null, null, url );
    }
    return url;
}