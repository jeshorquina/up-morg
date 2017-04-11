(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, BatchOperations) {

  BatchOperations.RenderBatches = function (source, controllerCallback) {

    var endpoint = source + "action/admin/manage/batch";
    HttpHelper.Get(endpoint, function (status, responseText) {
      RenderBatchesCallback(status, responseText, controllerCallback);
    });
  }

  function RenderBatchesCallback(status, responseText, controllerCallback) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if (status == HttpHelper.INTERNAL_SERVER_ERROR) {

      AlertFactory.GenerateDangerAlert(container, data.message);
      window.scrollTo(0, 0);
    }
    else if (status == HttpHelper.OK) {
      var batchContainer = document.getElementById("batch-list");
      for (var i = 0; i < data.length; i++) {
        DomHelper
      }
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.BatchOperations = (
    this.BatchOperations == undefined
  ) ? {} : this.BatchOperations
  );