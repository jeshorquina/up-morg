(function (AvailabilityGroupViewOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    groupID = (
      document
        .getElementById("availability-group-view-container")
        .getAttribute("data-group-id")
    );

  var changeTimeRangeCallback = function () {
    AvailabilityGroupViewOperations.ChangeTimeRange();
  }

  var controllerCallback = function () {

    document
      .getElementById("time-range-button")
      .addEventListener("click", changeTimeRangeCallback)

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  AvailabilityGroupViewOperations.RenderAvailabilityGroupViewPage(
    source, groupID, controllerCallback
  );

})(AvailabilityGroupViewOperations, ProfileDropdown, Loader);
