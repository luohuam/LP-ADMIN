<?php 
	class MenuController extends Controller{

		public function __construct(){
	        parent::__construct();
	        if(!isset($_SESSION['username'])){
	            header('Location:'.ADMIN_SITE.'Index/login');
	        }
	    }

		public function indexAction(){
			$this->display("menu_index.html");
		}

		public function getInfoAction(){
			$curPage = isset($_GET['page'])?$_GET['page']:1;
			$limit = isset($_GET['limit'])?$_GET['limit']:20;
			$start = ($curPage-1)*$limit;

			$model = new MenuModel();
			$menu = $model->getInfo("","$start,$limit");
			$total = $model->getTotal();
			for ($i=0;$i<count($menu);$i++){
				if ($menu[$i]['pid'] == "") {
					$menu[$i]['pid'] = "";
				}else{
					$fa = $model->getById($menu[$i]['pid']);
					$menu[$i]['pid'] = $fa['name'];
				}
			}

			$data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$menu));
			
			echo $data;
		}

		public function addAction(){
			$model = new MenuModel();
			if(!empty($_POST)){
				$data = array();
	            $data['name'] = $_POST['name'];
	            $data['play'] = $_POST['play'];
	            $data['controller'] = $_POST['controller'];
	            $data['first'] = $_POST['first'];
	            $data['pid'] = $_POST['pid'];
	            $data['icon'] = $_POST['icon'];
				$add = $model->add($data);
				if($add){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$first = $model->getByPid(0);//顶级节点
				$this->assign('first',$first);
				$this->display("menu_form.html");
			}
		}

		public function editAction(){
			$model = new MenuModel();
			if(!empty($_POST)){
				$data = array();
	            $data['id'] = $_POST['id'];
	            $data['name'] = $_POST['name'];
	            $data['controller'] = $_POST['controller'];
	            $data['play'] = $_POST['play'];
	            $data['first'] = $_POST['first'];
	            $data['pid'] = $_POST['pid'];
	            $data['icon'] = $_POST['icon'];
				$edit = $model->editById($data);
				if($edit){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$id = $_GET['id'];
				$menu = $model->getById($id);
				$this->assign('menu',$menu);

				$first = $model->getByPid("0");//顶级节点
				$this->assign('first',$first);

				$this->display("menu_form.html");
			}
		}

		public function delAction(){
			$model = new MenuModel();
    		$id = $_POST['id'];
    		if ($id == 1 || $id == 2 || $id == 3 || $id == 4 || $id == 5) {
    			echo json_encode(array('msg'=>4));//不能删除
    		}else{
    			$pids = $model->getByPid($id);
	    		if (count($pids)>0) {
					echo json_encode(array('msg'=>2));//含有子节点，无法删除
				}else{
					$del = $model->delById($id);
					if ($del) {
						echo json_encode(array('msg'=>1));//成功
					}else{
						echo json_encode(array('msg'=>3));//失败
					}
				}
    		}
		}

		public function deleteAction(){
			$model = new MenuModel();
			$ids = $_POST['data'];
			$n = 0;
			foreach ($ids as $id) {
				if ($id != 1 && $id != 2 && $id != 3 && $id != 4 && $id != 5) {
					$info = $model->getById($id);
					if ($info['pid'] == 0) {
						$pids = $model->getByPid($info['id']);
						if (count($pids)>0) {
							$n++;
						}else{
							$del = $model->delById($id);
						}
					}else{
						$del = $model->delById($id);
					}
				}				
			}
			if ($n > 0) {
				echo json_encode(array('msg'=>2));//删除节点当中有顶级节点
			}else{
				echo json_encode(array('msg'=>1));
			}
		}

		//修改显示状态
		public function switchAction(){
			$model = new MenuModel();
			$data = array();
			$data['id'] = $_POST['id'];
			$data['play'] = $_POST['check'];
			$edit = $model->editById($data);
			if($edit){
	            echo json_encode(array('msg'=>1));
	        }else{
	            echo json_encode(array('msg'=>2));
	        }
		}

		public function iconAction(){
			$this->display("icon.html");
		}
	}

?>