(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, LoginOperations) {

  LoginOperations.Login = function (source) {

    var form = document.getElementById("login-form");
    var username = form.elements["username"].value;
    var password = form.elements["password"].value;

    if (ValidateLoginData(username, password)) {

      var endpoint = source + "action/login";
      var data = new FormData(form);

      HttpHelper.Post(endpoint, data, LoginCallback);
    }
  }

  function ValidateLoginData(username, password) {

    // TODO: Validate the username and password semantics-wise

    return true;
  }

  function LoginCallback(status, responseText) {

    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    DomHelper.ClearContent(container);

    ["username", "password"].forEach(function (value) {
      DomHelper.RemoveClass(value, "form-input-error");
      DomHelper.ClearContent(value + "-error");
    });

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        container, "Could not log in. Please check validation errors."
      );
      window.scrollTo(0, 0);

      Object.keys(data).forEach(function (id) {
        if (id === 'password') {
          DomHelper.InputValue(id, "");
        }
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(id + "-error", data[id]);
      });
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
