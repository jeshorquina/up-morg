(function (DomHelper, MemberFactory) {

  MemberFactory.CreateMemberRow = function (member) {

    var name = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, member.name
    );

    var editButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-info-border button-small edit-member-button float-right",
        "data-member-id": member.id
      }, DomHelper.CreateElement("span", { "class": "icon-edit" })
    )

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small delete-member-button float-right",
        "data-member-id": member.id
      }, DomHelper.CreateElement("span", { "class": "icon-delete" })
    )

    return DomHelper.CreateElement(
      "li", { "class": "clearfix" }, [name, deleteButton, editButton]
    );
  }

  MemberFactory.CreateEmptyMemberRow = function () {
    return DomHelper.CreateElement(
      "li", {}, "There are currently no members to show."
    );
  }

})(
  DomHelper, this.MemberFactory = (
    this.MemberFactory == undefined
  ) ? {} : this.MemberFactory
  );