(function (
  DomHelper, HttpHelper, UrlHelper, AlertFactory,
  BatchFactory, BatchOperations
) {

  BatchOperations.RenderBatches = function (source, controllerCallback) {

    var endpoint = source + "action/admin/batch";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchesCallback(status, responseText, controllerCallback);
    });
  }

  BatchOperations.AddBatch = function (source, controllerCallback) {

    var endpoint = source + "action/admin/batch/add";
    var form = document.getElementById("add-batch-form");

    var data = new FormData(form);

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      AddBatchCallback(status, responseText, controllerCallback);
    });
  }

  BatchOperations.EditBatch = function (source, batchID) {
    UrlHelper.Redirect(source + "admin/batch/details/" + batchID);
  }

  BatchOperations.DeleteBatch = function (
    source, batchID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-id", batchID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/batch/delete";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      DeleteBatchCallback(status, responseText, controllerCallback);
    });
  }

  BatchOperations.ActivateBatch = function (
    source, batchID, csrfObject, controllerCallback
  ) {

    var data = new FormData();
    data.append("batch-id", batchID);
    data.append(csrfObject.name, csrfObject.value);

    var endpoint = source + "action/admin/batch/activate";

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      ActivateBatchCallback(status, responseText, controllerCallback);
    });
  }

  function AddBatchCallback(status, responseText, controllerCallback) {

    if (status == HttpHelper.CREATED) {
      DomHelper.InputValue("batch-academic-year", "");
    }
    BatchEntryProcessCallback(status, responseText, controllerCallback);
  }

  function DeleteBatchCallback(status, responseText, controllerCallback) {
    BatchEntryProcessCallback(status, responseText, controllerCallback);
  }

  function ActivateBatchCallback(status, responseText, controllerCallback) {
    BatchEntryProcessCallback(status, responseText, controllerCallback);
  }

  function BatchEntryProcessCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      RenderBatchesCallback(status, responseText, controllerCallback);
      AlertFactory.GenerateSuccessAlert(container, response.message);
    }
    else {
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function RenderBatchesCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      FillBatchList(response.data);
      controllerCallback();
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(
        document.getElementById("notifications"), response.message
      );
    }
  }

  function FillBatchList(batches) {

    var batchContainer = document.getElementById("batch-list");

    DomHelper.ClearContent(batchContainer);

    batches.forEach(function (batchEntry) {
      DomHelper.AppendContent(
        batchContainer, BatchFactory.CreateBatchRow(batchEntry)
      );
    });
  }

})(
  DomHelper, HttpHelper, UrlHelper, AlertFactory, BatchFactory,
  this.BatchOperations = (
    this.BatchOperations == undefined
  ) ? {} : this.BatchOperations
  );