(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, MemberFactory, MemberOperations
) {

  MemberOperations.members = {};

  MemberOperations.RenderMembers = function (source, controllerCallback) {

    var endpoint = source + "action/admin/member";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderMembersCallback(status, responseText, controllerCallback);
    });
  }

  MemberOperations.DeleteMember = function (
    source, memberID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("member-id", memberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/member/delete";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      DeleteBatchCallback(status, responseText, controllerCallback);
    });
  }

  MemberOperations.FilterMembers = function (searchQuery, controllerCallback) {
    FillMemberList(
      MemberOperations.members.filter(function (member) {
        return member.name.toLowerCase().indexOf(searchQuery.toLowerCase()) > -1;
      })
    );
    controllerCallback();
  }

  MemberOperations.EditMember = function (source, memberID) {
    UrlHelper.Redirect(source + "admin/member/details/" + memberID);
  }

  function DeleteBatchCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      RenderMembersCallback(status, responseText, controllerCallback);
      AlertFactory.GenerateSuccessAlert(container, response.message);
    }
    else {
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function RenderMembersCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      MemberOperations.members = response.data;

      FillMemberList(MemberOperations.members);
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillMemberList(members) {

    var memberContainer = document.getElementById("member-list");

    if (members.length > 0) {

      DomHelper.ClearContent(memberContainer);
      members.forEach(function (member) {
        DomHelper.AppendContent(
          memberContainer, MemberFactory.CreateMemberRow(member)
        );
      });
    }
    else {

      DomHelper.InsertContent(
        memberContainer, MemberFactory.CreateEmptyMemberRow()
      );
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, MemberFactory,
  this.MemberOperations = (
    this.MemberOperations == undefined
  ) ? {} : this.MemberOperations
  );