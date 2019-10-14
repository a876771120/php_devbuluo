aiui.define(['jquery','element','pjax','nprogress','popup'], function($,element,pjax,nprogress,popup){
    var body = $('body'),
    win = $(window),
     ClassName = {
        wrapper:'.aiui-wrapper',
        collapsed:'is-collapsed',
        sideOpen:'is-open',
        menutitle:'aiui-menu-title',
        collapsed_menu_title:'.aiui-wrapper.is-collapsed .aiui-menu-title',
        menu:'.aiui-menu',
        open_menu_title:'.aiui-wrapper .aiui-menu-title',
        aiui_sidebar_inner:'.aiui-sidebar-inner',
        pjax_container:'#pjax-container'
    },
    Admin = {
        /**
         * 自动初始化
         */
        init:function(){
            var that = this;
            //初始化事件
            $('body').on('click','*[aiui-event]',function(e){
                e.stopPropagation();
                var name = $(this).attr('aiui-event');
                that.event[name]  && that.event[name].call(this, e)
                return false;
            })
            //处理跳转事件
            jsJump();
            //进度条事件
            $(document).on('pjax:start', function() { nprogress.start(); });
            $(document).on('pjax:end',   function() { nprogress.done();  });
            //设置body的loading
            window['bodyLoading'] = new aiui.loading($('body')[0]);
        },
        /**
         * 设置事件
         * @param {String} name 名称
         * @param {Function} fn 回调函数
         */
        on:function(name,fn){
            this.event[name] = fn;
        },
        /**
         * 事件管理器
         */
        event:{
            //显示隐藏方法
            showMenu:function(){
                var that = $(this);
                if(that.hasClass('is-active')) return;
                that.addClass('is-active').parent().siblings().find('a').removeClass('is-active');
                $(ClassName.aiui_sidebar_inner+'[data-menu='+that.data('menuid')+']').show().siblings().hide();
            },
            //左侧大小菜单控制
            pushMenu:function(){
                $wrapper = $(ClassName.wrapper);
                if(win.width()<728){
                    //判断当前是否是开启
                    if($wrapper.hasClass(ClassName.sideOpen)){
                        $wrapper.removeClass(ClassName.sideOpen)
                    }else{
                        $wrapper.addClass(ClassName.sideOpen)
                    }
                }else{
                    //判断当前是否是开启
                    if($wrapper.hasClass(ClassName.collapsed)){
                        $wrapper.removeClass(ClassName.collapsed)
                    }else{
                        $wrapper.addClass(ClassName.collapsed)
                    }
                }
            },
        },
    },
    /**
     * 处理ajax跳转逻辑
     */
    jsJump=function(){
        $(document).delegate('.js-jump','click',function(e){
            var that    = $(this),url = that.attr('href') || that.data('url'),
                type    = that.attr('type'),ajaxType=that.data('method'),
            target_form = that.attr("target-form"),
            text        = that.data('text') || '确定要执行该操作吗？',
            title       = that.data('title') || '提示',
            form        = $('form[name=' + target_form + ']');
            if (!form[0]) {//兼容table
                form = $('.'+target_form);
            }
            var form_data   = form.serialize();
            //如果是提交按钮或者普通跳转
            if(type==='submit' || url){
                //如果是pjax
                if(that.hasClass('pjax')){
                    $.pjax({url:url,container: ClassName.pjax_container})
                    return false;
                }else if(that.hasClass('pop')){
                    popup.open({
                        title:title,
                        content:url,
                        type:1,
                        btnAlign:'left',
                        btn:[]
                    })
                    return false;
                }else if(that.hasClass('url_get')){
                    form_data={};
                    ajaxType = 'get';
                }else{
                    //form表单提交
                    // 不存在“.target-form”元素则返回false
                    if(undefined === form.get(0)) return false;
                    // 节点标签名为FORM表单
                    if("FORM" === form.get(0).nodeName){
                        url      = url || form.get(0).action;
                        ajaxType = form.get(0).method || 'post';
                    }else if("INPUT" === form.get(0).nodeName || "SELECT" === form.get(0).nodeName || "TEXTAREA" === form.get(0).nodeName){
                        var table = form.parents('.aiui-table');
                        if(table[0] && form.get(0).type==='checkbox' && form_data==''){//如果是table
                            popup.message('请选择要操作的数据',{
                                icon:'error',
                                duration:'3000',
                            });
                            return false;
                        }
                        //数据处理
                        if(table[0] && form.get(0).type==='checkbox' && form_data){
                            //去重处理
                            var tempData = form.serializeArray(),tempArr=[];
                            form_data = '';
                            $.each(tempData,function(key,v){
                                if($.inArray(v.value,tempArr)<0){
                                    tempArr.push(v.value);
                                    form_data = form_data + (tempArr.length>1?'&':'')+v.name+'='+v.value;
                                }
                            })
                            form_data = encodeURI(form_data)
                            ajaxType = 'post';
                        }
                    }
                }
                //提交信息
                if(that.hasClass('confirm')){
                    //提交前先判断是否提交
                    popup.confirm(text,{
                        icon:'warning',
                    },function(i,pop){
                        $.ajax({
                            url:url,
                            data:form_data,
                            type:ajaxType,
                            dataType:'json',
                            success:function(res){
                                
                            },
                            error:function(error){
                                popup.message('服务器内部错误！',{
                                    icon:'error'
                                })
                            }
                        })
                    },function(index){
                        popup.close(index);
                    })
                }else{
                    //直接提交
                    $.ajax({
                        url:url,
                        dataType:'json',
                        data:form_data,
                        type:ajaxType,
                        success:function(res){
                            if(res.code==1){
                                //返回成功信息
                                var index = that.data('pop-index');
                                if(index){
                                    popup.message(res.msg,{
                                        icon:'success',
                                    },function(){
                                        popup.close(index);  
                                    })
                                }
                            }else{
                                popup.message(res.msg,{
                                    icon:'error',
                                })
                            }
                        },
                        error:function(error){
                            popup.message('服务器内部错误！',{
                                icon:'error'
                            })
                        }
                    })
                }
            }
            return false;//阻止事件进行
        })
    }
    $.pjax.defaults.timeout = 3000;
    Admin.init();//自动初始化
    return Admin;
});