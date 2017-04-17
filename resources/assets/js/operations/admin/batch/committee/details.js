(function (
  DomHelper, HttpHelper, StringHelper, AlertFactory,
  BatchCommitteeDetailsFactory, BatchCommitteeDetailsOperations
) {

  BatchCommitteeDetailsOperations.RenderBatchCommitteeDetailsPage = function (
    source, batchID, committeeName, controllerCallback
  ) {

    var endpoint = (
      source + "action/admin/batch/details/" +
      batchID + "/" + StringHelper.MakeIndex(committeeName)
    );

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchCommitteeDetailsCallback(
        status, responseText, controllerCallback
      );
    });
  }

  BatchCommitteeDetailsOperations.ModifyFrontman = function (
    source, batchID, controllerCallback
  ) {

    var data = new FormData(document.getElementById("modify-frontmen-form"));
    var endpoint = (
      source + "action/admin/batch/details/" + batchID + "/modify/frontman"
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      ModifyFrontmenCallback(status, responseText, controllerCallback);
    });
  }

  BatchCommitteeDetailsOperations.AddCommitteeMember = function (
    source, batchID, committeeName, controllerCallback
  ) {

    var data = new FormData(
      document.getElementById("add-committee-member-form")
    );
    var endpoint = (
      source + "action/admin/batch/details/" + batchID + "/add/member/" +
      StringHelper.MakeIndex(committeeName)
    )

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshCommitteeMemberCallback(status, responseText, controllerCallback);
    });
  }

  BatchCommitteeDetailsOperations.RemoveCommitteeMember = function (
    source, batchID, batchMemberID, csrfObject, committeeName,
    controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-member-id", batchMemberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = (
      source + "action/admin/batch/details/" + batchID + "/remove/member/" +
      StringHelper.MakeIndex(committeeName)
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshCommitteeMemberCallback(status, responseText, controllerCallback);
    });
  }

  BatchCommitteeDetailsOperations.MakeCommitteeHead = function (
    source, batchID, batchMemberID, csrfObject, committeeName,
    controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-member-id", batchMemberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = (
      source + "action/admin/batch/details/" + batchID +
      "/make-committee-head/" + StringHelper.MakeIndex(committeeName)
    );

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshCommitteeMemberCallback(status, responseText, controllerCallback);
    });
  }

  function RenderBatchCommitteeDetailsCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      FillBatchName(response.data.batch.name);

      if (response.data.batch.committee.type == "frontman") {
        RenderFrontmanDetails(response.data.batch);
      }
      else {
        RenderCommitteeDetails(response.data.batch);
      }

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      )
    }
  }

  function FillBatchName(batchName) {

    var batchNameContainers = document.getElementsByClassName("batch-name");
    for (var i = 0; i < batchNameContainers.length; i++) {
      DomHelper.InsertContent(batchNameContainers[i], batchName);
    }
  }

  function RenderFrontmanDetails(batch) {

    batch.committee.members.forEach(function (member) {
      RenderFrontmanSelect(
        document.getElementById(
          StringHelper.MakeIndex(member.position) + "-select"
        ), member.id, batch.members
      );
    });
  }

  function RenderFrontmanSelect(select, selectedMemberID, members) {

    DomHelper.InsertContent(
      select, BatchCommitteeDetailsFactory.CreateUnassignOption()
    );
    members.forEach(function (member) {
      DomHelper.AppendContent(select, (member.id == selectedMemberID) ?
        BatchCommitteeDetailsFactory.CreateSelectedOption(member) :
        BatchCommitteeDetailsFactory.CreateOption(member)
      )
    });
  }

  function ModifyFrontmenCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if (status == HttpHelper.OK) {

      controllerCallback();

      window.scrollTo(0, 0);
      AlertFactory.GenerateSuccessAlert(container, response.message);
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function RefreshCommitteeMemberCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      RenderCommitteeDetails(response.data.batch);

      controllerCallback();

      window.scrollTo(0, 0);
      AlertFactory.GenerateSuccessAlert(container, response.message);
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function RenderCommitteeDetails(batch) {

    RenderCommitteeSelect(
      document.getElementById("add-committee-member-list"), batch.members
    );
    RenderMemberList(
      document.getElementById("committee-member-list"), batch.committee.members
    );
  }

  function RenderCommitteeSelect(list, members) {

    DomHelper.InsertContent(
      list, BatchCommitteeDetailsFactory.CreateDefaultOption()
    );

    members.forEach(function (member) {
      DomHelper.AppendContent(
        list, BatchCommitteeDetailsFactory.CreateOption(member)
      )
    })
  }

  function RenderMemberList(list, members) {

    DomHelper.InsertContent(
      list, BatchCommitteeDetailsFactory.CreateMemberHeader()
    );

    if (members.length > 0) {
      members.forEach(function (member) {
        DomHelper.AppendContent(
          list, BatchCommitteeDetailsFactory.CreateMemberItem(member)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        list, BatchCommitteeDetailsFactory.CreateEmptyMemberItem()
      );
    }
  }

})(
  DomHelper, HttpHelper, StringHelper,
  AlertFactory, BatchCommitteeDetailsFactory,
  this.BatchCommitteeDetailsOperations = (
    this.BatchCommitteeDetailsOperations == undefined
  ) ? {} : this.BatchCommitteeDetailsOperations
  );