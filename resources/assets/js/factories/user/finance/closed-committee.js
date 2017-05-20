(function (DomHelper, FinanceCommitteeFactory) {

  FinanceCommitteeFactory.CreatePreviousTotalRow = function (previousTotal) {

    return DomHelper.CreateElement("tr", { "class": "previous-balance" }, [
      DomHelper.CreateElement("td", { "colspan": "6" }),
      DomHelper.CreateElement("td", { "class": "text-right", "colspan": "2" }, [
        DomHelper.CreateElement("div", {}, previousTotal),
        DomHelper.CreateElement("small", {}, "(Previous balance)")
      ])
    ]);
  }

  FinanceCommitteeFactory.CreateNoLedgerEntriesRow = function () {

    return DomHelper.CreateElement("tr", {},
      DomHelper.CreateElement("td", {
        "colspan": "7",
        "class": "text-center"
      }, "There are currently no ledger entries for this batch.")
    );
  }

  FinanceCommitteeFactory.CreateLedgerEntryRow = function (entry) {

    var projected = (!Boolean(entry.status)) ? entry.total.projected : "";

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement("td", { "class": "text-center" }, entry.date),
      DomHelper.CreateElement("td", {}, entry.member),
      DomHelper.CreateElement("td", {}, entry.description),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.debit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.credit),
      DomHelper.CreateElement("td", { "class": "text-right" }, projected),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.total.actual),
    ]);
  }

})(
  DomHelper, this.FinanceCommitteeFactory = (
    this.FinanceCommitteeFactory == undefined
  ) ? {} : this.FinanceCommitteeFactory
  );