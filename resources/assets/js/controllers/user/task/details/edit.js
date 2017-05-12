(function (TaskEditOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    taskID = document
      .getElementById("task-details-container")
      .getAttribute("data-task-id");

  var viewOtherTaskCallback = function () {
    TaskEditOperations.ViewOtherTaskDetails(
      source, this.getAttribute("data-task-id")
    );
  }

  var editTaskCallback = function (event) {
    event.preventDefault();
    TaskEditOperations.EditTask(source, this, taskID, controllerCallback);
  }

  var addSubscriberCallback = function () {
    TaskEditOperations.AddSubscriber(
      document.getElementById("task-subscribers").value, controllerCallback
    );
  }

  var removeSubscriberCallback = function () {
    TaskEditOperations.RemoveSubscriber(
      this.getAttribute("data-subscriber-id"), controllerCallback
    );
  }

  var controllerCallback = function () {

    if (document.getElementById("parent-task-title-link")) {
      document
        .getElementById("parent-task-title-link")
        .addEventListener("click", viewOtherTaskCallback);
    }

    document
      .getElementById("edit-task-form")
      .addEventListener("submit", editTaskCallback);

    document
      .getElementById("task-subscribers-submit")
      .addEventListener("click", addSubscriberCallback);

    var removeSubscriberButtons = document.getElementsByClassName(
      "remove-subscriber-button"
    );
    for (var i = 0; i < removeSubscriberButtons.length; i++) {
      removeSubscriberButtons[i].addEventListener(
        "click", removeSubscriberCallback
      );
    }

    Loader.RemoveLoadingScreen();
  }

  TaskEditOperations.RenderTaskEditPage(source, taskID, controllerCallback);

})(TaskEditOperations, Loader);
