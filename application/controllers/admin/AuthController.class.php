<?php 
    class AuthController extends Controller{
        
        public function __construct(){
            parent::__construct();
            if(!isset($_SESSION['username'])){
                header('Location:'.ADMIN_SITE.'Index/login');
            }
        }

        public function indexAction(){
            $this->display("auth_index.html");
        }

        public function getInfoAction(){
            $curPage = isset($_GET['page'])?$_GET['page']:1;
            $limit = isset($_GET['limit'])?$_GET['limit']:10;
            $start = ($curPage-1)*$limit;

            $model = new AuthModel();
            $list = $model->getInfo("","$start,$limit");
            $total = $model->getTotal();

            $roleModel = new RoleModel();
            $role = $roleModel->getInfo("","");

            $menuModel = new MenuModel();
            $menu = $menuModel->getByPid("0");

            for($j=0; $j<count($list); $j++){
                for ($i=0; $i < count($role); $i++) { 
                    if ($list[$j]['role_id'] == $role[$i]['id']) {
                        $list[$j]['role_id'] = $role[$i]['name'];
                    }
                }
                $ids = explode(",", $list[$j]['nav_ids']);
                $nav = array();
                for ($m=0;$m<count($ids);$m++){
                    for($n=0;$n<count($menu);$n++){
                        if ($menu[$n]['id'] == $ids[$m]) {
                            array_push($nav, $menu[$n]['name']);
                        }
                    }
                }
                $nav = implode("，",$nav);
                $list[$j]['nav_ids'] = $nav;
            }

            $data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$list));
            
            echo $data;
        }

        public function getMenuAction(){
            $model = new MenuModel();
            $list = $model->getByPid("0");
            $total = $model->getTotal();

            $id = $_GET['id'];
            $authModel = new AuthModel();
            $auth = $authModel->getById($id);
            $navs = implode(",", $auth['nav_ids']);
            $item = array();
            foreach($list as $v){
                $check = 0;
                if (in_array($v['id'],$navs)) {
                    $check = 1;
                }
                array_push($item, array("id"=>$v['id'],"name"=>$v['name'],"check"=>$check));
            }
            $data = json_encode(array("count"=>$total,"msg"=>"","code"=>0,"data"=>$item));
            
            echo $data;
        }

        public function editAction(){
            $model = new AuthModel();
            if(!empty($_POST)){
                $data = array();
                $data['id'] = $_POST['id'];
                $data['nav_ids'] = $_POST['ids'];
                $res = $model->edit($data);
                if($res){
                    echo json_encode(array('msg'=>1));
                }else{
                    echo json_encode(array('msg'=>2));
                }
            }else{
                $model = new MenuModel();
                $list = $model->getByPid("0");
                $total = $model->getTotal();

                $id = $_GET['id'];
                $authModel = new AuthModel();
                $auth = $authModel->getById($id);
                $navs = explode(",", $auth['nav_ids']);
                $item = array();
                foreach($list as $v){
                    $check = 0;
                    if (in_array($v['id'],$navs)) {
                        $check = 1;
                    }
                    array_push($item, array("id"=>$v['id'],"name"=>$v['name'],"check"=>$check));
                }
                $this->assign("item",$item);

                $this->display("auth_form.html");
            }
        }
    }

?>