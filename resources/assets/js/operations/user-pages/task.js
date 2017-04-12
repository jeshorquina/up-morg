(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, TaskOperations) {

  TaskOperations.AddTask = function (source) {

    var form = document.getElementById("add-task-form");

    var endpoint = source + "action/task-manager/add-task";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, AddTaskCallback);
  }

  TaskOperations.RenderCurrentUserTasks = function (source, controllerCallback) {
    var endpoint = source + "action/task-manager/get-current-user-tasks";
    
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderCurrentUserTasksCallback(status, responseText, controllerCallback);
    })
  }

  function RenderCurrentUserTasksCallback(status, responseText, controllerCallback) {
    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if(status == HttpHelper.OK) {
      var taskContainer = document.getElementById("current-user-tasks-body");
      
      for(var i = 0; i < response.length; i++){
        DomHelper.AppendContent(taskContainer, GetCurrentUserTaskRow(response[i]));
      }
      controllerCallback();
    }
  }

  TaskOperations.RenderReportedTasks = function (source, controllerCallback) {
    var endpoint = source + "action/task-manager/get-reported-tasks";
    
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderReportedTasksCallback(status, responseText, controllerCallback);
    })
  }

  function RenderReportedTasksCallback(status, responseText, controllerCallback) {
    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if(status == HttpHelper.OK) {
      var taskContainer = document.getElementById("reported-tasks-body");
      
      for(var i = 0; i < response.length; i++){
        DomHelper.AppendContent(taskContainer, GetReportedTaskRow(response[i]));
      }
      controllerCallback();
    }
  }

  function GetCurrentUserTaskRow(task) {

    var titleColumn, deadlineColumn, reporterColumn, statusColumn;

    titleColumn = DomHelper.CreateElement("td", {}, String(task.title));
    deadlineColumn = DomHelper.CreateElement("td", {}, String(task.deadline));
    reporterColumn = DomHelper.CreateElement("td", {}, String(task.reporter));
    statusColumn = DomHelper.CreateElement("td", {}, String(task.status));

    return DomHelper.CreateElement("tr", {}, [titleColumn, deadlineColumn, reporterColumn, statusColumn]);
  }

  function GetReportedTaskRow(task) {
    
    var titleColumn, assigneeColumn, statusColumn, deadlineColumn;

    titleColumn = DomHelper.CreateElement("td", {}, String(task.title));
    assigneeColumn = DomHelper.CreateElement("td", {}, String(task.assignee));
    deadlineColumn = DomHelper.CreateElement("td", {}, String(task.deadline));
    statusColumn = DomHelper.CreateElement("td", {}, String(task.status));

    return DomHelper.CreateElement("tr", {}, [titleColumn, assigneeColumn, deadlineColumn, statusColumn]);
  }

  function AddTaskCallback(status, responseText) {
    alert(responseText);
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.TaskOperations = (
    this.TaskOperations == undefined
  ) ? {} : this.TaskOperations
  );