(function (EventAddOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  EventAddOperations.RenderEventAddPage(function () {

    document
      .getElementById("add-event-form")
      .addEventListener("submit", function (event) {
        event.preventDefault();
        EventAddOperations.AddEvent(source, this);
      });

    Loader.RemoveLoadingScreen();
  });

})(EventAddOperations, Loader);
