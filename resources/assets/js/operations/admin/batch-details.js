(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  BatchDetailsFactory, BatchDetailsOperations
) {

  BatchDetailsOperations.RenderBatchDetailsPage = function (
    source, batchID, controllerCallback
  ) {

    var endpoint = source + "action/admin/batch/details/" + batchID;

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  BatchDetailsOperations.AddMember = function (
    source, batchID, controllerCallback
  ) {

    var data = new FormData(document.getElementById("add-member-form"));
    var endpoint = source + "action/admin/batch/details/add/" + batchID;

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshBatchDetailsCallback(status, responseText, controllerCallback);
    })
  }

  BatchDetailsOperations.RemoveMember = function (
    source, batchID, batchMemberID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-member-id", batchMemberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/batch/details/remove/" + batchID;

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  function RefreshBatchDetailsCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    FillCommitteeSection(response.data.batch.committees);
    FillNonMemberSelect(response.data.batch.nonMembers);

    controllerCallback();

    window.scrollTo(0, 0);
    AlertFactory.GenerateSuccessAlert(
      document.getElementById("notifications"), response.message
    );
  }

  function RenderBatchDetailsCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillBatchName(response.data.batch.name);
      FillCommitteeSection(response.data.batch.committees);
      FillNonMemberSelect(response.data.batch.nonMembers);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillBatchName(batchName) {

    var batchNameContainers = document.getElementsByClassName("batch-name");
    for (var i = 0; i < batchNameContainers.length; i++) {
      DomHelper.InsertContent(batchNameContainers[i], batchName);
    }
  }

  function FillCommitteeSection(committees) {

    var committeeListContainer = document.getElementById("batch-member-groups");

    DomHelper.ClearContent(committeeListContainer);

    committees.forEach(function (committee) {
      DomHelper.AppendContent(
        committeeListContainer,
        BatchDetailsFactory.CreateCommitteeSection(committee)
      );
    });
  }

  function FillNonMemberSelect(nonMembers) {

    var nonMemberSelect = document.getElementById("add-member-list");

    DomHelper.InsertContent(
      nonMemberSelect,
      BatchDetailsFactory.CreateNonMemberDefaultOption()
    );

    nonMembers.forEach(function (nonMember) {
      DomHelper.AppendContent(
        nonMemberSelect,
        BatchDetailsFactory.CreateNonMemberOption(nonMember)
      )
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, BatchDetailsFactory,
  this.BatchDetailsOperations = (
    this.BatchDetailsOperations == undefined
  ) ? {} : this.BatchDetailsOperations
  );