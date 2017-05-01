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
        "th", { "width": "45%" }, "Title"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "15%" }, "Deadline"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "20%" }, "Reporter"
      ),
      DomHelper.CreateElement(
        "th", { "class": "text-center", "width": "20%" }, "Assignee"
      )
    ]);
  }

  TaskViewFactory.CreateTaskRow = function (task) {

    return DomHelper.CreateElement("tr", {
      "class": "hover",
      "data-task-id": task.id
    }, [
        DomHelper.CreateElement(
          "td", {}, task.title
        ),
        DomHelper.CreateElement(
          "td", { "class": "text-center" }, task.deadline
        ),
        DomHelper.CreateElement(
          "td", { "class": "text-center" }, task.reporter
        ),
        DomHelper.CreateElement(
          "td", { "class": "text-center" }, task.assignee
        ),
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