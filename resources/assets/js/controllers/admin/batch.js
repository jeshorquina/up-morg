(function (BatchOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var activateCallback = function () {
    BatchOperations.ActivateBatch(
      source, this.getAttribute("data-batch-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var editCallback = function () {
    BatchOperations.EditBatch(
      source, this.getAttribute("data-batch-id")
    )
  }

  var deleteCallback = function () {
    BatchOperations.DeleteBatch(
      source, this.getAttribute("data-batch-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }, controllerCallback
    )
  }

  var addCallback = function (event) {
    event.preventDefault();
    BatchOperations.AddBatch(source, controllerCallback);
  }

  var controllerCallback = function () {

    var activateButtons = document.getElementsByClassName(
      "activate-batch-button"
    );
    for (var i = 0; i < activateButtons.length; i++) {
      activateButtons[i].removeEventListener("click", activateCallback);
      activateButtons[i].addEventListener("click", activateCallback);
    }

    var editButtons = document.getElementsByClassName(
      "edit-batch-button"
    );
    for (var i = 0; i < editButtons.length; i++) {
      editButtons[i].removeEventListener("click", editCallback);
      editButtons[i].addEventListener("click", editCallback);
    }

    var deleteButtons = document.getElementsByClassName(
      "delete-batch-button"
    )
    for (var i = 0; i < deleteButtons.length; i++) {
      deleteButtons[i].removeEventListener("click", deleteCallback);
      deleteButtons[i].addEventListener("click", deleteCallback);
    }

    var addForm = document.getElementById("add-batch-form");
    addForm.removeEventListener("submit", addCallback);
    addForm.addEventListener("submit", addCallback);
  }

  BatchOperations.RenderBatches(source, controllerCallback);

})(BatchOperations);
