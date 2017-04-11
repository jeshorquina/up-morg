(function (DomHelper, AlertFactory, HttpHelper, UrlHelper, SignupOperations) {

  SignupOperations.Signup = function (source) {
    var form = document.getElementById("signup-form");

    var first_name = form.elements["first_name"].value;
    var middle_name = form.elements["middle_name"].value;
    var last_name = form.elements["last_name"];

    var email = form.elements["email"].value;
    var contact_number = form.elements["phone"].value;

    var password = form.elements["first_password"].value;
    var confirm_password = form.elements["second_password"].value;

    if (ValidateSignupData(first_name, middle_name, last_name,
      email, contact_number, password,
      confirm_password)) {

      var endpoint = source + "action/signup";
      var data = new FormData(form);

      HttpHelper.Post(endpoint, data, SignupCallback);
    }
  }

  function ValidateSignupData(first_name, middle_name, last_name,
    email, contact_number, password,
    confirm_password) {

    // TODO: Validate the inputs semantics-wise

    return true;
  }

  function SignupCallback(status, responseText) {
    var data = JSON.parse(responseText);
    var container = document.getElementById("notifications");

    DomHelper.ClearContent(container);

    ['first_name', 'middle_name', 'last_name',
      'email', 'phone', 'first_password',
      'second_password'].forEach(function (value) {
        DomHelper.RemoveClass(value, "form-input-error");
        DomHelper.ClearContent(value + "-error");
      });

    if (status == HttpHelper.UNPROCESSABLE_ENTITY) {

      AlertFactory.GenerateDangerAlert(
        container, "Could not sign up. Please check validation errors."
      );
      window.scrollTo(0, 0);

      Object.keys(data).forEach(function (id) {
        DomHelper.AddClass(id, "form-input-error");
        DomHelper.InsertContent(id + "-error", data[id].replace(/_/g, " "));
      });
    }
    else if (status == HttpHelper.INTERNAL_SERVER_ERROR) {

      AlertFactory.GenerateDangerAlert(container, data.message);
      window.scrollTo(0, 0);
    }
    else if (status == HttpHelper.CREATED) {

      AlertFactory.GenerateSuccessAlert(container, data.message);
      window.scrollTo(0, 0);

      UrlHelper.Redirect(data.redirect_url, 1000);
    }
  }

})(
  DomHelper, AlertFactory, HttpHelper, UrlHelper,
  this.SignupOperations = (
    this.SignupOperations == undefined
  ) ? {} : this.SignupOperations
  );
