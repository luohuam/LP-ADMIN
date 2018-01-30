<?php
class NewsController extends Controller{
    public $_perPage = 15;
    /**
     * 新闻列表的读取显示
     */
    public function newsAction(){
        $p = isset($_GET['p'])?$_GET['p']:1;
        //limit的第一个参数
        $start = ($p-1)*$this->_perPage;
        
        $newsModel = new NewsModel();
        $news = $newsModel->getNews("","{$start},{$this->_perPage}");
        
        //获取分类
        $total = $newsModel->getTotal("");
        $page = new PHPPage($total,$this->_perPage);
        
        $this->assign('page',$page);
        $this->assign('news',$news);
        $this->display('news.html');
    }
    /**
     * 增加新闻内容
     */
    public function addNewsAction(){
        $model = new NewsModel();
        if(!empty($_POST)){
            $data = array();
            $data['title'] = $_POST['title'];
            $data['num'] = $_POST['num'];
            $data['danwei'] = $_POST['danwei'];
            $data['place'] = $_POST['place'];
            $data['date'] = $_POST['date'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
            $data['user'] = $_POST['user'];
            $data['phone'] = $_POST['phone'];
            $data['people'] = $_POST['people'];
            $res = $model->addNews($data);
            if($res){
                echo json_encode(array('msg'=>1));
            }else{
                echo json_encode(array('msg'=>2));
            }
        }else{
            $num = $model->newNum() + 1;
            $this->assign('num',$num);
            $this->display('add_news.html');
        }
    }

    /**
     * 插入内容
     */
    public function insertAction(){
        $model = new NewsModel();
        if(!empty($_POST)){
            $news = $model->getNews("num>=".$_POST['num2'],"");
            foreach ($news as $v) {
                $v['num'] = $v['num'] + 1;
                $res = $model->modifyNewsById($v);
            }
            $data = array();
            $data['title'] = $_POST['title'];
            $data['num'] = $_POST['num2'];
            $data['danwei'] = $_POST['danwei'];
            $data['place'] = $_POST['place'];
            $data['date'] = $_POST['date'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
            $data['user'] = $_POST['user'];
            $data['phone'] = $_POST['phone'];
            $data['people'] = $_POST['people'];
            $res = $model->addNews($data);
            if($res){
                echo json_encode(array('msg'=>1));
            }else{
                echo json_encode(array('msg'=>2));
            }
        }else{
            $num = $model->newNum() + 1;
            $this->assign('num',$num);
            $this->display('insert_news.html');
        }
    }
    /**
     * 修改新闻
     */
    public function modifynewsAction(){
        $newsModel = new NewsModel();
        if(!empty($_POST)){
            $data = array();
            $data['id'] = $_POST['id'];
            $data['title'] = $_POST['title'];
            $data['num'] = $_POST['num'];
            $data['danwei'] = $_POST['danwei'];
            $data['place'] = $_POST['place'];
            $data['date'] = $_POST['date'];
            $data['start'] = $_POST['start'];
            $data['end'] = $_POST['end'];
            $data['user'] = $_POST['user'];
            $data['phone'] = $_POST['phone'];
            $data['people'] = $_POST['people'];
            $res = $newsModel->modifyNewsById($data);
            if($res){
                echo json_encode(array('msg'=>1));
            }else{
                echo json_encode(array('msg'=>2));
            }
        }else{
            $id = intval($_GET['id']);
            $news = $newsModel->getNewById($id);

            $this->assign('news',$news);
            $this->display('modify_news.html');
        }
        
    }
    /**
     * 删除新闻数据
     */
    public function delnewsAction(){
        $id = $_POST['id'];
        $model = new NewsModel();
        $num = $model->getNumByID($id);//删除的编号
        $newNum = $model->newNum();//最新编号
        $res = $model->delNewsById($id);
        if($res){
            if($num != $newNum){//如果删除的编号不等于最新的编号，则删除的是中间数据
                $total = $model->getTotal("");//数据总数
                for($i=0;$i<$total;$i++){
                    $curNum = $model->getNum($i);//当前编号
                    $nextNum = $model->getNum($i+1);//下一个编号
                    if ($i == 0 && $curNum != 1) {//第一条数据的编号不为1
                        $one = $model->updataNum(1,$curNum);//修改第一个编号为1
                        $curNum = 1;//当前编号为1
                        if($nextNum != 2 && $nextNum!=""){//如果下一个编号不等于2，这说明下一个编号需要修改
                            $update = $model->updataNum(2,$nextNum);//将下一个编号改为2
                            continue;
                            if (!$update) {
                                echo json_encode(array('msg'=>3));
                                break;
                            }
                        } 
                    }
                    if($curNum + 1 != $nextNum && $nextNum!=""){//如果当前编号+1！=下一个编号，这说明下一个编号需要修改
                        $update = $model->updataNum($curNum+1,$nextNum);
                        continue;
                        if (!$update) {
                            echo json_encode(array('msg'=>3));
                            break;
                        }
                    } 
                }
            }
            echo json_encode(array('msg'=>1));
        }else{
            echo json_encode(array('msg'=>2));
        }
    }

    //导出
    public function exportAction(){
        $newsModel = new NewsModel();
        $news = $newsModel->getNews("","");

        $model = new Export();
        $data=array('data'=>$news);
        ob_end_clean();//清除缓冲区,避免乱码
        $model::Exportuser($data);
    }
    
}