(function (EventsOperations, Loader) {

  var source = (
    document
      .getElementsByTagName("body")[0]
      .getAttribute("data-source")
  );

  var controllerCallback = function () {

    Loader.RemoveLoadingScreen();
  }

  EventsOperations.RenderEvents(source, controllerCallback);

})(EventsOperations, Loader);
