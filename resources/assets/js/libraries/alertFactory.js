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
    return "<div class='alert " + type + "'>"
      + "<div class='alert-content'>"
      + message
      + "</div>"
      + "</div>";
  }

})(
  DomHelper,
  this.AlertFactory = (this.AlertFactory == undefined) ? {} : this.AlertFactory
  );