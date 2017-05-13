(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, CalendarTasksViewOperations
) {

  CalendarTasksViewOperations.RenderCalendarTasksViewPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/calendar/tasks";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderCalendarTasksViewPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderCalendarTasksViewPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      RenderCalendarWithDetails(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RenderCalendarWithDetails(details) {

    $('#calendar').fullCalendar({
      header: {
        left: 'prev,next',
        center: 'title',
        right: 'month,listWeek'
      },
      defaultDate: Date.now(),
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: details
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  this.CalendarTasksViewOperations = (
    this.CalendarTasksViewOperations == undefined
  ) ? {} : this.CalendarTasksViewOperations
  );