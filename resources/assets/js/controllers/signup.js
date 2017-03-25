{
    // TODO: Call submit here of sign up form and use sign up controller
    document
        .getElementById("signup-form")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            SignupController.Signup(this.getAttribute("data-source"));
        });
}

(function (AlertFactory, HttpHelper, UrlHelper, LoginController) {

    SignupController.Signup = function (source) {
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

        if (status == HttpHelper.UNPROCESSABLE_ENTITY) {
            if (data['first_name'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['first_name']
                );
            }
            if (data['middle_name'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['middle_name']
                );
            }
            if (data['last_name'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['last_name']
                );
            }
            if (data['email_address'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['email_address']
                );
            }
            if (data['phone_number'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['phone_number']
                );
            }
            if (data['first_password'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['first_password']
                );
            }
            if (data['second_password'] != undefined) {
                AlertFactory.GenerateDangerAlert(
                    container, false, data['second_password']
                );
            }
        }
        else if (status == HttpHelper.CREATED) {
            AlertFactory.GenerateSuccessAlert(container, true, data.message);
            UrlHelper.Redirect(data.redirect_url, 1000);
        }
    }

})(
    AlertFactory, HttpHelper, UrlHelper,
    this.SignupController = (
        this.SignupController == undefined
    ) ? {} : this.SignupController
    );