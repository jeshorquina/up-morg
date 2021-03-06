(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceFrontmanFactory,
  FinanceFrontmanOperations
) {

  FinanceFrontmanOperations.RenderFinancePage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/finance";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFinancePageCallback(status, responseText, controllerCallback);
    });
  }

  FinanceFrontmanOperations.CloseLedger = function (source, form) {

    var data = new FormData(form);
    var endpoint = source + "action/finance/close";

    HttpHelper.Post(endpoint, data, CloseLedgerCallback);
  }

  function CloseLedgerCallback(status, responseText) {

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

  function RenderFinancePageCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      GenerateFinancePage(response.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function GenerateFinancePage(data) {

    FillLedgerEntries(data.entries);
  }

  function FillLedgerEntries(entries) {

    DomHelper.InsertContent(
      "ledger-entries-container",
      FinanceFrontmanFactory.CreatePreviousTotalRow(entries.previous)
    );

    if (entries.current.length > 0) {
      entries.current.forEach(function (entry) {
        DomHelper.AppendContent(
          "ledger-entries-container",
          FinanceFrontmanFactory.CreateLedgerEntryRow(entry)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        "ledger-entries-container",
        FinanceFrontmanFactory.CreateNoLedgerEntriesRow()
      );
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceFrontmanFactory,
  this.FinanceFrontmanOperations = (
    this.FinanceFrontmanOperations == undefined
  ) ? {} : this.FinanceFrontmanOperations
  );