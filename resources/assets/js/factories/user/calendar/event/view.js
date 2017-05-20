(function (DomHelper, EventDetailsViewFactory) {

  EventDetailsViewFactory.CreateEditButton = function (eventID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-info button-small margin-right-small",
        "id": "edit-event-button",
        "data-event-id": eventID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-edit" }, " Edit"
      )
    );
  }

  EventDetailsViewFactory.CreateDeleteButton = function (eventID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small",
        "id": "delete-event-button",
        "data-event-id": eventID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-delete" }, " Delete"
      )
    );
  }

  EventDetailsViewFactory.CreateTaskList = function (tasks) {

    var taskList = DomHelper.CreateElement(
      "ul", { "class": "list list-strips" }
    )

    DomHelper.InsertContent(
      taskList, EventDetailsViewFactory.CreateListHeader("Referenced Tasks")
    );

    if (tasks != false) {
      tasks.forEach(function (task, index) {
        DomHelper.AppendContent(
          taskList, EventDetailsViewFactory.CreateListRow(task, index)
        )
      });
    }

    return taskList;
  }

  EventDetailsViewFactory.CreateListHeader = function (label) {

    return DomHelper.CreateElement("li", { "class": "list-header" }, label);
  }

  EventDetailsViewFactory.CreateListRow = function (task, index) {

    var labelClass = "";
    switch (task.status.toLowerCase()) {
      case "to do":
        labelClass = "label-gray";
        break;
      case "in progress":
        labelClass = "label-yellow";
        break;
      case "for review":
        labelClass = "label-blue";
        break;
      case "needs changes":
        labelClass = "label-red";
        break;
      case "accepted":
        labelClass = "label-green";
        break;
      case "done":
        labelClass = "label-purple";
        break;
      default:
        labelClass = "label-blue";
        break;
    }

    var q = new Date();
    var currentDate = new Date(q.getFullYear(), q.getMonth(), q.getDate());
    var deadline = new Date(task.deadline);

    var deadlineClass = (currentDate > deadline) ? "label-text-red" : "";

    return DomHelper.CreateElement("li", {
      "class": "hover flex-container view-task-details",
      "data-task-id": task.id
    }, [
        DomHelper.CreateElement("div", {
          "class": "flex flex-1"
        }, [
            DomHelper.CreateElement("div", {
              "class": "align-middle"
            }, [
                DomHelper.CreateElement("span", {
                  "class": "cell"
                }, (index + 1) + ". " + task.title)
              ])
          ]),
        DomHelper.CreateElement("div", {
          "class": "flex flex-1 text-right align-middle"
        }, [
            DomHelper.CreateElement("span", {
              "class": "label " + labelClass + " margin-right-small"
            }, task.status),
            DomHelper.CreateElement("span", {
              "class": "cell " + deadlineClass
            }, task.deadline)
          ])
      ]);
  }

  EventDetailsViewFactory.CreateEventImage = function (image) {

    return DomHelper.CreateElement("a", {
      "class": "event-image-container",
      "href": image,
      "target": "_blank"
    }, [
        DomHelper.CreateElement("img", {
          "class": "event-image",
          "src": image
        })
      ]);
  }

})(
  DomHelper, this.EventDetailsViewFactory = (
    this.EventDetailsViewFactory == undefined
  ) ? {} : this.EventDetailsViewFactory
  );