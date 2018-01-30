<?php 
	class IndexController extends Controller{
		public function indexAction(){
			header("Location:".ADMIN_SITE."Index/login");
		}

	}
?>