(function (FrontmanDetailsOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var editCommitteeCallback = function () {
    FrontmanDetailsOperations.EditCommittee(
      source, this.getAttribute("data-committee-name")
    )
  }

  var controllerCallback = function () {

    var editCommitteeButtons = document.getElementsByClassName(
      "edit-committee-button"
    );
    for (var i = 0; i < editCommitteeButtons.length; i++) {
      editCommitteeButtons[i].removeEventListener(
        "click", editCommitteeCallback
      );
      editCommitteeButtons[i].addEventListener(
        "click", editCommitteeCallback
      );
    }

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  FrontmanDetailsOperations.RenderBatchDetailsPage(
    source, controllerCallback
  );

})(FrontmanDetailsOperations, ProfileDropdown, Loader);
