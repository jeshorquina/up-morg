(function (SignupOperations) {

  document
    .getElementById("signup-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      SignupOperations.Signup(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(SignupOperations);
