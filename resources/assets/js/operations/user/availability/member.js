(function (
  DomHelper, HttpHelper, AlertFactory,
  AvailabilityMemberFactory, AvailabilityMemberOperations
) {

  AvailabilityMemberOperations.schedules = [];
  AvailabilityMemberOperations.memberIndex = -1;
  AvailabilityMemberOperations.timeIntervals = [];

  AvailabilityMemberOperations.RenderAvailabilityMemberPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/availability/member";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityCallback(status, responseText, controllerCallback);
    });
  }

  AvailabilityMemberOperations.ChangeMemberDisplay = function (index) {
    AvailabilityMemberOperations.memberIndex = index;
    FillScheduleDetails();
  }

  function RenderAvailabilityCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      AvailabilityMemberOperations.schedules = response.data;
      FillSelectBox();
      FillTimeInterval();
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  AvailabilityMemberOperations.ChangeTimeRange = function() {

    var startTime = GetTime(document.getElementById("start-time").value);
    var endTime = GetTime(document.getElementById("end-time").value);

    AvailabilityMemberOperations.timeIntervals.forEach(function(timeInterval) {
      if(
          GetTime(timeInterval.interval.substr(0,5)) >= startTime && 
          GetTime(timeInterval.interval.substr(8,5)) <= endTime
      ) {
        timeInterval.enabled = true;
      }
      else
      {
        timeInterval.enabled = false;
      }
    });

    FillScheduleDetails();
  }

  function FillSelectBox()
  {
    DomHelper.InsertContent(
      "select-member-schedule",
      AvailabilityMemberFactory.MakeDefaultOption()
    )
    AvailabilityMemberOperations.schedules.forEach(function(schedule, index){
      DomHelper.AppendContent(
        "select-member-schedule",
        AvailabilityMemberFactory.MakeOption(schedule, index)
      )
    });
  }

  function FillScheduleDetails() {

    DomHelper.InsertContent(
      "schedule-container-header",
      AvailabilityMemberFactory.MakeScheduleHeaderRow()
    )

    var scheduleContainer = document.getElementById("schedule-container");

    DomHelper.ClearContent(scheduleContainer);

    AvailabilityMemberOperations.schedules[
      AvailabilityMemberOperations.memberIndex
    ].schedule.forEach(
      function (halfHour, index) {
        if(AvailabilityMemberOperations.timeIntervals[index].enabled) {
          DomHelper.AppendContent(
            scheduleContainer,
            AvailabilityMemberFactory.MakeScheduleRow(
              halfHour, index, 
              AvailabilityMemberOperations.timeIntervals[index].interval
            )
          );
        }
      }
    );
  }

  function FillTimeInterval() {

    var intervalSize = (
      AvailabilityMemberOperations.schedules[0].schedule.length
    );

    for(var i = 0; i < intervalSize; i++) {
      AvailabilityMemberOperations.timeIntervals.push({
        "interval": GetCurrentTimeRange(i),
        "enabled": true
      })
    }
  }

  function GetCurrentTimeRange(index) {

    var interval = 30;

    var lowerRangeSeconds = index * interval * 60;
    var upperRangeSeconds = (index + 1) * interval * 60;

    var lowerRange = (
      new Date(null, null, null, null, null, lowerRangeSeconds)
        .toTimeString().match(/\d{2}:\d{2}:\d{2}/)[0].substr(0, 5)
    );

    var upperRange = (
      new Date(null, null, null, null, null, upperRangeSeconds)
        .toTimeString().match(/\d{2}:\d{2}:\d{2}/)[0].substr(0, 5)
    )

    if(upperRange == "00:00") {
      upperRange = "24:00";
    }

    return lowerRange + " - " + upperRange;
  }

  function GetTime(time) {

    var time = time.split(":");
    return new Date(null, null, null, time[0], time[1], null);
  }

})(
  DomHelper, HttpHelper, AlertFactory, AvailabilityMemberFactory,
  this.AvailabilityMemberOperations = (
    this.AvailabilityMemberOperations == undefined
  ) ? {} : this.AvailabilityMemberOperations
  );