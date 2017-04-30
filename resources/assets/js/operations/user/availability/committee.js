(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  AvailabilityCommitteeFactory, AvailabilityCommitteeOperations
) {

  AvailabilityCommitteeOperations.timeIntervals = [];
  AvailabilityCommitteeOperations.schedule = [];

  AvailabilityCommitteeOperations.RenderAvailabilityCommitteePage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/availability/committee";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityCommitteeCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderAvailabilityCommitteeCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillTimeInterval(response.data.committee.members);
      FillSchedule(response.data.committee.members);

      RenderSharedSchedule();

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  AvailabilityCommitteeOperations.ChangeTimeRange = function () {

    var startTime = GetTime(document.getElementById("start-time").value);
    var endTime = GetTime(document.getElementById("end-time").value);

    AvailabilityCommitteeOperations.timeIntervals.forEach(
      function (timeInterval) {
        if (
          GetTime(timeInterval.interval.substr(0, 5)) >= startTime &&
          GetTime(timeInterval.interval.substr(8, 5)) <= endTime
        ) {
          timeInterval.enabled = true;
        }
        else {
          timeInterval.enabled = false;
        }
      }
    );

    RenderSharedSchedule();
  }

  function FillTimeInterval(members) {

    for (var i = 0; i < members[0].schedule.length; i++) {
      AvailabilityCommitteeOperations.timeIntervals.push({
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

    if (upperRange == "00:00") {
      upperRange = "24:00";
    }

    return lowerRange + " - " + upperRange;
  }

  function FillSchedule(members) {

    members.forEach(function (member) {
      member.schedule.forEach(function (block, index) {
        Object.keys(block).forEach(function (day) {
          if (block[day] == "0") {
            AddToScheduleBlock(member.name, index, day, "unavailable");
          }
          else {
            AddToScheduleBlock(member.name, index, day, "available");
          }
        })
      });
    });
  }

  function AddToScheduleBlock(name, index, day, availability) {

    if (typeof AvailabilityCommitteeOperations.schedule[index] == "undefined") {
      AvailabilityCommitteeOperations.schedule.push({
        "Sunday": {
          "available": [],
          "unavailable": []
        },
        "Monday": {
          "available": [],
          "unavailable": []
        },
        "Tuesday": {
          "available": [],
          "unavailable": []
        },
        "Wednesday": {
          "available": [],
          "unavailable": []
        },
        "Thursday": {
          "available": [],
          "unavailable": []
        },
        "Friday": {
          "available": [],
          "unavailable": []
        },
        "Saturday": {
          "available": [],
          "unavailable": []
        }
      });
    }

    AvailabilityCommitteeOperations.schedule[index][day][availability].push(
      name
    );
  }

  function RenderSharedSchedule() {

    DomHelper.InsertContent(
      "schedule-container-header",
      AvailabilityCommitteeFactory.MakeScheduleHeaderRow()
    )

    var scheduleContainer = document.getElementById("schedule-container");

    DomHelper.ClearContent(scheduleContainer);

    AvailabilityCommitteeOperations.schedule.forEach(
      function (halfHour, index) {
        if (AvailabilityCommitteeOperations.timeIntervals[index].enabled) {
          DomHelper.AppendContent(
            scheduleContainer,
            AvailabilityCommitteeFactory.MakeScheduleRow(
              halfHour, index,
              AvailabilityCommitteeOperations.timeIntervals[index].interval
            )
          );
        }
      }
    );
  }

  function GetTime(time) {

    var time = time.split(":");
    return new Date(null, null, null, time[0], time[1], null);
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, AvailabilityCommitteeFactory,
  this.AvailabilityCommitteeOperations = (
    this.AvailabilityCommitteeOperations == undefined
  ) ? {} : this.AvailabilityCommitteeOperations
  );