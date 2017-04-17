(function (
  DomHelper, HttpHelper, StringHelper, AlertFactory, MemberOperations
) {

  MemberDetailsOperations.RenderMember = function (
    source, memberID, controllerCallback
  ) {

    var endpoint = source + "action/admin/member/details/" + memberID;
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderMemberCallback(status, responseText, controllerCallback);
    });
  }

  MemberDetailsOperations.ModifyMember = function (
    source, form, memberID, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = source + "action/admin/member/details/modify/" + memberID;
    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshMemberCallback(status, responseText, controllerCallback);
    });
  }

  function RefreshMemberCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    ResetFormValidation();

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillMemberName(response.data.member);
      FillMemberDetails(response.data.member);

      controllerCallback();

      window.scrollTo(0, 0);
      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );

      Object.keys(response.data).forEach(function (id) {
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(
          id + "-error", StringHelper.UnmakeIndex(response.data[id])
        );
      });
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function ResetFormValidation() {
    [
      'first-name', 'middle-name', 'last-name', 'email-address', 'phone-number'
    ].forEach(function (value) {
      DomHelper.RemoveClass(value, "form-input-error");
      DomHelper.ClearContent(value + "-error");
    });
  }

  function RenderMemberCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillMemberName(response.data.member);
      FillMemberDetails(response.data.member);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillMemberName(member) {

    var memberName = (
      member["first-name"] + " " +
      member["middle-name"] + " " +
      member["last-name"]
    ).replace(/  /g, " ");

    var memberNameContainers = document.getElementsByClassName("member-name");
    for (var i = 0; i < memberNameContainers.length; i++) {
      DomHelper.InsertContent(memberNameContainers[i], memberName);
    }
  }

  function FillMemberDetails(member) {

    Object.keys(member).forEach(function (key) {
      if (key != "id") {
        DomHelper.InputValue(key, member[key]);
      }
    });
  }

})(
  DomHelper, HttpHelper, StringHelper, AlertFactory,
  this.MemberDetailsOperations = (
    this.MemberDetailsOperations == undefined
  ) ? {} : this.MemberDetailsOperations
  );