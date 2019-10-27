dui.define('buildform',['jquery','form','popup'],function($,form,popup){
    var thisPopup,
    SELECTOR={

    },
    BuildForm = {
        render:function(el){
            form.render(el);
            // 设置弹窗
            thisPopup = window.thisPopup || null;
            var loading = null;
            // 联动下拉切换事件
            var linkageChange = function(select,init){
                var $select         = $(select);//当前下拉
                var next_items      = $select.attr('linkage-field').split(',');//会影响的菜单
                var next_item       = next_items[0];//第一个会影响的节点
                var url             = $select.attr('linkage-url');//请求地址
                var param           = $select.attr('linkage-param')||$select.attr('name'); // 额外参数
                var value           = $select.val();//请求值
                var $next           = $('select[name="'+ next_item +'"]');
                var data            = {};
                data[param]         = value;
                // 删除所有选项
                if (next_items.length > 0) {
                    for (var i = 0; i < next_items.length; i++) {
                        $('select[name="'+ next_items[i] +'"]').html('');
                    }
                }
                if(thisPopup && thisPopup.loading){
                    loading = thisPopup.loading;
                }else{
                    loading = popup.loading({
                        target:$select.parents('form')[0]
                    })
                }
                // 请求数据
                if(!value){
                    $next.attr('placeholder','请先选择上级联动');
                }else{
                    $next.attr('placeholder','请选择一项');
                    loading.show();
                    $.ajax({
                        url:url,
                        type:'post',
                        dataType:'json',
                        data:data,
                        success:function(res){
                            if(res.code==1){
                                var list = res.data;
                                if (list) {
                                    $.each(list, function (index, item) {
                                        var option = $('<option></option>');
                                        option.val(item['key']).html(item['value']);
                                        if(init && item['key']==$next.attr('dui-value')){
                                            option.attr('selected','selected');
                                        }
                                        $next.append(option);
                                    });
                                    form.render($select.parents('[dui-form]')[0],'select',$next.attr('dui-filter'))
                                }
                            }else{
                                popup.message(res.msg,{
                                    type:'error'
                                })
                            }
                        },
                        error:function(error){
                            popup.message('获取表单元素：'+$next.attr('name')+'的选项失败',{
                                type:'error'
                            })
                        },
                        complete:function(e){
                            loading.close();
                        }
                    })
                }
            }
            // 初始化linkage的下级值
            $(el).find('select[linkage-field]').each(function(i,select){
                linkageChange(select,true);
            })
            // 手动触发
            $(el).on('change','select[linkage-field]',function(e){
                linkageChange(this);
            })
        }
    }
    return BuildForm;
})