(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  TaskAddFactory, TaskAddOperations
) {

  TaskAddOperations.subscribers = [];

  TaskAddOperations.RenderTaskAddPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/task/add";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderTaskAddPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  function RenderTaskAddPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillTaskAssigneeSelect(response.data.members);
      FillTaskSubscribersSelect(response.data.members);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillTaskAssigneeSelect(members) {

    var assigneeSelect = document.getElementById("task-assignee");
    DomHelper.InsertContent(
      assigneeSelect, TaskAddFactory.CreateMemberDefaultOption()
    );
    members.forEach(function (member) {
      DomHelper.AppendContent(
        assigneeSelect, TaskAddFactory.CreateMemberOption(member)
      );
    });
  }

  function FillTaskSubscribersSelect(members) {

    var subscribersSelect = document.getElementById("task-subscribers");
    DomHelper.InsertContent(
      subscribersSelect, TaskAddFactory.CreateMemberDefaultOption()
    );
    members.forEach(function (member) {
      DomHelper.AppendContent(
        subscribersSelect, TaskAddFactory.CreateMemberOption(member)
      );
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, TaskAddFactory,
  this.TaskAddOperations = (
    this.TaskAddOperations == undefined
  ) ? {} : this.TaskAddOperations
  );