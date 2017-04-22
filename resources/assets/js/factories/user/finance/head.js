(function (DomHelper, FinanceHeadFactory) {

  FinanceHeadFactory.CreatePreviousTotalRow = function (previousTotal) {

    return DomHelper.CreateElement("tr", { "class": "previous-balance" },
      [
        DomHelper.CreateElement("td", { "colspan": "6" }, "Previous balance"),
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

})(
  DomHelper, this.FinanceHeadFactory = (
    this.FinanceHeadFactory == undefined
  ) ? {} : this.FinanceHeadFactory
  );