(function (BatchCommitteeDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    batchID = (
      document
        .getElementById("batch-committee-container")
        .getAttribute("data-batch-id")
    ),
    committeeName = (
      document
        .getElementById("batch-committee-container")
        .getAttribute("data-committee-name")
    );

  var modifyFrontmanCallback = function (event) {
    event.preventDefault();
    BatchCommitteeDetailsOperations.ModifyFrontman(
      source, batchID, controllerCallback
    );
  }

  var addCommitteeMemberCallback = function (event) {
    event.preventDefault();
    BatchCommitteeDetailsOperations.AddCommitteeMember(
      source, batchID, committeeName, controllerCallback
    );
  }

  var removeCommitteeMemberCallback = function () {
    BatchCommitteeDetailsOperations.RemoveCommitteeMember(
      source, batchID, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, committeeName, controllerCallback
    );
  }

  var makeCommitteeHeadCallback = function () {
    BatchCommitteeDetailsOperations.MakeCommitteeHead(
      source, batchID, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, committeeName, controllerCallback
    );
  }

  var controllerCallback = function () {

    if (committeeName.toLowerCase() == "frontman") {

      document
        .getElementById("modify-frontmen-form")
        .addEventListener("submit", modifyFrontmanCallback);
    }
    else {

      document
        .getElementById("add-committee-member-form")
        .addEventListener("submit", addCommitteeMemberCallback);

      var removeCommitteeMembersButton = (
        document.getElementsByClassName("remove-committee-member-button")
      );
      for (var i = 0; i < removeCommitteeMembersButton.length; i++) {
        removeCommitteeMembersButton[i].addEventListener(
          "click", removeCommitteeMemberCallback
        )
      }

      var makeCommitteeHeadButtons = (
        document.getElementsByClassName("make-committee-head-button")
      );
      for (var i = 0; i < makeCommitteeHeadButtons.length; i++) {
        makeCommitteeHeadButtons[i].addEventListener(
          "click", makeCommitteeHeadCallback
        )
      }
    }
  }

  BatchCommitteeDetailsOperations.RenderBatchCommitteeDetailsPage(
    source, batchID, committeeName, controllerCallback
  );

})(BatchCommitteeDetailsOperations);
