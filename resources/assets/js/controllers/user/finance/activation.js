(function (FinanceActivationOperations) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var activateCallback = function (event) {
    event.preventDefault();
    FinanceActivationOperations.ActivateLedger(source, this);
  }

  var controllerCallback = function () {

    document
      .getElementById("activate-form")
      .addEventListener("submit", activateCallback);
  }

  FinanceActivationOperations.RenderFinanceActivationPage(
    source, controllerCallback
  );

})(FinanceActivationOperations);