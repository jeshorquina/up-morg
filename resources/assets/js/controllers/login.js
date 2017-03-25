{
  document
    .getElementById("login-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      LoginController.Login(this.getAttribute("data-source"));
    });
}

(function (AlertFactory, HttpHelper, UrlHelper, LoginController) {

  LoginController.Login = function (source) {

    var form = document.getElementById("login-form");
    var username = form.elements["username"].value;
    var password = form.elements["password"].value;

    if (ValidateLoginData(username, password)) {

      var endpoint = source + "action/login";
      var data     = new FormData(form);

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

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {
      if (data['username'] != undefined) {
        AlertFactory.GenerateDangerAlert(container, true, data['username']);
      }
      if (data['password'] != undefined) {
        AlertFactory.GenerateDangerAlert(container, false, data['password']);
      }
    }
    else if (status == HttpHelper.OK) {
      AlertFactory.GenerateSuccessAlert(container, true, data.message);
      UrlHelper.Redirect(data.redirect_url, 1000);
    }
  }

})(
  AlertFactory, HttpHelper, UrlHelper,
  this.LoginController = (
    this.LoginController == undefined
  ) ? {} : this.LoginController
  );
