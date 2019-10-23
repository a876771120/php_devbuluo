!function(t,e){"object"==typeof exports&&"undefined"!=typeof module?module.exports=e(require("jquery")):"function"==typeof define&&define.amd?define("popup",["jquery"],e):(t=t||self).popup=e(t.jQuery)}(this,function(b){"use strict";b=b&&b.hasOwnProperty("default")?b.default:b;function a(t,e){var i=new n[t](e);return i.type=t,m.push(i),i}function t(t){function e(){0<n.duration&&(i.timer=setTimeout(function(){i.closed||i.close()},n.duration))}var i=this,o=i.id="popup-"+x++,n=i.config=b.extend(!0,{message:"",type:"info",iconClass:"",customClass:"",duration:3e3,showClose:!1,center:!1,onClose:"",offset:20},t),s=i.template=['<div class="dui-message'+(n.type&&!n.iconClass?" dui-message--"+n.type:""),n.center?" is-center":"",n.showClose?" is-closable":"",'" style="" id="'+o+'">',n.iconClass?'<i class="'+n.iconClass+'"></i>':'<i class="dui-message__icon dui-icon-'+n.type+'"></i>','<p class="dui-message__content">'+n.message+"</p>",n.showClose?'<i class="dui-message__closeBtn dui-icon-close"></i>':"","</div>"].join(""),a=i.dom=b(s),d=i.btn=a.find(".dui-message__closeBtn");a.find(".dui-message__content").html("").append(n.message),b("body").append(a),i.offsetHeight=a.outerHeight(),a.css("display","none"),a.css("z-index",dui.getMaxZIndex()+1),i.transition=dui.transition(a[0],{name:"dui-message-fade",afterLeave:function(t){a.remove()}});var c,r,u,l,f=(c="message",r=i,l=u=0,b.each(m,function(t,e){if(e.type==c){if(l+=e.offsetHeight,e.id==r.id)return 20*(u+1)+l;u++}}),{num:u,top:20*(u+1)+l});0<f.num&&a.css("top",f.top),a.hover(function(){clearTimeout(i.timer)},e),d.on("click",function(t){i.close()}),i.transition.show(),e()}function e(t){function e(){0<n.duration&&(i.timer=setTimeout(function(){i.closed||i.close()},n.duration))}var i=this,o=i.id="popup-"+x++,n=i.config=b.extend(!0,{title:"",position:"top-right",message:"",type:"",iconClass:"",customClass:"",duration:3e3,showClose:!0,center:!1,onClose:"",onClick:"",offset:20},t),s=i.horizontalClass=-1!==n.position.indexOf("right")?"right":"left",a=i.verticalProperty=/^top-/.test(n.position)?"top":"bottom",d="dui-notification__icon dui-icon-"+n.type,c=i.template=['<div class="dui-notification '+s+(n.customClass?" "+n.customClass:"")+'" id="'+o+'">',n.type||n.iconClass?'<i class="'+(n.type?d:n.iconClass)+'"></i>':"",'<div class="dui-notification__group'+(n.type||n.iconClass?" is-with-icon":"")+'">','<h2 class="dui-notification__title">'+n.title+"</h2>",n.message?'<div class="dui-notification__content"><p>'+n.message:"",n.message?"</p></div>":"",n.showClose?'<div class="dui-notification__closeBtn dui-icon-close"></div>':"","</div>","</div>"].join(""),r=i.dom=b(c),u=i.btn=r.find(".dui-notification__closeBtn");b("body").append(r),i.offsetHeight=r.outerHeight(),r.css("display","none"),r.css("z-index",dui.getMaxZIndex()+1),i.transition=dui.transition(r[0],{name:"dui-notification-fade",afterLeave:function(t){r.remove()}});var l,f,p,h=(l=i,p=f=0,b.each(m,function(t,e){if("notify"==e.type&&l.verticalProperty==e.verticalProperty&&l.horizontalClass==e.horizontalClass){if(p+=e.offsetHeight,e.id==l.id)return 20*(f+1)+p;f++}}),{num:f,px:20*(f+1)+p});r.css(a,h.px),r.hover(function(){clearTimeout(i.timer)},function(){0!==n.duration&&e()}),u.on("click",function(t){i.close()}),"function"==typeof n.onClick&&r.on("click",function(t){n.onClick.call(this,t)}),i.transition.show(),0!==n.duration&&e()}function i(t){var o,e,n,a=this,s=(a.id="popup-"+x++,a.config=b.extend(!1,{title:"",content:"",offset:"auto",type:"",htmlAppend:"",done:"",width:"50%",height:"auto",top:"",showFooter:!0,modal:!0,modalClose:!1,customClass:"",showClose:!0,move:!0,moveOut:!1,center:!1,close:"",closed:"",btns:["确定","取消"],btnAngin:"right"},t)),i=a.btns=(o=[],e=b.extend(!0,{},s).btns,n="right"==s.btnAngin?e.reverse():e,b.each(n,function(t,e){var i=['<button type="button" class="dui-button dui-button--'+("right"==s.btnAngin&&t==n.length-1||"right"!=s.btnAngin&&0==t?"primary":"default")+' dui-button--small">',"<span>"+e+"</span>","</button>"].join("");o.push(i)}),o.join("")),d=['<div class="dui-popup'+(s.customClass?" "+s.customClass:"")+'">','<div class="dui-popup__header">','<div class="dui-popup__title">','<span style="display:block">'+s.title+"</span>","</div>",s.showClose?'<button type="button" class="dui-popup__headerbtn"><i class="dui-popup__close dui-icon-close"></i></button>':"","</div>",'<div class="dui-popup__content"></div>',s.showFooter?'<div class="dui-popup__btns"'+("right"!=s.btnAngin?'style=" text-align:'+s.btnAngin+';"':"")+">"+i+"</div>":"","</div>",s.modal?'<div class="dui-modal"></div>':""].join(""),c=b(document),r=b(window),u=a.dom=b(d),l=a.header=u.find(".dui-popup__header"),f=a.content=u.find(".dui-popup__content"),p=a.footer=u.find(".dui-popup__btns"),h=a.closeBtn=l.find(".dui-popup__headerbtn"),m=p.find("button");f.append(s.content),b(u[0]).css("z-index",dui.getMaxZIndex()+2),s.modal&&b(u[1]).css("z-index",dui.getMaxZIndex()+1);var g=a.modalTransition=dui.transition(u[1],{name:"v",duration:200,beforeEnter:function(t){b(t).addClass("dui-modal-enter")},afterEnter:function(t){b(t).removeClass("dui-modal-enter")},beforeLeave:function(t){b(t).addClass("dui-modal-leave")},afterLeave:function(t){b(t).removeClass("dui-modal-leave"),u[0].remove()}});function v(){var t=function(){if("number"==typeof s.width)return s.width;if(-1===s.width.indexOf("%"))return-1!==s.width.indexOf("px")?Number(s.width.split("px")[0]):50*b("body").width()/100;var t=s.width.split("%"),e=Number(t[0]);return b("body").width()*e/100}();b(u[0]).css("width",t);var e=function(){if("number"==typeof s.height)return s.height;if(-1===s.height.indexOf("%"))return-1!==s.height.indexOf("px")?Number(s.height.split("px")[0]):"auto";var t=s.height.split("%"),e=Number(t[0]);return b("body").height()*e/100}();if("auto"!==e){b(u[0]).css("height",e);var i=e-l.outerHeight()-p.outerHeight()-(parseFloat(f.css("padding-top"))+parseFloat(f.css("padding-bottom")));f.css({"max-height":i,"overflow-y":"auto"})}var o=function(){if("string"==typeof s.offset){if("auto"==s.offset)return{top:(b("body").height()-b(u[0]).outerHeight())/2,left:(b("body").width()-b(u[0]).outerWidth())/2};if(-1!==s.offset.indexOf("%")){var t=s.offset[0].split("%"),e=Number(t[0]);return{top:b("body").width()*e/100}}if(-1!==s.offset.indexOf("px")){t=s.offset[0].split("px");return{top:e=Number(t[0])}}}else{if(b.isArray(s.offset))return{top:function(){if("number"==typeof s.offset[0])return s.offset[0];if(-1===s.offset[0].indexOf("%"))return-1!==s.offset[0].indexOf("px")?Number(s.offset[0].split("px")[0]):10*b("body").width()/100;var t=s.offset[0].split("%"),e=Number(t[0]);return b("body").width()*e/100}(),left:function(){if("number"==typeof s.offset[1])return s.offset[1];if(-1===s.offset[1].indexOf("%"))return-1!==s.offset[1].indexOf("px")?Number(s.offset[1].split("px")[0]):10*b("body").width()/100;var t=s.offset[1].split("%"),e=Number(t[1]);return b("body").width()*e/100}()};if("number"==typeof s.offset)return{top:s.offset,left:(b(window).width()-parseFloat(b(u).css("width")))/2}}}();o.top=o.top<0?20:o.top,b(u[0]).css("top",o.top),b(u[0]).css("left",o.left)}a.transition=dui.transition(u[0],{name:"popup-fade",duration:300,beforeEnter:function(){s.modal&&g.show()},beforeLeave:function(){s.modal&&g.hide()},afterLeave:function(){u.remove(),"function"==typeof s.closed&&s.closed.call()}}),b("body").append(u),v(),s.htmlAppend&&"function"==typeof s.htmlAppend&&s.htmlAppend.call(a,s),u.css("display","none"),h.on("click",function(t){a.close()});var y={};s.move&&(l.on("mousedown",function(t){t.preventDefault(),y.moveStart=!0,y.start={left:t.clientX-parseFloat(b(u[0]).css("left")),top:t.clientY-parseFloat(b(u[0]).css("top"))}}),c.on("mousemove",function(t){if(y.moveStart){t.preventDefault();var e=t.clientX-y.start.left,i=t.clientY-y.start.top,o="fixed"===b(u[0]).css("position");if(y.stX=o?0:r.scrollLeft(),y.stY=o?0:r.scrollTop(),!a.config.moveOut){var n=r.width()-b(u[0]).outerWidth()+y.stX,s=r.height()-b(u[0]).outerHeight()+y.stY;e<y.stX&&(e=y.stX),n<e&&(e=n),i<y.stY&&(i=y.stY),s<i&&(i=s)}b(u[0]).css({left:e,top:i})}}).on("mouseup",function(t){delete y.moveStart})),m.each(function(e,t){b(t).on("click",function(t){"right"==s.btnAngin?"function"==typeof s["btn"+(s.btns.length-1-e)]&&s["btn"+(s.btns.length-1-e)].call(this,t):"function"==typeof s["btn"+e]&&s["btn"+(s.btns.length-e)].call(this,t)})}),b(window).on("resize",function(t){v()}),s.modal&&s.modalClose&&b(u[1]).on("click",function(t){a.close()}),s.done&&"function"==typeof s.done?s.done.call(a,s)&&a.transition.show():a.transition.show()}function o(t){var e=this,i=(e.id="popup-"+x++,e.config=b.extend(!0,{target:"",fullscreen:!0,lock:!1,text:"",spinner:"",background:"",customClass:""},t)),o=['<div class="dui-loading-mask" '+(i.background?' style="background-color:'+i.background+'"':"")+">",'<div class="dui-loading-spinner">',i.spinner?'<i class="'+i.spinner+'"></i>':'<svg viewBox="25 25 50 50" class="circular"><circle cx="50" cy="50" r="20" fill="none" class="path"></circle></svg>',i.text?'<p class="dui-loading-text">'+i.text+"</p>":"","</div>","</div>"].join("");if(i.target){var n=e.target=b(i.target),s=e.showDom=b(o);s.css("display","none");e.transition=dui.transition(s[0],{name:"dui-loading-fade",afterLeave:function(t){n.removeClass("dui-loading-parent--relative"),n.removeClass("dui-laoding-parent--hidden"),s.remove()}})}}var x=1,m=[],n={message:t,notify:e,dialog:i,loading:o};return t.prototype.close=function(){var i=this;b.each(m,function(t,e){e&&e.id==i.id&&m.splice(t,1)}),function(){var n=[],s=0;b.each(m,function(t,e){"message"==e.type&&n.push(e)}),b.each(n,function(t,e){var i=e.dom,o=e.offsetHeight;1<n.length?(i.css("top",20*(t+1)+s),s+=o):i.css("top","")})}(),this.transition.hide(),"function"==typeof i.config.onClose&&i.config.onClose.call()},e.prototype.close=function(){var i=this;b.each(m,function(t,e){e&&e.id==i.id&&m.splice(t,1)}),function(i,n){var o=[],s=0;b.each(m,function(t,e){"notify"==e.type&&i==e.horizontalClass&&n==e.verticalProperty&&o.push(e)}),b.each(o,function(t,e){var i=e.dom,o=e.offsetHeight;i.css(n,20*(t+1)+s),s+=o})}(i.horizontalClass,i.verticalProperty),this.transition.hide(),"function"==typeof i.config.onClose&&i.config.onClose.call()},i.prototype.close=function(){var i=this;b.each(m,function(t,e){e&&e.id==i.id&&m.splice(t,1)}),this.transition.hide(),"function"==typeof i.config.close&&i.config.close.call()},o.prototype.show=function(){var t=this,e=t.config;t.target.addClass("dui-loading-parent--relative"),e.lock&&t.target.addClass("dui-laoding-parent--hidden"),t.target.append(t.showDom),t.transition.show()},o.prototype.close=function(){var i=this;b.each(m,function(t,e){e&&e.id==i.id&&m.splice(t,1)}),i.transition.hide()},a.loading=function(t){return t=b.extend(!0,{},t),a("loading",t)},a.message=function(t,e){return e=b.extend(!0,e,{message:t}),a("message",e)},a.notify=function(t,e){return e=b.extend(!0,e,{title:t}),a("notify",e)},a.dialog=function(t){return a("dialog",t)},a.messageBox=function(t){var e=t.type,i=[e?'<div class="dui-popup__status dui-icon-'+e+'"></div>':"",'<div class="dui-popup__message"><p>'+t.message+"</p></div>"].join("");return t=b.extend(!0,t,{width:"420px",content:i}),a("dialog",t)},a.confirm=function(t,e){var i={title:(e=e||{}).title||"信息",type:"question",message:t};return b.each(arguments,function(t,e){1<t&&(i["btn"+(t-2)]=e)}),e=b.extend(!0,e,i),a.messageBox(e)},a.alert=function(t,e){var i=(e=e||{}).title||"信息",o=arguments[2],n={title:i,type:"info",message:t,btns:["确定"],btn0:function(t){s.close(),o&&"function"==typeof o&&o.call(this,t)}};e=b.extend(!0,e,n);var s=a.messageBox(e);return s},a.close=function(t){},a.closeAll=function(){},a});