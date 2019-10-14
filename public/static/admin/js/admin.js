define('admin',['jquery','element','pjax','nprogress'],function($,element,pjax,nprogress){
    var _BODY=$('body'),
    _WIN = $(window),
    SELECTOR={
        aside:'.dui-aside',
        pjax_container:'#pjax-container'
    },
    ADMIN = {
        /**
         * 初始化后台js
         */
        render:function(){
            var that = this;
            //初始化事件管理
            $(document).delegate('*[dui-event]','click',function(e){
                var name = $(this).attr('dui-event');
                that.events[name]  && that.events[name].call(this, e)
                return false;
            })
            // 初始化url跳转事件
            $(document).delegate('[jump]','click',function(e){
                var othis       = $(this),
                    url         = othis.attr('href') || othis.attr('jump-url'),
                    type        = othis.attr('type'),//检测是否是提交
                    target      = othis.attr('jump-target'),//跳转方式
                    form_name   = othis.attr('jump-form'),//form名称
                    text        = othis.attr('jump-text'),//跳转提示信息
                    title       = othis.attr('jump-title'),//跳转提示标题
                    form        = $('form[name="'+form_name+'"]');//表单
                if(type=='submit'){// 表单提交

                }else if(url){//其他跳转方式
                    if(target=='_pjax'){//pjax方式
                        $.pjax({url:url,container: SELECTOR.pjax_container});
                    }    
                }
                return false;
            })
            // 设置pjax开始监听
            $(document).on('pjax:start', function() { nprogress.start(); });
            // 设置pjax结束监听
            $(document).on('pjax:end',   function() { nprogress.done();  });
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
            // 切换app菜单
            changeApp:function(e){
                var othis = $(this),
                id = othis.data('id'),
                menus=$(SELECTOR.aside).find('[dui-menubar][data-id="'+id+'"]');
                // 如果当前app已经选中直接返回
                if(othis.hasClass('is-active')) return;
                // 当前应用选中，其他应用不选中
                othis.addClass('is-active').siblings().removeClass('is-active');
                // 隐藏其他应用菜单，显示当前选中菜单
                menus.siblings('[dui-menubar]').hide();
                menus.show();
            }
        }
    }
    // 设置pjax请求超时时间
    $.pjax.defaults.timeout = 10000;
    ADMIN.render();
    return ADMIN;
})