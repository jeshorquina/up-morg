(function (DomHelper, BatchFactory) {

  BatchFactory.CreateBatchRow = function (batchEntry) {

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
        }, DomHelper.CreateElement("span", { "class": "icon-activate" })
      )
    }

    var editButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-info-border button-small edit-batch-button float-right",
        "data-batch-id": batchEntry.BatchID,
      }, DomHelper.CreateElement("span", { "class": "icon-edit" })
    );

    var deleteButton = DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small delete-batch-button float-right",
        "data-batch-id": batchEntry.BatchID
      }, DomHelper.CreateElement("span", { "class": "icon-delete" })
    )

    return DomHelper.CreateElement(
      "li", { "class": "batch-entry clearfix" }, [
        span, deleteButton, editButton, activeButton
      ]
    );
  }

  BatchFactory.CreateEmptyBatchRow = function () {

    return DomHelper.CreateElement(
      "li", {
        "class": "batch-entry"
      }, "There are currently no batch to show. Add some"
    );
  }

})(
  DomHelper, this.BatchFactory = (
    this.BatchFactory == undefined
  ) ? {} : this.BatchFactory
  );