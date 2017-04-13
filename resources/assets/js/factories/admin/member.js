(function (DomHelper, MemberFactory) {

  MemberFactory.CreateMemberRow = function (memberEntry) {

    var idColumn, firstNameColumn, middleNameColumn, lastNameColumn, emailColumn, phoneColumn;

    idColumn = DomHelper.CreateElement("td", {}, memberEntry.memberID);
    firstNameColumn = DomHelper.CreateElement("td", {}, memberEntry.firstName);
    middleNameColumn = DomHelper.CreateElement("td", {}, memberEntry.middleName);
    lastNameColumn = DomHelper.CreateElement("td", {}, memberEntry.lastName);
    emailColumn = DomHelper.CreateElement("td", {}, memberEntry.emailAddress);
    phoneColumn = DomHelper.CreateElement("td", {}, memberEntry.phoneNumber);

    return DomHelper.CreateElement("tr", {}, [idColumn, firstNameColumn, middleNameColumn, lastNameColumn, emailColumn, phoneColumn]);
  }

})(
  DomHelper, this.MemberFactory = (
    this.MemberFactory == undefined
  ) ? {} : this.MemberFactory
  );