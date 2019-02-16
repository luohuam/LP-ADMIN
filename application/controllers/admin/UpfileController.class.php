<?php 
class UpfileController extends Controller{
    //批量上传图片
    public function upfilesAction(){
        if(isset($_FILES['file'])){
            $files = $_FILES['file'];
            $name = []; //文件名
            $type = []; //文件类型
            $tmp_name = []; //临时文件位置
            $error = [];   //是否错误
            $size = []; //文件大小
            $imgPath = [];//上传的文件
            for ($i=0; $i < count($files['name']); $i++) { 
                array_push($name,$files['name'][$i]);
                array_push($type,$files['type'][$i]);
                array_push($tmp_name,$files['tmp_name'][$i]);
                array_push($error,$files['error'][$i]);
                array_push($size,$files['size'][$i]);
            }
           
            for ($i=0; $i < count($name); $i++) { 
                //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
                $oldPath = $tmp_name[$i];
                //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
                $ext = pathinfo($name[$i],PATHINFO_EXTENSION);//后缀
                $newName = time().mt_rand().'.'.$ext;
                $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

                $path = date('Ymd').'/'.$newName;

                if(file_exists(UPLOAD_PATH.date('Ymd'))){
                    if(move_uploaded_file($oldPath,$newPath)){
                        array_push($imgPath, BASE_SITE.'public/uploads/'.$path);
                    }else{
                        echo json_encode(array("msg"=>2));//上传失败
                    }
                }else{
                    if(mkdir(UPLOAD_PATH.date('Ymd'))){
                        if(move_uploaded_file($oldPath,$newPath)){
                            array_push($imgPath, BASE_SITE.'public/uploads/'.$path);
                        }else{
                            echo json_encode(array("msg"=>2));//上传失败
                        }
                    }else{
                        echo json_encode(array("msg"=>3));//目录创建失败
                    }
                }
            }
            echo json_encode(array("msg"=>1,'imgPath'=>$imgPath));
        }
    }

    //单图上传
    public function upfileAction(){
        if(isset($_FILES['file'])){
            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
            $oldPath = $_FILES['file']['tmp_name'];
            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
            $ext = pathinfo($_FILES['file']['name'],PATHINFO_EXTENSION);
            $newName = time().mt_rand().'.'.$ext;
            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;
            $path = date('Ymd').'/'.$newName;
            $imgPath = BASE_SITE.'public/uploads/'.$path;
            // $imgPath = UPLOADS_PATH.$path;
            if(file_exists(UPLOAD_PATH.date('Ymd'))){
                if(move_uploaded_file($oldPath,$newPath)){
                    echo json_encode(array("code"=>0,"msg"=>"","data"=>array("src"=>$imgPath)));
                }else{
                    echo json_encode(array("code"=>1,"msg"=>"","data"=>array("src"=>"")));
                }
            }else{
                if(mkdir(UPLOAD_PATH.date('Ymd'))){
                    if(move_uploaded_file($oldPath,$newPath)){
                        echo json_encode(array("code"=>0,"msg"=>"","data"=>array("src"=>$imgPath)));
                    }else{
                        echo json_encode(array("code"=>1,"msg"=>"","data"=>array("src"=>"")));
                    }
                }else{
                    echo json_encode(array("code"=>2,"msg"=>"","data"=>array("src"=>"")));//目录创建失败
                }
            }
        }
    }
}
?>