(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceCommitteeFactory,
  FinanceCommitteeOperations
) {

  FinanceCommitteeOperations.RenderFinancePage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/finance/closed";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFinancePageCallback(status, responseText, controllerCallback);
    });
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
      FinanceCommitteeFactory.CreatePreviousTotalRow(entries.previous)
    );

    if (entries.current.length > 0) {
      entries.current.forEach(function (entry) {
        DomHelper.AppendContent(
          "ledger-entries-container",
          FinanceCommitteeFactory.CreateLedgerEntryRow(entry)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        "ledger-entries-container",
        FinanceCommitteeFactory.CreateNoLedgerEntriesRow()
      );
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceCommitteeFactory,
  this.FinanceCommitteeOperations = (
    this.FinanceCommitteeOperations == undefined
  ) ? {} : this.FinanceCommitteeOperations
  );