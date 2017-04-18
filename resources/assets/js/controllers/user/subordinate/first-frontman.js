(function (FirstFrontmanDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var addMemberCallback = function (event) {
    event.preventDefault();
    FirstFrontmanDetailsOperations.AddMember(source, controllerCallback);
  }

  var removeMemberCallback = function () {
    FirstFrontmanDetailsOperations.RemoveMember(
      source, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var editCommitteeCallback = function () {
    FirstFrontmanDetailsOperations.EditCommittee(
      source, this.getAttribute("data-committee-name")
    )
  }

  var controllerCallback = function () {

    var addMemberForm = document.getElementById("add-member-form");
    addMemberForm.removeEventListener("submit", addMemberCallback);
    addMemberForm.addEventListener("submit", addMemberCallback);

    var removeMemberButtons = document.getElementsByClassName(
      "remove-member-button"
    );
    for (var i = 0; i < removeMemberButtons.length; i++) {
      removeMemberButtons[i].removeEventListener(
        "click", removeMemberCallback
      );
      removeMemberButtons[i].addEventListener(
        "click", removeMemberCallback
      );
    }

    var editCommitteeButtons = document.getElementsByClassName(
      "edit-committee-button"
    );
    for (var i = 0; i < editCommitteeButtons.length; i++) {
      editCommitteeButtons[i].removeEventListener(
        "click", editCommitteeCallback
      );
      editCommitteeButtons[i].addEventListener(
        "click", editCommitteeCallback
      );
    }
  }

  FirstFrontmanDetailsOperations.RenderBatchDetailsPage(
    source, controllerCallback
  );

})(FirstFrontmanDetailsOperations);
