(function (AvailabilityModifyOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var toggleScheduleElementHoverCallback = function (event) {
    if (event.ctrlKey) {
      AvailabilityModifyOperations.ToggleScheduleElement(this);
    }
  }

  var toggleScheduleElementClickCallback = function () {
    AvailabilityModifyOperations.ToggleScheduleElement(this);
  }

  var controllerCallback = function () {

    var scheduleElements = document.getElementsByClassName("schedule-element");
    for (var i = 0; i < scheduleElements.length; i++) {
      scheduleElements[i].addEventListener(
        "mouseover", toggleScheduleElementHoverCallback
      );
      scheduleElements[i].addEventListener(
        "click", toggleScheduleElementClickCallback
      )
    }
  }

  AvailabilityModifyOperations.RenderAvailabilitySchedule(
    source, controllerCallback
  );

})(AvailabilityModifyOperations);