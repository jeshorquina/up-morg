(function (DomHelper, AvailabilityModifyFactory) {

  AvailabilityModifyFactory.MakeScheduleHeaderRow = function () {

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement("td", { "width": "16%" }),
      DomHelper.CreateElement("td", { "width": "12%" }, "Sunday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Monday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Tuesday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Wednesday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Thursday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Friday"),
      DomHelper.CreateElement("td", { "width": "12%" }, "Saturday"),
    ]);
  }

  AvailabilityModifyFactory.MakeScheduleRow = function (quarterHour, index) {

    var sunday = (
      (quarterHour.Sunday == "1") ?
        {
          "class": "schedule-element enabled",
          "data-day": "Sunday",
          "data-index": index
        } : {
          "class": "schedule-element",
          "data-day": "Sunday",
          "data-index": index
        }
    ),
      monday = (
        (quarterHour.Monday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Monday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Monday",
            "data-index": index
          }
      ),
      tuesday = (
        (quarterHour.Tuesday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Tuesday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Tuesday",
            "data-index": index
          }
      ),
      wednesday = (
        (quarterHour.Wednesday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Wednesday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Wednesday",
            "data-index": index
          }
      ),
      thursday = (
        (quarterHour.Thursday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Thursday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Thursday",
            "data-index": index
          }
      ),
      friday = (
        (quarterHour.Friday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Friday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Friday",
            "data-index": index
          }
      ),
      saturday = (
        (quarterHour.Saturday == "1") ?
          {
            "class": "schedule-element enabled",
            "data-day": "Saturday",
            "data-index": index
          } : {
            "class": "schedule-element",
            "data-day": "Saturday",
            "data-index": index
          }
      );

    return DomHelper.CreateElement("tr", {},
      [
        DomHelper.CreateElement("td", {}, GetCurrentTimeRange(index)),
        DomHelper.CreateElement("td", sunday),
        DomHelper.CreateElement("td", monday),
        DomHelper.CreateElement("td", tuesday),
        DomHelper.CreateElement("td", wednesday),
        DomHelper.CreateElement("td", thursday),
        DomHelper.CreateElement("td", friday),
        DomHelper.CreateElement("td", saturday)
      ]
    );
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

    return lowerRange + " - " + upperRange;
  }

})(
  DomHelper, this.AvailabilityModifyFactory = (
    this.AvailabilityModifyFactory == undefined
  ) ? {} : this.AvailabilityModifyFactory
  );