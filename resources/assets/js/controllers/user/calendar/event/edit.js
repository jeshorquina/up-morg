(function (EventEditOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    eventID = document
      .getElementById("event-details-container")
      .getAttribute("data-event-id");


  var editEventCallback = function (event) {
    event.preventDefault();
    EventEditOperations.EditEvent(source, this, eventID, controllerCallback);
  }

  var controllerCallback = function () {

    document
      .getElementById("edit-event-form")
      .addEventListener("submit", editEventCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  EventEditOperations.RenderEventEditPage(source, eventID, controllerCallback);

})(EventEditOperations, ProfileDropdown, Loader);
