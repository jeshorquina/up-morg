(function (
  DomHelper, HttpHelper, StringHelper, AlertFactory,
  FrontmanDetailsFactory, FrontmanDetailsOperations
) {

  FrontmanDetailsOperations.RenderFrontmanDetailsPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/member/committee/frontman";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFrontmanDetailsCallback(
        status, responseText, controllerCallback
      );
    });
  }

  FrontmanDetailsOperations.ModifyFrontman = function (
    source, controllerCallback
  ) {

    var data = new FormData(document.getElementById("modify-frontmen-form"));
    var endpoint = source + "action/member/committee/frontman/modify";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      ModifyFrontmanCallback(status, responseText, controllerCallback);
    });
  }

  function RenderFrontmanDetailsCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      FillBatchName(response.data.batch.name);

      RenderFrontmanDetails(response.data.batch);

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

    members.forEach(function (member) {
      DomHelper.AppendContent(select, (member.id == selectedMemberID) ?
        FrontmanDetailsFactory.CreateSelectedOption(member) :
        FrontmanDetailsFactory.CreateOption(member)
      )
    });
  }

  function ModifyFrontmanCallback(status, responseText, controllerCallback) {

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

})(
  DomHelper, HttpHelper, StringHelper, AlertFactory, FrontmanDetailsFactory,
  this.FrontmanDetailsOperations = (
    this.FrontmanDetailsOperations == undefined
  ) ? {} : this.FrontmanDetailsOperations
  );