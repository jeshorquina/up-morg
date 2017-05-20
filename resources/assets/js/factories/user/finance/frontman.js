(function (DomHelper, FinanceFrontmanFactory) {

  FinanceFrontmanFactory.CreatePreviousTotalRow = function (previousTotal) {

    return DomHelper.CreateElement("tr", { "class": "previous-balance" }, [
      DomHelper.CreateElement("td", { "colspan": "6" }),
      DomHelper.CreateElement("td", { "class": "text-right", "colspan": "2" }, [
        DomHelper.CreateElement("div", {}, previousTotal),
        DomHelper.CreateElement("small", {}, "(Previous balance)")
      ])
    ]);
  }

  FinanceFrontmanFactory.CreateNoLedgerEntriesRow = function () {

    return DomHelper.CreateElement("tr", {},
      DomHelper.CreateElement("td", {
        "colspan": "8",
        "class": "text-center"
      }, "There are currently no ledger entries for this batch.")
    );
  }

  FinanceFrontmanFactory.CreateLedgerEntryRow = function (entry) {

    var projected = (!Boolean(entry.status)) ? entry.total.projected : "";

    return DomHelper.CreateElement("tr", {}, [
      DomHelper.CreateElement("td", { "class": "text-center" }, entry.date),
      DomHelper.CreateElement("td", { "class": "text-center" },
        (Boolean(entry.status)) ? "Yes" : "No"
      ),
      DomHelper.CreateElement("td", {}, entry.member),
      DomHelper.CreateElement("td", {}, entry.description),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.debit),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.credit),
      DomHelper.CreateElement("td", { "class": "text-right" }, projected),
      DomHelper.CreateElement("td", { "class": "text-right" }, entry.total.actual),
    ]);
  }

})(
  DomHelper, this.FinanceFrontmanFactory = (
    this.FinanceFrontmanFactory == undefined
  ) ? {} : this.FinanceFrontmanFactory
  );