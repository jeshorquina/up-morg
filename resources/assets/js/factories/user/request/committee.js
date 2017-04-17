(function (DomHelper, RequestCommitteeFactory) {

  RequestCommitteeFactory.CreateDefaultOption = function () {

    return DomHelper.CreateElement(
      "option", {
        "selected": "selected",
        "disabled": "disabled",
      }, "Select from committee list"
    );
  }

  RequestCommitteeFactory.CreateOption = function (committee) {

    var attributes = {
      "name": "committee-id",
      "value": committee.id
    };

    if (committee.selected == true) {
      attributes.selected = "selected";
    }

    return DomHelper.CreateElement("option", attributes, committee.name);
  }

})(
  DomHelper, this.RequestCommitteeFactory = (
    this.RequestCommitteeFactory == undefined
  ) ? {} : this.RequestCommitteeFactory
  );