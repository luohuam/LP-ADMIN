<?php 
header("Content-type:text/html;charset=utf-8");
	//可以把下面的方法直接拿到对应控制器中使用，或者直接调用该类
	class sendMesController extends Controller{
		public function sendAction(){
	    	if(!empty($_POST)){
	    		$mobile=$_POST["phone"];
	    		
	    		$code = rand(100000,999999);
	    		$code=(string)($code);
	    		 
	    		$message = new SmsDemo();
	    		$ret=$message->sendSms("签名","SMS_107435217",$mobile,array("code"=>$code,'product'=>"test"),"");

	    		echo json_encode(array('msg'=>1,'code'=>$code));
	    	}
	    }
	}
?>
