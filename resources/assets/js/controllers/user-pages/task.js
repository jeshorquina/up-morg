(function (TaskOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");
  
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

    var controllerCallback = function () {

    }

    TaskOperations.RenderCurrentUserTasks(source, controllerCallback);
    TaskOperations.RenderReportedTasks(source, controllerCallback);

})(TaskOperations);