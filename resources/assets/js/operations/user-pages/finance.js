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

  FinanceOperations.VerifyLedgerEntry = function (
    source, ledgerEntryID, csrfObject, controllerCallback
  ) {
    var data = new FormData();
    data.append("ledger-entry-id", ledgerEntryID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/finance-tracker/verify-balance";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      VerifyLedgerEntryCallback(status, responseText, controllerCallback);
    });
  }

  function VerifyLedgerEntryCallback(status, responseText, controllerCallback) {
    alert(responseText);
  }

  function RenderLedgerEntriesCallback(status, responseText, controllerCallback) {
    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if(status == HttpHelper.OK) {
      var entryContainer = document.getElementById("entry-list-body");
      
      for(var i = 0; i < response.length; i++){
        DomHelper.AppendContent(entryContainer, GetEntryRow(response[i]));
      }
      controllerCallback();
    }
  }

  function GetEntryRow(entry) {

    var debitColumn, creditColumn;
    if(entry.type == "debit") {
      debitColumn = DomHelper.CreateElement("td", {}, String(entry.amount));
      creditColumn = DomHelper.CreateElement("td", {});
    }
    else {
      debitColumn = DomHelper.CreateElement("td", {});
      creditColumn = DomHelper.CreateElement("td", {}, String(entry.amount));
    }

    var ownerColumn =  DomHelper.CreateElement("td", {}, String(entry.owner));

    var isVerifiedColumn;
    if(!entry.verified) {
      isVerifiedColumn = DomHelper.CreateElement("td", {}, DomHelper.CreateElement("button", {
        "class": "verify-ledger-button",
        "data-entry-id": entry.id
      }, "Verify"))
    }
    else {
      isVerifiedColumn = DomHelper.CreateElement("td", {}, String(entry.verified));
    }

    return DomHelper.CreateElement("tr", {}, [debitColumn, creditColumn, ownerColumn, isVerifiedColumn]);
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