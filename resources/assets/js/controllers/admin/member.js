(function (MemberOperations) {

  var body = document.getElementsByTagName("body")[0];
  var source = body.getAttribute("data-source");

  var controllerCallback = function () { 

  }

  MemberOperations.RenderMembers(source, controllerCallback);
  
})(MemberOperations);