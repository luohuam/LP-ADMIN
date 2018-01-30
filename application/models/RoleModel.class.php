<?php 
	class RoleModel extends Model{
		public $table = "role";

		//获取所有数据
		public function getInfo($where,$limit){
			if($where!=''){
                $where = "where ".$where;
            }
            if($limit!=''){
                $limit = "limit ".$limit;
            }
			$sql = "select * from {$this->table} $where order by id asc $limit";
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

	    //添加
	    public function add($data){
			if(empty($data)){
	            return false;
	        }else{
	            return $this->insert($data);
	        }
		}

		public function edit($data){
	        $id = intval($data['id']);
	        if($id<=0){
	            return false;
	        }else{
	            return $this->update($data);
	        }
	    }
	}
?>