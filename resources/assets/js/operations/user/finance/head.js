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

  FinanceHeadOperations.AddLedgerEntry = function (
    source, form, controllerCallback
  ) {

    var data = new FormData(form);
    var endpoint = source + "action/finance/add";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshFinancePageCallback(status, responseText, controllerCallback);
    });
  }

  FinanceHeadOperations.VerifyLedgerEntry = function (
    source, entryID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/finance/verify/" + entryID;

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      RefreshFinancePageCallback(status, responseText, controllerCallback);
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

  function RefreshFinancePageCallback(
    status, responseText, controllerCallback
  ) {

    var response = JSON.parse(responseText);

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      GenerateFinancePage(response.data);

      controllerCallback();

      AlertFactory.GenerateSuccessAlert(
        document.getElementById("notifications"), response.message
      );
    }
    else {

      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function GenerateFinancePage(data) {

    FillLedgerEntries(data.entries);
    RemoveAddLedgerEntryFormDetails();
  }

  function FillLedgerEntries(entries) {

    DomHelper.InsertContent(
      "ledger-entries-container",
      FinanceHeadFactory.CreatePreviousTotalRow(entries.previous)
    );

    if (entries.current.length > 0) {
      entries.current.forEach(function (entry) {
        DomHelper.AppendContent(
          "ledger-entries-container",
          FinanceHeadFactory.CreateLedgerEntryRow(entry)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        "ledger-entries-container",
        FinanceHeadFactory.CreateNoLedgerEntriesRow()
      );
    }
  }

  function RemoveAddLedgerEntryFormDetails() {
    document.getElementById("add-ledger-entry-form").reset();
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceHeadFactory,
  this.FinanceHeadOperations = (
    this.FinanceHeadOperations == undefined
  ) ? {} : this.FinanceHeadOperations
  );