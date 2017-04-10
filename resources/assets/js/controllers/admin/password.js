(function (PasswordOperations) {

  document
    .getElementById("password-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      PasswordOperations.ChangePassword(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(PasswordOperations);
