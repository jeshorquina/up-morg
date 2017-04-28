(function (
  DomHelper, HttpHelper, AlertFactory,
  AvailabilityModifyFactory, AvailabilityModifyOperations
) {

  AvailabilityModifyOperations.RenderAvailabilitySchedule = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/availability";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityCallback(status, responseText, controllerCallback);
    });
  }

  AvailabilityModifyOperations.ToggleScheduleElement = function (element) {

    if (DomHelper.HasClass(element, "enabled")) {
      DomHelper.RemoveClass(element, "enabled");
    }
    else {
      DomHelper.AddClass(element, "enabled");
    }
  }

  function RenderAvailabilityCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      FillScheduleDetails(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillScheduleDetails(schedule) {

    DomHelper.InsertContent(
      "schedule-container-header",
      AvailabilityModifyFactory.MakeScheduleHeaderRow()
    )

    var scheduleContainer = document.getElementById("schedule-container");

    DomHelper.ClearContent(scheduleContainer);

    schedule.forEach(function (quarterHour, index) {
      DomHelper.AppendContent(
        scheduleContainer,
        AvailabilityModifyFactory.MakeScheduleRow(quarterHour, index)
      );
    });
  }

})(
  DomHelper, HttpHelper, AlertFactory, AvailabilityModifyFactory,
  this.AvailabilityModifyOperations = (
    this.AvailabilityModifyOperations == undefined
  ) ? {} : this.AvailabilityModifyOperations
  );