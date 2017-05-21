(function (FrontmanDetailsOperations, ProfileDropdown, Loader) {

  var source = (
    document
      .getElementsByTagName("body")[0]
      .getAttribute("data-source")
  );

  var modifyFrontmanCallback = function (event) {
    event.preventDefault();
    FrontmanDetailsOperations.ModifyFrontman(source, controllerCallback);
  }

  var controllerCallback = function () {

    document
      .getElementById("modify-frontmen-form")
      .addEventListener("submit", modifyFrontmanCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  FrontmanDetailsOperations.RenderFrontmanDetailsPage(
    source, controllerCallback
  );

})(FrontmanDetailsOperations, ProfileDropdown, Loader);
