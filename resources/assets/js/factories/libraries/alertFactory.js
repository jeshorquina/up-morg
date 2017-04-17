(function (DomHelper, AlertFactory) {

  AlertFactory.GenerateDangerAlert = function (container, data) {
    GenerateAlert(container, data, "alert-danger");
  }

  AlertFactory.GenerateSuccessAlert = function (container, data) {
    GenerateAlert(container, data, "alert-success");
  }

  function GenerateAlert(container, value, type) {
    DomHelper.InsertContent(container, CreateAlert(value, type));
  }

  function CreateAlert(message, type) {
    return DomHelper.CreateElement(
      "div", {
        "class": "alert " + type
      }, DomHelper.CreateElement(
        "div", {
          "class": "alert-content"
        }, message
      )
    );
  }

})(
  DomHelper,
  this.AlertFactory = (this.AlertFactory == undefined) ? {} : this.AlertFactory
  );