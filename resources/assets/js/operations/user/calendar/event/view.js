(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  EventDetailsViewFactory, EventDetailsViewOperations
) {

  EventDetailsViewOperations.RenderEventDetailsViewPage = function (
    source, eventID, controllerCallback
  ) {

    var endpoint = source + "action/calendar/events/details/" + eventID;
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderEventDetailsViewCallback(status, responseText, controllerCallback);
    })
  }

  EventDetailsViewOperations.EditEvent = function (
    source, eventID, controllerCallback
  ) {
    UrlHelper.Redirect(source + "calendar/events/details/" + eventID + "/edit");
  }

  EventDetailsViewOperations.DeleteEvent = function (
    source, eventID, csrfObject, controllerCallback
  ) {

    if (confirm("Are you sure you want to delete this event?")) {

      var data = new FormData();
      data.append(csrfObject.name, csrfObject.value);

      var endpoint = (
        source + "action/calendar/events/details/" + eventID + "/delete"
      );

      HttpHelper.Post(endpoint, data, function (status, responseText) {
        RefreshRenderEventDetailsViewCallback(
          status, responseText, controllerCallback
        );
      });
    }
  }

  EventDetailsViewOperations.ViewOtherTaskDetails = function (source, taskID) {
    UrlHelper.Redirect(source + "task/view/details/" + taskID);
  }

  function RenderEventDetailsViewCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderEventDetailsSections(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderEventDetailsViewCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      if (!response.redirect_url) {

        RenderEventDetailsSections(response.data);
        controllerCallback();
      }
      else {
        UrlHelper.Redirect(response.redirect_url, 1000);
      }

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else {
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RenderEventDetailsSections(event) {

    FillEventDetails(event.details);
    FillTaskList(event.tasks);
    FillEventButtonContainer(event.flags, event.details.id);
  }

  function FillEventDetails(event) {

    var eventBreadcrumbName = (event.name.length > 30) ? (
      event.name.substr(0, 30) + "..."
    ) : event.name;
    DomHelper.InsertContent('event-breadcrumb-name', eventBreadcrumbName);

    var eventNames = document.getElementsByClassName('event-name');
    for (var i = 0; i < eventNames.length; i++) {
      DomHelper.InsertContent(eventNames[i], event.name);
    }

    var eventOwner = document.getElementsByClassName('event-owner');
    for (var i = 0; i < eventOwner.length; i++) {
      DomHelper.InsertContent(eventOwner[i], event.owner);
    }

    var eventDate = document.getElementsByClassName('event-date');
    for (var i = 0; i < eventDate.length; i++) {
      DomHelper.InsertContent(eventDate[i], event.date);
    }

    var eventDescription = document.getElementsByClassName('event-description');
    for (var i = 0; i < eventDescription.length; i++) {
      DomHelper.InsertContent(eventDescription[i], event.description);
    }

    if (new Boolean(event.image) != false) {
      DomHelper.InsertContent(
        "event-image-container",
        EventDetailsViewFactory.CreateEventImage(event.image)
      )
    }
    else if (document.getElementById("event-image-container")) {
      DomHelper.RemoveElement("event-image-container");
    }
  }

  function FillTaskList(tasks) {

    DomHelper.InsertContent(
      "event-tasks", EventDetailsViewFactory.CreateTaskList(tasks)
    );
  }

  function FillEventButtonContainer(flags, eventID) {
    if (flags.edit == true) {
      var eventButtonContainer = document.getElementById(
        "event-buttons-container"
      );
      DomHelper.InsertContent(
        eventButtonContainer, EventDetailsViewFactory.CreateEditButton(eventID)
      )
      DomHelper.AppendContent(
        eventButtonContainer, EventDetailsViewFactory.CreateDeleteButton(eventID)
      )
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, EventDetailsViewFactory,
  this.EventDetailsViewOperations = (
    this.EventDetailsViewOperations == undefined
  ) ? {} : this.EventDetailsViewOperations
  );