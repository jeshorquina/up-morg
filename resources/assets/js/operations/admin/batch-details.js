(function (
  DomHelper, AlertFactory, HttpHelper, UrlHelper, BatchDetailsOperations
) {

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

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.BatchDetailsOperations = (
    this.BatchDetailsOperations == undefined
  ) ? {} : this.BatchDetailsOperations
  );