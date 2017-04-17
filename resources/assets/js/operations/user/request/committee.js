(function (
  DomHelper, HttpHelper, AlertFactory, RequestCommitteeFactory,
  RequestCommitteeOperations
) {

  RequestCommitteeOperations.RenderRequestPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/request/committee";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderRequestPageCallback(status, responseText, controllerCallback);
    });
  }

  RequestCommitteeOperations.RequestCommittee = function (
    source, form, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = source + "action/request/committee/change";
    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshRequestPageCallback(status, responseText, controllerCallback);
    });
  }

  function RenderRequestPageCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderCommittees(response.data);
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RefreshRequestPageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      RenderCommittees(response.data);

      controllerCallback();

      window.scrollTo(0, 0);
      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function RenderCommittees(commitees) {

    var committeeSelect = document.getElementById("select-committee");

    DomHelper.InsertContent(
      committeeSelect, RequestCommitteeFactory.CreateDefaultOption()
    );

    commitees.forEach(function (commitee) {
      DomHelper.AppendContent(
        committeeSelect, RequestCommitteeFactory.CreateOption(commitee)
      );
    });
  }

})(
  DomHelper, HttpHelper, AlertFactory, RequestCommitteeFactory,
  this.RequestCommitteeOperations = (
    this.RequestCommitteeOperations == undefined
  ) ? {} : this.RequestCommitteeOperations
  );