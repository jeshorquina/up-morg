(function (DomHelper, FrontmanDetailsFactory) {

  FrontmanDetailsFactory.CreateCommitteeSection = function (committee) {

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

      var listRight = "";
      if (member.position != "Unassigned") {
        listRight = DomHelper.CreateElement(
          "span", { "class": "float-right member-position" }, member.position
        );
      }
      else {
        listRight = DomHelper.CreateElement(
          "span", {
            "class": "float-right member-position"
          }, "Pending in " + member.committee
        );
      }

      DomHelper.AppendContent(
        list, DomHelper.CreateElement(
          "li", { "class": "clearfix" }, [listLeft, listRight]
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

})(
  DomHelper, this.FrontmanDetailsFactory = (
    this.FrontmanDetailsFactory == undefined
  ) ? {} : this.FrontmanDetailsFactory
  );