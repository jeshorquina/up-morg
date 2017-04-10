(function (LoginOperations) {

  document
    .getElementById("login-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      LoginOperations.Login(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(LoginOperations);
