(function (FinanceFrontmanOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

  }

  FinanceFrontmanOperations.RenderFinancePage(source, controllerCallback);

})(FinanceFrontmanOperations);