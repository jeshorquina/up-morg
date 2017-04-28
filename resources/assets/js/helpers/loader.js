(function (Loader) {

  var loaderElement = document.getElementById("loader");

  Loader.DisplayLoadingScreen = function () {
    loaderElement.style.display = "flex";
  }

  Loader.RemoveLoadingScreen = function () {
    loaderElement.style.opacity = 1;
    fade(loaderElement);
  }

  function fade() {
    if ((loaderElement.style.opacity -= .1) < 0) {
      loaderElement.style.display = "none"
    }
    else {
      setTimeout(fade, 50)
    }
  }

})(this.Loader = (this.Loader == undefined) ? {} : this.Loader);
