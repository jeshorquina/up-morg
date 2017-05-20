(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceFrontmanFactory,
  FinanceFrontmanOperations
) {

  FinanceFrontmanOperations.data = {};

  FinanceFrontmanOperations.RenderFinancePage = function (
    source, controllerCallback
  ) {

    var endpoint = source + "action/finance/closed";

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderFinancePageCallback(status, responseText, controllerCallback);
    });
  }

  FinanceFrontmanOperations.GenerateReport = function () {

    pdfMake.createPdf(DefineReportPDF()).download();
  }

  function RenderFinancePageCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK) {

      FinanceFrontmanOperations.data = response.data;

      GenerateFinancePage(FinanceFrontmanOperations.data);

      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function GenerateFinancePage(data) {

    FillLedgerEntries(data.entries);
  }

  function FillLedgerEntries(entries) {

    DomHelper.InsertContent(
      "ledger-entries-container",
      FinanceFrontmanFactory.CreatePreviousTotalRow(entries.previous)
    );

    if (entries.current.length > 0) {
      entries.current.forEach(function (entry) {
        DomHelper.AppendContent(
          "ledger-entries-container",
          FinanceFrontmanFactory.CreateLedgerEntryRow(entry)
        );
      });
    }
    else {
      DomHelper.AppendContent(
        "ledger-entries-container",
        FinanceFrontmanFactory.CreateNoLedgerEntriesRow()
      );
    }
  }

  function DefineReportPDF() {

    var preparedBody = [
      ['Date', 'Finance Member', 'Description', 'Debit', 'Credit', 'Total'],
      ['', '', '', '', '', FinanceFrontmanOperations.data.entries.previous]
    ];

    FinanceFrontmanOperations.data.entries.current.forEach(function (entry) {
      preparedBody.push([
        entry.date, entry.member, entry.description, entry.debit,
        entry.credit, entry.total.actual
      ]);
    })

    return {
      content: [
        {
          layout: 'lightHorizontalLines', // optional
          table: {
            headerRows: 1,
            widths: ['10%', '20%', '20%', '13%', '13%', '14%'],
            body: preparedBody
          }
        }
      ]
    }
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, FinanceFrontmanFactory,
  this.FinanceFrontmanOperations = (
    this.FinanceFrontmanOperations == undefined
  ) ? {} : this.FinanceFrontmanOperations
  );