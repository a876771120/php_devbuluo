define('buildtable',['jquery','popup'],function($,popup){
    var thisTable,
    BuildTable = {
        render:function(table){
            // 设置当前table，一切操作都是居于这个表格
            thisTable = table;
            // 初始化简单搜索
            initMethod.initSearch();
            // 初始化高级查询
            initMethod.initSearchArea();
        }
    },
    initMethod={
        // 初始化基础搜索
        initSearch:function(){
            
        },
        // 初始化高级查询
        initSearchArea:function(){

        }
    };
    return BuildTable;
})