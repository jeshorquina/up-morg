(function (RequestCommitteeOperations, ProfileDropdown, Loader) {

  var source = (
    document
      .getElementsByTagName("body")[0]
      .getAttribute("data-source")
  );

  var requestCommitteeCallback = function (event) {

    event.preventDefault();
    RequestCommitteeOperations.RequestCommittee(
      source, this, controllerCallback
    );
  }

  var controllerCallback = function () {

    document
      .getElementById("select-committee-form")
      .addEventListener("submit", requestCommitteeCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  RequestCommitteeOperations.RenderRequestPage(source, controllerCallback);

})(RequestCommitteeOperations, ProfileDropdown, Loader);
