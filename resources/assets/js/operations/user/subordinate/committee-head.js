(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  CommitteeHeadDetailsFactory, CommitteeHeadDetailsOperations
) {

  CommitteeHeadDetailsOperations.RenderBatchDetailsPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/member/";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  CommitteeHeadDetailsOperations.EditCommittee = function (
    source, committeeName
  ) {
    UrlHelper.Redirect(
      source + "member/committee/" + committeeName
    );
  }

  function RenderBatchDetailsCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillBatchName(response.data.batch.name);
      FillCommitteeSection(response.data.batch.committees);

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
        CommitteeHeadDetailsFactory.CreateCommitteeSection(committee)
      );
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, CommitteeHeadDetailsFactory,
  this.CommitteeHeadDetailsOperations = (
    this.CommitteeHeadDetailsOperations == undefined
  ) ? {} : this.CommitteeHeadDetailsOperations
  );