(function (AvailabilityModifyOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    isMouseDown = false,
    isSelected;

  document.addEventListener("mouseup", function () {
    isMouseDown = false;
  });

  var toggleScheduleElementMouseDown = function () {
    isMouseDown = true;
    isSelected = (
      AvailabilityModifyOperations.ToggleScheduleElement(this)
    );
  }

  var toggleScheduleElementMouseOver = function () {
    if (isMouseDown) {
      isSelected = AvailabilityModifyOperations.ToggleScheduleElement(
        this, isSelected
      );
    }
  }

  var updateScheduleCallback = function () {
    AvailabilityModifyOperations.UpdateSchedule(source, {
      "name": body.getAttribute("data-csrf-name"),
      "value": body.getAttribute("data-csrf-hash")
    });
  }

  var controllerCallback = function () {

    var scheduleElements = document.getElementsByClassName("schedule-element");
    for (var i = 0; i < scheduleElements.length; i++) {
      scheduleElements[i].addEventListener(
        "mousedown", toggleScheduleElementMouseDown
      );
      scheduleElements[i].addEventListener(
        "mouseover", toggleScheduleElementMouseOver
      );
    }

    document
      .getElementById("button-update-schedule")
      .addEventListener("click", updateScheduleCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  AvailabilityModifyOperations.RenderAvailabilitySchedule(
    source, controllerCallback
  );

})(AvailabilityModifyOperations, ProfileDropdown, Loader);