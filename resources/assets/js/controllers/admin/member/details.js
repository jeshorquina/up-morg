(function (MemberDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    memberID = (
      document
        .getElementById("member-details-container")
        .getAttribute("data-member-id")
    );

  var modifyMemberCallback = function (event) {
    event.preventDefault();
    MemberDetailsOperations.ModifyMember(
      source, this, memberID, controllerCallback
    );
  }

  var controllerCallback = function () {

    document
      .getElementById("modify-member-form")
      .addEventListener("submit", modifyMemberCallback);
  }

  MemberDetailsOperations.RenderMember(source, memberID, controllerCallback);

})(MemberDetailsOperations);
