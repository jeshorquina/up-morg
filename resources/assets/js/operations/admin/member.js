(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  BatchFactory, BatchOperations
) {

    MemberOperations.RenderMembers = function (source, controllerCallback) {

    var endpoint = source + "action/admin/members";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderMembersCallback(status, responseText, controllerCallback);
    });
  }

    function RenderMembersCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillMemberList(response.data);
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillMemberList(batches) {

    var memberContainer = document.getElementById("member-list");

    DomHelper.ClearContent(memberContainer);

    members.forEach(function (memberEntry) {
      DomHelper.AppendContent(
        memberContainer, MemberFactory.CreateMemberRow(memberEntry)
      );
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, BatchFactory,
  this.MemberOperations = (
    this.MemberOperations == undefined
  ) ? {} : this.MemberOperations
  );