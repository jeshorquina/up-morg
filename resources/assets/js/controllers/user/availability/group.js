(function (AvailabilityGroupOperations, ProfileDropdown, Loader) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var viewCallback = function () {
    AvailabilityGroupOperations.ViewGroup(
      source, this.getAttribute("data-group-id")
    );
  }

  var editCallback = function () {
    AvailabilityGroupOperations.EditGroup(
      source, this.getAttribute("data-group-id")
    );
  }

  var deleteCallback = function () {
    AvailabilityGroupOperations.DeleteGroup(
      source, this.getAttribute("data-group-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var addCallback = function (event) {
    event.preventDefault();
    AvailabilityGroupOperations.AddGroup(source, controllerCallback);
  }

  var controllerCallback = function () {

    var viewButtons = document.getElementsByClassName(
      "view-group-button"
    );
    for (var i = 0; i < viewButtons.length; i++) {
      viewButtons[i].removeEventListener("click", viewCallback);
      viewButtons[i].addEventListener("click", viewCallback);
    }

    var editButtons = document.getElementsByClassName(
      "edit-group-button"
    );
    for (var i = 0; i < editButtons.length; i++) {
      editButtons[i].removeEventListener("click", editCallback);
      editButtons[i].addEventListener("click", editCallback);
    }

    var deleteButtons = document.getElementsByClassName(
      "delete-group-button"
    )
    for (var i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].removeEventListener("click", deleteCallback);
      deleteButtons[i].addEventListener("click", deleteCallback);
    }

    var addForm = document.getElementById("add-group-form");
    addForm.removeEventListener("submit", addCallback);
    addForm.addEventListener("submit", addCallback);

    ProfileDropdown.Initialize();
    Loader.RemoveLoadingScreen();
  }

  AvailabilityGroupOperations.RenderAvailabilityGroupPage(
    source, controllerCallback
  );

})(AvailabilityGroupOperations, ProfileDropdown, Loader);
