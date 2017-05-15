(function (
  DomHelper, AlertFactory, HttpHelper, EventsFactory,
  EventsOperations
) {

  EventsOperations.RenderEvents = function (source, controllerCallback) {

    var endpoint = source + "action/events";
    HttpHelper.Get(endpoint, function (status, responseText) {
      EventsPageCallback(status, responseText, controllerCallback);
    });
  }

  function EventsPageCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      response.data.forEach(function (event) {
        DomHelper.AppendContent(
          "events-container", EventsFactory.CreateEventSection(event)
        )
      });

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, EventsFactory,
  this.EventsOperations = (
    this.EventsOperations == undefined
  ) ? {} : this.EventsOperations
  );
