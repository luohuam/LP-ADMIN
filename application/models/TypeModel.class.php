<?php 
	class TypeModel extends Model{
		public $table = "type";

		//获取所有数据
		public function getType($where,$limit){
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

	    public function getByPid($id){
	    	$id = intval($id);
	        if($id<=0){
	            return false;
	        }else{
	        	$sql = "select * from {$this->table} where pid = {$id}";
	        	return $this->db->getAll($sql);
	        }
	    }

//-----------------------------------------------------------------------------

		public function addType($data){
			if(empty($data)){
	            return false;
	        }else{
	            return $this->insert($data);
	        }
		}

		public function delTypeById($id){
			$id = intval($id);
	        if($id<=0){
	            return false;
	        }else{
	        	$sql = "select * from {$this->table} where pid = {$id}";
	        	$res = $this->db->getAll($sql);
	        	if($res){
	        		return 2;
	        	}else{
	        		return $this->delete($id);
	        	}
	        }
		}

		

	    public function modifyTypeById($data){
	        $id = intval($data['id']);
	        if($id<=0){
	            return false;
	        }else{
	            return $this->update($data);
	        }
	    }

	    //一二级
	    public function types(){
	        $sql = "select * from {$this->table} where pid in (0,1,2)";
			return $this->db->getAll($sql);
	    }
	    
	    //根据ID搜索子集
	    public function getChild($id){
	        $id = intval($id);
	        if($id<0){
	            return false;
	        }else{
	            $sql = "select * from {$this->table} where pid = {$id}";
	            return $this->db->getAll($sql); 
	        }
	    }

	    //查询父ID
	    public function check($id){
	        $sql = "select pid from {$this->table} where id={$id}";
			return $this->db->getOne($sql);
	    }
	}
?>