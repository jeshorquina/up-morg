(function (DomHelper, FinanceMemberFactory) {

  FinanceMemberFactory.CreatePreviousTotalRow = function (previousTotal) {

    return DomHelper.CreateElement("tr", { "class": "previous-balance" },
      [
        DomHelper.CreateElement("td", { "colspan": "5" }, "Previous balance"),
        DomHelper.CreateElement("td", { "class": "text-right" }, previousTotal)
      ]
    );
  }

  FinanceMemberFactory.CreateNoLedgerEntriesRow = function () {

    return DomHelper.CreateElement("tr", {},
      DomHelper.CreateElement("td", {
        "colspan": "6",
        "class": "text-center"
      }, "There are currently no ledger entries for this batch.")
    );
  }

  FinanceMemberFactory.CreateLedgerEntryRow = function (entry) {

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement("td", { "class": "text-center" }, entry.date),
      DomHelper.CreateElement("td", {}, entry.member),
      DomHelper.CreateElement("td", {}, entry.description),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.debit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.credit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.total)
    ]);
  }

})(
  DomHelper, this.FinanceMemberFactory = (
    this.FinanceMemberFactory == undefined
  ) ? {} : this.FinanceMemberFactory
  );