(function (AvailabilityGroupEditOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    groupID = (
      document
        .getElementById("availability-group-edit-container")
        .getAttribute("data-group-id")
    );

  var addGroupMemberCallback = function (event) {
    event.preventDefault();
    AvailabilityGroupEditOperations.AddGroupMember(
      source, groupID, this, controllerCallback
    );
  }

  var removeGroupMemberCallback = function () {
    AvailabilityGroupEditOperations.RemoveGroupMember(
      source, groupID, this.getAttribute("data-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    );
  }

  var controllerCallback = function () {

    document
      .getElementById("add-group-member-form")
      .addEventListener("submit", addGroupMemberCallback);

    var removeGroupMembersButton = (
      document.getElementsByClassName("remove-group-member-button")
    );
    for (var i = 0; i < removeGroupMembersButton.length; i++) {
      removeGroupMembersButton[i].addEventListener(
        "click", removeGroupMemberCallback
      )
    }

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  AvailabilityGroupEditOperations.RenderAvailabilityGroupEditPage(
    source, groupID, controllerCallback
  );

})(AvailabilityGroupEditOperations, ProfileDropdown, Loader);
