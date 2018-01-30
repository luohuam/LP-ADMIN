<?php 
	class TypeController extends Controller{

		public function indexAction(){
			$this->display("type.html");
		}

		public function getInfoAction(){
			$curPage = isset($_GET['page'])?$_GET['page']:1;
			$limit = isset($_GET['limit'])?$_GET['limit']:10;
			$start = ($curPage-1)*$limit;

			$model = new TypeModel();
			$type = $model->getType("","$start,$limit");
			$total = $model->getTotal();

			$data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$type));
			
			echo $data;
		}

		public function delAction(){
			$model = new TypeModel();
    		$id = $_POST['id'];
    		$pids = $model->getByPid($id);
    		if (count($pids)>0) {
				echo json_encode(array('msg'=>2));
			}else{
				$del = $model->delById($id);
				if ($del) {
					echo json_encode(array('msg'=>1));
				}else{
					echo json_encode(array('msg'=>3));
				}
			}
		}

		public function deleteAction(){
			$model = new TypeModel();
			$ids = $_POST['data'];
			$n = 0;
			foreach ($ids as $id) {
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
			if ($n > 0) {
				echo json_encode(array('msg'=>2));//删除节点当中有顶级节点
			}else{
				echo json_encode(array('msg'=>1));
			}
		}

		public function editAction(){
			$typeModel = new TypeModel();
			if(!empty($_POST)){
				$data = array();
				$data['id'] = $_POST['id'];
	            $data['name'] = $_POST['name'];
	            if($_POST['type2']!=""){
	            	$data['pid'] = $_POST['type2'];
	            }else if($_POST['type2']==""){
	            	$data['pid'] = $_POST['type1'];
	            }
	            $data['recommend'] = $_POST['recommend'];
				$edit = $typeModel->modifyTypeById($data);
				if($edit){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$id = $_GET['id'];
				$check = $typeModel->check($id);
				//判断是否为二级分类
				if($check==1 || $check==2){
					$one = $check;
					$two = $typeModel->getChild($one);
					$three = "";
					$four = $typeModel->getChild($id);
					$this->assign('num',2);
				}else{//判断是否为三级分类
					$one = $typeModel->check($check);
					$two = $check;
					$three = $typeModel->getChild($two);
					$four = $typeModel->getChild($one);
					$this->assign('num',3);
				}
				$type = $typeModel->getOneType($id);
				$fen = $typeModel->types();
				
				$this->assign('one',$one);
        		$this->assign('two',$two);
        		$this->assign('three',$three);
				$this->assign('four',$four);
            	$this->assign('type',$type);
            	$this->assign('fen',$fen);
				$this->display("modify_Type.html");
			}
		}

		public function addAction(){
			$typeModel = new TypeModel();
			if(!empty($_POST)){
				$data = array();
	            $data['name'] = $_POST['name'];
	            if($_POST['type2']!=""){
	            	$data['pid'] = $_POST['type2'];
	            }else if($_POST['type2']==""){
	            	$data['pid'] = $_POST['type1'];
	            }
	            $data['recommend'] = $_POST['recommend'];
				$edit = $typeModel->addType($data);
				if($edit){
		            echo json_encode(array('msg'=>1));
		        }else{
		            echo json_encode(array('msg'=>2));
		        }
			}else{
				$types = $typeModel->getChild("0");//一级分类
				$fen = $typeModel->types();
				$this->assign('types',$types);
				$this->assign('fen',$fen);
				$this->display("add_Type.html");
			}
		}
	}

?>