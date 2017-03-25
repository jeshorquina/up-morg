(function (DomHelper) {

  DomHelper.AddClass = function (el, className) {

    el = checkEl(el);
    if (!el.classList.contains(className)) {
      el.classList.add(className);
    }
  }

  DomHelper.RemoveClass = function (el, className) {

    el = checkEl(el);
    if (el.classList.contains(className)) {
      el.classList.remove(className);
    }
  }

  DomHelper.ClearHTML = function (el) {

    el = checkEl(el);
    el.innerHTML = "";
  }

  DomHelper.AppendHTML = function (el, addition) {

    el = checkEl(el);
    el.innerHTML = el.innerHTML + addition;
  }

  DomHelper.InnerHTML = function (el, value) {

    el = checkEl(el);

    DomHelper.ClearHTML(el);
    DomHelper.AppendHTML(el, value);
  }

  function checkEl(el) {
    return (typeof el == 'string') ? document.getElementById(el) : el;
  }

})(this.DomHelper = (this.DomHelper == undefined) ? {} : this.DomHelper);
