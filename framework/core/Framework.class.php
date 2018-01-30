<?php

class Framework{
    public static function run(){
        self::init();
        self::autoload();
        self::dispatch();
    }
    //初始化方法
	private static function init(){
	    $module = "home";  //表示默认的模块名称
	    $controller = "Index"; //表示默认的控制器名称
	    $action = "index"; //表示默认的方法名称
	    if(isset($_SERVER['PATH_INFO'])){
	        $requstInfo = explode('/', $_SERVER['PATH_INFO']);
	        $module = isset($requstInfo['1']) ? $requstInfo['1'] : $module;
	        $controller = isset($requstInfo['2']) ? $requstInfo['2'] : $controller;
	        $action = isset($requstInfo['3']) ? $requstInfo['3'] : $action;
	    }else{
	        $module = isset($_GET['m']) ? $_GET['m'] : $module;
	        $controller = isset($_GET['c']) ? $_GET['c'] : $controller;
	        $action = isset($_GET['a']) ? $_GET['a'] : $action;
	    }
		//定义路径常量
		define("DS", DIRECTORY_SEPARATOR);
		define("ROOT", getcwd() . DS ); //根目录
		define("APP_PATH", ROOT . 'application' . DS);
		define("FRAMEWORK_PATH", ROOT . "framework" .DS);
		define("PUBLIC_PATH", ROOT . "public" .DS);
		define("CONFIG_PATH", APP_PATH . "config" .DS);
		define("CONTROLLER_PATH", APP_PATH . "controllers" .DS);
		define("MODEL_PATH", APP_PATH . "models" .DS);
		define("VIEW_PATH", APP_PATH . "views" .DS);
		define("CORE_PATH", FRAMEWORK_PATH . "core" .DS);
		define("DB_PATH", FRAMEWORK_PATH . "databases" .DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" .DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" .DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" .DS);
		define('BASE_SITE', "http://www.perf.com/");
		define("UPLOADS_PATH", BASE_SITE . "public/uploads/");
		define('HOME_SITE', BASE_SITE."index.php/home/");
		define('ADMIN_SITE', BASE_SITE."index.php/admin/");
		define("HOME_STYLE", BASE_SITE . "public/style/home" .DS);
		define("ADMIN_STYLE", BASE_SITE . "public/style/admin" .DS);
		define("JS", BASE_SITE . "public/js" .DS);
		define("HOME_IMG", BASE_SITE . "public/images" .DS);
		//获取参数m、c、a,index.php?m=admin&c=goods&a=add GoodsController中的addAction
		define('MODULE',$module);
		define('CONTROLLER',$controller);
		define('ACTION',$action);
		//设置当前控制器和视图目录 CUR-- current
		define("CUR_CONTROLLER_PATH", CONTROLLER_PATH . MODULE . DS);
		define("CUR_VIEW_PATH", VIEW_PATH . MODULE . DS);

		//载入配置文件
		$GLOBALS['config'] = include CONFIG_PATH . "config.php";

		//载入核心类
		include CORE_PATH . "Controller.class.php";
		include CORE_PATH . "Model.class.php";
		include DB_PATH . "Mysql.class.php";
		include LIB_PATH . "PHPPage.class.php";
		include LIB_PATH . "ValidateCode.class.php";
		include LIB_PATH . "PHPExcel".DS."Export.class.php";
	}
	
    //定义路由分发方法,说白了，就是实例化对象并调用方法
	//index.php?m=admin&c=goods&a=add GoodsController中的addAction
	private static function dispatch(){
		//获取控制器名称
		$controller_name = CONTROLLER . "Controller";
		//获取方法名
		$action_name = ACTION . "Action";
		//实例化控制器对象
		$controller = new $controller_name();
		//调用方法
		$controller->$action_name();
	}
	
	//注册为自动加载
	private static function autoload(){
	    // $arr = array(__CLASS__,'load');
	    spl_autoload_register('self::load');
	}
	
	//自动加载功能,此处我们只实现控制器和数据库模型的自动加载
	//如GoodsController、 GoodsModel
	private static function load($classname){
	    if (substr($classname, -10) == 'Controller') {
	        //载入控制器
	        include CUR_CONTROLLER_PATH . "{$classname}.class.php";
	    } elseif (substr($classname, -5) == 'Model') {
	        //载入数据库模型
	        include MODEL_PATH . "{$classname}.class.php";
	    } else {
	        //暂略
	    }
	}
}
?>