(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, CalendarOperations) {

  CalendarOperations.AddEvent = function (source) {

    var form = document.getElementById("add-event-form");

    var endpoint = source + "action/calendar/add-event";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, AddEventCallback);
  }

  function AddEventCallback(status, responseText) {
    alert(responseText);
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.CalendarOperations = (
    this.CalendarOperations == undefined
  ) ? {} : this.CalendarOperations
  );