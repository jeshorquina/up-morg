!function(t,e){function n(){T=S=H=B=O=k=F}function i(t,e){for(var n in e)e.hasOwnProperty(n)&&(t[n]=e[n])}function o(t){return parseFloat(t)||0}function r(){A={top:e.pageYOffset,left:e.pageXOffset}}function a(){return e.pageXOffset!=A.left?(r(),void H()):void(e.pageYOffset!=A.top&&(r(),d()))}function s(t){setTimeout(function(){e.pageYOffset!=A.top&&(A.top=e.pageYOffset,d())},0)}function d(){for(var t=N.length-1;t>=0;t--)c(N[t])}function c(t){if(t.inited){var e=A.top<=t.limit.start?0:A.top>=t.limit.end?2:1;t.mode!=e&&g(t,e)}}function l(){for(var t=N.length-1;t>=0;t--)if(N[t].inited){var e=Math.abs(b(N[t].clone)-N[t].docOffsetTop),n=Math.abs(N[t].parent.node.offsetHeight-N[t].parent.height);if(e>=2||n>=2)return!1}return!0}function f(t){isNaN(parseFloat(t.computed.top))||t.isCell||"none"==t.computed.display||(t.inited=!0,t.clone||m(t),"absolute"!=t.parent.computed.position&&"relative"!=t.parent.computed.position&&(t.parent.node.style.position="relative"),c(t),t.parent.height=t.parent.node.offsetHeight,t.docOffsetTop=b(t.clone))}function p(t){var e=!0;t.clone&&v(t),i(t.node.style,t.css);for(var n=N.length-1;n>=0;n--)if(N[n].node!==t.node&&N[n].parent.node===t.parent.node){e=!1;break}e&&(t.parent.node.style.position=t.parent.css.position),t.mode=-1}function u(){for(var t=N.length-1;t>=0;t--)f(N[t])}function h(){for(var t=N.length-1;t>=0;t--)p(N[t])}function g(t,e){var n=t.node.style;switch(e){case 0:n.position="absolute",n.left=t.offset.left+"px",n.right=t.offset.right+"px",n.top=t.offset.top+"px",n.bottom="auto",n.width="auto",n.marginLeft=0,n.marginRight=0,n.marginTop=0;break;case 1:n.position="fixed",n.left=t.box.left+"px",n.right=t.box.right+"px",n.top=t.css.top,n.bottom="auto",n.width="auto",n.marginLeft=0,n.marginRight=0,n.marginTop=0;break;case 2:n.position="absolute",n.left=t.offset.left+"px",n.right=t.offset.right+"px",n.top="auto",n.bottom=0,n.width="auto",n.marginLeft=0,n.marginRight=0}t.mode=e}function m(t){t.clone=document.createElement("div");var e=t.node.nextSibling||t.node,n=t.clone.style;n.height=t.height+"px",n.width=t.width+"px",n.marginTop=t.computed.marginTop,n.marginBottom=t.computed.marginBottom,n.marginLeft=t.computed.marginLeft,n.marginRight=t.computed.marginRight,n.padding=n.border=n.borderSpacing=0,n.fontSize="1em",n.position="static",n.cssFloat=t.computed.cssFloat,t.node.parentNode.insertBefore(t.clone,e)}function v(t){t.clone.parentNode.removeChild(t.clone),t.clone=void 0}function y(t){var e=getComputedStyle(t),n=t.parentNode,i=getComputedStyle(n),r=t.style.position;t.style.position="relative";var a={top:e.top,marginTop:e.marginTop,marginBottom:e.marginBottom,marginLeft:e.marginLeft,marginRight:e.marginRight,cssFloat:e.cssFloat,display:e.display},s={top:o(e.top),marginBottom:o(e.marginBottom),paddingLeft:o(e.paddingLeft),paddingRight:o(e.paddingRight),borderLeftWidth:o(e.borderLeftWidth),borderRightWidth:o(e.borderRightWidth)};t.style.position=r;var d={position:t.style.position,top:t.style.top,bottom:t.style.bottom,left:t.style.left,right:t.style.right,width:t.style.width,marginTop:t.style.marginTop,marginLeft:t.style.marginLeft,marginRight:t.style.marginRight},c=L(t),l=L(n),f={node:n,css:{position:n.style.position},computed:{position:i.position},numeric:{borderLeftWidth:o(i.borderLeftWidth),borderRightWidth:o(i.borderRightWidth),borderTopWidth:o(i.borderTopWidth),borderBottomWidth:o(i.borderBottomWidth)}},p={node:t,box:{left:c.win.left,right:M.clientWidth-c.win.right},offset:{top:c.win.top-l.win.top-f.numeric.borderTopWidth,left:c.win.left-l.win.left-f.numeric.borderLeftWidth,right:-c.win.right+l.win.right-f.numeric.borderRightWidth},css:d,isCell:"table-cell"==e.display,computed:a,numeric:s,width:c.win.right-c.win.left,height:c.win.bottom-c.win.top,mode:-1,inited:!1,parent:f,limit:{start:c.doc.top-s.top,end:l.doc.top+n.offsetHeight-f.numeric.borderBottomWidth-t.offsetHeight-s.top-s.marginBottom}};return p}function b(t){for(var e=0;t;)e+=t.offsetTop,t=t.offsetParent;return e}function L(t){var n=t.getBoundingClientRect();return{doc:{top:n.top+e.pageYOffset,left:n.left+e.pageXOffset},win:n}}function w(){x=setInterval(function(){!l()&&H()},500)}function R(){clearInterval(x)}function E(){C&&(document[D]?R():w())}function T(){C||(r(),u(),e.addEventListener("scroll",a),e.addEventListener("wheel",s),e.addEventListener("resize",H),e.addEventListener("orientationchange",H),t.addEventListener(I,E),w(),C=!0)}function H(){if(C){h();for(var t=N.length-1;t>=0;t--)N[t]=y(N[t].node);u()}}function B(){e.removeEventListener("scroll",a),e.removeEventListener("wheel",s),e.removeEventListener("resize",H),e.removeEventListener("orientationchange",H),t.removeEventListener(I,E),R(),C=!1}function O(){B(),h()}function k(){for(O();N.length;)N.pop()}function S(t){for(var e=N.length-1;e>=0;e--)if(N[e].node===t)return;var n=y(t);N.push(n),C?f(n):T()}function W(t){for(var e=N.length-1;e>=0;e--)N[e].node===t&&(p(N[e]),N.splice(e,1))}var A,x,N=[],C=!1,M=t.documentElement,F=function(){},D="hidden",I="visibilitychange";void 0!==t.webkitHidden&&(D="webkitHidden",I="webkitvisibilitychange"),e.getComputedStyle||n();for(var G=["","-webkit-","-moz-","-ms-"],Y=document.createElement("div"),P=G.length-1;P>=0;P--){try{Y.style.position=G[P]+"sticky"}catch(U){}""!=Y.style.position&&n()}r(),e.Stickyfill={stickies:N,add:S,remove:W,init:T,rebuild:H,pause:B,stop:O,kill:k}}(document,window),window.jQuery&&!function(t){t.fn.Stickyfill=function(t){return this.each(function(){Stickyfill.add(this)}),this}}(window.jQuery);for(var stickyElements=document.getElementsByClassName("sticky"),i=stickyElements.length-1;i>=0;i--)Stickyfill.add(stickyElements[i]);!function(t){function e(t){return"string"==typeof t?document.getElementById(t):t}t.AddClass=function(t,n){t=e(t),t.classList.contains(n)||t.classList.add(n)},t.RemoveClass=function(t,n){t=e(t),t.classList.contains(n)&&t.classList.remove(n)},t.ClearHTML=function(t){t=e(t),t.innerHTML=""},t.AppendHTML=function(t,n){t=e(t),t.innerHTML=t.innerHTML+n},t.InnerHTML=function(n,i){n=e(n),t.ClearHTML(n),t.AppendHTML(n,i)},t.InputValue=function(t,n){t=e(t),t.value=n}}(this.DomHelper=void 0==this.DomHelper?{}:this.DomHelper),function(t,e){function n(e,n,o){t.AppendHTML(e,i(n,o))}function i(t,e){return"<div class='alert "+e+"'><div class='alert-content'>"+t+"</div></div>"}e.GenerateDangerAlert=function(t,e){n(t,e,"alert-danger")},e.GenerateSuccessAlert=function(t,e){n(t,e,"alert-success")}}(DomHelper,this.AlertFactory=void 0==this.AlertFactory?{}:this.AlertFactory),function(t){function e(t,e,n,i){var o=new XMLHttpRequest;o.onload=function(){o.readyState==XMLHttpRequest.DONE&&i(o.status,o.responseText)},o.open(e,t),o.send(n)}t.INTERNAL_SERVER_ERROR=500,t.UNPROCESSABLE_ENTITY=422,t.OK=200,t.CREATED=201,t.Get=function(t,n){e(t,"GET","",n)},t.Post=function(t,n,i){e(t,"POST",n,i)}}(this.HttpHelper=void 0==this.HttpHelper?{}:this.HttpHelper),function(t){t.Redirect=function(t,e){setTimeout(function(){window.location=t},e)}}(this.UrlHelper=void 0==this.UrlHelper?{}:this.UrlHelper),function(t,e,n,i,o){function r(t,i){var o=JSON.parse(i),r=document.getElementById("notifications");t==n.INTERNAL_SERVER_ERROR?(e.GenerateDangerAlert(r,o.message),window.scrollTo(0,0)):t==n.OK&&alert(i)}o.RenderBatches=function(t){var e=t+"action/admin/manage/batch";n.Get(e,r)}}(DomHelper,AlertFactory,HttpHelper,UrlHelper,this.BatchOperations=void 0==this.BatchOperations?{}:this.BatchOperations),function(t){var e=document.getElementsByTagName("body")[0].getAttribute("data-source");t.RenderBatches(e)}(BatchOperations);
//# sourceMappingURL=batch.js.map
