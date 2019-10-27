define('admin',['jquery','element','pjax','nprogress','popup'],function($,element,pjax,nprogress,popup){
    var _BODY=$('body'),
    _WIN = $(window),
    moreAppDialog='',
    SELECTOR={
        adminbox:'.dui-admin',
        aside:'.dui-admin__aside',
        header:'.dui-admin__header',
        popper:'.dui-popper',
        menubar:'[dui-menubar]',
        menus:'.dui-menu',
        submenu:'.dui-submenu',
        submenusTitles:'.dui-submenu__title',
        menuItem:'.dui-menu-item',
        moreappContent:'.dui-admin__moreapps-content',
        moreappItem:'.dui-admin__moreapps-item',
        moreappCard:'.dui-card',
        pjax_container:'#pjax-container'
    },
    CLASS={
        open:'is-open',
        shrink:'is-shrink',
        active:'is-active',
    },
    ADMIN = {
        /**
         * 初始化后台js
         */
        render:function(){
            var that = this,bodyLoading;thisPopup=null;
            //初始化事件管理
            $(document).delegate('*[dui-event]','click',function(e){
                var name = $(this).attr('dui-event');
                that.events[name]  && that.events[name].call(this, e)
                return false;
            })
            // 初始化url跳转事件
            $(document).delegate('[jump]','click',function(e){
                var othis       = $(this),
                    url         = othis.attr('href') || othis.attr('jump-url'),     //跳转以及
                    type        = othis.attr('type') || othis.attr('jump'),         //检测是否是提交
                    mode        = othis.attr('jump-mode') || '_pjax',               //跳转方式
                    target      = othis.attr('jump-target'),                        //跳转目标
                    method      = othis.attr('jump-method') || 'get',               //提交方式，post还是get
                    form_name   = othis.attr('jump-form'),                          //提交数据所在的form表单
                    text        = othis.attr('jump-text')||'确定要执行该操作吗？',     //跳转提示信息
                    title       = othis.attr('jump-title')||othis.attr('title')||'提示',//跳转提示标题
                    form        = $('form[name="'+form_name+'"]'),                  //表单
                    formData    = form.serialize()||'',                             //数据
                    goAjax = function(close){
                        if(thisPopup && thisPopup.close){
                            thisPopup.close();
                        }
                        // 提交数据
                        $.ajax({
                            url:url,
                            method:method,
                            data:formData,
                            dataType:'json',
                            success:function(data){
                                if(data.code==1){
                                    popup.message(data.msg,{
                                        type:'success',
                                        onClose:function(){
                                            var currUrl = window.location.href;
                                            $.pjax({url:currUrl,container: SELECTOR.pjax_container})
                                        }
                                    });
                                }else{
                                    popup.message(data.msg,{type:'error'})
                                }
                            },
                            error:function(error){
                                popup.message(error.responseJSON.message,{type:'error'})
                                thisPopup.close();
                            }
                        })
                    };
                // console.log(type,othis);return false;
                // 不管是什么操作必须得有url
                if(url || type=='submit'){
                    if(type=='submit'){// 表单提交
                        if(form.get(0) && "FORM" === form.get(0).nodeName){
                            method = form.attr('method');
                            url = form.attr('action');
                            if(thisPopup && thisPopup.loading && form.parents('.dui-popup')[0]){
                                thisPopup.loading.show();
                            }else{
                                bodyLoading.show();
                            }
                            // 提交数据
                            $.ajax({
                                url:url,
                                method:method,
                                data:formData,
                                dataType:'json',
                                success:function(data){
                                    if(data.code==1){
                                        if(thisPopup && thisPopup.close){
                                            thisPopup.close();
                                        }
                                        popup.message(data.msg,{
                                            type:'success',
                                            onClose:function(){
                                                var currUrl = (data.url ? data.url: window.location.href);
                                                console.log(currUrl);
                                                $.pjax({url:currUrl,container: SELECTOR.pjax_container})
                                                // $.pjax.reload('#pjax-container')
                                            }
                                        });
                                    }else{
                                        popup.message(data.msg,{type:'error'})
                                    }
                                },
                                error:function(error){
                                    try {
                                        res = error.responseJSON.message;
                                    } catch (error) {
                                        res = '网络请求失败';
                                    }
                                    popup.message(res,{type:'error'})
                                },
                                complete:function(){
                                    if(thisPopup && thisPopup.loading && form.parents('.dui-popup')[0]){
                                        thisPopup.loading.close();
                                    }else{
                                        bodyLoading.close();
                                    }
                                }
                            })
                            return false;
                        }else{
                            // 如果是table的多行数据提交
                            if(!formData && $('#'+form_name)[0] && $('#'+form_name)[0].table){
                                var othisTable = $('#'+form_name)[0].table;
                                var pk = $('#'+form_name)[0].pk;
                                var checkData = othisTable.getCheckedData();
                                var ids = [];
                                $.each(checkData,function(i,rowData){
                                    if(rowData[pk]){
                                        ids.push(rowData[pk]);
                                    }else{
                                        ids.push(rowData);
                                    }
                                })
                                formData = {};
                                formData[pk+'s'] = ids;
                                method = 'post';
                                if(ids.length==0){
                                    popup.message('请选择数据后操作',{type:'error'})
                                    return false;
                                }
                            }
                            if(othis.hasClass('confirm')){
                                thisPopup = popup.confirm(text,{
                                    btns:['确定','取消'],
                                    title:title,
                                    modalClose:true
                                },function(){
                                    goAjax();
                                },function(){
                                    // 取消不做任何处理
                                    thisPopup.close();
                                })
                            }else{
                                goAjax();
                            }
                            return false;
                        }
                    }else{//其他链接跳转
                        if(mode=='_pjax'){//pjax方式
                            if(location.pathname==url) return false;
                            $.pjax({url:url,container: SELECTOR.pjax_container});
                        }else if(mode=='_ajax'){
                            if(othis.hasClass('confirm')){
                                thisPopup = popup.confirm(text,{
                                    btns:['确定','取消'],
                                    title:title,
                                    modalClose:true
                                },function(){
                                    goAjax();
                                },function(){
                                    // 取消不做任何处理
                                    thisPopup.close();
                                })
                            }else{
                                goAjax();
                            }
                        }else if(mode=='_pop'){
                            thisPopup = window.thisPopup =  popup.dialog({
                                title:title,
                                content:'',
                                offset:['15%','auto'],
                                move:false,
                                modalClose:true,
                                showFooter:true,
                                // height:$(window).width()<=768?'90%':'70%',
                                width:$(window).width()<=768?'90%':'50%',
                                showFooter:true,
                                onClose:function(){
                                    window.thisPopup = null;
                                },
                                done:function(cfg){
                                    var that = this;
                                    var contentDiv = that.content;
                                    $.ajax({
                                        url:url+'?_pop=1',
                                        method:method,
                                        dataType:'html',
                                        success:function(html){
                                            // 设置内容
                                            contentDiv.html(html);
                                            that.loading = popup.loading({target:contentDiv[0]});
                                            // 设置按钮事件
                                            var enterBtn = that.footer.find('button.dui-button--primary');
                                            var formName = contentDiv.find('form').attr('name');
                                            enterBtn.attr('jump','').attr('type','submit').attr('jump-form',formName);
                                            thisPopup.transition.show();
                                        },
                                        error:function(error){
                                            contentDiv.html(error.responseText||'网络请求错误，未获取到页面');
                                            thisPopup.transition.show();
                                        }
                                    })
                                    return false;
                                },
                                btn1:function(){
                                    thisPopup.close();
                                }
                            })
                            console.log(thisPopup);
                        }
                    }
                }
                return false;
            })
            // 给body 添加一个加载动画
            bodyLoading = popup.loading({target:$('body')[0]})
            // 设置pjax开始监听
            $(document).on('pjax:start', function(e){ 
                nprogress.start();
            });
            // 设置pjax结束监听
            $(document).on('pjax:end',   function() { 
                nprogress.done();
                var menuId = window.duiRoute;
                that.custonEvent.changeUrlHander.call(this,menuId);
                window.currenLocation = null;
            });
            // 窗口大小发生变化事件
            $(window).on('resize',function(e){
                $(SELECTOR.adminbox).removeClass(CLASS.open).removeClass(CLASS.shrink);
            })
        },
        /**
         * 添加事件
         * @param {String} event 事件名称
         * @param {Function} fn 回调函数
         */
        on:function(event,fn){
            this.events[event] = fn;
        },
        /**
         * 事件管理
         */
        events:{
            // 伸缩菜单
            flexible:function(e){
                //如果当前是手机
                var adminbox=$(SELECTOR.adminbox),winWidth = $(window).width();
                // 手机访问
                if(winWidth<=768){
                    // 如果当前是打开则关闭
                    if(adminbox.hasClass(CLASS.open)){
                        adminbox.removeClass(CLASS.open);
                    }else{
                        adminbox.addClass(CLASS.open);
                    }
                }else{
                    if(adminbox.hasClass(CLASS.shrink)){
                        adminbox.removeClass(CLASS.shrink);
                    }else{
                        adminbox.addClass(CLASS.shrink);
                    }
                }
            },
            // 跟多应用
            moreapp:function(e){
                // 获取当前宽度
                var winWidth=$(window).width(),width,content,stance;
                // 手机界面
                if(winWidth<=768){
                    width='90%';
                }else{
                    width=600;
                }
                stance = $('<div class="dui-dialog__stance"></div>');
                content = $(SELECTOR.moreappContent);
                content.after(stance);
                // 打开多应用界面
                moreAppDialog=popup.dialog({
                    title:'更多应用',
                    customClass:'dui-admin__moreapps',
                    modalClose:true,
                    content:content[0],
                    move:false,
                    width:width,
                    height:'auto',
                    showFooter:false,
                    offset:0,
                    closed:function(){
                        stance.after(content);
                        stance.remove();
                    }
                })
            }
        },
        custonEvent:{
            changeUrlHander:function(id){
                // 找到url所属的侧边栏元素
                var currentAsideMenu = $(SELECTOR.aside).find(SELECTOR.menuItem+'[data-id="'+id+'"]');
                // 如果当前元素有class为is-active，则直接返回
                if(currentAsideMenu.hasClass(CLASS.active)) return;
                // 移除当前菜单跳转高亮
                $(SELECTOR.aside).find(SELECTOR.menuItem).removeClass(CLASS.active);
                // 移除当前菜单的子菜单高亮
                $(SELECTOR.aside).find(SELECTOR.submenusTitles).removeClass(CLASS.active);
                // 添加当前选中高亮
                // 当前菜单高亮
                addCurrenMenuHeight(currentAsideMenu);
                // 如果是弹窗进入
                moreAppDialog && moreAppDialog.close && moreAppDialog.close();
                /**
                 * 根据指定菜单高亮其他父节点
                 * @param {Element} el 菜单元素
                 */
                function addCurrenMenuHeight(el){
                    // 当前节点高亮
                    $(el).addClass(CLASS.active);
                    // 找到所有的父节点
                    var submenus = $(el).parents(SELECTOR.menus).prev(SELECTOR.submenusTitles);
                    // 设置高亮
                    submenus.addClass(CLASS.active);
                    // 循环检测父元素是否打开
                    submenus.each(function(i,item){
                        // 如果父元素是没有打开状态,则手动触发
                        if(!$(item).parent().hasClass('is-opened')){
                            console.log('进来了');
                            $(item).trigger("click");
                        }
                    })
                    var id = $(el).parents(SELECTOR.menubar).data('id');
                    // 显示当前应用下的菜单
                    $(el).parents(SELECTOR.menubar).show().siblings(SELECTOR.menubar).hide();
                    // 找到顶部菜单
                    var topMenu = $(SELECTOR.header).find(SELECTOR.menuItem+'[data-id="'+id+'"]');
                    topMenu.addClass(CLASS.active).siblings().removeClass(CLASS.active);
                    // 找到更多应用
                    var currenCard = $(SELECTOR.moreappContent).find(SELECTOR.moreappCard+'[data-id="'+id+'"]');
                    currenCard.addClass(CLASS.active).parents(SELECTOR.moreappItem).siblings().find(SELECTOR.moreappCard).removeClass(CLASS.active);
                }
            }
        }
    }
    // 设置pjax请求超时时间
    $.pjax.defaults.timeout = 10000;
    ADMIN.render();
    return ADMIN;
})