(function (EventDetailsViewOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");
  var eventID = document
    .getElementById("event-details-container")
    .getAttribute("data-event-id");

  var viewOtherTaskCallback = function () {
    EventDetailsViewOperations.ViewOtherTaskDetails(
      source, this.getAttribute("data-task-id")
    );
  }

  var editEventCallback = function () {
    EventDetailsViewOperations.EditEvent(
      source, eventID, controllerCallback
    );
  }

  var deleteEventCallback = function () {
    EventDetailsViewOperations.DeleteEvent(
      source, eventID, {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    );
  }

  var controllerCallback = function () {

    var taskRows = document.getElementsByClassName("view-task-details");
    for (var i = 0; i < taskRows.length; i++) {
      taskRows[i].addEventListener("click", viewOtherTaskCallback);
    }

    document
      .getElementById("edit-event-button")
      .addEventListener("click", editEventCallback);

    document
      .getElementById("delete-event-button")
      .addEventListener("click", deleteEventCallback);

    Loader.RemoveLoadingScreen();
  }

  EventDetailsViewOperations.RenderEventDetailsViewPage(
    source, eventID, controllerCallback
  );

})(EventDetailsViewOperations);
