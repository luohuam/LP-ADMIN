$(document).ready(function() {
    $('#ul').hide(); //打开页面隐藏下拉列表 
    $('#it').hover( //鼠标滑过导航栏目时 
        function() {
            $('#ul').show(); //显示下拉列表 
            $(this).css({ 'color': 'red', 'background-color': 'orange' }); //设置导航栏目样式，醒目 
        },
        function() {
            $('#ul').hide(); //鼠标移开后隐藏下拉列表 
        }
    );
    $('#ul').hover( //鼠标滑过下拉列表自身也要显示，防止无法点击下拉列表 
        function() {
            $('#ul').show();
        },
        function() {
            $('#ul').hide();
            $('#it').css({ 'color': 'white', 'background-color': 'black' }); //鼠标移开下拉列表后，导航栏目的样式也清除 
        }
    );
    $('li').hover( //鼠标滑过下拉列表是改变当前栏目样式 
        function() {
            $(this).css({ 'color': 'red', 'background-color': 'orange' });
        },
        function() {
            $(this).css({ 'color': 'white', 'background-color': 'black' });
        }
    );
});
