(function (LoginController) {

  LoginController.Login = function (source) {

    var form = document.getElementById("login-form");

    var username = form.elements["username"].value;
    var password = form.elements["password"].value;

    if (validateLoginData(username, password)) {

      var endpoint = source + "action/login";
      var method = 'POST';
      var data = {
        username: username,
        password: password
      };

      var body = [];
      for (var key in data) {
        body.push(encodeURIComponent(key) + '=' + encodeURIComponent(data[key]));
      }

      var response = callLoginEndpoint(endpoint, method, body.join("&"));
    }
  }

  function validateLoginData(username, password) {
    return true;
  }

  function callLoginEndpoint(endpoint, method, data) {

    var xmlhttp = new XMLHttpRequest();

    xmlhttp.onreadystatechange = function () {
      if (xmlhttp.readyState == XMLHttpRequest.DONE) {
        return xmlhttp.responseText;
      }
    };

    xmlhttp.open(method, endpoint, true);
    xmlhttp.setRequestHeader('Content-Type', 'application/json');
    xmlhttp.withCredentials = true;
    xmlhttp.send(data);
  }

})(this.LoginController = (this.LoginController == undefined) ? {} : this.LoginController)
