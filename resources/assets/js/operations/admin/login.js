(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, LoginOperations) {

  LoginOperations.Login = function (source) {

    var form = document.getElementById("login-form");
    var password = form.elements["password"].value;
    var username = form.elements["username"].value;

    if (ValidateLoginData(password)) {

      var endpoint = source + "action/admin/login";
      var data = new FormData(form);

      HttpHelper.Post(endpoint, data, LoginCallback);
    }
  }

  function ValidateLoginData(password) {

    // TODO: Validate the username and password semantics-wise

    return true;
  }

  function LoginCallback(status, responseText) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    DomHelper.ClearContent(container);
    DomHelper.RemoveClass("password", "form-input-error");

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(container, data.message);
      window.scrollTo(0, 0);

      DomHelper.AddClass("password", "form-input-error");
    }
    else if (status == HttpHelper.OK) {

      AlertFactory.GenerateSuccessAlert(container, data.message);
      window.scrollTo(0, 0);

      UrlHelper.Redirect(data.redirect_url, 1000);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.LoginOperations = (
    this.LoginOperations == undefined
  ) ? {} : this.LoginOperations
  );