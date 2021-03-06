(function (FinanceCommitteeOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0],
    source = body.getAttribute("data-source");

  var controllerCallback = function () {

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  FinanceCommitteeOperations.RenderFinancePage(source, controllerCallback);

})(FinanceCommitteeOperations, ProfileDropdown, Loader);