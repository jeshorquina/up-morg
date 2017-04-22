(function (FinanceMemberOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

  }

  FinanceMemberOperations.RenderFinancePage(source, controllerCallback);

})(FinanceMemberOperations);