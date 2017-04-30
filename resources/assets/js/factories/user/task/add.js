(function (DomHelper, TaskAddFactory) {

  TaskAddFactory.CreateMemberDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
        "value": 0,
      }, "Select a member from the options"
    );
  }

  TaskAddFactory.CreateMemberOption = function (member) {

    return DomHelper.CreateElement(
      "option", {
        "value": member.id
      }, member.name
    );
  }

})(
  DomHelper, this.TaskAddFactory = (
    this.TaskAddFactory == undefined
  ) ? {} : this.TaskAddFactory
  );