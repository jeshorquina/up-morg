(function (FinanceFrontmanOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var generateReportCallback = function (event) {
    event.preventDefault();
    FinanceFrontmanOperations.GenerateReport();
  }

  var controllerCallback = function () {

    document
      .getElementById("generate-report-form")
      .addEventListener("submit", generateReportCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  FinanceFrontmanOperations.RenderFinancePage(source, controllerCallback);

})(FinanceFrontmanOperations, ProfileDropdown, Loader);