(function (CalendarTasksViewOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  CalendarTasksViewOperations.RenderCalendarTasksViewPage(
    source, controllerCallback
  );

})(CalendarTasksViewOperations, ProfileDropdown, Loader);
