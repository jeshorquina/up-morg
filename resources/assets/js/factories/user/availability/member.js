(function (DomHelper, AvailabilityMemberFactory) {

  AvailabilityMemberFactory.MakeDefaultOption = function() {

    return DomHelper.CreateElement("option", {
      "selected": "selected",
      "disabled": "disabled"
    }, "Please select one member");
  }

  AvailabilityMemberFactory.MakeOption = function(schedule, index) {
    
    return DomHelper.CreateElement("option", {
      "value": index
    }, schedule.owner);
  }

  AvailabilityMemberFactory.MakeScheduleHeaderRow = function () {

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

  AvailabilityMemberFactory.MakeScheduleRow = function (
    halfHour, index, timeInterval
  ) {

    var sunday = (
      (halfHour.Sunday == "1") ?
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
        (halfHour.Monday == "1") ?
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
        (halfHour.Tuesday == "1") ?
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
        (halfHour.Wednesday == "1") ?
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
        (halfHour.Thursday == "1") ?
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
        (halfHour.Friday == "1") ?
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
        (halfHour.Saturday == "1") ?
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
        DomHelper.CreateElement("td", {}, timeInterval),
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

})(
  DomHelper, this.AvailabilityMemberFactory = (
    this.AvailabilityMemberFactory == undefined
  ) ? {} : this.AvailabilityMemberFactory
  );