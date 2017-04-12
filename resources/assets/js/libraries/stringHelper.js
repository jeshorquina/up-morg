(function (StringHelper) {

  StringHelper.MakeIndex = function (value) {

    return value.toLowerCase().replace(/ /g, "-");
  }

  StringHelper.UnmakeIndex = function (value) {
    return ToTitleCase(value.replace(/-/g, " "));
  }

  function ToTitleCase(value) {
    return value.replace(/\w\S*/g, CapitalizeFirstLetter);
  }

  function CapitalizeFirstLetter(value) {
    return value.charAt(0).toUpperCase() + value.substr(1).toLowerCase()
  }

})(
  this.StringHelper = (this.StringHelper == undefined) ? {} : this.StringHelper
  );
