(function (DomHelper, AvailabilityGroupViewFactory) {

  AvailabilityGroupViewFactory.MakeScheduleHeaderRow = function () {

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

  AvailabilityGroupViewFactory.MakeScheduleRow = function (
    halfHour, index, timeInterval
  ) {

    var sunday = {
      "class": "schedule-element percent-" + Math.round(
        (halfHour.Sunday.available.length / (
          halfHour.Sunday.available.length + halfHour.Sunday.unavailable.length
        )) * 100
      ),
      "data-day": "Sunday",
      "data-index": index
    },
      monday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Monday.available.length / (
            halfHour.Monday.available.length + halfHour.Monday.unavailable.length
          )) * 100
        ),
        "data-day": "Monday",
        "data-index": index
      },
      tuesday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Tuesday.available.length / (
            halfHour.Tuesday.available.length + halfHour.Tuesday.unavailable.length
          )) * 100
        ),
        "data-day": "Tuesday",
        "data-index": index
      },
      wednesday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Wednesday.available.length / (
            halfHour.Wednesday.available.length + halfHour.Wednesday.unavailable.length
          )) * 100
        ),
        "data-day": "Wednesday",
        "data-index": index
      },
      thursday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Thursday.available.length / (
            halfHour.Thursday.available.length + halfHour.Thursday.unavailable.length
          )) * 100
        ),
        "data-day": "Thursday",
        "data-index": index
      },
      friday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Friday.available.length / (
            halfHour.Friday.available.length + halfHour.Friday.unavailable.length
          )) * 100
        ),
        "data-day": "Friday",
        "data-index": index
      },
      saturday = {
        "class": "schedule-element percent-" + Math.round(
          (halfHour.Saturday.available.length / (
            halfHour.Saturday.available.length + halfHour.Saturday.unavailable.length
          )) * 100
        ),
        "data-day": "Saturday",
        "data-index": index
      };

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

  AvailabilityGroupViewFactory.MakeEmptyScheduleRow = function () {

    return DomHelper.CreateElement("tr", {},
      DomHelper.CreateElement(
        "td", {
          "colspan": "8",
          "class": "empty-row"
        }, "There are no group members. Add some first to show shared schedule."
      )
    );
  }

})(
  DomHelper, this.AvailabilityGroupViewFactory = (
    this.AvailabilityGroupViewFactory == undefined
  ) ? {} : this.AvailabilityGroupViewFactory
  );