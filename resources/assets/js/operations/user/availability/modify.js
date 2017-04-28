(function (
  DomHelper, HttpHelper, AlertFactory,
  AvailabilityModifyFactory, AvailabilityModifyOperations
) {

  AvailabilityModifyOperations.schedule = [];

  AvailabilityModifyOperations.RenderAvailabilitySchedule = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/availability";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityCallback(status, responseText, controllerCallback);
    });
  }

  AvailabilityModifyOperations.ToggleScheduleElement = function (
    element, isSelected
  ) {

    var day = element.getAttribute("data-day");
    var index = element.getAttribute("data-index");
    var value;

    if (typeof isSelected == "undefined") {
      if (DomHelper.HasClass(element, "enabled")) {
        DomHelper.RemoveClass(element, "enabled");
        value = false;
      }
      else {
        DomHelper.AddClass(element, "enabled");
        value = true;
      }
    }
    else {
      if (DomHelper.HasClass(element, "enabled")) {
        if (!isSelected) {
          DomHelper.RemoveClass(element, "enabled");
          value = false;
        }
        else {
          value = true;
        }
      }
      else {
        if (isSelected) {
          DomHelper.AddClass(element, "enabled");
          value = true;
        }
        else {
          value = false;
        }
      }
    }

    AvailabilityModifyOperations.schedule[index][day] = (value) ? "1" : "0";

    return value;
  }

  AvailabilityModifyOperations.UpdateSchedule = function (source, csrfObject) {

    var data = new FormData();
    data.append(csrfObject.name, csrfObject.value);
    data.append("data", JSON.stringify(AvailabilityModifyOperations.schedule));

    var endpoint = source + "action/availability/update";

    HttpHelper.Post(endpoint, data, UpdateScheduleCallback);
  }

  function RenderAvailabilityCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      AvailabilityModifyOperations.schedule = response.data;
      FillScheduleDetails();
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillScheduleDetails() {

    DomHelper.InsertContent(
      "schedule-container-header",
      AvailabilityModifyFactory.MakeScheduleHeaderRow()
    )

    var scheduleContainer = document.getElementById("schedule-container");

    DomHelper.ClearContent(scheduleContainer);

    AvailabilityModifyOperations.schedule.forEach(
      function (quarterHour, index) {
        DomHelper.AppendContent(
          scheduleContainer,
          AvailabilityModifyFactory.MakeScheduleRow(quarterHour, index)
        );
      }
    );
  }

  function UpdateScheduleCallback(status, responseText) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK) {
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

})(
  DomHelper, HttpHelper, AlertFactory, AvailabilityModifyFactory,
  this.AvailabilityModifyOperations = (
    this.AvailabilityModifyOperations == undefined
  ) ? {} : this.AvailabilityModifyOperations
  );