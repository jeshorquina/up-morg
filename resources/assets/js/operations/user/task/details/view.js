(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  TaskDetailsViewFactory, TaskDetailsViewOperations
) {

  TaskDetailsViewOperations.RenderTaskDetailsViewPage = function (
    source, taskID, controllerCallback
  ) {

    var endpoint = source + "action/task/view/details/" + taskID;
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderTaskDetailsViewCallback(status, responseText, controllerCallback);
    })
  }

  TaskDetailsViewOperations.ViewOtherTaskDetails = function (source, taskID) {
    UrlHelper.Redirect(source + "task/view/details/" + taskID);
  }

  TaskDetailsViewOperations.AddComment = function (
    source, form, taskID, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = (
      source + "action/task/view/details/" + taskID + "/comment/add"
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {

      form.reset();
      RefreshRenderTaskDetailsViewCallback(
        status, responseText, controllerCallback
      );
    });
  }

  TaskDetailsViewOperations.EditTask = function (
    source, taskID, controllerCallback
  ) {
    UrlHelper.Redirect(source + "task/view/details/" + taskID + "/edit");
  }

  TaskDetailsViewOperations.DeleteTask = function (
    source, taskID, csrfObject, controllerCallback
  ) {

    if (confirm(
      "Are you sure you want to delete this task? " +
      "Attached subtasks will also be deleted.")
    ) {

      var data = new FormData();
      data.append(csrfObject.name, csrfObject.value);

      var endpoint = source + "action/task/view/details/" + taskID + "/delete";

      HttpHelper.Post(endpoint, data, function (status, responseText) {
        RefreshRenderTaskDetailsViewCallback(
          status, responseText, controllerCallback
        );
      });
    }
  }

  TaskDetailsViewOperations.SubmitTask = function (
    source, taskID, form, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = source + "action/task/view/details/" + taskID + "/submit";

    HttpHelper.Post(endpoint, data, function (status, responseText) {

      form.reset();
      RefreshRenderTaskDetailsViewCallback(
        status, responseText, controllerCallback
      );
    });
  }

  TaskDetailsViewOperations.ApproveTask = function (
    source, taskID, form, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = source + "action/task/view/details/" + taskID + "/approve";

    HttpHelper.Post(endpoint, data, function (status, responseText) {

      form.reset();
      RefreshRenderTaskDetailsViewCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderTaskDetailsViewCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderTaskDetailsSections(response.data.task);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderTaskDetailsViewCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      if (!response.redirect_url) {

        RenderTaskDetailsSections(response.data.task);
        controllerCallback();
      }
      else {
        UrlHelper.Redirect(response.redirect_url, 1000);
      }

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else {
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RenderTaskDetailsSections(task) {

    FillTaskDetails(task);
    FillTaskButtonContainer(task.flags, task.details.id);
    FillTaskCommentsSection(task.comments);

    if (task.children != false) {
      FillSubtaskList(task.children);
    }

    FillSubmitSection(task);
    FillApproveSection(task);
  }

  function FillTaskDetails(task) {

    var parent = task.parent;
    var details = task.details;

    if (parent != false) {
      DomHelper.InsertContent(
        "parent-task-title",
        TaskDetailsViewFactory.CreateParentTaskLink(parent)
      );
    }
    else if (document.getElementById("parent-task-title-container")) {
      DomHelper.RemoveElement("parent-task-title-container");
    }

    var taskBreadcrumbTitle = (details.title.length > 20) ? (
      details.title.substr(0, 20) + "..."
    ) : details.title;
    DomHelper.InsertContent('task-breadcrumb-title', taskBreadcrumbTitle);

    var taskTitles = document.getElementsByClassName('task-title');
    for (var i = 0; i < taskTitles.length; i++) {
      DomHelper.InsertContent(taskTitles[i], details.title);
    }

    var taskStatus = document.getElementsByClassName('task-status');
    for (var i = 0; i < taskStatus.length; i++) {
      DomHelper.InsertContent(
        taskStatus[i],
        TaskDetailsViewFactory.CreateStatusLabel(details.status.name)
      );
    }

    var taskDescription = document.getElementsByClassName('task-description');
    for (var i = 0; i < taskDescription.length; i++) {
      DomHelper.InsertContent(taskDescription[i], details.description);
    }

    var taskAssignee = document.getElementsByClassName('task-assignee');
    for (var i = 0; i < taskAssignee.length; i++) {
      DomHelper.InsertContent(taskAssignee[i], details.assignee);
    }

    var taskReporter = document.getElementsByClassName('task-reporter');
    for (var i = 0; i < taskReporter.length; i++) {
      DomHelper.InsertContent(taskReporter[i], details.reporter);
    }

    var taskDeadline = document.getElementsByClassName('task-deadline');
    for (var i = 0; i < taskDeadline.length; i++) {
      DomHelper.InsertContent(
        taskDeadline[i],
        TaskDetailsViewFactory.CreateDeadline(details.deadline)
      );
    }
  }

  function FillTaskButtonContainer(flags, taskID) {
    if (flags.edit == true) {
      var taskButtonContainer = document.getElementById(
        "task-buttons-container"
      );
      DomHelper.InsertContent(
        taskButtonContainer, TaskDetailsViewFactory.CreateEditButton(taskID)
      )
      DomHelper.AppendContent(
        taskButtonContainer, TaskDetailsViewFactory.CreateDeleteButton(taskID)
      )
    }
  }

  function FillSubtaskList(children) {

    DomHelper.InsertContent(
      "task-subtasks", TaskDetailsViewFactory.CreateSubtaskList(children)
    );
  }

  function FillTaskCommentsSection(comments) {

    DomHelper.InsertContent(
      "task-comments-list", TaskDetailsViewFactory.CreateListHeader("Comments")
    );

    if (comments.length > 0) {
      comments.forEach(function (comment) {
        DomHelper.AppendContent(
          "task-comments-list",
          TaskDetailsViewFactory.CreateCommentRow(comment)
        )
      });
    }
    else {
      DomHelper.AppendContent(
        "task-comments-list", TaskDetailsViewFactory.CreateEmptyCommentRow()
      );
    }
  }

  function FillSubmitSection(task) {

    if (task.flags.submit && task.children == false) {
      switch (task.details.status.name.toLowerCase()) {
        case "to do":
          DomHelper.InsertContent(
            "task-submit-form-content",
            TaskDetailsViewFactory.CreateToDoSubmitSection(
              task.details.status.id
            )
          );
          break;
        case "in progress":
        case "needs changes":
          DomHelper.InsertContent(
            "task-submit-form-content",
            TaskDetailsViewFactory.CreateInProgressSubmitSection(
              task.submissions, task.details.status.id
            )
          );
          break;
        case "for review":
          DomHelper.InsertContent(
            "task-submit-form-content",
            TaskDetailsViewFactory.CreateForReviewSubmitSection(
              task.submissions, task.details.status.id
            )
          );
          break;
        case "accepted":
          DomHelper.InsertContent(
            "task-submit-form-content",
            TaskDetailsViewFactory.CreateAcceptedSubmitSection(
              task.submissions, task.details.status.id
            )
          );
          break;
        case "done":
        default:
          if (document.getElementById("task-submit-form")) {
            DomHelper.RemoveElement("task-submit-form");
          }
          break;
      }
    }
    else if (document.getElementById("task-submit-form")) {
      DomHelper.RemoveElement("task-submit-form");
    }
  }

  function FillApproveSection(task) {

    if (task.flags.approve && task.children == false) {
      switch (task.details.status.name.toLowerCase()) {
        case "for review":
        case "needs changes":
        case "accepted":
          if (document.getElementById("task-approve-form-content").innerHTML == "") {
            DomHelper.InsertContent(
              "task-approve-form-content",
              TaskDetailsViewFactory.CreateForReviewApproveSection(
                task.submissions, task.details.status.id
              )
            );
          }
          break;
        case "done":
        default:
          if (document.getElementById("task-approve-form")) {
            DomHelper.RemoveElement("task-approve-form");
          }
          break;
      }
    }
    else if (document.getElementById("task-approve-form")) {
      DomHelper.RemoveElement("task-approve-form");
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, TaskDetailsViewFactory,
  this.TaskDetailsViewOperations = (
    this.TaskDetailsViewOperations == undefined
  ) ? {} : this.TaskDetailsViewOperations
  );