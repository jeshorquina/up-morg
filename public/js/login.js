!function(e){e.ClearHTML=function(e){e.innerHTML=""},e.AppendHTML=function(e,t){e.innerHTML=e.innerHTML+t}}(this.DomHelper=void 0==this.DomHelper?{}:this.DomHelper),function(e,t){function n(t,n,o,i){i&&e.ClearHTML(t),e.AppendHTML(t,r(n,o))}function r(e,t){return"<div class='alert "+t+"'>"+e+"</div>"}t.GenerateDangerAlert=function(e,t,r){n(e,t,"alert-danger",r)},t.GenerateSuccessAlert=function(e,t,r){n(e,t,"alert-success",r)}}(DomHelper,this.AlertFactory=void 0==this.AlertFactory?{}:this.AlertFactory),function(e){function t(e,t,n,r){var o=new XMLHttpRequest;o.onload=function(){o.readyState==XMLHttpRequest.DONE&&r(o.status,o.responseText)},o.open(t,e),o.send(n)}e.UNPROCESSABLE_ENTITY=422,e.OK=200,e.Get=function(e,n){t(e,"GET","",callback)},e.Post=function(e,n,r){t(e,"POST",n,r)}}(this.HttpHelper=void 0==this.HttpHelper?{}:this.HttpHelper),function(e){e.Redirect=function(e,t){setTimeout(function(){window.location=e},t)}}(this.UrlHelper=void 0==this.UrlHelper?{}:this.UrlHelper),document.getElementById("login-form").addEventListener("submit",function(e){e.preventDefault(),LoginController.Login(this.getAttribute("data-source"))}),function(e,t,n,r){function o(e,t){return!0}function i(r,o){var i=JSON.parse(o),l=document.getElementById("notifications");r==t.UNPROCESSABLE_ENTITY?(void 0!=i.username&&e.GenerateDangerAlert(l,i.username,!0),void 0!=i.password&&e.GenerateDangerAlert(l,i.password,!1)):r==t.OK&&(e.GenerateSuccessAlert(l,i.message,!0),n.Redirect(i.redirect_url,1e3))}r.Login=function(e){var n=document.getElementById("login-form"),r=n.elements.username.value,l=n.elements.password.value;if(o(r,l)){var s=e+"action/login",a=new FormData(n);t.Post(s,a,i)}}}(AlertFactory,HttpHelper,UrlHelper,this.LoginController=void 0==this.LoginController?{}:this.LoginController);
//# sourceMappingURL=login.js.map
