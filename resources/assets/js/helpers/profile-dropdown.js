(function (DomHelper, ProfileDropdown) {

  ProfileDropdown.Initialize = function () {

    var dropdownButton = document.querySelector('.profile-dropdown-key');

    return new Drop({
      target: dropdownButton,
      content: CreateDropdown(
        dropdownButton.getAttribute("data-logout-link"),
        dropdownButton.getAttribute("data-account-link"),
        dropdownButton.getAttribute("data-user-name"),
        dropdownButton.getAttribute("data-user-position")
      ),
      classes: 'drop-theme-basic',
      position: 'bottom right',
      openOn: 'click'
    });
  }

  function CreateDropdown(logoutLink, accountLink, userName, userPosition) {

    return DomHelper.CreateElement("div", {}, [
      DomHelper.CreateElement("div", { "class": "profile-details" }, [
        DomHelper.CreateElement("strong", {}, userName),
        DomHelper.CreateElement("br"),
        DomHelper.CreateElement("small", {}, userPosition)
      ]),
      DomHelper.CreateElement("a", {
        "href": accountLink, "class": "profile-links"
      }, "Edit Account"),
      DomHelper.CreateElement("a", {
        "href": logoutLink, "class": "profile-links"
      }, "Logout")
    ])
  }

})(DomHelper, this.ProfileDropdown = (this.ProfileDropdown == undefined) ?
  {} : this.ProfileDropdown);
