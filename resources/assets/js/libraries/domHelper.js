(function (DomHelper) {

  DomHelper.AddClass = function (element, className) {

    element = checkEl(element);
    if (!element.classList.contains(className)) {
      element.classList.add(className);
    }
  }

  DomHelper.RemoveClass = function (element, className) {

    element = checkEl(element);
    if (element.classList.contains(className)) {
      element.classList.remove(className);
    }
  }

  DomHelper.ClearHTML = function (element) {

    element = checkEl(element);
    element.innerHTML = "";
  }

  DomHelper.AppendHTML = function (element, addition) {

    element = checkEl(element);
    element.innerHTML = element.innerHTML + addition;
  }

  DomHelper.InnerHTML = function (element, value) {

    element = checkEl(element);

    DomHelper.ClearHTML(element);
    DomHelper.AppendHTML(element, value);
  }

  DomHelper.InputValue = function (element, value) {

    element = checkEl(element);
    element.value = value;
  }

  function checkEl(element) {
    return (typeof element == 'string') ? document.getElementById(element) : element;
  }

})(this.DomHelper = (this.DomHelper == undefined) ? {} : this.DomHelper);
