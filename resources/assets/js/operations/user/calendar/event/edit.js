(function (DomHelper, HttpHelper, AlertFactory, EventEditOperations) {

  EventEditOperations.RenderEventEditPage = function (
    source, eventID, controllerCallback
  ) {

    var endpoint = (
      source + "action/calendar/events/details/" + eventID + "/edit-details"
    );

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderEventEditPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  EventEditOperations.EditEvent = function (
    source, form, eventID, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = (
      source + "action/calendar/events/details/" + eventID + "/edit"
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRenderEventEditPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderEventEditPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderDatePickerPlugin(response.data);
      FillEventData(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderEventEditPageCallback(status, responseText) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    ResetFormValidation();

    if (status == HttpHelper.OK) {

      FillEventData(response.data);

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );

      Object.keys(response.data).forEach(function (id) {
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(id + "-error", response.data[id]);
      });
    }
    else {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function ResetFormValidation() {
    [
      'event-name', 'event-description', 'event-start-date'
    ].forEach(function (value) {
      if (DomHelper.HasClass(value, "form-input-error")) {
        DomHelper.RemoveClass(value, "form-input-error");
        DomHelper.ClearContent(value + "-error");
      }
    });
  }

  function RenderDatePickerPlugin(event) {

    flatpickr("#event-start-date.flatpickr-input-date", {
      enableTime: false,
      altInput: true,
      defaultDate: event.date.start
    });

    flatpickr("#event-end-date.flatpickr-input-date", {
      enableTime: false,
      altInput: true,
      defaultDate: event.date.end
    });

    flatpickr("#event-start-time.flatpickr-input-time", {
      defaultDate: event.time.start,
      enableTime: true,
      altInput: true,
      noCalendar: true,
      enableSeconds: false,
      time_24hr: false,
      dateFormat: "H:i",
    });

    flatpickr("#event-end-time.flatpickr-input-time", {
      defaultDate: event.time.end,
      enableTime: true,
      altInput: true,
      noCalendar: true,
      enableSeconds: false,
      time_24hr: false,
      dateFormat: "H:i",
    });
  }

  function FillEventData(event) {

    var eventBreadcrumbName = (event.name.length > 30) ? (
      event.name.substr(0, 30) + "..."
    ) : event.name;
    DomHelper.InsertContent('event-breadcrumb-name', eventBreadcrumbName);

    var visibility = (event.public) ? "public" : "internal";

    DomHelper.InputValue("event-name", event.name);
    DomHelper.InputValue("event-description", event.description);
    DomHelper.InputValue("event-visibility", visibility);
  }

})(
  DomHelper, HttpHelper, AlertFactory,
  this.EventEditOperations = (
    this.EventEditOperations == undefined
  ) ? {} : this.EventEditOperations
  );