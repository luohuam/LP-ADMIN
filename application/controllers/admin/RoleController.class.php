<?php 
	class RoleController extends Controller{
		
		public function __construct(){
	        parent::__construct();
	        if(!isset($_SESSION['username'])){
	            header('Location:'.ADMIN_SITE.'Index/login');
	        }
	    }

		public function indexAction(){
			$this->display("role_index.html");
		}

		public function getInfoAction(){
			$curPage = isset($_GET['page'])?$_GET['page']:1;
			$limit = isset($_GET['limit'])?$_GET['limit']:10;
			$start = ($curPage-1)*$limit;

			$model = new RoleModel();
			$role = $model->getInfo("","$start,$limit");
			$total = $model->getTotal();

			$data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$role));
			
			echo $data;
		}

		public function addAction(){
			$model = new RoleModel();
			$authModel = new AuthModel();
			if(!empty($_POST)){
	            $data = array();
	            $data['name'] = $_POST['name'];
	            $info = $model->getInfo("name='{$_POST['name']}'","");
	            if (!empty($info)) {
	            	echo json_encode(array('msg'=>3));//已存在
	            }else{
	            	$res = $model->add($data);
	            	$id = $model->getInfo("name='{$_POST['name']}'","")[0]['id'];
	            	$add_auth = $authModel->add(array("role_id"=>$id));
	            	if($res){
		                echo json_encode(array('msg'=>1));
		            }else{
		                echo json_encode(array('msg'=>2));
		            }
	            }
	        }else{
				$this->display("role_form.html");
			}
		}

		public function editAction(){
			$model = new RoleModel();
			if(!empty($_POST)){
	            $data = array();
	            $data['id'] = $_POST['id'];
	            $data['name'] = $_POST['name'];

	            $info = $model->getById($_POST['id']);//该ID下原角色名
	            $infos = $model->getInfo("name='{$_POST['name']}'","");//根据传过来的角色名查找是否存在
	            if (empty($infos) || $_POST['name'] == $info['name']) {
	            	$res = $model->edit($data);
		            if($res){
		                echo json_encode(array('msg'=>1));
		            }else{
		                echo json_encode(array('msg'=>2));
		            }
	            }else{
	            	echo json_encode(array('msg'=>3));//已存在
	            }
	        }else{
	        	$id = $_GET['id'];
				$info = $model->getById($id);
				$this->assign("info",$info);
				$this->display("role_form.html");
			}
		}

		//单个删除
		public function delAction(){
	    	$model = new RoleModel();
	    	$authModel = new AuthModel();
            if(!empty($_POST)){
                $id = $_POST['id'];
                $del = $model->delById($id);
                $auth_id = $authModel->getInfo("role_id='{$id}'")[0]['id'];
                $auth_del = $authModel->delById($auth_id);
                if($del){
                    echo json_encode(array('msg'=>1));
                }else{
                    echo json_encode(array('msg'=>2));
                }
            }
	    }

	    //批量删除
	    public function deleteAction(){
			$model = new RoleModel();
			$authModel = new AuthModel();
			$ids = $_POST['data'];
			foreach ($ids as $id) {
				$info = $model->getById($id);
				$del = $model->delById($id);	
				$auth_id = $authModel->getInfo("role_id='{$id}'")[0]['id'];
                $auth_del = $authModel->delById($auth_id);		
			}
			echo json_encode(array('msg'=>1));
		}
	}

?>