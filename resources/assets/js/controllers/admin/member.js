(function (MemberOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var deleteCallback = function () {
    MemberOperations.DeleteMember(
      source, this.getAttribute("data-member-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var editCallback = function () {
    MemberOperations.EditMember(source, this.getAttribute("data-member-id"));
  }

  var searchCallback = function () {
    MemberOperations.FilterMembers(this.value, controllerCallback);
  }

  var controllerCallback = function () {

    document
      .getElementById("name-search-bar")
      .addEventListener("keyup", searchCallback);

    var editButtons = document.getElementsByClassName(
      "edit-member-button"
    );
    for (var i = 0; i < editButtons.length; i++) {
      editButtons[i].addEventListener("click", editCallback);
    }

    var deleteButtons = document.getElementsByClassName(
      "delete-member-button"
    )
    for (var i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].addEventListener("click", deleteCallback);
    }

    Loader.RemoveLoadingScreen();
  }

  MemberOperations.RenderMembers(source, controllerCallback);

})(MemberOperations);
