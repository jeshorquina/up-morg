(function (CalendarEventsViewOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  CalendarEventsViewOperations.RenderCalendarEventsViewPage(
    source, controllerCallback
  );

})(CalendarEventsViewOperations, ProfileDropdown, Loader);
