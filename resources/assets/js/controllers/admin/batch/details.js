(function (BatchDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    batchID = (
      document
        .getElementById("batch-details-container")
        .getAttribute("data-batch-id")
    );

  var addMemberCallback = function (event) {
    event.preventDefault();
    BatchDetailsOperations.AddMember(source, batchID, controllerCallback);
  }

  var removeMemberCallback = function () {
    BatchDetailsOperations.RemoveMember(
      source, batchID, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var editCommitteeCallback = function () {
    BatchDetailsOperations.EditCommittee(
      source, batchID, this.getAttribute("data-committee-name")
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

    Loader.RemoveLoadingScreen();
  }

  BatchDetailsOperations.RenderBatchDetailsPage(
    source, batchID, controllerCallback
  );

})(BatchDetailsOperations);
