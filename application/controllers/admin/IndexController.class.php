<?php 
	class IndexController extends Controller{

		public function indexAction(){
			// 判断是否登录
	        if(!isset($_SESSION['username'])){
	            header('Location:'.ADMIN_SITE.'Index/login');
	        }

	        //所有显示的菜单及子菜单
	        $model = new MenuModel();
	        $menu = $model->getInfo("pid=0 and play='on'","");
	        $child = $model->getInfo("pid!=0 and play='on'","");
	        $this->assign("menu",$menu);
	        $this->assign("child",$child);

	        //当前登录账号的角色
			$manageModel = new ManageModel();
	        $role_id = $manageModel->getRight("{$_SESSION['username']}");

	        //根据角色查找auth_id权限
	        $authModel = new AuthModel();
	        $auth = $authModel->getRight("{$role_id}");
	        $auth = explode(",", $auth);
	        $this->assign("auth",$auth);
	        
			$this->display('admin.html');
		}

		public function loginAction(){
	        if(!empty($_POST)){
	        	if($_POST['code']==$_SESSION['code']){
		            $username = trim($_POST['admin_user']);
		            $pwd = $_POST['admin_pass'];
	                $manageModel = new ManageModel();
	                $res = $manageModel->userIsExists($username,$pwd);
	                if($res){
	                    $_SESSION['username'] = $username;
	                    $data = array();
	                    $data['id'] = $res;
	                    $data['last_ip'] = $_SERVER['REMOTE_ADDR'];
	                    $data['last_time'] = date("Y-m-d H:m:s");
	                    // print_r($count);
	                    $manageModel->edit($data);
	                    echo json_encode(array('msg'=>1)); //登陆成功
	                }else{
	                    echo json_encode(array('msg'=>3)); //登陆失败
	                } 
                }else{
                	echo json_encode(array('msg'=>2)); //登陆成功
                }
	        }else{
	            $this->display('admin_login.html');
	        }
	    }

	    //验证码 
	    public function codeAction(){
	        $code = new ValidateCode();
	        $code->doimg();
	        $_SESSION['code'] = $code->getCode();
	    }
	    
	    //退出
	    public function logoutAction(){
	        if(isset($_SESSION['username'])){
	            unset($_SESSION['username']);
	            $this->display('admin_login.html');
	        }
	    }

	    public function topAction(){
	        $this->display('top.html');
	    }
	    
	    public function sidebarAction(){
	        $this->display('sidebar.html');
	    }
	    
	    public function sidebarnAction(){
	        $this->display('sidebarn.html');
	    }
	    
	    public function manageAction(){
	        $this->display('manage.html');
	    }
	}
?>