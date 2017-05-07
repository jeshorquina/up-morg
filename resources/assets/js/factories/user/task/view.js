(function (DomHelper, TaskViewFactory) {

  TaskViewFactory.CreateTaskSection = function (section) {

    var header = DomHelper.CreateElement(
      "h3", { "class": "no-margin" }, section.name
    );

    var head = DomHelper.CreateElement(
      "thead", {}, TaskViewFactory.CreateTaskHeaderRow()
    );

    var body = DomHelper.CreateElement("tbody", {});
    if (section.tasks.length > 0) {
      section.tasks.forEach(function (task) {
        DomHelper.AppendContent(
          body, TaskViewFactory.CreateTaskRow(task)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        body, TaskViewFactory.CreateEmptyTaskRow()
      );
    }

    var table = DomHelper.CreateElement(
      "table", { "class": "table margin-top-small" }, [head, body]
    );

    return DomHelper.CreateElement(
      "div", { "class": "task-section" }, [header, table]
    );
  }

  TaskViewFactory.CreateTaskHeaderRow = function () {

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement(
        "th", { "width": "35%" }, "Title"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "20%" }, "Reporter"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "20%" }, "Assignee"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "10%" }, "Status"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "15%" }, "Deadline"
      )
    ]);
  }

  TaskViewFactory.CreateTaskRow = function (task) {

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

    return DomHelper.CreateElement("tr", {
      "class": "hover view-task-details",
      "data-task-id": task.id
    }, [
        DomHelper.CreateElement(
          "td", {}, (task.title.length > 40) ? (
            task.title.substr(0, 40) + "..."
          ) : task.title
        ),
        DomHelper.CreateElement(
          "td", { "class": "text-center" }, (task.reporter.length > 20) ? (
            task.reporter.substr(0, 20) + "..."
          ) : task.reporter
        ),
        DomHelper.CreateElement(
          "td", { "class": "text-center" }, (task.assignee.length > 20) ? (
            task.assignee.substr(0, 20) + "..."
          ) : task.assignee
        ),
        DomHelper.CreateElement(
          "td", {
            "class": "text-center"
          }, DomHelper.CreateElement(
            "span", {
              "class": "label " + labelClass
            },
            task.status
          )
        ),
        DomHelper.CreateElement(
          "td", {
            "class": "text-center " + deadlineClass
          }, task.deadline
        )
      ]);
  }

  TaskViewFactory.CreateEmptyTaskRow = function () {

    return DomHelper.CreateElement(
      "tr", {}, DomHelper.CreateElement(
        "td", { "colspan": "5", "class": "text-center" }, "No tasks to show."
      )
    );
  }

})(
  DomHelper, this.TaskViewFactory = (
    this.TaskViewFactory == undefined
  ) ? {} : this.TaskViewFactory
  );