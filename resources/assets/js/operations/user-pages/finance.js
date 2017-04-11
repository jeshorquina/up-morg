(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, FinanceOperations) {

  FinanceOperations.AddDebitCredit = function (source) {

    var form = document.getElementById("add-debit-credit-form");

    var endpoint = source + "action/finance-tracker/add-debit-credit";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, AddDebitCreditCallback);
  }

  function AddDebitCreditCallback(status, responseText) {
    alert(responseText);
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.FinanceOperations = (
    this.FinanceOperations == undefined
  ) ? {} : this.FinanceOperations
  );