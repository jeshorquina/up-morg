(function (CommitteeDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source"),
    committeeName = (
      document
        .getElementById("batch-committee-container")
        .getAttribute("data-committee-name")
    );

  var addCommitteeMemberCallback = function (event) {
    event.preventDefault();
    CommitteeDetailsOperations.AddCommitteeMember(
      source, committeeName, controllerCallback
    );
  }

  var removeCommitteeMemberCallback = function () {
    CommitteeDetailsOperations.RemoveCommitteeMember(
      source, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, committeeName, controllerCallback
    );
  }

  var makeCommitteeHeadCallback = function () {
    CommitteeDetailsOperations.MakeCommitteeHead(
      source, this.getAttribute("data-batch-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, committeeName, controllerCallback
    );
  }

  var controllerCallback = function () {

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

    Loader.RemoveLoadingScreen();
  }

  CommitteeDetailsOperations.RenderCommitteeDetailsPage(
    source, committeeName, controllerCallback
  );

})(CommitteeDetailsOperations);
