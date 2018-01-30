<?php
class ManageModel extends Model{
    public $table = 'manage';
    
    public function userIsExists($username,$pwd=null){
        if($pwd){
            $sql = "select id from {$this->table} where name='{$username}' and pwd='{$pwd}' limit 1";
        }else{
            $sql = "select id from {$this->table} where name='{$username}' limit 1";
        }
        return $this->db->getOne($sql);
    }

    public function edit($data){
        $id = intval($data['id']);
        if($id<=0){
            return false;
        }else{
            return $this->update($data);
        }
    }

    /**
     * 查询manage表中所有的数据
     * @return $list
     */
    public function getInfo($where='',$limit=''){
        if($where !=''){
            $where = 'where '.$where;
        }
        if($limit != ''){
            $limit = 'limit '.$limit;
        }
        $sql = "select * from {$this->table} $where order by id asc {$limit}";
        return $this->db->getAll($sql);
    }
    
    public function getTotal(){
        $sql = "select count(*) as total from {$this->table}";
        return $this->db->getOne($sql);
    }
    
    public function add($data){
        if(empty($data)){
            return false;
        }else{
            return $this->insert($data);
        }
    }
    /**
     * 通过主键来查询出一条数据
     * @param unknown $id
     * @return boolean
     */
    public function getById($id){
        $id = intval($id);
        if($id<=0){
            return false;
        }else{
            return $this->selectByPk($id);
        }
    }
    
    public function delById($id){
        $id = intval($id);
        if($id<=0){
            return false;
        }else{
            return $this->delete($id);
        }
    }
    // //通过ID获取登录次数
    // public function getTimes($id){
    //     $id = intval($id);
    //     $sql = "select count() from {$this->table} where id = {$id}";
    //     return $this->db->getOne($sql);
    // }

    public function getRight($username){
        $sql = "select role_id from {$this->table} where name = '{$username}'";
        return $this->db->getOne($sql);
    }
}