(function (TaskDetailsViewOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");
  var taskID = document
    .getElementById("task-details-container")
    .getAttribute("data-task-id");

  var viewOtherTaskCallback = function () {
    TaskDetailsViewOperations.ViewOtherTaskDetails(
      source, this.getAttribute("data-task-id")
    );
  }

  var addTaskCommentCallback = function (event) {
    event.preventDefault();
    TaskDetailsViewOperations.AddComment(
      source, this, taskID, controllerCallback
    );
  }

  var editTaskCallback = function () {
    TaskDetailsViewOperations.EditTask(
      source, this.getAttribute("data-task-id"), controllerCallback
    );
  }

  var deleteTaskCallback = function () {
    TaskDetailsViewOperations.DeleteTask(
      source, this.getAttribute("data-task-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    );
  }

  var submitTaskCallback = function (event) {
    event.preventDefault();
    TaskDetailsViewOperations.SubmitTask(
      source, taskID, this, controllerCallback
    );
  }

  var approveTaskCallback = function (event) {
    event.preventDefault();
    TaskDetailsViewOperations.ApproveTask(
      source, taskID, this, controllerCallback
    );
  }

  var controllerCallback = function () {

    var subtaskRows = document.getElementsByClassName("view-task-details");
    for (var i = 0; i < subtaskRows.length; i++) {
      subtaskRows[i].addEventListener("click", viewOtherTaskCallback);
    }

    if (document.getElementById("parent-task-title-link")) {
      document
        .getElementById("parent-task-title-link")
        .addEventListener("click", viewOtherTaskCallback);
    }

    document
      .getElementById("task-comment-form")
      .addEventListener("submit", addTaskCommentCallback);

    var editButton = document.getElementById("edit-task-button");
    if (editButton) {
      editButton.addEventListener("click", editTaskCallback);
    }

    var deleteButton = document.getElementById("delete-task-button");
    if (deleteButton) {
      deleteButton.addEventListener("click", deleteTaskCallback);
    }

    if (document.getElementById("task-submit-form")) {
      document
        .getElementById("task-submit-form")
        .addEventListener("submit", submitTaskCallback);
    }

    if (document.getElementById("task-approve-form")) {
      document
        .getElementById("task-approve-form")
        .addEventListener("submit", approveTaskCallback)
    }

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  TaskDetailsViewOperations.RenderTaskDetailsViewPage(
    source, taskID, controllerCallback
  );

})(TaskDetailsViewOperations, ProfileDropdown, Loader);
