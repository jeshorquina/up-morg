(function (AvailabilityCommitteeOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var changeTimeRangeCallback = function () {
    AvailabilityCommitteeOperations.ChangeTimeRange();
  }

  var controllerCallback = function () {

    document
      .getElementById("time-range-button")
      .addEventListener("click", changeTimeRangeCallback)

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  AvailabilityCommitteeOperations.RenderAvailabilityCommitteePage(
    source, controllerCallback
  );

})(AvailabilityCommitteeOperations, ProfileDropdown, Loader);
