<?php 
	class NewsModel extends Model{
		public $table = "news";
		//根据类型获取相关新闻
		public function getNews($where,$limit=''){
	        if($where != ''){
	            $where = 'where '.$where;
	        }
	        if($limit != ''){
	            $limit = 'limit '.$limit;
	        }

			$sql = "select * from {$this->table} {$where} order by num asc {$limit} ";
			
			return $this->db->getAll($sql);
		}

		//获取总数
		public function getTotal($where){
	        if($where != ''){
	            $where = 'where '.$where;
	        }
			$sql = "select count(*) from {$this->table} {$where} order by created desc";
			return $this->db->getOne($sql);
		}

		//首页推荐新闻
		public function getTui($limit,$where){
			if($limit != ''){
	            $limit = 'limit '.$limit;
	        }
	        if ($where!="") {
	        	$where = "and ".$where;
	        }
			$sql = "select * from {$this->table} where recommend=1 {$where} order by created desc {$limit}";
			return $this->db->getAll($sql);
		}

		//根据ID删除
		public function delNewsById($id){
			$id = intval($id);
	        if($id<=0){
	            return false;
	        }else{
	            return $this->delete($id);
	        }
		}

		//根据ID修改
		public function modifyNewsById($data){
	        if($data['id']<=0){
	            return false;
	        }else{
	            return $this->update($data);
	        }
	    }

	    //添加新闻
	    public function addNews($data){
			if(empty($data)){
	            return false;
	        }else{
	            return $this->insert($data);
	        }
		}

		//根据ID获取对应新闻
		public function getNewById($id){
			$where = "";
	        if($id != ''){
	            $where = 'where id='.$id;
	        }

			$sql = "select * from {$this->table} {$where}";
			
			return $this->db->getAll($sql);
		}

		//获取最新编号
		public function newNum(){
			$sql = "select num from {$this->table} order by num desc limit 1";
			return $this->db->getOne($sql);
		}

		//获取第$i个编号
		public function getNum($i){
			$sql = "select num from {$this->table} order by num asc limit {$i},1";
			return $this->db->getOne($sql);
		}

		//根据ID获取编号
		public function getNumByID($id){
			$sql = "select num from {$this->table} where id = {$id}";
			return $this->db->getOne($sql);
		}

		//更新编号
		public function updataNum($cur,$next){
			$sql = "UPDATE `{$this->table}` SET num = {$cur} where num = {$next}";
			$this->db->query($sql);
		}

	}
?>