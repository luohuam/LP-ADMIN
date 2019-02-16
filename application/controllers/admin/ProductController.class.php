<?php 
	class ProductController extends Controller{
		public $_perPage = 5;

		
	    public function productAction(){
	    	$Products = new ProductModel();
	    	//分页
	    	$p = isset($_GET['p'])?$_GET['p']:1;
	        $start = ($p-1)*$this->_perPage;
	    	$res = $Products->getPp("","{$start},{$this->_perPage}");
	    	$pro = array();
	        foreach ($res as $v){
	        	$data["id"] = $v['id'];
	        	$data["type1"] = $v['type1'];
	        	$data["type2"] = $v['type2'];
	        	$data["type3"] = $v['type3'];
	        	$data["name"] = $v['name'];
	        	$data["qq"] = $v['qq'];
	        	$data["email"] = $v['email'];
	        	$data["price"] = $v['price'];
	        	$data["jianjie"] = $v['jianjie'];
	        	$data["date"] = $v['date'];	
	        	$data["recommend"] = $v['recommend'];
	        	$data["content"] = $v['content'];
	        	$data['image'] = explode(",",$v['images']);
	        	$pro[] = $data;
	        }
	        $total = $Products->getTotal("");
	        $page = new PHPPage($total,$this->_perPage);

	        $type = $Products->getTypeList();
	        $this->assign("page",$page);
	        $this->assign('start',$start);
	    	$this->assign("pro",$pro);
	    	$this->assign("type",$type);

	    	$this->display("product.html");
	    }

	    
	    public function addProductAction(){
	    	$Products = new ProductModel();
	    	if(!empty($_POST)){
	    		// print_r($_POST);
	    		$data = array();
    			$data['type1'] = $_POST['type1'];
    			$data['type2'] = $_POST['type2'];
            	$data['type3'] = $_POST['type3'];
	    		$data['name'] = $_POST['name'];
	    		$data["qq"] = $_POST['qq'];
	    		$data["email"] = $_POST['email'];
	    		$data['images'] = implode(",",$_POST['file']) ;
	    		$data['price'] = $_POST['price'];
	    		$data['jianjie'] = $_POST['jianjie'];
	    		$data['date'] = $_POST['date'];
	    		$data['recommend'] = $_POST['recommend'];
	    		$data['content'] = $_POST['content'];
	            
	            $res = $Products->addProduct($data);

	            if($res){
	                echo json_encode(array('msg'=>1));
	            }else{
	                echo json_encode(array('msg'=>2));
	            }
	    	}else{
	    		$type = $Products->tt();
	    		$this->assign("type",$type);
	    		$this->display("add_product.html");
	    	}	
	    }

	    /**
	     * 修改导航页
	     * @return [type] [description]
	     */
	    public function modifyProductAction(){
	        $Product = new ProductModel();
	        if(!empty($_POST)){
	            $data = array();
	            $data['id'] = $_POST['id'];
	    		$data['type1'] = $_POST['type1'];
    			$data['type2'] = $_POST['type2'];
            	$data['type3'] = $_POST['type3'];
	    		$data['name'] = $_POST['name'];
	    		$data["qq"] = $_POST['qq'];
	    		$data["email"] = $_POST['email'];
	    		$data['images'] = implode(",",$_POST['file']) ;
	    		$data['price'] = $_POST['price'];
	    		$data['jianjie'] = $_POST['jianjie'];
	    		$data['date'] = $_POST['date'];
	    		$data['recommend'] = $_POST['recommend'];
	    		$data['content'] = $_POST['content'];
	            $res = $Product->modifyProductById($data);
	            if($res){
	                echo json_encode(array('msg'=>1));
	            }else{
	                echo json_encode(array('msg'=>2));
	            }
	        }else{
	        	$id = $_GET['id'];
	            $p = $Product->getProductsById($id);
	            $p['image']=explode(",",$p["images"]);
	            $one = $p['type1'];
	            $two = $p['type2'];
	            $typeModel = new TypeModel();
	        	$type2 = $typeModel->getChild(1);
	        	$type3 = $typeModel->getChild($two);
	    		$this->assign("type2",$type2);
	    		$this->assign("type3",$type3);
	            $this->assign('p',$p);
	            $this->display('modify_product.html');
	        }
	        
	    }

	    /**
	     * 删除导航
	     * @return [type] [description]
	     */
	    public function delProductAction(){
	    	$id = $_POST['id'];
	        $Product = new ProductModel();
	        $res = $Product->delProductById($id);
	        if($res){
	            echo json_encode(array('msg'=>1));
	        }else{
	            echo json_encode(array('msg'=>2));
	        }
	    }

		public function upfileAction(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file').value='$path';
		                    window.opener.document.getElementById('pic').src='$imgPath';
		                    window.opener.document.getElementById('pic').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file').value='$path';
	                        window.opener.document.getElementById('pic').src='$imgPath';
	                        window.opener.document.getElementById('pic').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile.html');
	        }
	    }
	    public function upfile1Action(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file1').value='$path';
		                    window.opener.document.getElementById('pic1').src='$imgPath';
		                    window.opener.document.getElementById('pic1').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file1').value='$path';
	                        window.opener.document.getElementById('pic1').src='$imgPath';
	                        window.opener.document.getElementById('pic1').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile1.html');
	        }
	    }

	    public function upfile2Action(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file2').value='$path';
		                    window.opener.document.getElementById('pic2').src='$imgPath';
		                    window.opener.document.getElementById('pic2').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file2').value='$path';
	                        window.opener.document.getElementById('pic2').src='$imgPath';
	                        window.opener.document.getElementById('pic2').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile2.html');
	        }
	    }

	    public function upfile3Action(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file3').value='$path';
		                    window.opener.document.getElementById('pic3').src='$imgPath';
		                    window.opener.document.getElementById('pic3').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file3').value='$path';
	                        window.opener.document.getElementById('pic3').src='$imgPath';
	                        window.opener.document.getElementById('pic3').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile3.html');
	        }
	    }

	    public function upfile4Action(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file4').value='$path';
		                    window.opener.document.getElementById('pic4').src='$imgPath';
		                    window.opener.document.getElementById('pic4').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file4').value='$path';
	                        window.opener.document.getElementById('pic4').src='$imgPath';
	                        window.opener.document.getElementById('pic4').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile4.html');
	        }
	    }

	    public function upfile5Action(){
	        if(isset($_FILES['pic'])){
	            //将临时路径中的文件转移到目标路径  move_uploaded_file($oldPath,$newPath)
	            $oldPath = $_FILES['pic']['tmp_name'];
	            //新的图片文件名命名规则为:当前时间戳拼接随机数，后缀不变
	            $ext = pathinfo($_FILES['pic']['name'],PATHINFO_EXTENSION);
	            $newName = time().mt_rand().'.'.$ext;
	            $newPath = UPLOAD_PATH.date('Ymd').'/'.$newName;

	            $path = date('Ymd').'/'.$newName;
	            $imgPath = BASE_SITE.'public/uploads/'.$path;
	            // $imgPath = UPLOADS_PATH.$path;
	            if(file_exists(UPLOAD_PATH.date('Ymd'))){
	                if(move_uploaded_file($oldPath,$newPath)){
	                    echo "<script>
		                    window.opener.document.getElementById('file5').value='$path';
		                    window.opener.document.getElementById('pic5').src='$imgPath';
		                    window.opener.document.getElementById('pic5').style.display='block';
	                   
	                    window.close();
	                    </script>";
	                }else{
	                    echo "<script>alert('图片上传失败')</script>";
	                }
	            }else{
	                if(mkdir(UPLOAD_PATH.date('Ymd'))){
	                    if(move_uploaded_file($oldPath,$newPath)){
	                        echo "<script>
	                        window.opener.document.getElementById('file5').value='$path';
	                        window.opener.document.getElementById('pic5').src='$imgPath';
	                        window.opener.document.getElementById('pic5').style.display='block';
	                        window.close();
	                        </script>";
	                    }else{
	                        echo "<script>alert('图片上传失败')</script>";
	                    }
	                }else{
	                    echo "<script>alert('目录创建失败')</script>";
	                }
	            }
	        }else{
	            $this->display('upfile5.html');
	        }
	    }

	    public function fenAction(){
			$typeModel = new TypeModel();
			if(isset($_POST['id'])){
				$id = $_POST['id'];
				$child = $typeModel->getChild($id);
				echo json_encode($child );
			}
		}
	}
?>