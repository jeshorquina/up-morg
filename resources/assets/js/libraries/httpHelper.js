(function (HttpHelper) {

  HttpHelper.INTERNAL_SERVER_ERROR = 500;
  HttpHelper.UNPROCESSABLE_ENTITY = 422;
  HttpHelper.OK = 200;
  HttpHelper.CREATED = 201;

  HttpHelper.Get = function (endpoint, calback) {
    callEndpoint(endpoint, "GET", "", callback);
  }

  HttpHelper.Post = function (endpoint, data, callback) {
    callEndpoint(endpoint, "POST", data, callback);
  }

  function callEndpoint(endpoint, method, data, callback) {
    var request = new XMLHttpRequest();

    request.onload = function () {
      if (request.readyState == XMLHttpRequest.DONE) {
        callback(request.status, request.responseText);
      }
    }
    request.open(method, endpoint);
    request.send(data);
  }

})(this.HttpHelper = (this.HttpHelper == undefined) ? {} : this.HttpHelper);
