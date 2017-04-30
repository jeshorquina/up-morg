(function (DomHelper, AvailabilityGroupFactory) {

  AvailabilityGroupFactory.CreateGroupRow = function (group) {

    var span = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, group.name
    );

    var viewButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-success-border button-small view-group-button float-right",
        "data-group-id": group.id,
      }, DomHelper.CreateElement("span", { "class": "icon-view" })
    );

    var editButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-info-border button-small edit-group-button float-right",
        "data-group-id": group.id,
      }, DomHelper.CreateElement("span", { "class": "icon-edit" })
    );

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small delete-group-button float-right",
        "data-group-id": group.id
      }, DomHelper.CreateElement("span", { "class": "icon-delete" })
    )

    return DomHelper.CreateElement(
      "li", { "class": "group-entry clearfix" }, [
        span, deleteButton, editButton, viewButton
      ]
    );
  }

  AvailabilityGroupFactory.CreateEmptyGroupRow = function () {

    return DomHelper.CreateElement(
      "li", {
        "class": "group-entry"
      }, "There are currently no groups to show."
    );
  }

})(
  DomHelper, this.AvailabilityGroupFactory = (
    this.AvailabilityGroupFactory == undefined
  ) ? {} : this.AvailabilityGroupFactory
  );