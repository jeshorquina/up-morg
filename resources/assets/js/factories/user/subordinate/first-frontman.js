(function (DomHelper, FirstFrontmanDetailsFactory) {

  FirstFrontmanDetailsFactory.CreateCommitteeSection = function (committee) {

    var headerName = DomHelper.CreateElement(
      "h3", { "class": "no-margin table-cell" }, committee.committee.name
    );

    var headerButton = "";
    if (committee.committee.name != "Unassigned") {
      headerButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-info-border button-small edit-committee-button float-right",
          "data-committee-name": committee.committee.name.toLowerCase().replace(/ /g, "-")
        }, DomHelper.CreateElement(
          "span", { "class": "icon-edit" }
        )
      );
    }

    var header = DomHelper.CreateElement(
      "li", {
        "class": "list-header clearfix",
        "data-committee-id": committee.committee.id
      }, [headerName, headerButton]
    );

    var list = DomHelper.CreateElement(
      "ul", {
        "id": committee.committee.name.toLowerCase().replace(/ /g, "-"),
        "class": "list list-strips margin-top-medium"
      }, header
    );

    var hasMember = false;
    committee.members.forEach(function (member) {

      hasMember = true;

      var listLeft = DomHelper.CreateElement(
        "span", { "class": "table-cell width-half" }, member.name
      );

      var listRight = "", button = "";
      if (member.position != "Unassigned") {
        listRight = DomHelper.CreateElement(
          "span", { "class": "float-right member-position" }, member.position
        );
      }
      else {

        button = DomHelper.CreateElement(
          "button", {
            "class": "button button-danger-border button-small remove-member-button float-right",
            "data-batch-member-id": member.id
          }, DomHelper.CreateElement("span", { "class": "icon-remove" })
        );

        if (member.committee != false) {
          listRight = DomHelper.CreateElement(
            "div", {
              "class": "table-cell text-right member-position width-half",
            }, "Pending in " + member.committee
          );
        }
      }

      DomHelper.AppendContent(
        list, DomHelper.CreateElement(
          "li", { "class": "clearfix" }, [listLeft, listRight, button]
        )
      );
    });

    if (!hasMember) {
      DomHelper.AppendContent(
        list, DomHelper.CreateElement(
          "li", {}, "No members for this group yet."
        )
      );
    }

    return list;
  }

  FirstFrontmanDetailsFactory.CreateNonMemberDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, "Select from member list"
    );
  }

  FirstFrontmanDetailsFactory.CreateNonMemberOption = function (nonMember) {

    return DomHelper.CreateElement(
      "option", {
        "name": "member-id",
        "value": nonMember.id
      }, nonMember.name
    );
  }

})(
  DomHelper, this.FirstFrontmanDetailsFactory = (
    this.FirstFrontmanDetailsFactory == undefined
  ) ? {} : this.FirstFrontmanDetailsFactory
  );