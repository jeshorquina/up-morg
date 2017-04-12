(function (
  DomHelper, AlertFactory, HttpHelper, UrlHelper, BatchDetailsOperations
) {

  BatchDetailsOperations.RenderBatchDetailsPage = function (
    source, controllerCallback
  ) {

    var batchDetailsContainer = document.getElementById("batch-details-container");
    var batchID = batchDetailsContainer.getAttribute("data-batch-id");
    var endpoint = source + "action/admin/batch/details/" + batchID;

    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchDetailsCallback(status, responseText, controllerCallback);
    });
  }

  BatchDetailsOperations.DeleteBatch = function (
    source, batchID, csrfObject
  ) {

    var data = new FormData();
    data.append("batch-id", batchID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/batch/delete";

    HttpHelper.Post(endpoint, data, function (status, responseText) {

    });
  }

  BatchDetailsOperations.ActivateBatch = function (
    source, batchID, csrfObject
  ) {

    var data = new FormData();
    data.append("batch-id", batchID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/batch/activate";

    HttpHelper.Post(endpoint, data, function (status, responseText) {

    });
  }

  function RenderBatchDetailsCallback(
    status, responseText, controllerCallback
  ) {
    alert(responseText);
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.BatchDetailsOperations = (
    this.BatchDetailsOperations == undefined
  ) ? {} : this.BatchDetailsOperations
  );