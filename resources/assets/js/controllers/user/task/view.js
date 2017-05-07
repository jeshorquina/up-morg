(function (TaskViewOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var viewTaskDetailsCallback = function () {
    TaskViewOperations.ViewTaskDetails(
      source, this.getAttribute('data-task-id')
    );
  }

  var controllerCallback = function () {

    var viewTaskDetailsButton = document.getElementsByClassName(
      "view-task-details"
    );
    for (var i = 0; i < viewTaskDetailsButton.length; i++) {
      viewTaskDetailsButton[i].addEventListener(
        'click', viewTaskDetailsCallback
      );
    }

    Loader.RemoveLoadingScreen();
  }

  TaskViewOperations.RenderTaskViewPage(source, controllerCallback);

})(TaskViewOperations);
