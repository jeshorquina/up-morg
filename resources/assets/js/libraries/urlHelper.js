(function (UrlHelper) {

  UrlHelper.Redirect = function (url, delay) {
    setTimeout(function () {
      window.location = url;
    }, delay);
  }

})(this.UrlHelper = (this.UrlHelper == undefined) ? {} : this.UrlHelper);
