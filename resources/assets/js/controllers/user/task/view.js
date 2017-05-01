(function (TaskViewOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var controllerCallback = function () {

    Loader.RemoveLoadingScreen();
  }

  TaskViewOperations.RenderTaskViewPage(source, controllerCallback);

})(TaskViewOperations);
