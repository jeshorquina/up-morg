(function (DomHelper, CommitteeDetailsFactory) {

  CommitteeDetailsFactory.CreateDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, "Select from batch member list"
    );
  }

  CommitteeDetailsFactory.CreateSelectedOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id,
      "selected": "selected"
    }, member.name);
  }

  CommitteeDetailsFactory.CreateOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id
    }, member.name);
  }

  CommitteeDetailsFactory.CreateMemberHeader = function () {

    return DomHelper.CreateElement(
      "li", { "class": "list-header" }, DomHelper.CreateElement(
        "h3", { "class": "no-margin" }, "Committee Members"
      )
    );
  }

  CommitteeDetailsFactory.CreateMemberItem = function (member) {

    var name = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, member.name
    );

    var deleteButton = "";
    if (member.position.toLowerCase() == "committee member") {
      deleteButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-danger-border button-small remove-committee-member-button float-right",
          "data-batch-member-id": member.id
        }, DomHelper.CreateElement("span", { "class": "icon-remove" })
      )
    }

    var makeHeadButton = "",
      isCommitteeHead = (
        document
          .getElementById("batch-committee-container")
          .getAttribute("data-is-committee-head")
      );


    if (member.position.toLowerCase() == "committee head") {

      makeHeadButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-success button-small no-hover float-right"
        }, DomHelper.CreateElement(
          "span", { "class": "icon-leader" }, " Head"
        )
      );
    }
    else if (!isCommitteeHead) {

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

  CommitteeDetailsFactory.CreateEmptyMemberItem = function () {
    return DomHelper.CreateElement(
      "li", {}, "There are no members for this committee. Add some."
    );
  }

})(
  DomHelper, this.CommitteeDetailsFactory = (
    this.CommitteeDetailsFactory == undefined
  ) ? {} : this.CommitteeDetailsFactory
  );