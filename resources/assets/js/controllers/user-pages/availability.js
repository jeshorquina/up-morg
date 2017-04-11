(function (AvailabilityOperations) {

  document
    .getElementById("update-schedule-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      AvailabilityOperations.UpdateSchedule(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(AvailabilityOperations);