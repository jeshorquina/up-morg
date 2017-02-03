(function (DomHelper, AlertFactory) {

  AlertFactory.GenerateDangerAlert = function (container, clearHtml, data) {
    GenerateAlert(container, data, "alert-danger", clearHtml);
  }

  AlertFactory.GenerateSuccessAlert = function (container, clearHtml, data) {
    GenerateAlert(container, data, "alert-success", clearHtml);
  }

  function GenerateAlert(container, value, type, clearHtml) {
    if (clearHtml) {
      DomHelper.ClearHTML(container);
    }
    DomHelper.AppendHTML(container, CreateAlert(value, type));
  }

  function CreateAlert(message, type) {
    return "<div class='alert " + type + "'>" + message + "</div>";
  }

})(
  DomHelper,
  this.AlertFactory = (this.AlertFactory == undefined) ? {} : this.AlertFactory
  );