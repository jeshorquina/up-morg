(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, FinanceOperations) {

  FinanceOperations.AddDebitCredit = function (source) {

    var form = document.getElementById("add-debit-credit-form");

    var endpoint = source + "action/finance-tracker/add-debit-credit";
    var data = new FormData(form);
    
    HttpHelper.Post(endpoint, data, AddDebitCreditCallback);
  }

  FinanceOperations.RenderLedgerEntries = function (source, controllerCallback) {
    var endpoint = source + "action/finance-tracker/get-ledger-entries";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderLedgerEntriesCallback(status, responseText, controllerCallback);
    })
  }

  function RenderLedgerEntriesCallback(status, responseText, controllerCallback) {
    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if(status == HttpHelper.OK) {
      var entryContainer = document.getElementById("entry-list");
      
      for(var i = 0; i < response.length; i++){
        DomHelper.AppendContent(entryContainer, GetEntryRow(response[i]));
      }
    }
  }

  function GetEntryRow(entry) {
    return DomHelper.CreateElement("tr", {}, JSON.stringify(entry));
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