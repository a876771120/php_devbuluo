dui.define('apiform',['jquery','form','popup','element'],function($,form,popup,element){
    var thisPopup,
    SELECTOR={

    },
    ApiForm = {
        render:function(el){
            form.render(el);
            // 初始化tabs
            element.render('tabs');
            // 初始化field表格
            initFieldsTable();
            // 拦截提交事件
            $('[jump-form="api_index_add"]').on('click',function(e){
                e.stopPropagation();
                submit.call(this,e);
            })
            // 拦截提交事件
            $('[jump-form="api_index_edit"]').on('click',function(e){
                e.stopPropagation();
                submit.call(this,e);
            })
            var submit = function(e){
                e.stopPropagation();
                var othis = $(this),form = $('form[name="api_index_add"]');
                var formdata = form.serializeArray();
                var ajaxData = {};
                $.each(formdata,function(i,item){
                    ajaxData[item.name] = item.value;
                })
                // 如果名称为空
                if(ajaxData.name=='' || ajaxData.name==undefined){
                    popup.message('接口名称不能为空',{type:'error'})
                    $('input[name="name"]').focus();
                    return;
                }
                // 如果名称为空
                if(ajaxData.api_class=='' || ajaxData.api_class==undefined){
                    popup.message('接口访问真实类不能为空',{type:'error'})
                    $('input[name="api_class"]').focus();
                    return;
                }
                // 如果名称为空
                if(ajaxData.api_class=='' || ajaxData.api_class==undefined){
                    popup.message('接口访问真实类不能为空',{type:'error'})
                    $('input[name="name"]').focus();
                    return;
                }
                // 判断是那种请求方式
                if(ajaxData.request_type=='form'){
                    // 删除自定义数据类型
                    // 组装请求参数
                    var tbody = $('.request-form').find('tbody');
                    tr = tbody.find('tr');
                    var list = [];
                    tr.each(function(i,item){
                        var temp = {},
                        otr = $(item);
                        temp.name = otr.find('.field_name').val();
                        temp.type = otr.find('.field_type').val();
                        temp.require = otr.find('.field_require').is(':checked');
                        temp.default = otr.find('.field_default').val();
                        temp.remark = otr.find('.field_remark').val();
                        temp.example = otr.find('.field_example').val();
                        temp.options = otr.find('.field_options').val()||'';
                        list.push(temp);
                    })
                    if(list.length==0){
                        ajaxData.request = undefined;
                    }else{
                        ajaxData.request =JSON.stringify(list);
                    }
                    delete ajaxData['custom_type'];
                }else{
                    ajaxData.request = ajaxData['request_custom_rule'];
                }
                ajaxData.response = function(){
                    // 组装请求参数
                    var tbody = $('.response-form').find('tbody');
                    tr = tbody.find('tr');
                    var list = [];
                    tr.each(function(i,item){
                        var temp = {},
                        otr = $(item);
                        temp.name = otr.find('.field_name').val();
                        temp.type = otr.find('.field_type').val();
                        temp.require = otr.find('.field_require').is(':checked');
                        temp.default = otr.find('.field_default').val();
                        temp.remark = otr.find('.field_remark').val();
                        temp.example = otr.find('.field_example').val();
                        temp.options = otr.find('.field_options').val()||'';
                        list.push(temp);
                    })
                    if(list.length==0){
                        return undefined;
                    }else{
                        return JSON.stringify(list);
                    }
                }();
                // 删除多余
                delete ajaxData['request_custom_rule'];
                $.ajax({
                    url:form.attr('action'),
                    type:"post",
                    dataType:"json",
                    data:ajaxData,
                    success:function(res){
                        if(res.code==1){
                            popup.message(res.msg,{
                                type:'success',
                                onClose:function(){
                                    var currUrl = (res.url ? res.url: window.location.href);
                                    $.pjax({url:currUrl,container: '#pjax-container'})
                                    // $.pjax.reload('#pjax-container')
                                }
                            });
                        }else{
                            popup.message(res.msg,{type:'error'})
                        }
                    },
                    error(error){
                        var res = '';
                        try {
                            res = error.responseJSON.message;
                        } catch (error) {
                            res = '网络请求失败';
                        }
                        popup.message(res,{type:'error'})
                    }
                })


            }
            // 初始化样式
            $('textarea').trigger('input');
        }
    };
    function initFieldsTable(){
        var doing = false;
        // 提交参数类型变化事件
        $('[name="request_type"]').on('change',function(){
            var othis = $(this),value = othis.val(),
            panel = othis.parents('.dui-tabs__panel');
            if(value=='custom'){
                panel.find('.request-custom').show().prev().hide();
            }else{
                panel.find('.request-form').show().next().hide();
            }

        })
        $(document).on('dblclick','.json-edit',function(){
            var othis = $(this),json = othis.val();
            var obj;
            try {
                if(typeof json == 'object'){
                    obj = [json];
                }else{
                    if (json == ""){
                        json = "\"\"";
                    }
                    obj = eval("[" + json + "]");
                }
            } catch (e) {
                othis.parents('.josn-edit-panel').next().find('pre').html(e.message);
                return;
            }
            othis.val(JSON.stringify(obj[0],'\t',4));
        })
        // json格式化工具
        $(document).on('input','.json-edit',function(e){
            var othis = $(this);
            var options = {
                dom: othis.parents('.josn-edit-panel').next().find('pre'),
                isCollapsible: true,
                quoteKeys: true,
                tabSize: 2,
                imgCollapsed: "/static/admin/images/Collapsed.png",
                imgExpanded: "/static/admin/images/Expanded.png"
            };
            jf = new JsonFormater(options);
            jf.doFormat(othis.val());
        })
        // 输入框添加字段
        $('.dui-table-fields').find('.appendRow').each(function(i,addrow){
            // 设置输入框事件
            $(addrow).on('compositionstart',function(e){
                doing=true;
            })
            $(addrow).on('input',function(e){
                if(!doing){
                    this.value !='' && addFieldsRow.call(this,e)
                }
            })
            $(addrow).on('compositionend',function(e){
                doing=false;
                this.value !='' && addFieldsRow.call(this,e)
            })
        })
        // 往前插入
        $('.dui-table-fields').on('click','.prependRow',function(e){
            var othis = $(this),parent = othis.parents('tr');
            addFieldsRow.call(this,e,parent)
        })
        // 删除当前行
        $('.dui-table-fields').on('click','.deleteRow',function(e){
            var othis = $(this),tr = othis.parents('tr');
            tr.remove();
        })
        // 添加子字段操作
        $('.dui-table-fields').on('click','.addChildField',function(e){
            var othis = $(this),tr = othis.parents('tr'),
            level = tr.attr('dui-level'),
            template = `<span class="dui-table__expand-icon dui-table__expand-icon--expanded">
                    <i class=" dui-icon-arrow-right"></i>
                </span>`;
            tr.find('td').eq(1).find('.dui-table__row--level_'+level).html(template);
            tr.find('td').eq(1).find('.dui-input').css('padding-left',30);
                addFieldsRow.call(this,e,tr[0])
        })
        // 导入
        $('.import').on('click',function(){
            var btn = $(this),type = btn.parent('');
            var content = $(`<div class="dui-textarea">
                    <textarea rows="5" placeholder="请输入正确的json数据" class="dui-textarea__inner"></textarea>
            </div>`);
            // 弹出输入框
            var thisPop = popup.dialog({
                title:'导入JSON',
                content:content,
                width:($(window).width()<=768 ? '90%' : 700),
                modalClose:true,
                btn0:function(e){
                    var value = content.find('textarea').val(),
                    table = btn.next();
                    var res = improtData(table,value);
                    if(res===true){
                        thisPop.close();
                    }
                },
                btn1:function(e){
                    thisPop.close();
                }
            })
        })
    }
    /**
     * 给table插入字段信息
     * @param {HTMLTableElement} table 要插入数据的表格元素
     * @param {Object} json json对象
     */
    function improtData(table,json){
        var obj;
        try {
            if(typeof json == 'object'){
                obj = [json];
            }else{
                if (json == ""){
                    json = "\"\"";
                }
                obj = eval("["+json+"]");
            }
            var res = formatRow(obj[0],''),
            // 表头
            thead = $(table).find('thead'),
            // 表格内容
            tbody = $(table).find('tbody'),
            // 头部的字段是否是必填
            checked= thead.find('.requiredAll').is(":checked");
            // 把tbody置空
            $(table).find('tbody').html('');
            // 循环添加
            $.each(res,function(i,row){
                // 模板
                var $trDom = $([`<tr>
                <td>
                    <div class="cell">
                        <div class="dui-input dui-input--mini">
                            <input type="text" class="dui-input__inner dui-table__input field_name" id="addRow" placeholder="参数名" value="`+row.field+`">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <select class="field_type" placeholder="请选择类型" dui-select size="mini">
                            <option value="1">String</option>
                            <option value="2">Integer</option>
                            <option value="3">Float</option>
                            <option value="4">Boolean</option>
                            <option value="5">File</option>
                            <option value="6">Enum</option>
                            <option value="7">JSON</option>
                            <option value="8">Object</option>
                            <option value="9">Array</option>
                        </select>
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <input type="checkbox" class="field_require" dui-checkbox value="1" label="必填" checked="checked">
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <div class="dui-input dui-input--mini">
                            <input type="text" class="dui-input__inner dui-table__input field_default" placeholder="默认值">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <div class="dui-input dui-input--mini">
                            <input type="text" class="dui-input__inner dui-table__input field_remark" placeholder="参数说明">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <div class="dui-input dui-input--mini">
                            <input type="text" class="dui-input__inner dui-table__input field_example" placeholder="示例">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="cell">
                        <button class="dui-button dui-button--text moreSetting" type="button">更多设置</button>
                        <button class="dui-button dui-button--text prependRow" type="button">插入</button>
                        <button class="dui-button dui-button--text deleteRow" type="button">删除</button>
                    </div>
                </td>
                </tr>`].join(''));
                // 添加行
                tbody.append($trDom);
                // 设置默认值
                $trDom.find('.field_type').val(row.type);
                // 是否选中
                $trDom.find('.field_require').prop('checked',checked);
                // 设置示例值
                $trDom.find('.field_example').val(row.example);
                // 渲染当前行
                form.render($trDom);
            })
            return true;
        } catch (e) {
            popup.message("JSON数据格式不正确:\n" + e.message,{
                type:'error'
            })
            return false;
        }
    }
    /**
     * 把json对象格式化为字段对应属性
     * @param {Object} json json对象
     * @param {String}} prefix 拼接前缀
     */
    function formatRow(json,prefix){
        var res = [];
        $.each(json,function(key,value){
            var temp = {};
            temp.field = prefix+key;
            if($.isArray(value)){
                value = value[0];
                temp.type = '9';
                temp.field = prefix+key;
                res.push(temp);
                res = res.concat(formatRow(value,prefix+key+'[]{}'))
            }else if($.isPlainObject(value)){
                temp.type = '8';
                temp.field = prefix+key;
                res.push(temp);
                res = res.concat(formatRow(value,prefix+key+'{}'))
            }else if(typeof value==="number"){
                if(value%1 ===0){
                    temp.type = '2';
                }else{
                    temp.type = '3';
                }
                temp.example = value;
                res.push(temp);
            }else if(typeof value==="boolean"){
                temp.type = '4';
                temp.example = value;
                res.push(temp);
            }else{
                temp.type = '1';
                if(parseInt(value)+''===value){
                    temp.type = '2';
                }else if(parseFloat(value)+''===value){
                    temp.type = '3';
                }else{
                    try {
                        var obj = eval("["+value+"]");
                        console.log(obj);
                    } catch (e) {
                        
                    }
                }
                temp.example = value;
                res.push(temp);
            }
        })
        return res;
    }
    function addFieldsRow(e,parent){
        var othis = $(this),table =othis.parents('.dui-table').find('tbody'),
        thead = othis.parents('.dui-table').find('thead'),
        tfoot = othis.parents('.dui-table').find('tfoot'),
        tr = othis.parents('tr'),
        template = [`<tr>
        <td>
            <div class="cell">
                <div class="dui-input dui-input--mini">
                    <input type="text" class="dui-input__inner dui-table__input field_name" id="addRow" placeholder="参数名">
                </div>
            </div>
        </td>
        <td>
            <div class="cell">
                <select class="field_type" placeholder="请选择类型" dui-select size="mini">
                    <option value="1">String</option>
                    <option value="2">Integer</option>
                    <option value="3">Float</option>
                    <option value="4">Boolean</option>
                    <option value="5">File</option>
                    <option value="6">Enum</option>
                    <option value="7">JSON</option>
                    <option value="8">Object</option>
                    <option value="9">Array</option>
                </select>
            </div>
        </td>
        <td>
            <div class="cell">
                <input type="checkbox" class="field_require" dui-checkbox value="1" label="必填" checked="checked">
            </div>
        </td>
        <td>
            <div class="cell">
                <div class="dui-input dui-input--mini">
                    <input type="text" class="dui-input__inner dui-table__input field_default" placeholder="默认值">
                </div>
            </div>
        </td>
        <td>
            <div class="cell">
                <div class="dui-input dui-input--mini">
                    <input type="text" class="dui-input__inner dui-table__input field_remark" placeholder="参数说明">
                </div>
            </div>
        </td>
        <td>
            <div class="cell">
                <div class="dui-input dui-input--mini">
                    <input type="text" class="dui-input__inner dui-table__input field_example" placeholder="示例">
                </div>
            </div>
        </td>
        <td>
            <div class="cell">
                <button class="dui-button dui-button--text moreSetting" type="button">更多设置</button>
                <button class="dui-button dui-button--text prependRow" type="button">插入</button>
                <button class="dui-button dui-button--text deleteRow" type="button">删除</button>
            </div>
        </td>
        </tr>`].join(''),
        $trDom = $(template);
        if(tr.parents('tfoot')[0]){
            console.log(table);
            table.append($trDom);
        }else{
            tr.before($trDom);
        }
        // 头部的字段是否是必填
        var checked= thead.find('.requiredAll').is(":checked");
        $trDom.find('.field_require').prop('checked',checked);
        // 渲染
        form.render($trDom[0])
        // 如果是文本框触发添加行事件
        if(othis.is('input')){
            // 设置默认信息
            $trDom.find('.field_name').val(othis.val());
            // 置空
            othis.val('');
        }
        // 焦点
        $trDom.find('.field_name').focus();
    }
    function JsonFormater(opt) {
        this.options = $.extend({
            dom: '',
            tabSize: 2,
            singleTab: "  ",
            quoteKeys: true,
            imgCollapsed: "images/Collapsed.gif",
            imgExpanded: "images/Expanded.gif",
            isCollapsible: true
        }, opt || {});
        this.isFormated = false;
        this.obj = {
            _dateObj: new Date(),
            _regexpObj: new RegExp()
        };
        this.init();
    }
    JsonFormater.prototype = {
        init: function () {
            this.tab = this.multiplyString(this.options.tabSize, this.options.singleTab);
            this.bindEvent();
        },
        doFormat: function (json) {
            var html;
            var obj;
            try {
                if(typeof json == 'object'){
                    obj = [json];
                }else{
                    if (json == ""){
                        json = "\"\"";
                    }
                    obj = eval("[" + json + "]");
                }
                html = this.ProcessObject(obj[0], 0, false, false, false);
                $(this.options.dom).addClass('jf-CodeContainer');
                $(this.options.dom).html(html);
                this.isFormated = true;
            } catch (e) {
                $(this.options.dom).html("JSON数据格式不正确:\n" + e.message);
                this.isFormated = false;
            }
        },
        bindEvent: function () {
            var that = this;
            $(this.options.dom).off('click','.imgToggle');
            $(this.options.dom).on('click', '.imgToggle', function () {
                if (that.isFormated == false) {
                    return;
                }
                that.makeContentVisible($(this).parent().next(), !$(this).data('status'));
            });
        },
        expandAll: function () {
            if (this.isFormated == false) {
                return;
            }
            var that = this;
            this.traverseChildren($(this.options.dom), function(element){
                if(element.hasClass('jf-collapsible')){
                    that.makeContentVisible(element, true);
                }
            }, 0);
        },
        collapseAll: function () {
            if (this.isFormated == false) {
                return;
            }
            var that = this;
            this.traverseChildren($(this.options.dom), function(element){
                if(element.hasClass('jf-collapsible')){
                    that.makeContentVisible(element, false);
                }
            }, 0);
        },
        collapseLevel: function(level){
            if (this.isFormated == false) {
                return;
            }
            var that = this;
            this.traverseChildren($(this.options.dom), function(element, depth){
                if(element.hasClass('jf-collapsible')){
                    if(depth >= level){
                        that.makeContentVisible(element, false);
                    }else{
                        that.makeContentVisible(element, true);
                    }
                }
            }, 0);
    
        },
        isArray: function (obj) {
            return  obj &&
                typeof obj === 'object' &&
                typeof obj.length === 'number' && !(obj.propertyIsEnumerable('length'));
        },
        getRow: function (indent, data, isPropertyContent) {
            var tabs = "";
            if (!isPropertyContent) {
                tabs = this.multiplyString(indent, this.tab);
            }
            if (data != null && data.length > 0 && data.charAt(data.length - 1) != "\n") {
                data = data + "\n";
            }
            return tabs + data;
        },
        formatLiteral: function (literal, quote, comma, indent, isArray, style) {
            if (typeof literal == 'string') {
                literal = literal.split("<").join("&lt;").split(">").join("&gt;");
            }
            var str = "<span class='jf-" + style + "'>" + quote + literal + quote + comma + "</span>";
            if (isArray) str = this.getRow(indent, str);
            return str;
        },
        formatFunction: function (indent, obj) {
            var tabs;
            var i;
            var funcStrArray = obj.toString().split("\n");
            var str = "";
            tabs = this.multiplyString(indent, this.tab);
            for (i = 0; i < funcStrArray.length; i++) {
                str += ((i == 0) ? "" : tabs) + funcStrArray[i] + "\n";
            }
            return str;
        },
        multiplyString: function (num, str) {
            var result = '';
            for (var i = 0; i < num; i++) {
                result += str;
            }
            return result;
        },
        traverseChildren: function (element, func, depth) {
            var length = element.children().length;
            for (var i = 0; i < length; i++) {
                this.traverseChildren(element.children().eq(i), func, depth + 1);
            }
            func(element, depth);
        },
        makeContentVisible : function(element, visible){
            var img = element.prev().find('img');
            if(visible){
                element.show();
                img.attr('src', this.options.imgExpanded);
                img.data('status', 1);
            }else{
                element.hide();
                img.attr('src', this.options.imgCollapsed);
                img.data('status', 0);
            }
        },
        ProcessObject: function (obj, indent, addComma, isArray, isPropertyContent) {
            var html = "";
            var comma = (addComma) ? "<span class='jf-Comma'>,</span> " : "";
            var type = typeof obj;
            var clpsHtml = "";
            var prop;
            if (this.isArray(obj)) {
                if (obj.length == 0) {
                    html += this.getRow(indent, "<span class='jf-ArrayBrace'>[ ]</span>" + comma, isPropertyContent);
                } else {
                    clpsHtml = this.options.isCollapsible ? "<span><img class='imgToggle' data-status='1' src='" + this.options.imgExpanded + "'/></span><span class='jf-collapsible'>" : "";
                    html += this.getRow(indent, "<span class='jf-ArrayBrace'>[</span>" + clpsHtml, isPropertyContent);
                    for (var i = 0; i < obj.length; i++) {
                        html += this.ProcessObject(obj[i], indent + 1, i < (obj.length - 1), true, false);
                    }
                    clpsHtml = this.options.isCollapsible ? "</span>" : "";
                    html += this.getRow(indent, clpsHtml + "<span class='jf-ArrayBrace'>]</span>" + comma);
                }
            } else if (type == 'object') {
                if (obj == null) {
                    html += this.formatLiteral("null", "", comma, indent, isArray, "Null");
                } else {
                    var numProps = 0;
                    for (prop in obj) numProps++;
                    if (numProps == 0) {
                        html += this.getRow(indent, "<span class='jf-ObjectBrace'>{ }</span>" + comma, isPropertyContent);
                    } else {
                        clpsHtml = this.options.isCollapsible ? "<span><img class='imgToggle' data-status='1' src='" + this.options.imgExpanded + "'/></span><span class='jf-collapsible'>" : "";
                        html += this.getRow(indent, "<span class='jf-ObjectBrace'>{</span>" + clpsHtml, isPropertyContent);
                        var j = 0;
                        for (prop in obj) {
                            var quote = this.options.quoteKeys ? "\"" : "";
                            html += this.getRow(indent + 1, "<span class='jf-PropertyName'>" + quote + prop + quote + "</span>: " + this.ProcessObject(obj[prop], indent + 1, ++j < numProps, false, true));
                        }
                        clpsHtml = this.options.isCollapsible ? "</span>" : "";
                        html += this.getRow(indent, clpsHtml + "<span class='jf-ObjectBrace'>}</span>" + comma);
                    }
                }
            } else if (type == 'number') {
                html += this.formatLiteral(obj, "", comma, indent, isArray, "Number");
            } else if (type == 'boolean') {
                html += this.formatLiteral(obj, "", comma, indent, isArray, "Boolean");
            }else if (type == 'undefined') {
                html += this.formatLiteral("undefined", "", comma, indent, isArray, "Null");
            } else {
                html += this.formatLiteral(obj.toString().split("\\").join("\\\\").split('"').join('\\"'), "\"", comma, indent, isArray, "String");
            }
            return html;
        }
    };    
    return ApiForm;
})