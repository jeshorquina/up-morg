(function (BatchDetailsOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var deleteCallback = function () {
    BatchOperations.DeleteBatch(
      source, this.getAttribute("data-batch-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }
    );
  }

  var activateCallback = function () {
    BatchOperations.ActivateBatch(
      source, this.getAttribute("data-batch-id"), {
        "name": body.getAttribute("data-csrf-name"),
        "value": body.getAttribute("data-csrf-hash")
      }
    )
  }

  var controllerCallback = function () {

  }

  BatchDetailsOperations.RenderBatchDetailsPage(source, controllerCallback)

})(BatchDetailsOperations);
