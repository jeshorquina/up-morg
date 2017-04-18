(function (DomHelper, FrontmanDetailsFactory) {

  FrontmanDetailsFactory.CreateSelectedOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id,
      "selected": "selected"
    }, member.name);
  }

  FrontmanDetailsFactory.CreateOption = function (member) {

    return DomHelper.CreateElement("option", {
      "value": member.id
    }, member.name);
  }

})(
  DomHelper, this.FrontmanDetailsFactory = (
    this.FrontmanDetailsFactory == undefined
  ) ? {} : this.FrontmanDetailsFactory
  );