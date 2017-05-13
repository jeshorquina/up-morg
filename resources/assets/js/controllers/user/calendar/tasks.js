(function (CalendarTasksViewOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    Loader.RemoveLoadingScreen();
  }

  CalendarTasksViewOperations.RenderCalendarTasksViewPage(
    source, controllerCallback
  );

})(CalendarTasksViewOperations, Loader);
