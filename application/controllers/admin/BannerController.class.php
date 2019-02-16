<?php 
	class BannerController extends Controller{
		
		public function __construct(){
	        parent::__construct();
	        if(!isset($_SESSION['username'])){
	            header('Location:'.ADMIN_SITE.'Index/login');
	        }
	    }

		public function indexAction(){
			$this->display("banner_index.html");
		}

		public function getInfoAction(){
			$curPage = isset($_GET['page'])?$_GET['page']:1;
			$limit = isset($_GET['limit'])?$_GET['limit']:10;
			$start = ($curPage-1)*$limit;

			$model = new BannerModel();
			$banner = $model->getInfo("","$start,$limit");
			$total = $model->getTotal();

			$data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$banner));
			
			echo $data;
		}

		public function addAction(){
			$model = new BannerModel();
			$authModel = new AuthModel();
			if(!empty($_POST)){
	            $data = array();
	            $data['title'] = $_POST['title'];
	            $data['url'] = $_POST['url'];
	            $data['image'] = $_POST['image'];
	            $data['content'] = $_POST['content'];
            	$res = $model->add($data);
            	if($res){
	                echo json_encode(array('msg'=>1));
	            }else{
	                echo json_encode(array('msg'=>2));
	            }
	        }else{
				$this->display("banner_form.html");
			}
		}

		public function editAction(){
			$model = new BannerModel();
			if(!empty($_POST)){
	            $data = array();
	            $data['id'] = $_POST['id'];
	            $data['title'] = $_POST['title'];
	            $data['url'] = $_POST['url'];
	            $data['image'] = $_POST['image'];
	            $data['content'] = $_POST['content'];
            	$res = $model->edit($data);
	            if($res){
	                echo json_encode(array('msg'=>1));
	            }else{
	                echo json_encode(array('msg'=>2));
	            }
	        }else{
	        	$id = $_GET['id'];
				$info = $model->getById($id);
				$this->assign("info",$info);
				$this->display("banner_form.html");
			}
		}

		//单个删除
		public function delAction(){
	    	$model = new BannerModel();
            if(!empty($_POST)){
                $id = $_POST['id'];
                $del = $model->delById($id);
                if($del){
                    echo json_encode(array('msg'=>1));
                }else{
                    echo json_encode(array('msg'=>2));
                }
            }
	    }

	    //批量删除
	    public function deleteAction(){
			$model = new BannerModel();
			$ids = $_POST['data'];
			foreach ($ids as $id) {
				$info = $model->getById($id);
				$del = $model->delById($id);		
			}
			echo json_encode(array('msg'=>1));
		}
	}

?>