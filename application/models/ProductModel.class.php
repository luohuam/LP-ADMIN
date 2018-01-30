<?php 
      class ProductModel extends Model{
        public $table = "product";
        public $table2 = "type";

        //查询一级分类
        public function getTypes(){
            $sql = "SELECT * from {$this->table2} WHERE pid = 0";
            return $this->db->getAll($sql);
        }

        public function getList(){
            $sql = "SELECT * from {$this->table2} WHERE pid != 0";
            return $this->db->getAll($sql);
        }

        public function getTypeList(){
            $sql = "SELECT * from {$this->table2}";
            return $this->db->getAll($sql);
        }

        //查询所有商品
        public function getProducts($where,$limit){
            if($where!=''){
                $where = "where ".$where;
            }
            if($limit!=''){
                $limit = "limit ".$limit;
            }
            $sql = "SELECT * from {$this->table} $where order by recommend desc,created desc $limit";
            return $this->db->getAll($sql);
        }

        //查询所有商品
        public function getPp($where,$limit){
            if($where!=''){
                $where = "where ".$where;
            }
            if($limit!=''){
                $limit = "limit ".$limit;
            }
            $sql = "SELECT * from {$this->table} $where order by created desc $limit";
            return $this->db->getAll($sql);
        }

        public function getPro($name,$id){
            if($id != "" && $name==""){
                $sql = "SELECT * from {$this->table} where $id ";
            }
            if($name !="" && $id==""){
                $sql = "SELECT * from {$this->table} where $name ";
            }
            if($id!="" && $name!=""){
                $sql = "SELECT * from {$this->table} where $id and $name";
            }
            
            return $this->db->getAll($sql);
        }

         //根据ID查询对应的小分类
         public function getLi($id){
            $sql = "select * from {$this->table2} where pid=$id";
            return $this->db->getAll($sql);
         }


         //默认显示的小分类
         public function getMo($id){
            $sql = "select * from {$this->table2} where pid=$id limit 1";
            return $this->db->getAll($sql);
         }

         //根据PID查询对应的商品
         public function getBypid($id){
            $sql = "select * from {$this->table} where type3=$id limit 7";
            return $this->db->getAll($sql);
         }

         public function getBypk($id){
            $sql = "select * from {$this->table} where id=$id";
            return $this->db->getAll($sql);
         }

         //总数
         public function getTotal($where){
            if($where!=''){
                $where = "where ".$where;
            }
            $sql = "select count(*) from {$this->table} $where";
            return $this->db->getOne($sql);
        }

        public function delProductById($id){
            $id = intval($id);
            if($id<=0){
                return false;
            }else{
                return $this->delete($id);
            }
        }

        public function addProduct($data){
            if(empty($data)){
                return false;
            }else{
                return $this->insert($data);
            }
        }

        public function types(){
            $sql = "select * from {$this->table2} where pid in (1,2)";
            return $this->db->getAll($sql);
        }

        public function getProductsById($id){
            $id = intval($id);
            if($id<=0){
                return false;
            }else{
                return $this->selectByPk($id);
            }
        }

        public function modifyProductById($data){
            $id = intval($data['id']);
            if($id<=0){
                return false;
            }else{
                return $this->update($data);
            }
        }

        public function tt(){
            $sql = "select * from {$this->table2} where pid!=0 and pid!=1 and pid!=2";
            return $this->db->getAll($sql);
        }

        public function getP(){
            $sql = "SELECT * from {$this->table} p LEFT JOIN {$this->table2} t ON p.type2=t.id where p.recommend=1 order by created desc";
            return $this->db->getAll($sql);
        }

        public function getPd(){
            $sql = "SELECT * from {$this->table} where recommend=1 order by created desc";
            return $this->db->getAll($sql);
        }

        public function li($id){
            $sql = "select * from {$this->table2} where pid=$id and recommend=1";
            return $this->db->getAll($sql);
        }

        public function getPid($id){
            $sql = "select pid from {$this->table2} where id=$id";
            return $this->db->getOne($sql);
        }

    }
?>