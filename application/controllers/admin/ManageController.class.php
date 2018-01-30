<?php 
    class ManageController extends Controller{
        
        public function __construct(){
            parent::__construct();
            if(!isset($_SESSION['username'])){
                header('Location:'.ADMIN_SITE.'Index/login');
            }
        }

        public function indexAction(){
            $this->display("manage_index.html");
        }

        public function getInfoAction(){
            $curPage = isset($_GET['page'])?$_GET['page']:1;
            $limit = isset($_GET['limit'])?$_GET['limit']:10;
            $start = ($curPage-1)*$limit;

            $model = new ManageModel();
            $list = $model->getInfo("","$start,$limit");
            $total = $model->getTotal();

            $roleModel = new RoleModel();
            $role = $roleModel->getInfo("","");
            for($j=0; $j<count($list); $j++){
                for ($i=0; $i < count($role); $i++) { 
                    if ($list[$j]['role_id'] == $role[$i]['id']) {
                        $list[$j]['role_id'] = $role[$i]['name'];
                    }
                }
            }
            $data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$list));
            
            echo $data;
        }

        public function addAction(){
            $model = new ManageModel();
            if(!empty($_POST)){
                $data = array();
                $data['name'] = $_POST['name'];
                $data['pwd'] = $_POST['pwd'];
                $data['role_id'] = $_POST['role_id'];
                // $data['email'] = $_POST['email'];
                // $data['phone'] = $_POST['phone'];
                
                $list = $model->getInfo("","");//获取所有账号信息
                foreach ($list as $v) {
                    //传过来的账号名已有账号名当中
                    if ($v['name'] == $_POST['name']) {
                        echo json_encode(array('msg'=>3));die;
                    }
                }
                $res = $model->add($data);
                if($res){
                    echo json_encode(array('msg'=>1));
                }else{
                    echo json_encode(array('msg'=>2));
                }
            }else{
                $roleModel = new RoleModel();
                $role = $roleModel->getInfo("","");
                $this->assign("role",$role);
                $this->display("manage_form.html");
            }
        }

        public function editAction(){
            $model = new ManageModel();
            if(!empty($_POST)){
                $data = array();
                $data['id'] = $_POST['id'];
                $data['name'] = $_POST['name'];
                $data['pwd'] = $_POST['pwd'];
                $data['role_id'] = $_POST['role_id'];
                // $data['email'] = $_POST['email'];
                // $data['phone'] = $_POST['phone'];
                
                $list = $model->getInfo("","");//获取所有账号信息
                $man = $model->getById($_POST['id']);//获取当前账号信息
                foreach ($list as $v) {
                    //传过来的账号名不等于原账号名，且存在于已有账号名当中
                    if ($v['name'] == $_POST['name'] && $man['name'] != $_POST['name']) {
                        echo json_encode(array('msg'=>3));die;
                    }
                }
                $res = $model->edit($data);
                if($res){
                    echo json_encode(array('msg'=>1));
                }else{
                    echo json_encode(array('msg'=>2));
                }
            }else{
                $id = $_GET['id'];
                $list = $model->getById($id);
                $this->assign("list",$list);

                $roleModel = new RoleModel();
                $role = $roleModel->getInfo("","");
                $this->assign("role",$role);

                $this->display("manage_form.html");
            }
        }

        public function delAction(){
            $model = new ManageModel();
            if(!empty($_POST)){
                $id = $_POST['id'];
                if ($_POST['name'] == $_SESSION['username']) {
                    echo json_encode(array('msg'=>3));
                }else{
                    $del = $model->delById($id);
                    if($del){
                        echo json_encode(array('msg'=>1));
                    }else{
                        echo json_encode(array('msg'=>2));
                    }
                } 
            }
        }
        /**
         * 批量删除
         */
        public function deleteAction(){
            $model = new ManageModel();
            $ids = $_POST['data'];
            $n = 0;
            foreach ($ids as $id) {
                $info = $model->getById($id);
                if ($info['name'] == $_SESSION['username']) {
                    $n++;
                }else{
                   $del = $model->delById($id); 
               }           
            }
            if ($n > 0) {
                echo json_encode(array('msg'=>2));
            }else{
                echo json_encode(array('msg'=>1));
            }
        }
    }

?>