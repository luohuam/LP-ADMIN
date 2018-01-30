<?php
class Controller{
    public $smarty;
    public function __construct(){
        
        //引入并实例化smarty模板引擎类
        require LIB_PATH.'smarty/Smarty.class.php';
        $this->smarty = new Smarty();
        
        //配置模板目录
        $this->smarty->template_dir = VIEW_PATH.MODULE;
        
        $this->smarty->left_delimiter = "{{";
        $this->smarty->right_delimiter = "}}";

        //判断session是否存在用户名
        session_start();
        if(isset($_SESSION['username'])){
            $username = $_SESSION['username'];
            $manageModel = new ManageModel();
            $this->assign("username",$username);
        }

        //判断中英文版本
        if(isset($_GET['lang'])){
            $lang = $_GET['lang'];
        }else{
            $lang = "en";
        }
        $this->assign("lang",$lang);

        //获取当前URL
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
        // $url = $_SERVER['PHP_SELF'];
        $this->assign("url",$url);
    }
    
    public function assign($key,$val){
        return $this->smarty->assign($key,$val);
    }
    
    public function display($view){
        return $this->smarty->display($view); 
    }
}