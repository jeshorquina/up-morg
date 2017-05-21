(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, AccountPasswordOperations) {

  AccountPasswordOperations.ChangePassword = function (source) {

    var endpoint = source + "action/account/password/change";
    var data = new FormData(document.getElementById("password-form"));

    HttpHelper.Post(endpoint, data, ChangePasswordCallback);
  }

  function ChangePasswordCallback(status, responseText) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    DomHelper.ClearContent(container);

    ["old-password", "new-password", "confirm-password"].forEach(function (value) {
      DomHelper.RemoveClass(value, "form-input-error");
      DomHelper.ClearContent(value + "-error");
    });

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        container, "Cannot change password. Please check validation errors."
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
  this.AccountPasswordOperations = (
    this.AccountPasswordOperations == undefined
  ) ? {} : this.AccountPasswordOperations
  );
