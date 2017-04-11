(function (FinanceOperations) {

  var source = 
    document
      .getElementsByTagName("body")[0]
      .getAttribute("data-source");

    var controllerCallback = function () {

      document
        .getElementById("add-debit-credit-form")
        .addEventListener("submit", function (event) {
          event.preventDefault();
          FinanceOperations.AddDebitCredit(source);
        });
    }

    FinanceOperations.RenderLedgerEntries(source, controllerCallback);

})(FinanceOperations);