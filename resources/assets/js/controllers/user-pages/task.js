(function (TaskOperations) {

  document
    .getElementById("add-task-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      TaskOperations.AddTask(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(TaskOperations);