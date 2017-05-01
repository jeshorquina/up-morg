(function (
  DomHelper, HttpHelper, StringHelper, UrlHelper, AlertFactory,
  TaskAddFactory, TaskAddOperations
) {

  TaskAddOperations.self = {};
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

  TaskAddOperations.AddTask = function (source, form, controllerCallback) {

    var data = new FormData(form);
    data.append("task-subscribers", JSON.stringify(GetSubscriberList()));

    var endpoint = source + "action/task/add-task";
    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRenderTaskAddPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  TaskAddOperations.AddSubscriber = function (id, controllerCallback) {

    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (id == subscriber.id) {
        subscriber.selected = true;
      }
    });

    FillTaskSubscribersSelect();
    FillTaskSubscriberList();

    controllerCallback();
  }

  TaskAddOperations.RemoveSubscriber = function (id, controllerCallback) {

    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (id == subscriber.id) {
        subscriber.selected = false;
      }
    });

    FillTaskSubscribersSelect();
    FillTaskSubscriberList();

    controllerCallback();
  }

  TaskAddOperations.SelectAssignee = function (id, controllerCallback) {

    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (id == subscriber.id) {
        subscriber.assignee = true;
      }
      else {
        subscriber.assignee = false;
      }
    });

    FillTaskSubscribersSelect();
    FillTaskSubscriberList();

    controllerCallback();
  }

  function RenderTaskAddPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      TaskAddOperations.self = response.data.self;

      FillTaskAssigneeSelect(response.data.members);

      GenerateSubscriberList(response.data.members);

      FillTaskSubscribersSelect();
      FillTaskSubscriberList();

      FillTaskEventSelect(response.data.events);
      FillTaskParentSelect(response.data.tasks);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderTaskAddPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    ResetFormValidation();
    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      TaskAddOperations.self = response.data.self;

      FillTaskAssigneeSelect(response.data.members);

      GenerateSubscriberList(response.data.members);

      FillTaskSubscribersSelect();
      FillTaskSubscriberList();

      FillTaskEventSelect(response.data.events);
      FillTaskParentSelect(response.data.tasks);

      controllerCallback();

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );

      Object.keys(response.data).forEach(function (id) {
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(id + "-error", response.data[id]);
      });
    }
    else {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillTaskAssigneeSelect(members) {

    var assigneeSelect = document.getElementById("task-assignee");
    DomHelper.InsertContent(
      assigneeSelect, TaskAddFactory.CreateDefaultOption(
        "Select assignee"
      )
    );
    members.forEach(function (member) {
      DomHelper.AppendContent(
        assigneeSelect, TaskAddFactory.CreateOption(member)
      );
    });
  }

  function GenerateSubscriberList(members) {

    members.forEach(function (member) {
      TaskAddOperations.subscribers.push({
        "id": member.id,
        "name": member.name,
        "selected": (TaskAddOperations.self.id == member.id),
        "assignee": false
      });
    });
  }

  function GetSubscriberList() {
    var subscribers = [];
    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (subscriber.selected || subscriber.assignee) {
        subscribers.push(subscriber.id);
      }
    });
    return subscribers;
  }

  function FillTaskSubscribersSelect() {

    var subscribersSelect = document.getElementById("task-subscribers");
    DomHelper.InsertContent(
      subscribersSelect, TaskAddFactory.CreateDefaultOption(
        "Select subscribers"
      )
    );
    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (!subscriber.selected && !subscriber.assignee) {
        DomHelper.AppendContent(
          subscribersSelect, TaskAddFactory.CreateOption(subscriber)
        );
      }
    });
  }

  function FillTaskSubscriberList() {

    var subscriberList = document.getElementById("task-subscriber-list");
    DomHelper.InsertContent(
      subscriberList, TaskAddFactory.CreateHeaderListRow("Subscribers")
    );
    TaskAddOperations.subscribers.forEach(function (subscriber) {
      if (subscriber.selected || subscriber.assignee) {
        DomHelper.AppendContent(
          subscriberList, TaskAddFactory.CreateListRow(
            subscriber, (TaskAddOperations.self.id == subscriber.id || subscriber.assignee)
          )
        );
      }
    });
  }

  function FillTaskEventSelect(events) {

    var eventSelect = document.getElementById("task-event");
    DomHelper.InsertContent(
      eventSelect, TaskAddFactory.CreateDefaultOption(
        "Select event reference"
      )
    );
    events.forEach(function (event) {
      DomHelper.AppendContent(
        eventSelect, TaskAddFactory.CreateOption(event)
      );
    });
  }

  function FillTaskParentSelect(tasks) {

    var parentSelect = document.getElementById("task-parent");
    DomHelper.InsertContent(
      parentSelect, TaskAddFactory.CreateDefaultOption(
        "Select parent task"
      )
    );
    tasks.forEach(function (task) {
      DomHelper.AppendContent(
        parentSelect, TaskAddFactory.CreateOption(task)
      );
    });
  }

  function ResetFormValidation() {
    [
      'task-title', 'task-description', 'task-deadline', 'task-assignee',
      'task-subscribers'
    ].forEach(function (value) {
      DomHelper.RemoveClass(value, "form-input-error");
      DomHelper.ClearContent(value + "-error");
    });
  }

})(
  DomHelper, HttpHelper, StringHelper, UrlHelper,
  AlertFactory, TaskAddFactory,
  this.TaskAddOperations = (
    this.TaskAddOperations == undefined
  ) ? {} : this.TaskAddOperations
  );