(function (FinanceOperations) {

  document
    .getElementById("add-debit-credit-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      FinanceOperations.AddDebitCredit(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(FinanceOperations);