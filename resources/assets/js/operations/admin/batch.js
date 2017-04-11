(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, BatchOperations) {

  BatchOperations.RenderBatches = function (source, controllerCallback) {

    var endpoint = source + "action/admin/batch";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchesCallback(status, responseText, controllerCallback);
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
      BatchEntryProcessCallback(status, responseText, controllerCallback);
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
      BatchEntryProcessCallback(status, responseText, controllerCallback);
    });
  }

  BatchOperations.AddBatch = function (source, controllerCallback) {

    var endpoint = source + "action/admin/batch/add";
    var form = document.getElementById("add-batch-form");

    var data = new FormData(form);

    HttpHelper.Post(endpoint, data, function (status, responseText) {
      if (status == HttpHelper.CREATED) {
        DomHelper.InputValue("batch-academic-year", "");
      }
      BatchEntryProcessCallback(status, responseText, controllerCallback);
    });
  }

  function RenderBatchesCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      var batchContainer = document.getElementById("batch-list");
      var batchList = response.data;

      DomHelper.ClearContent(batchContainer);

      for (var i = 0; i < batchList.length; i++) {

        DomHelper.AppendContent(batchContainer, GetBatchRow(batchList[i]));
        if (i == batchList.length - 1) {
          controllerCallback();
        }
      }
    }
    else {

      window.scrollTo(0, 0);
      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

  function GetBatchRow(batchEntry) {

    var span = DomHelper.CreateElement(
      "span", { "class": "table-cell" }, [
        "Batch ", DomHelper.CreateElement(
          "strong", {}, batchEntry.AcadYear
        )
      ]
    );

    var activeButton;
    if ((new Boolean(batchEntry.IsActive)) == true) {

      activeButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-success button-small no-hover float-right",
          "disabled": "disabled"
        }, "Active Batch"
      );
    }
    else {

      activeButton = DomHelper.CreateElement(
        "button", {
          "class": "button button-success-border button-small activate-batch-button float-right",
          "data-batch-id": batchEntry.BatchID,
        }, "Activate"
      )
    }

    var editButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-info-border button-small edit-batch-button float-right",
        "data-batch-id": batchEntry.BatchID,
      }, DomHelper.CreateElement(
        "span", {
          "class": "icon-pencil"
        }
      )
    );

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small delete-batch-button float-right",
        "data-batch-id": batchEntry.BatchID
      }, DomHelper.CreateElement(
        "span", {
          "class": "icon-trashcan"
        }
      )
    )

    return DomHelper.CreateElement(
      "li", {
        "class": "batch-entry clearfix"
      }, [span, deleteButton, editButton, activeButton]
    );
  }

  function BatchEntryProcessCallback(status, responseText, controllerCallback) {

    var response = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    window.scrollTo(0, 0);

    if (status == HttpHelper.OK || status == HttpHelper.CREATED) {

      AlertFactory.GenerateSuccessAlert(container, response.message);
      RenderBatchesCallback(status, responseText, controllerCallback);
    }
    else {

      AlertFactory.GenerateDangerAlert(container, response.message);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.BatchOperations = (
    this.BatchOperations == undefined
  ) ? {} : this.BatchOperations
  );