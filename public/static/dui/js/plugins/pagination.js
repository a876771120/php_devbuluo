!function(e,n){"object"==typeof exports&&"undefined"!=typeof module?module.exports=n(require("jquery"),require("form")):"function"==typeof define&&define.amd?define("pagination",["jquery","form"],n):(e=e||self).pagination=n(e.jQuery,e.form)}(this,function(a,i){"use strict";a=a&&a.hasOwnProperty("default")?a.default:a,i=i&&i.hasOwnProperty("default")?i.default:i;var t={v:"1.0.0",render:function(e){return new n(e).index},index:0},r={class:"",el:"",total:"",size:10,sizes:[10,20,30,40,50],current:1,pagerNum:5,prev:"上一页",next:"下一页",first:1,last:"",layout:"total, sizes, prev, pager, next, jumper",jump:"",background:!1},n=function(e){var n=this;n.config=a.extend({},r,e),n.index=++t.index,r.current=n.config.current,n.render()};return n.prototype.render=function(){var e=this,n=e.config,t=e.view();e.parent=a(n.el)[0]?a(n.el):dui.error("没有获取到dom"),e.dom=a(t),e.parent.html(e.dom),i.render(e.dom[0]),e.setEvent()},n.prototype.view=function(){var t,u=this.config,i={},l=u.pagerNum="pagerNum"in u?0|u.pagerNum:5;u.Allpage=Math.ceil(parseInt(u.total)/parseInt(u.size)),i.total='<span class="dui-pagination__total">共 '+u.total+" 条</span>",i.sizes=['<span class="dui-pagination__sizes">',(t='<select dui-select size="mini">',a.each(u.sizes,function(e,n){t+='<option value="'+n+'" '+(n==u.size?'selected="selected"':"")+">"+n+"条/页</option>"}),t+"</select>"),"</span>"].join(""),i.prev='<button type="button" class="btn-prev"'+function(){if(1==u.current)return'disabled="disabled"'}()+">"+u.prev+"</button>",i.pager=['<ul class="dui-pager">',function(){var e=[];if(u.total<1)return"";l<0?l=1:l>u.Allpage&&(l=u.Allpage);var n=u.Allpage>l?Math.ceil((u.current+(1<l?1:0))/(0<l?l:1)):1;1<n&&0<l&&e.push('<li class="number" data-page="1">'+u.first+"</li>");var t,i=Math.floor((l-1)/2),r=1<n?u.current-i:1,a=1<n?(t=u.current+(l-i-1))>u.Allpage?u.Allpage:t:l;for(a-r<l-1&&(r=a-l+1),!1!==u.first&&2<r&&e.push('<li class="number left-more">…</li>');r<=a;r++)u.current==r?e.push('<li class="number active">'+r+"</li>"):e.push('<li class="number" data-page="'+r+'">'+r+"</li>");return u.Allpage>l&&u.Allpage>a&&!1!==u.last&&(a+1<u.Allpage&&e.push('<li class="number right-more">…</li>'),0!==l&&e.push('<li class="number" data-page="'+u.Allpage+'">'+(u.last?u.last:u.Allpage)+"</li>")),e.join("")}(),"</ul>"].join(""),i.next='<button type="button" class="btn-next"'+function(){if(u.current==u.Allpage)return'disabled="disabled"'}()+">"+u.next+"</button>",i.jumper=['<span class="dui-pagination__jump">前往<div class="dui-input dui-pagination__editor is-in-pagination">','<input type="number" class="dui-input__inner" name="pager-jump" value="'+u.current+'">',"</div>页</span>"].join("");var r='<div class="dui-pagination'+(u.small?" dui-pagination__small":"")+(u.background?" is-background":"")+'">';return a.each(u.layout.split(","),function(e,n){r+=i[n.trim()]}),r+"</div>"},n.prototype.setEvent=function(){var i=this,n=i.config;i.dom.on("click",".dui-pager .number",function(e){var n=a(this),t=n.data("page");if(n.hasClass("active"))return!1;i.jump(t)}),i.dom.on("click",".btn-prev",function(e){i.jump(n.current-1)}),i.dom.on("click",".btn-next",function(e){i.jump(n.current+1)}),i.dom.on("change",".dui-pagination__sizes select[dui-select]",function(e){var n=a(this).val();i.jump(null,n)}),i.dom.on("keydown",'input[name="pager-jump"]',function(e){var n=(e=e||window.event).keyCode||e.which||e.charCode,t=a(this).val();13==n&&i.jump(t)})},n.prototype.jump=function(e,n){var t=this,i=t.config;if(e=parseInt(e||i.current),n=parseInt(n||i.size),e-1<0)return!1;i.size=n,i.current=e,t.render(),e>i.Allpage&&(i.current=i.Allpage,t.render()),i.current<=1&&t.dom.find(".btn-prev").attr("disabled","disabled"),i.current>=i.Allpage&&t.dom.find(".btn-next").attr("disabled","disabled"),i.jump&&"function"==typeof i.jump&&i.jump.call(this,{page:i.current,size:i.size})},t});