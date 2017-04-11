(function (CalendarOperations) {

  document
    .getElementById("add-event-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      CalendarOperations.AddEvent(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(CalendarOperations);