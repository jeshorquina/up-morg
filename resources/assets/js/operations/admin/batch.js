(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, BatchOperations) {

  BatchOperations.RenderBatches = function (source) {

    var endpoint = source + "action/admin/manage/batch";
    HttpHelper.Get(endpoint, RenderBatchesCallback);
  }

  function RenderBatchesCallback(status, responseText) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    if (status == HttpHelper.INTERNAL_SERVER_ERROR) {

      AlertFactory.GenerateDangerAlert(container, data.message);
      window.scrollTo(0, 0);
    }
    else if (status == HttpHelper.OK) {
      alert(responseText);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.BatchOperations = (
    this.BatchOperations == undefined
  ) ? {} : this.BatchOperations
  );