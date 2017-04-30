(function (TaskAddOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    Loader.RemoveLoadingScreen();
  }

  TaskAddOperations.RenderTaskAddPage(source, controllerCallback);

})(TaskAddOperations, Loader);
