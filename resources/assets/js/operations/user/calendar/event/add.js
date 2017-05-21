(function (DomHelper, HttpHelper, UrlHelper, AlertFactory, EventAddOperations) {

  EventAddOperations.RenderEventAddPage = function (controllerCallback) {

    RenderDatePickerPlugin();
    controllerCallback();
  }

  EventAddOperations.AddEvent = function (source, form) {

    var data = new FormData(form);
    var endpoint = source + "action/calendar/add/event";

    HttpHelper.Post(endpoint, data, RenderEventAddPageCallback);
  }

  function RenderEventAddPageCallback(status, responseText) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    ResetFormValidation();

    if (status == HttpHelper.CREATED) {

      document.getElementById("add-event-form").reset();

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );

      UrlHelper.Redirect(response.redirect_url, 1000);
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

  function RenderDatePickerPlugin() {

    flatpickr(".flatpickr-input-date", {
      enableTime: false,
      altInput: true,
    });

    flatpickr(".flatpickr-input-time", {
      enableTime: true,
      altInput: true,
      noCalendar: true,
      enableSeconds: false,
      time_24hr: false,
      dateFormat: "H:i",
    });
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

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  this.EventAddOperations = (
    this.EventAddOperations == undefined
  ) ? {} : this.EventAddOperations
  );