(function (DomHelper, EventDetailsViewFactory) {

  EventDetailsViewFactory.CreateEditButton = function (eventID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-info button-small margin-right-small",
        "id": "edit-event-button",
        "data-event-id": eventID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-edit" }, " Edit"
      )
    );
  }

  EventDetailsViewFactory.CreateDeleteButton = function (eventID) {

    return DomHelper.CreateElement(
      "button", {
        "class": "button button-danger-border button-small",
        "id": "delete-event-button",
        "data-event-id": eventID
      }, DomHelper.CreateElement(
        "span", { "class": "icon-delete" }, " Delete"
      )
    );
  }

})(
  DomHelper, this.EventDetailsViewFactory = (
    this.EventDetailsViewFactory == undefined
  ) ? {} : this.EventDetailsViewFactory
  );