(function (DomHelper, AvailabilityGroupEditFactory) {

  AvailabilityGroupEditFactory.CreateDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, "Select member from list"
    );
  }

  AvailabilityGroupEditFactory.CreateOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id
    }, member.name);
  }

  AvailabilityGroupEditFactory.CreateMemberItem = function (member) {

    var name = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, member.name
    );

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small remove-group-member-button float-right",
        "data-member-id": member.id
      }, DomHelper.CreateElement("span", { "class": "icon-remove" })
    )

    return DomHelper.CreateElement(
      "li", { "class": "clearfix" }, [name, deleteButton]
    );
  }

  AvailabilityGroupEditFactory.CreateEmptyMemberItem = function () {
    return DomHelper.CreateElement(
      "li", {}, "There are no members for this group. Add some."
    );
  }

})(
  DomHelper, this.AvailabilityGroupEditFactory = (
    this.AvailabilityGroupEditFactory == undefined
  ) ? {} : this.AvailabilityGroupEditFactory
  );