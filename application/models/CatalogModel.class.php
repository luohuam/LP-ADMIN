<?php 
	class CatalogModel extends Model{
		public $table = "catalog";

		//获取所有数据
		public function getInfo($where,$limit){
			if($where!=''){
                $where = "where ".$where;
            }
            if($limit!=''){
                $limit = "limit ".$limit;
            }
			$sql = "select * from {$this->table} $where order by pid asc,id asc $limit";
			return $this->db->getAll($sql);
		}

		//获取总数
		public function getTotal(){
			$sql = "select count(*) from {$this->table}";
			return $this->db->getOne($sql);
		}

		//根据ID删除
		public function delById($id){
			$id = intval($id);
	        if($id<=0){
	            return false;
	        }else{
	        	return $this->delete($id);
	        }
		}

		//根据ID查询
		public function getById($id){
	        $id = intval($id);
	        if($id<=0){
	            return false;
	        }else{
	            return $this->selectByPk($id);
	        }
	    }

	    //根据父id查询信息
	    public function getByPid($id){
	    	$id = intval($id);
	        if($id<0){
	            return false;
	        }else{
	        	$sql = "select * from {$this->table} where pid = {$id} order by id asc";
	        	return $this->db->getAll($sql);
	        }
	    }

	    //添加菜单
	    public function add($data){
			if(empty($data)){
	            return false;
	        }else{
	            return $this->insert($data);
	        }
		}

		public function editById($data){
	        $id = intval($data['id']);
	        if($id<=0){
	            return false;
	        }else{
	            return $this->update($data);
	        }
	    }

	    //根据ID查询PID
	    public function getIdByPid($id){
	        $sql = "select pid from {$this->table} where id={$id}";
			return $this->db->getOne($sql);
	    }
	}
?>