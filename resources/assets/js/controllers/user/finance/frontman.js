(function (FinanceFrontmanOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var closeLedgerCallback = function (event) {
    event.preventDefault();
    FinanceFrontmanOperations.CloseLedger(source, this);
  }

  var controllerCallback = function () {

    document
      .getElementById("close-ledger-form")
      .addEventListener("submit", closeLedgerCallback);

    Loader.RemoveLoadingScreen();
  }

  FinanceFrontmanOperations.RenderFinancePage(source, controllerCallback);

})(FinanceFrontmanOperations);