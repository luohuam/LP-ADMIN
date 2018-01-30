<?php 
/**
 * @name PHPPage
 * @description A simple PHP pagination class
 * @author crazymus < QQ: 291445576 >
 * @version 1.0.0
 * @licenced apache2.0
 * @updated 2015-09-11
 */
class PHPPage{
	
	protected $_page_max = 0;
	protected $_total = 0;
	protected $_limit = 10;
	protected $_p = 'p';
	protected $_split = '';

	public function __construct($total,$limit){
		$this->_page_max = ceil($total/$limit);
		$this->_total = $total;
		$this->_limit = $limit;
	}
	
	//show pages
	public function show(){
	
		$page_max = $this->_page_max;
		$url = $_SERVER['PHP_SELF'];
		
		$param = $this->_getParam();
		
		$p = isset($_GET[$this->_p])?intval($_GET[$this->_p]):1;
		$p = $p<1?1:$p;
		$p = $p>$page_max?$page_max:$p;
		
		echo '<div class="php_page" >';
		
		if($p>1){
			$last_page = $p-1;
			echo "<a href='$url?{$this->_p}=$last_page{$param}'>上页</a>";
			echo $this->_split;
		}
	
		if($p==1){
			echo '<span class="php_page_current">1</span>';
		}else{
			echo "<a href='$url?{$this->_p}=1{$param}'>1</a>";
		}
		echo $this->_split;
		
		$start = $this->_getStart($p);
		$end   = $this->_getEnd($p);
		
		if($start>2){
			echo '...';
			echo $this->_split;
		}
		
		for($i=$start;$i<=$end;$i++){
			if($p == $i){
				echo "<span class='php_page_current'>".$i.'</span>';
			}else{
				echo "<a href='$url?{$this->_p}={$i}{$param}'>".$i.'</a>';
			}
			echo $this->_split;
		}
		if($end<$page_max-1){
			echo '...';
			echo $this->_split;
		}
		
		if($page_max>1){
			if($p==$page_max){
				echo "<span class='php_page_current'>$page_max</span>";
			}else{
				echo "<a href='$url?{$this->_p}={$page_max}{$param}'>$page_max</a>";
			}
			echo $this->_split;
		}
		
		if($p<$page_max){
			$next_page = $p+1;
			echo "<a href='$url?{$this->_p}=$next_page{$param}'>下页</a>";
			echo $this->_split;
		}
		
		echo '<span class="php_page_info">';
		echo $this->_total.' 条数据,当前第 '.$p.' 页,共 '.$page_max.' 页';
		echo '</span>';
		
		echo '</div>';
	}
	
	public function setP($val){
		$this->_p = $val;
	}
	
	//private 
	private function _getStart($p){
		if($p<9){
			return 2;
		}else{
			return $p>$this->_page_max-8?$this->_page_max-8:$p;
		}
	}
	
	//private
	private function _getEnd($p){
		$start = $this->_getStart($p);
		if($p<9){
			$end = 9;
			return $end>$this->_page_max-1?$this->_page_max-1:$end;
		}else{
			$end = $p+7;
			return $end>$this->_page_max-1?$this->_page_max-1:$end;
		}
	}
	
	//save params
	private function _getParam(){
		$query_str = $_SERVER['QUERY_STRING'];
		if(!$query_str){
			return '';
		}
		$query_arr = explode('&',$query_str);
		
		$param_arr = array();
		foreach($query_arr as $query_item){
			$item = explode('=',$query_item);
			$key = $item[0];
			$value = $item[1];
			$param_arr[$key] = $key.'='.$value;
		}

		unset($param_arr[$this->_p]);
		if(empty($param_arr)){
			return '';
		}
		$param = implode('&',$param_arr);
		return '&'.$param;
	}
}
?>