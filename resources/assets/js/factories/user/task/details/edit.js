(function (DomHelper, TaskEditFactory) {

  TaskEditFactory.CreateParentTaskLink = function (parent) {

    var parentTitle = (parent.title.length > 20) ? (
      parent.title.substr(0, 20) + "...") : parent.title;

    return DomHelper.CreateElement("a", {
      "id": "parent-task-title-link",
      "class": "hover",
      "data-task-id": parent.id
    }, parentTitle);
  }

  TaskEditFactory.CreateTaskLink = function (details) {

    var title = (details.title.length > 20) ? (
      details.title.substr(0, 20) + "...") : details.title;

    return DomHelper.CreateElement("a", {
      "id": "task-title-link",
      "class": "hover",
      "data-task-id": details.id
    }, title);
  }

  TaskEditFactory.CreateDefaultOption = function (message) {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, message
    );
  }

  TaskEditFactory.CreateNonDisabledDefaultOption = function (message) {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "value": "-1"
      }, message
    );
  }

  TaskEditFactory.CreateOption = function (object) {

    return DomHelper.CreateElement(
      "option", {
        "value": object.id
      }, object.name
    );
  }

  TaskEditFactory.CreateSelectedOption = function (object) {

    return DomHelper.CreateElement(
      "option", {
        "value": object.id,
        "selected": "selected"
      }, object.name
    );
  }

  TaskEditFactory.CreateHeaderListRow = function (message) {

    return DomHelper.CreateElement(
      "li", { "class": "list-header", }, message
    );
  }

  TaskEditFactory.CreateListRow = function (object, isSelf) {

    var span = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, object.name
    );

    var removeButton = "";

    if (!isSelf) {
      removeButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-danger-border button-small remove-subscriber-button float-right",
          "data-subscriber-id": object.id
        }, DomHelper.CreateElement("span", { "class": "icon-remove" })
      );
    }

    return DomHelper.CreateElement("li", { "class": "subscriber-entry clearfix" }, [
      span, removeButton
    ]);
  }

})(
  DomHelper, this.TaskEditFactory = (
    this.TaskEditFactory == undefined
  ) ? {} : this.TaskEditFactory
  );