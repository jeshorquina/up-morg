(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  TaskViewFactory, TaskViewOperations
) {

  TaskViewOperations.RenderTaskViewPage = function (source, controllerCallback) {

    var endpoint = source + "action/task/view";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderTaskViewCallback(status, responseText, controllerCallback);
    });
  }

  TaskViewOperations.ViewTaskDetails = function (source, taskID) {
    UrlHelper.Redirect(source + "task/view/details/" + taskID);
  }

  function RenderTaskViewCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderTaskSections(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RenderTaskSections(sections) {

    var taskContainer = document.getElementById("tasks-container");

    sections.forEach(function (section) {
      DomHelper.AppendContent(
        taskContainer, TaskViewFactory.CreateTaskSection(section)
      );
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, TaskViewFactory,
  this.TaskViewOperations = (
    this.TaskViewOperations == undefined
  ) ? {} : this.TaskViewOperations
  );