(function (AvailabilityMemberOperations, Loader) {

  var source = (
    document.getElementsByTagName("body")[0].getAttribute("data-source")
  );

  var viewMemberScheduleCallback = function () {
    AvailabilityMemberOperations.ChangeMemberDisplay(this.value);
  }

  var changeTimeRangeCallback = function () {
    AvailabilityMemberOperations.ChangeTimeRange();
  }

  var controllerCallback = function () {

    document
      .getElementById("select-member-schedule")
      .addEventListener("change", viewMemberScheduleCallback);

    document
      .getElementById("time-range-button")
      .addEventListener("click", changeTimeRangeCallback)

    Loader.RemoveLoadingScreen();
  }

  AvailabilityMemberOperations.RenderAvailabilityMemberPage(
    source, controllerCallback
  );

})(AvailabilityMemberOperations, Loader);