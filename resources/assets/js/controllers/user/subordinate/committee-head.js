(function (CommitteeHeadDetailsOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var editCommitteeCallback = function () {
    CommitteeHeadDetailsOperations.EditCommittee(
      source, this.getAttribute("data-committee-name")
    )
  }

  var controllerCallback = function () {

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

  CommitteeHeadDetailsOperations.RenderBatchDetailsPage(
    source, controllerCallback
  );

})(CommitteeHeadDetailsOperations);
