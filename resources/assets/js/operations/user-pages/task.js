(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, TaskOperations) {

  TaskOperations.AddTask = function (source) {

    var form = document.getElementById("add-task-form");

    var endpoint = source + "action/task-manager/add-task";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, AddTaskCallback);
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