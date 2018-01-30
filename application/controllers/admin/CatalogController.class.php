<?php 
	class CatalogController extends Controller{

		public function __construct(){
	        parent::__construct();
	        if(!isset($_SESSION['username'])){
	            header('Location:'.ADMIN_SITE.'Index/login');
	        }
	    }

		public function indexAction(){
			$data = $this->info(0);;
			$this->assign('data',json_encode($data));
			$this->display("catalog_index.html");
		}

		//递归处理树形图
		public function info($pid){
			$model = new CatalogModel();
			$list = $model->getByPid($pid);
			$data = '';
			if (!empty($list)) {
				foreach($list as $v){
					if ($v['pid'] == $pid) {
						$v['children'] = $this->info($v['id']);
						$v['spread'] = true;
						$data[] = $v;
					}
				}
				return $data;
			}
		}

		public function getInfoAction(){
			$curPage = isset($_GET['page'])?$_GET['page']:1;
			$limit = isset($_GET['limit'])?$_GET['limit']:20;
			$start = ($curPage-1)*$limit;

			$model = new CatalogModel();
			$list = $model->getInfo("","$start,$limit");
			$total = $model->getTotal();

			for($i=0;$i<count($list);$i++){
				if ($list[$i]['pid'] != "0") {
					$fa = $model->getById($list[$i]['pid']);
					$list[$i]['pid'] = $fa['name'];
				}
				$child = $model->getByPid($list[$i]['id']);
				if (count($child)>0) {
					$list[$i]['play'] = 0;
				}else{
					$list[$i]['play'] = 1;
				}
			}

			$data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$list,"page"=>$curPage));
			
			echo $data;
		}

		public function addAction(){
			$model = new CatalogModel();

			if(!empty($_POST)){
				$data = array();
	            $data['name'] = $_POST['name'];
	            $data['sort'] = $_POST['sort'];
	            $data['pid'] = $_POST['pid'];
				$add = $model->add($data);
				if($add){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$first = $model->getByPid(0);//顶级节点
				$this->assign('first',$first);
				$this->display("catalog_form.html");
			}
		}

		public function editAction(){
			$model = new CatalogModel();
			if(!empty($_POST)){
				$data = array();
	            $data['id'] = $_POST['id'];
	            $data['name'] = $_POST['name'];
	            $data['pid'] = $_POST['pid'];
				$edit = $model->editById($data);
				if($edit){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$id = $_GET['id'];
				$list = $model->getById($id);
				$this->assign('list',$list);

				$this->display("catalog_form.html");
			}
		}

		public function delAction(){
			$model = new CatalogModel();
    		$id = $_POST['id'];
			$pids = $model->getByPid($id);
			$del = $model->delById($id);
			if ($del) {
				echo json_encode(array('msg'=>1));//成功
			}else{
				echo json_encode(array('msg'=>2));//失败
			}
		}

		public function deleteAction(){
			$model = new CatalogModel();
			$ids = $_POST['data'];
			foreach ($ids as $id) {
				$del = $model->delById($id);		
			}
			echo json_encode(array('msg'=>2));//失败

		}
	}

?>