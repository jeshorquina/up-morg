(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceHeadFactory,
  FinanceHeadOperations
) {

  FinanceHeadOperations.RenderFinancePage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/finance";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFinancePageCallback(status, responseText, controllerCallback);
    });
  }

  function RenderFinancePageCallback(
    status, responseText, controllerCallback
  ) {

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
      FinanceHeadFactory.CreatePreviousTotalRow(entries.previous)
    );

    if (entries.current.length > 0) {
      entries.forEach(function (entry) {

      });
    }
    else {
      DomHelper.AppendContent(
        "ledger-entries-container",
        FinanceHeadFactory.CreateNoLedgerEntriesRow()
      );
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceHeadFactory,
  this.FinanceHeadOperations = (
    this.FinanceHeadOperations == undefined
  ) ? {} : this.FinanceHeadOperations
  );