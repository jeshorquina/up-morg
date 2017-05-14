(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  TaskEditFactory, TaskEditOperations
) {

  TaskEditOperations.self = {};
  TaskEditOperations.subscribers = [];

  TaskEditOperations.RenderTaskEditPage = function (
    source, taskID, controllerCallback
  ) {

    var endpoint = (
      source + "action/task/view/details/" + taskID + "/edit-details"
    );

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderTaskEditPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  TaskEditOperations.EditTask = function (
    source, form, taskID, controllerCallback
  ) {

    var data = new FormData(form);
    data.append("task-subscribers", JSON.stringify(GetSubscriberList()));

    var endpoint = source + "action/task/view/details/" + taskID + "/edit";
    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRenderTaskEditPageCallback(
        status, responseText, controllerCallback
      );
    });
  }

  TaskEditOperations.AddSubscriber = function (id, controllerCallback) {

    TaskEditOperations.subscribers.forEach(function (subscriber) {
      if (id == subscriber.id) {
        subscriber.selected = true;
      }
    });

    FillTaskSubscribersSelect();
    FillTaskSubscriberList();

    controllerCallback();
  }

  TaskEditOperations.RemoveSubscriber = function (id, controllerCallback) {

    TaskEditOperations.subscribers.forEach(function (subscriber) {
      if (id == subscriber.id) {
        subscriber.selected = false;
      }
    });

    FillTaskSubscribersSelect();
    FillTaskSubscriberList();

    controllerCallback();
  }

  TaskEditOperations.ViewOtherTaskDetails = function (source, taskID) {
    UrlHelper.Redirect(source + "task/view/details/" + taskID);
  }

  function RenderTaskEditPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      TaskEditOperations.self = response.data.self;

      FillNonSelectDetails(response.data.details);

      GenerateSubscriberList(
        response.data.members, response.data.details.subscribers,
        response.data.details.assignee
      );

      FillTaskSubscribersSelect();
      FillTaskSubscriberList();

      FillTaskEventSelect(response.data.events, response.data.details);
      FillTaskParentSelect(response.data.tasks, response.data.details);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRenderTaskEditPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillNonSelectDetails(response.data.details);

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

  function GenerateSubscriberList(members, subscribers, assignee) {

    TaskEditOperations.subscribers = [];
    members.forEach(function (member) {
      TaskEditOperations.subscribers.push({
        "id": member.id,
        "name": member.name,
        "selected": (subscribers.indexOf(member.id) > -1),
        "assignee": (assignee.id == member.id)
      });
    });
  }

  function GetSubscriberList() {
    var subscribers = [];
    TaskEditOperations.subscribers.forEach(function (subscriber) {
      if (subscriber.selected || subscriber.assignee) {
        subscribers.push(subscriber.id);
      }
    });
    return subscribers;
  }

  function FillTaskSubscribersSelect() {

    var subscribersSelect = document.getElementById("task-subscribers");
    DomHelper.InsertContent(
      subscribersSelect, TaskEditFactory.CreateDefaultOption(
        "Select subscribers"
      )
    );
    TaskEditOperations.subscribers.forEach(function (subscriber) {
      if (!subscriber.selected && !subscriber.assignee) {
        DomHelper.AppendContent(
          subscribersSelect, TaskEditFactory.CreateOption(subscriber)
        );
      }
    });
  }

  function FillTaskSubscriberList() {

    var subscriberList = document.getElementById("task-subscriber-list");
    DomHelper.InsertContent(
      subscriberList, TaskEditFactory.CreateHeaderListRow("Subscribers")
    );
    TaskEditOperations.subscribers.forEach(function (subscriber) {
      if (subscriber.selected || subscriber.assignee) {
        DomHelper.AppendContent(
          subscriberList, TaskEditFactory.CreateListRow(
            subscriber, (TaskEditOperations.self.id == subscriber.id || subscriber.assignee)
          )
        );
      }
    });
  }

  function FillTaskEventSelect(events, details) {

    var eventSelect = document.getElementById("task-event");
    DomHelper.InsertContent(
      eventSelect,
      TaskEditFactory.CreateNonDisabledDefaultOption("No event reference")
    );
    events.forEach(function (event) {
      DomHelper.AppendContent(
        eventSelect,
        (details.event.id == event.id) ?
          TaskEditFactory.CreateSelectedOption(event) :
          TaskEditFactory.CreateOption(event)
      );
    });
  }

  function FillTaskParentSelect(tasks, details) {

    var parentSelect = document.getElementById("task-parent");
    DomHelper.InsertContent(
      parentSelect, TaskEditFactory.CreateNonDisabledDefaultOption(
        "No parent task"
      )
    );
    tasks.forEach(function (task) {
      DomHelper.AppendContent(
        parentSelect,
        (details.parent.id == task.id) ?
          TaskEditFactory.CreateSelectedOption(task) :
          TaskEditFactory.CreateOption(task)
      );
    });
  }

  function FillNonSelectDetails(details) {

    if (details.parent != false) {
      DomHelper.InsertContent(
        "parent-task-title",
        TaskEditFactory.CreateParentTaskLink(details.parent)
      );
    }
    else if (document.getElementById("parent-task-title-container")) {
      DomHelper.RemoveElement("parent-task-title-container");
    }

    DomHelper.InsertContent(
      'task-breadcrumb-title',
      TaskEditFactory.CreateTaskLink(details)
    );

    var taskTitles = document.getElementsByClassName('task-title');
    for (var i = 0; i < taskTitles.length; i++) {
      DomHelper.InsertContent(taskTitles[i], details.title);
    }

    document.getElementById("task-title").value = details.title;
    document.getElementById("task-deadline").value = details.deadline;
    document.getElementById("task-description").value = details.description;

    var taskAssignee = document.getElementsByClassName('task-assignee');
    for (var i = 0; i < taskAssignee.length; i++) {
      DomHelper.InsertContent(taskAssignee[i], details.assignee.name);
    }

    var taskReporter = document.getElementsByClassName('task-reporter');
    for (var i = 0; i < taskReporter.length; i++) {
      DomHelper.InsertContent(taskReporter[i], details.reporter.name);
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper,
  AlertFactory, TaskEditFactory,
  this.TaskEditOperations = (
    this.TaskEditOperations == undefined
  ) ? {} : this.TaskEditOperations
  );