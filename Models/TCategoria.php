<?php
    require_once("Libraries/Core/Mysql.php");
    
    trait TCategoria{
        private $con;
        private $strRuta;
        private $intIdCategoria;

        public function getCategoriaT(){
            $this->con = new Mysql();
            $sql = "SELECT t.idtopic, t.name, t.image, t.route,p.topics_id, COUNT(p.topics_id) as registros 
                    FROM post p 
                    INNER JOIN topics t 
                    WHERE t.idtopic = p.topics_id AND p.status =1
                    group by topics_id
                    ORDER BY registros DESC LIMIT 5";

            $request = $this->con->select_all($sql);

            /*if(count($request)>0){
                for ($c=0; $c < count($request) ; $c++) { 
                    $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                }
            }*/
            return $request;
        }

        public function getCategoriasT(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM topics 
                    WHERE status = 1
                    ORDER BY name";

            $request = $this->con->select_all($sql);

            /*if(count($request)>0){
                for ($c=0; $c < count($request) ; $c++) { 
                    $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                }
            }*/
            return $request;
        }
    }
?>