(function (TaskAddOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var addTaskCallback = function (event) {
    event.preventDefault();
    TaskAddOperations.AddTask(source, this, controllerCallback);
  }

  var addSubscriberCallback = function () {
    TaskAddOperations.AddSubscriber(
      document.getElementById("task-subscribers").value, controllerCallback
    );
  }

  var removeSubscriberCallback = function () {
    TaskAddOperations.RemoveSubscriber(
      this.getAttribute("data-subscriber-id"), controllerCallback
    );
  }

  var selectAssigneeCallback = function (event) {
    TaskAddOperations.SelectAssignee(this.value, controllerCallback);
  }

  var noListenerCallback = function (event) {
    event.preventDefault();
    return false;
  }

  var controllerCallback = function () {

    document
      .getElementById("add-task-form")
      .addEventListener("submit", addTaskCallback);

    document
      .getElementById("task-subscribers-submit")
      .addEventListener("click", addSubscriberCallback);

    document
      .getElementById("task-assignee")
      .addEventListener("change", selectAssigneeCallback);

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

  TaskAddOperations.RenderTaskAddPage(source, controllerCallback);

})(TaskAddOperations, Loader);
