(function (DomHelper, FinanceHeadFactory) {

  FinanceHeadFactory.CreatePreviousTotalRow = function (previousTotal) {

    return DomHelper.CreateElement("tr", { "class": "previous-balance" },
      [
        DomHelper.CreateElement("td", { "colspan": "6" },
          DomHelper.CreateElement("strong", {}, "Previous balance")
        ),
        DomHelper.CreateElement("td", { "class": "text-right" }, previousTotal)
      ]
    );
  }

  FinanceHeadFactory.CreateNoLedgerEntriesRow = function () {

    return DomHelper.CreateElement("tr", {},
      DomHelper.CreateElement("td", {
        "colspan": "7",
        "class": "text-center"
      }, "There are currently no ledger entries for this batch.")
    );
  }

  FinanceHeadFactory.CreateLedgerEntryRow = function (entry) {

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement("td", { "class": "text-center" }, entry.date),
      DomHelper.CreateElement("td", { "class": "text-center" },
        (!Boolean(entry.status)) ? DomHelper.CreateElement(
          "button", {
            "class": "button button-extra-small button-info no-margin verify-entry-button",
            "data-entry-id": entry.id
          }, "Verify"
        ) : "Verified"
      ),
      DomHelper.CreateElement("td", {}, entry.member),
      DomHelper.CreateElement("td", {}, entry.description),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.debit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.credit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.total)
    ]);
  }

})(
  DomHelper, this.FinanceHeadFactory = (
    this.FinanceHeadFactory == undefined
  ) ? {} : this.FinanceHeadFactory
  );