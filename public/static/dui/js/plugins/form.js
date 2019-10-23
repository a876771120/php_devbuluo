!function(e,i){"object"==typeof exports&&"undefined"!=typeof module?module.exports=i(require("jquery")):"function"==typeof define&&define.amd?define("form",["jquery"],i):(e=e||self).form=i(e.jQuery)}(this,function(y){"use strict";y=y&&y.hasOwnProperty("default")?y.default:y;function o(e,i,t){return new o.Item[i](e,t)}function e(a,e){var o=this,i={name:String,disabled:{type:[Boolean,String],default:!1},label:String,value:String,bordered:Boolean,indeterminate:Boolean,buttoned:Boolean,checked:{type:[Boolean,String],default:!1},state:{type:[Boolean,String],default:!1},items:String};dui.setData(a,"checkbox",{},e),dui.setProps(a,"checkbox",i),o.el=a;var l=o.config=y.extend(!0,{},a.vnode.props.checkbox),t=o.template=['<div class="dui-checkbox'+(l.buttoned?"-button":"")+(l.checked?" is-checked":"")+(l.disabled?" is-disabled":"")+(l.bordered?" is-bordered":"")+'">',l.buttoned?"":'<span class="dui-checkbox__input'+(l.checked?" is-checked":"")+(l.disabled?" is-disabled":"")+'">','<span class="dui-checkbox'+(l.buttoned?"-button":"")+'__inner">'+(l.buttoned?l.label:"")+"</span>",l.buttoned?"":"</span>",l.buttoned?"":l.label?'<span class="dui-checkbox__label">'+l.label+"</span>":"","</div>"].join(""),c=o.$showDom=y(t),n=(y(a).parents(p.form),p.checkbox,l.items,"."+S.checkbox+(l.buttoned?"-button":"")+"__inner"),s=y(a).prev(n);l.indeterminate&&y(a).removeAttr("name"),s[0]&&s.parents("."+S.checkbox).after(a)&&s.parents("."+S.checkbox).remove(),y(a).after(c)&&c.find(n).after(a),a.checked=!(!l.checked||!0===l.indeterminate),l.disabled||dui.on(c[0],"click",function(e){var i=c,t=y(a),n=t.prop("checked");l.indeterminate&&(n=!i.find("."+S.checkboxInput).hasClass("is-indeterminate")&&!!i.hasClass("is-checked")),o.setChecked(!n),t[0]&&t.change&&t.change(),a.vnode.event.checkbox&&a.vnode.event.checkbox.change&&a.vnode.event.checkbox.change.call(a,t.prop("checked"))})}function i(e,i){var n=this,t=n.elements={},a={name:String,multiple:{type:[Boolean,String],default:!1},disabled:{type:[Boolean,String],default:!1},size:String,clearable:Boolean,placeholder:String,filterable:Boolean,original:Boolean};function o(){t.clickDom.removeClass("is-focuse"),g.removeClass("is-reverse"),n.isShow=!1,n.transition.hide()}n.state={inited:!1},dui.setData(e,"checkbox",i),dui.setProps(e,"checkbox",a);var l,c=n.config=y.extend(!0,{},e.vnode.props.checkbox),s=y(e).next("."+S.select),d=n.value=c.multiple?[]:"",r=n.optData=function n(e){var a=[];return y(e).children().each(function(e,i){var t={};"optgroup"===i.tagName.toLowerCase()?(t.label=y(i).attr("label"),t.type="group",0<i.children.length&&(t.childrens=n(i))):"option"===i.tagName.toLowerCase()&&(t.type="item",t.label=y(i).text(),t.value=y(i).val(),t.selected=void 0!==y(i).attr("selected"),t.disabled=void 0!==y(i).attr("disabled")),a.push(t)}),a}(e),u=n.tags=(l={},y(e).find("option").each(function(e,i){var t=y(i).text(),n=y(i).val(),a=y('<span class="dui-tag dui-tag--info dui-tag--small dui-tag--light"><span class="dui-select__tags-text">'+t+'</span><i class="dui-tag__close dui-icon-close"></i></span>')[0];a.value=n,l[n]=a}),l),p=n.optHtml=['<div class="dui-select-dropdown dui-popper'+(c.multiple?" is-multiple":"")+'" style="display:none">','<ul class="dui-select-dropdown__list">'+function t(e){var n="";return y.each(e,function(e,i){"group"==i.type?n+='<ul class="dui-select-group__wrap"><li class="dui-select-group__title">'+i.label+"</li><li>"+function(){if(i.childrens)return'<ul class="dui-select-group">'+t(i.childrens)+"</ul>"}()+"</li></ul>":"item"==i.type&&(n+='<li class="dui-select-dropdown__item'+(i.disabled?" is-disabled":"")+(i.selected?" selected":"")+'" dui-value="'+i.value+'"><span>'+i.label+"</span></li>")}),n}(r)+"</ul>",'<div x-arrow="" class="popper__arrow"></div>',"</div>"].join(" "),h=['<div class="'+S.select+(c.size?" "+S.select+"--"+c.size:"")+'">',c.multiple?'<div class="dui-select__tags"><span></span></div>':"",'<div class="dui-input'+(c.size?" dui-input--"+c.size:"")+" dui-input--suffix"+(c.disabled?" is-disabled":"")+'">','<input class="dui-input__inner dui-input--suffix"'+(c.filterable?"":' readonly="readonly"')+' placeholder="'+c.placeholder+'"'+(c.disabled?'disabled="disabled"':"")+">",'<span class="dui-input__suffix">','<span class="dui-input__suffix-inner">','<i class="dui-select__caret dui-input__icon dui-icon-arrow-up"></i>',c.clearable?'<i class="dui-select__caret dui-input__icon '+S.selectClearable+'" style="display:none"></i>':"","</span>","</span>","</div>","</div>"].join(""),f=t.original=y(e),v=t.emptyDom=y(['<p class="dui-select-dropdown__empty">无匹配数据</p>'].join("")),b=t.clickDom=y(h),m=(t.input=t.clickDom.find(".dui-input"),t.inputInner=t.clickDom.find(".dui-input__inner")),g=t.caret=t.clickDom.find(".dui-select__caret"),k=t.optDom=y(p),_=t.opts=k.find("."+S.selectOption);n.scrollbar=dui.addScrollBar(k.find(".dui-select-dropdown__list")[0],{wrapClass:"dui-select-dropdown__wrap"}),s[0]&&s.remove(),y(e).css("display","none").after(b),b.append(k),k.css("min-width",m.outerWidth());var w=b[0],x=k[0],C={top:"bottom",bottom:"top"};n.popper=dui.addPopper(w,x,{arrowOffset:35,onCreate:function(e){n.transition=dui.transition(x,{name:"dui-zoom-in-"+C[e._options.placement]})},onUpdate:function(e){n.transition.data.name="dui-zoom-in-"+C[e.placement],k.css("min-width",b.outerWidth())}}),c.multiple?f.find("option[selected]").each(function(e,i){var t=y(i).val();-1==y.inArray(t,d)&&n.value.push(t)}):f.find("option[selected]").each(function(e,i){n.value=y(i).val()}),n.setValue(),c.disabled||(dui.on(b[0],"click",function(e){e.stopPropagation(),n.isShow?o():(y("body").append(x),t.input.addClass("is-focuse"),g.addClass("is-reverse"),k.css("min-width",b.outerWidth()),n.popper.updatePopper(),n.isShow=!0,n.transition.show())}),_.on("click",function(e){var i=y(this),t=i.attr("dui-value");c.multiple?i.hasClass("selected")?n.value.splice(y.inArray(t,d),1):-1==y.inArray(t,d)&&n.value.push(t):(n.value=t,o()),n.setValue()}),y.each(u,function(i,e){dui.on(e.children[1],"click",function(e){e.stopPropagation(),n.value.splice(y.inArray(i,n.value),1),n.setValue()})}),c.clearable&&(b.hover(function(){0<n.value.length&&(b.find(".dui-icon-arrow-up").css("display","none"),b.find("."+S.selectClearable).css("display",""))},function(e){b.find(".dui-icon-arrow-up").css("display",""),b.find("."+S.selectClearable).css("display","none")}),b.find("."+S.selectClearable).on("click",function(e){e.stopPropagation(),d=n.value=c.multiple?[]:"",n.setValue()})),c.filterable&&m.on("input",function(e){var a=this.value,i=e.keyCode;if(9===i||13===i||37===i||38===i||39===i||40===i)return!1;_.each(function(e,i){var t=y(i),n=t.text();t[-1===n.indexOf(a)?"addClass":"removeClass"](S.hide)}),y(k).find(".dui-select-group__wrap").each(function(e,i){var t=y(i);t.find("."+S.selectOption+"."+S.hide).length==t.find("."+S.selectOption).length?t.addClass(S.hide):t.removeClass(S.hide)}),k.find("."+S.selectOption+"."+S.hide).length==_.length?(y(n.scrollbar.scroll).addClass("is-empty"),y(n.scrollbar.scroll).after(v)):(y(n.scrollbar.scroll).removeClass("is-empty"),v.remove())}),dui.on(document,"click",function(e){var i=y(e.target);if(t.optDom.find(i)[0]||t.optDom[0]==i[0])return!1;"none"!=t.optDom.css("display")&&o()}))}var p={form:"[dui-form]",switch:'input[type="checkbox"][dui-switch]',checkbox:'input[type="checkbox"][dui-checkbox]',radio:'input[type="radio"][dui-radio]',select:"select[dui-select]"},S={switch:"dui-switch",switchCore:"dui-switch__core",switchLabelLeft:"dui-switch__label--left",switchLabelRight:"dui-switch__label--right",checkbox:"dui-checkbox",checkboxInput:"dui-checkbox__input",radio:"dui-radio",radioInput:"dui-radio__input",radioGroup:"dui-radio-group",select:"dui-select",selectOption:"dui-select-dropdown__item",selectClearable:"dui-icon-circle-close",hide:"dui-hide"};return o.Item=o.prototype={init:function(n,e,i){(this.el=n).vnode&&delete n.vnode,dui.setData(n,"form",{rule:!1},e);return y(n).off("submit").on("submit",function(e){var i=n.vnode.data.form,t=n.vnode.event.form;return t.submit&&"function"==typeof t.submit&&t.submit.call(n,e),i.rule,!0}),i||o.render(n),this},switch:function(n,e){var a=this,o={name:{type:String,default:""},activeValue:{type:[Boolean,String,Number],default:!0},inactiveValue:{type:[Boolean,String,Number],default:!1},skin:{type:[String],default:"label-out"},value:{type:[Boolean,String,Number],default:!1},disabled:{type:Boolean,default:!1},activeText:String,inactiveText:String,activeColor:String,inactiveColor:String,clearable:{type:Boolean,default:!1},width:{type:Number,default:40}};a.el=n,a.originalValue||(a.originalValue=n.value),dui.setData(n,"switch",{},e),dui.setProps(n,"switch",o);var l=a.config=y.extend(!0,{},n.vnode.props.switch);a.template=['<div class="dui-switch'+(l.activeValue==l.value?" is-checked":"")+" "+l.skin+'">',"label-out"==l.skin&&a.config.inactiveText?'<span class="dui-switch__label dui-switch__label--left'+(l.inactiveValue==l.value?" is-active":"")+'"><span>'+l.inactiveText+"</span></span>":"",'<span class="dui-switch__core" style="width: '+l.width+"px;"+(l.activeValue==l.value?"border-color:"+l.activeColor+";background-color:"+l.activeColor+";":"border-color:"+l.inactiveColor+";background-color:"+l.inactiveColor+";")+'">'+("label-in"==l.skin?"<em>"+(l.activeValue==l.value?l.activeText:l.inactiveText)+"</em>":"")+"</span>","label-out"==l.skin&&a.config.activeText?'<span class="dui-switch__label dui-switch__label--right'+(l.activeValue==l.value?" is-active":"")+'"><span>'+l.activeText+"</span></span>":"","</div>"].join(""),y(n).prop("checked",!0);var c=a.$showDom=y(a.template),i=y(n).next("."+S.switch);return i[0]&&(n.value=a.originalValue)&&i.remove(),y(n).after(c),dui.on(c[0],"click",function(e){if(!l.disabled){var i=y(a.el),t=i.val();dui.convertProp(t,o.value.type)==a.config.activeValue?(i.val(a.config.inactiveValue),c.removeClass("is-checked"),c.find("."+S.switchLabelLeft).addClass("is-active"),c.find("."+S.switchLabelRight).removeClass("is-active"),"label-in"==l.skin&&c.find("."+S.switchCore).find("em").text(l.inactiveText),c.find("."+S.switchCore).css("background",l.inactiveColor),c.find("."+S.switchCore).css("border-color",l.inactiveColor)):(i.val(a.config.activeValue),c.addClass("is-checked"),c.find("."+S.switchLabelLeft).removeClass("is-active"),c.find("."+S.switchLabelRight).addClass("is-active"),"label-in"==l.skin&&c.find("."+S.switchCore).find("em").text(l.activeText),c.find("."+S.switchCore).css("background",l.activeColor),c.find("."+S.switchCore).css("border-color",l.activeColor)),i[0]&&i.change&&i.change(),n.vnode.event.switch&&n.vnode.event.switch.change&&n.vnode.event.switch.change.call(n,i.val())}}),a},checkbox:e,radio:function(t,e){var i=this,n={name:String,value:{type:[Boolean,Number,String],default:""},label:{type:[Boolean,Number,String],default:""},bordered:Boolean,disabled:{type:[Boolean,String],default:!1},buttoned:Boolean,checked:{type:[Boolean,String],default:!1}};dui.setData(t,"checkbox",{},e),dui.setProps(t,"checkbox",n);var a=i.config=y.extend(!0,{},t.vnode.props.checkbox),o=0<y(t).parents("."+S.radioGroup).length?y(t).parents("."+S.radioGroup):y(t).parents(p.form),l=a.buttoned?"is-active":"is-checked",c=1==o.find(p.radio+'[name="'+a.name+'"][checked]').length&&a.checked?" "+l:(y(t).prop("checked",!1),y(t).removeAttr("checked"),""),s=i.template=['<div class="dui-radio'+(a.buttoned?"-button":"")+(a.bordered?" is-bordered":"")+(c?" "+l:"")+(a.disabled?" is-disabled":"")+'">',a.buttoned?"":'<span class="dui-radio__input'+(c?" is-checked":"")+(a.disabled?" is-disabled":"")+'">','<span class="dui-radio'+(a.buttoned?"-button":"")+'__inner">'+(a.buttoned?a.label:"")+"</span>",a.buttoned?"":"</span>",a.buttoned?"":'<span class="dui-radio__label">'+a.label+"</span>","</div>"].join(""),d=i.$showDom=y(s),r="."+S.radio+(a.buttoned?"-button":"")+"__inner",u=y(t).prev(r);u[0]&&u.parents("."+S.radio).after(t)&&u.parents("."+S.radio).remove(),y(t).after(d)&&d.find(r).after(t),d.on("click",function(e){if(!a.disabled){var i=y(t);!1===i.prop("checked")&&(o.find(p.radio+'[name="'+a.name+'"]').prop("checked",!1),i.prop("checked",!0),o.find(p.radio+'[name="'+a.name+'"]').parents("."+S.radio+(a.buttoned?"-button":"")).removeClass(l),"is-checked"==l&&o.find(p.radio+'[name="'+a.name+'"]').parents("."+S.radioInput).removeClass(l),d.addClass(l),"is-checked"==l&&i.parents("."+S.radioInput).addClass(l),i[0]&&i.change&&i.change(),t.vnode.event.radio&&t.vnode.event.radio.change&&t.vnode.event.radio.change.call(t,i.prop("checked")))}})},select:i},o.render=function(e,i,t,n){t=t?'[dui-filter="'+t+'"]':"";var a={switch:function(){y(e).find(p.switch+t).each(function(e,i){i.switchClass=new o.Item.switch(i,n)})},checkbox:function(){y(e).find(p.checkbox).each(function(e,i){i.checkboxClass=new o.Item.checkbox(i,n)})},radio:function(){y(e).find(p.radio).each(function(e,i){i.radioClass=new o.Item.radio(i,n)})},select:function(){y(e).find(p.select).each(function(e,i){i.selectClass=new o.Item.select(i,n)})}};e.vnode&&new o.Item.init(e,{},!0),i?a[i]&&a[i]():y.each(a,function(e,i){i()})},o.init=function(e,t){e=e?'[dui-filter="'+e+'"]':"";var i=y(p.form+e),n=[];return i.each(function(e,i){n.push(new o.Item.init(i,t))}),1<n.length?n:n[0]},i.prototype.setValue=function(e){var t=this,i=t.config,n=t.elements,a=n.optDom.find("."+S.selectOption),o=n.clickDom.find(".dui-select__tags>span");if(e&&(t.value=e),0==t.value.length?(n.inputInner.val(""),n.original.val(null),i.multiple&&n.inputInner.attr("placeholder",i.placeholder)):(n.original.val(t.value),i.multiple&&n.inputInner.attr("placeholder","")),o.html(""),a.removeClass("selected"),i.multiple){y.each(t.value,function(e,i){n.optDom.find("."+S.selectOption+'[dui-value="'+i+'"]').addClass("selected"),o.append(t.tags[i])});var l=parseFloat(o.parent().outerHeight()),c=parseFloat(n.inputInner.outerHeight());c<l||36<c?n.inputInner.css("height",parseFloat(l)+6):n.inputInner.css("height","")}else{var s=n.optDom.find("."+S.selectOption+'[dui-value="'+t.value+'"]');s.addClass("selected"),n.inputInner.val(s.text())}if(t.popper.updatePopper(),t.state.inited){var d=n.original[0].vnode.event;n.original.change&&n.original.change(),d.select&&d.select.change&&"function"==typeof d.select.change&&d.select.change.call(n.original,t.value)}else t.state.inited=!0},e.prototype.setChecked=function(e){var i=this.config,t=this.el,n=y(t),a=n.parents(".dui-checkbox"),o="is-checked";"indeterminate"===e&&i.indeterminate?(n.prop("checked",!1),a.find("."+S.checkboxInput).removeClass("is-checked").addClass("is-indeterminate"),a.removeClass("is-checked"),i.buttoned||a.find("."+S.checkboxInput).removeClass("is-checked")):(!0===e?(i.indeterminate?n.prop("checked",!1):n.prop("checked",!0),a.addClass(o),i.buttoned||a.find("."+S.checkboxInput).addClass(o)):(n.prop("checked",!1),a.removeClass(o),i.buttoned||a.find("."+S.checkboxInput).removeClass(o)),i.indeterminate&&a.find("."+S.checkboxInput).removeClass("is-indeterminate"))},o.init(),o});