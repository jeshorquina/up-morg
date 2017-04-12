(function (FinanceOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

    var verifyCallback = function () {
      FinanceOperations.VerifyLedgerEntry(
        source, this.getAttribute("data-entry-id"), {
          "name": body.getAttribute("data-csrf-name"),
          "value": body.getAttribute("data-csrf-hash")
        }, controllerCallback
      );
    }

    var controllerCallback = function () {

      document
        .getElementById("add-debit-credit-form")
        .addEventListener("submit", function (event) {
          event.preventDefault();
          FinanceOperations.AddDebitCredit(source);
        });

        var verifyButtons = document.getElementsByClassName("verify-ledger-button");
        for(var i = 0; i < verifyButtons.length; i++) {
          verifyButtons[i].removeEventListener("click", verifyCallback);
          verifyButtons[i].addEventListener("click", verifyCallback);
        }
    }

    FinanceOperations.RenderLedgerEntries(source, controllerCallback);

})(FinanceOperations);