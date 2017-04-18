(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  FirstFrontmanDetailsFactory, FirstFrontmanDetailsOperations
) {

  FirstFrontmanDetailsOperations.RenderBatchDetailsPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/member/";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  FirstFrontmanDetailsOperations.AddMember = function (
    source, controllerCallback
  ) {

    var data = new FormData(document.getElementById("add-member-form"));
    var endpoint = source + "action/member/add";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  FirstFrontmanDetailsOperations.RemoveMember = function (
    source, batchMemberID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-member-id", batchMemberID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/member/remove";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  FirstFrontmanDetailsOperations.EditCommittee = function (
    source, committeeName
  ) {
    UrlHelper.Redirect(
      source + "member/committee/" + committeeName
    );
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
        FirstFrontmanDetailsFactory.CreateCommitteeSection(committee)
      );
    });
  }

  function FillNonMemberSelect(nonMembers) {

    var nonMemberSelect = document.getElementById("add-member-list");

    DomHelper.InsertContent(
      nonMemberSelect,
      FirstFrontmanDetailsFactory.CreateNonMemberDefaultOption()
    );

    nonMembers.forEach(function (nonMember) {
      DomHelper.AppendContent(
        nonMemberSelect,
        FirstFrontmanDetailsFactory.CreateNonMemberOption(nonMember)
      )
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FirstFrontmanDetailsFactory,
  this.FirstFrontmanDetailsOperations = (
    this.FirstFrontmanDetailsOperations == undefined
  ) ? {} : this.FirstFrontmanDetailsOperations
  );