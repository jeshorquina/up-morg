(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, AvailabilityOperations) {

  AvailabilityOperations.UpdateSchedule = function (source) {

    var form = document.getElementById("update-schedule-form");

    var endpoint = source + "action/availability-tracker/update-schedule";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, UpdateScheduleCallback);
  }

  function UpdateScheduleCallback(status, responseText) {
    alert(responseText);
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.AvailabilityOperations = (
    this.AvailabilityOperations == undefined
  ) ? {} : this.AvailabilityOperations
  );