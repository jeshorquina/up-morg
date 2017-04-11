(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, PasswordOperations) {

  PasswordOperations.ChangePassword = function (source) {

    var form = document.getElementById("password-form");

    var old_password = form.elements["old-password"].value;
    var new_password = form.elements["new-password"].value;
    var confirm_password = form.elements["confirm-password"].value;

    if (ValidateData(old_password, new_password, confirm_password)) {

      var endpoint = source + "action/admin/account/password/change";
      var data = new FormData(form);

      HttpHelper.Post(endpoint, data, Callback);
    }
  }

  function ValidateData(old_password, new_password, confirm_password) {

    // TODO: Validate semantics-wise

    return true;
  }

  function Callback(status, responseText) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    DomHelper.ClearContent(container);

    ["old-password", "new-password", "confirm-password"].forEach(function (value) {
      DomHelper.RemoveClass(value, "form-input-error");
      DomHelper.ClearContent(value + "-error");
    });

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        container, "Could not change password. Please check validation errors."
      );
      window.scrollTo(0, 0);

      Object.keys(data).forEach(function (id) {
        DomHelper.InputValue(id, "");
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(id + "-error", data[id].replace(/-/g, " "));
      });
    }
    else if (status == HttpHelper.INTERNAL_SERVER_ERROR) {

      AlertFactory.GenerateDangerAlert(container, data.message);
      window.scrollTo(0, 0);

    }
    else if (status == HttpHelper.OK) {

      AlertFactory.GenerateSuccessAlert(container, data.message);
      window.scrollTo(0, 0);

      UrlHelper.Redirect(data.redirect_url, 1000);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.PasswordOperations = (
    this.PasswordOperations == undefined
  ) ? {} : this.PasswordOperations
  );
