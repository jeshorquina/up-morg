{
  document
    .getElementById("login-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      LoginController.Login(this.getAttribute("data-source"));
    });
}

(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, LoginController) {

  LoginController.Login = function (source) {

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

    DomHelper.ClearHTML(container);

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        container, "Could not log in. Please check validation errors."
      );

      ["username", "password"].forEach(function (value) {
        DomHelper.RemoveClass(value, "input-error");
        DomHelper.ClearHTML(value + "-error");
      });

      Object.keys(data).forEach(function (value) {
        DomHelper.AddClass(value, "input-error");
        DomHelper.InnerHTML(value + "-error", data[value]);
      });
    }
    else if (status == HttpHelper.OK) {

      AlertFactory.GenerateSuccessAlert(container, data.message);
      UrlHelper.Redirect(data.redirect_url, 1000);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.LoginController = (
    this.LoginController == undefined
  ) ? {} : this.LoginController
  );
