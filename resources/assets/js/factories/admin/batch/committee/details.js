(function (DomHelper, BatchCommitteeDetailsFactory) {

  BatchCommitteeDetailsFactory.CreateUnassignOption = function () {

    return DomHelper.CreateElement("option", {
      "value": 0,
      "selected": "selected"
    }, "Un-assign position");
  }

  BatchCommitteeDetailsFactory.CreateDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, "Select from batch member list"
    );
  }

  BatchCommitteeDetailsFactory.CreateSelectedOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id,
      "selected": "selected"
    }, member.name);
  }

  BatchCommitteeDetailsFactory.CreateOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id
    }, member.name);
  }

  BatchCommitteeDetailsFactory.CreateMemberHeader = function () {

    return DomHelper.CreateElement(
      "li", { "class": "list-header" }, DomHelper.CreateElement(
        "h3", { "class": "no-margin" }, "Committee Members"
      )
    );
  }

  BatchCommitteeDetailsFactory.CreateMemberItem = function (member) {

    var name = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, member.name
    );

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small remove-committee-member-button float-right",
        "data-batch-member-id": member.id
      }, DomHelper.CreateElement("span", { "class": "icon-remove" })
    )

    var makeHeadButton;
    if (member.position.toLowerCase() == "committee head") {

      makeHeadButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-success button-small no-hover float-right"
        }, DomHelper.CreateElement(
          "span", { "class": "icon-leader" }, " Head"
        )
      );
    }
    else {

      makeHeadButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-success-border button-small make-committee-head-button float-right",
          "data-batch-member-id": member.id
        }, DomHelper.CreateElement("span", { "class": "icon-leader" })
      )
    }

    return DomHelper.CreateElement(
      "li", { "class": "clearfix" }, [name, deleteButton, makeHeadButton]
    );
  }

  BatchCommitteeDetailsFactory.CreateEmptyMemberItem = function () {
    return DomHelper.CreateElement(
      "li", {}, "There are no members for this committee. Add some."
    );
  }

})(
  DomHelper, this.BatchCommitteeDetailsFactory = (
    this.BatchCommitteeDetailsFactory == undefined
  ) ? {} : this.BatchCommitteeDetailsFactory
  );