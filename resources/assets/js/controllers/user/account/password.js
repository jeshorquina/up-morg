(function (AccountPasswordOperations, ProfileDropdown) {

  ProfileDropdown.Initialize();

  document
    .getElementById("password-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      AccountPasswordOperations.ChangePassword(
        document
          .getElementsByTagName("body")[0]
          .getAttribute("data-source")
      );
    });

})(AccountPasswordOperations, ProfileDropdown);
