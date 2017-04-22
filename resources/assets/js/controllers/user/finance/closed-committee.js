(function (FinanceCommitteeOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

  }

  FinanceCommitteeOperations.RenderFinancePage(source, controllerCallback);

})(FinanceCommitteeOperations);