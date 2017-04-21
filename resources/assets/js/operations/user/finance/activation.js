(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceActivationOperations
) {

  FinanceActivationOperations.RenderFinanceActivationPage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/finance/activation";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFinanceActivationCallback(status, responseText, controllerCallback);
    });
  }

  FinanceActivationOperations.ActivateLedger = function (source, form) {

    var endpoint = source + "action/finance/activate";
    var data = new FormData(form);

    HttpHelper.Post(endpoint, data, ActivateLedgerCallback);
  }

  function RenderFinanceActivationCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      FillCurrentLedgerDetails(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillCurrentLedgerDetails(data) {

    DomHelper.InsertContent("current-debit", data.debit);
    DomHelper.InsertContent("current-credit", data.credit);
    DomHelper.InsertContent("current-total", data.total);
  }

  function ActivateLedgerCallback(status, responseText) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK) {

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
      UrlHelper.Redirect(response.redirect_url, 1000);
    }
    else {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  this.FinanceActivationOperations = (
    this.FinanceActivationOperations == undefined
  ) ? {} : this.FinanceActivationOperations
  );