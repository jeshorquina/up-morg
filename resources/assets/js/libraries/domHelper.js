(function (DomHelper) {

  DomHelper.ClearHTML = function (el) {
    el.innerHTML = "";
  }

  DomHelper.AppendHTML = function (el, addition) {
    el.innerHTML = el.innerHTML + addition;
  }

})(this.DomHelper = (this.DomHelper == undefined) ? {} : this.DomHelper);
