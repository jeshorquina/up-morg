(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  AvailabilityGroupViewFactory, AvailabilityGroupViewOperations
) {

  AvailabilityGroupViewOperations.timeIntervals = [];
  AvailabilityGroupViewOperations.schedule = [];

  AvailabilityGroupViewOperations.RenderAvailabilityGroupViewPage = function (
    source, groupID, controllerCallback
  ) {

    var endpoint = source + "action/availability/group/view/" + groupID;
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderAvailabilityGroupViewCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderAvailabilityGroupViewCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillGroupName(response.data.group.name);
      FillTimeInterval(response.data.group.members);
      FillSchedule(response.data.group.members);

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

  AvailabilityGroupViewOperations.ChangeTimeRange = function () {

    var startTime = GetTime(document.getElementById("start-time").value);
    var endTime = GetTime(document.getElementById("end-time").value);

    AvailabilityGroupViewOperations.timeIntervals.forEach(
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

  function FillGroupName(groupName) {

    var groupNameContainers = document.getElementsByClassName("group-name");
    for (var i = 0; i < groupNameContainers.length; i++) {
      DomHelper.InsertContent(groupNameContainers[i], groupName);
    }
  }

  function FillTimeInterval(members) {

    if (members.length > 0) {
      for (var i = 0; i < members[0].schedule.length; i++) {
        AvailabilityGroupViewOperations.timeIntervals.push({
          "interval": GetCurrentTimeRange(i),
          "enabled": true
        })
      }
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

    if (members.length > 0) {
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
  }

  function AddToScheduleBlock(name, index, day, availability) {

    if (typeof AvailabilityGroupViewOperations.schedule[index] == "undefined") {
      AvailabilityGroupViewOperations.schedule.push({
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

    AvailabilityGroupViewOperations.schedule[index][day][availability].push(
      name
    );
  }

  function RenderSharedSchedule() {

    DomHelper.InsertContent(
      "schedule-container-header",
      AvailabilityGroupViewFactory.MakeScheduleHeaderRow()
    );

    if (AvailabilityGroupViewOperations.schedule.length > 0) {

      var scheduleContainer = document.getElementById("schedule-container");

      DomHelper.ClearContent(scheduleContainer);

      AvailabilityGroupViewOperations.schedule.forEach(
        function (halfHour, index) {
          if (AvailabilityGroupViewOperations.timeIntervals[index].enabled) {
            DomHelper.AppendContent(
              scheduleContainer,
              AvailabilityGroupViewFactory.MakeScheduleRow(
                halfHour, index,
                AvailabilityGroupViewOperations.timeIntervals[index].interval
              )
            );
          }
        }
      );
    }
    else {
      DomHelper.InsertContent(
        "schedule-container",
        AvailabilityGroupViewFactory.MakeEmptyScheduleRow()
      )

    }
  }

  function GetTime(time) {

    var time = time.split(":");
    return new Date(null, null, null, time[0], time[1], null);
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, AvailabilityGroupViewFactory,
  this.AvailabilityGroupViewOperations = (
    this.AvailabilityGroupViewOperations == undefined
  ) ? {} : this.AvailabilityGroupViewOperations
  );