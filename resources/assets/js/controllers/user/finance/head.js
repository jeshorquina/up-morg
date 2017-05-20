(function (FinanceHeadOperations, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var addLedgerEntryCallback = function (event) {
    event.preventDefault();
    FinanceHeadOperations.AddLedgerEntry(source, this, controllerCallback);
  }

  var verifyEntryCallback = function () {
    FinanceHeadOperations.VerifyLedgerEntry(
      source, this.getAttribute("data-entry-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var controllerCallback = function () {

    document
      .getElementById("add-ledger-entry-form")
      .addEventListener("submit", addLedgerEntryCallback);

    var verifyButtons = document.getElementsByClassName("verify-entry-button");
    for (var i = 0; i < verifyButtons.length; i++) {
      verifyButtons[i].addEventListener("click", verifyEntryCallback)
    }

    Loader.RemoveLoadingScreen();
  }

  FinanceHeadOperations.RenderFinancePage(source, controllerCallback);

})(FinanceHeadOperations, Loader);
