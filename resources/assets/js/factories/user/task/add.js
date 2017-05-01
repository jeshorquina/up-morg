(function (DomHelper, TaskAddFactory) {

  TaskAddFactory.CreateDefaultOption = function (message) {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, message
    );
  }

  TaskAddFactory.CreateOption = function (object) {

    return DomHelper.CreateElement(
      "option", {
        "value": object.id
      }, object.name
    );
  }

  TaskAddFactory.CreateHeaderListRow = function (message) {

    return DomHelper.CreateElement(
      "li", { "class": "list-header", }, message
    );
  }

  TaskAddFactory.CreateListRow = function (object, isSelf) {

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
  DomHelper, this.TaskAddFactory = (
    this.TaskAddFactory == undefined
  ) ? {} : this.TaskAddFactory
  );