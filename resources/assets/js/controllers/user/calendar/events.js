(function (CalendarEventsViewOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    Loader.RemoveLoadingScreen();
  }

  CalendarEventsViewOperations.RenderCalendarEventsViewPage(
    source, controllerCallback
  );

})(CalendarEventsViewOperations, Loader);
