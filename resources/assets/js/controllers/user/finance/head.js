(function (FinanceHeadOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

  }

  FinanceHeadOperations.RenderFinancePage(source, controllerCallback);

})(FinanceHeadOperations);
