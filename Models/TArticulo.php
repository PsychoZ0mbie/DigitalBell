<?php
    require_once("Libraries/Core/Mysql.php");
    
    trait TArticulo{
        private $con;
        private $strRuta;
        private $strCategoria;
        private $intIdCategoria;
        private $intIdPost;
        private $cant;

        public function getArticulosT(){
            $this->con = new Mysql();
            $sql = "SELECT p.person_id,p.idpost,p.topics_id,p.description, p.title, DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date, p.image, p.route, p.status, t.idtopic, 
                            t.name as categoria, e.id_person,e.first_name, e.last_name 
                    FROM post p
                    INNER JOIN topics t, persona e
                    WHERE p.topics_id = t.idtopic AND p.person_id = e.id_person AND p.status = 1
                    ORDER BY p.idpost DESC limit 1,4";
            $request = $this->con->select_all($sql);
            if(count($request)>0){
                for ($c=0; $c < count($request) ; $c++) { 
                    if(filter_var($request[$c]['image'],FILTER_VALIDATE_URL) == false){
                        $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                    }
                }
            }
            return $request;
        }

        public function getArticulosCategoriasT(int $idcategoria, string $ruta){
            $this->con = new Mysql();
            $this->intIdCategoria = $idcategoria;
            $this->strRuta = $ruta;
            $sql_cat = "SELECT idtopic, name FROM topics WHERE idtopic = '{$this->intIdCategoria}'";
            $request = $this->con->select($sql_cat);

            if(!empty($request)){
                $this->strCategoria = $request['name'];
                $sql = "SELECT p.person_id,p.idpost,p.topics_id,p.description, p.title, DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date, p.image, p.route, p.status, t.idtopic, 
                                t.name as categoria, e.id_person,e.first_name, e.last_name 
                        FROM post p
                        INNER JOIN topics t, persona e

                        WHERE t.idtopic = $this->intIdCategoria AND t.idtopic = topics_id AND p.person_id = e.id_person AND p.status =1
                        ORDER BY p.idpost DESC";
                $request = $this->con->select_all($sql);
                if(count($request)>0){
                    for ($c=0; $c < count($request) ; $c++) { 
                        if(filter_var($request[$c]['image'],FILTER_VALIDATE_URL) == false){
                            $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                        }
                    }
                }
            $request = array('idtopic' => $this->intIdCategoria, 'categoria' => $this->strCategoria,'articulos'=> $request);
            }
            return $request;
        }

        public function getArticuloT(int $idArticulo, string $ruta){
			//BUSCAR CATEGORIA
            $this->con = new Mysql();
            $this->strRuta = $ruta;
			$this->intIdPost = $idArticulo;
			$sql = "SELECT p.idpost, 
                    p.person_id, 
                    p.topics_id, 
                    u.id_person, 
                    t.idtopic, 
                    p.title, 
                    p.description,
                    concat(u.first_name,' ',u.last_name) as autor, 
                    DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date,
                    p.image, 
                    p.status, 
                    t.name as categoria,
                    p.route
            from post p
            inner join persona u, topics t
            where p.topics_id = t.idtopic and u.id_person = p.person_id and p.idpost=$this->intIdPost and p.route = '{$this->strRuta}'";
			$request = $this->con->select($sql);
            if(filter_var($request['image'],FILTER_VALIDATE_URL)== false){
                $request['image'] = BASE_URL.'/Assets/images/uploads/'.$request['image'];
            }
			return $request;
		}

        public function getArticuloRandom($idcategoria, int $cant){
            $this->con = new Mysql();
            $this->intIdCategoria = $idcategoria;
			$this->cant = $cant;

            if($this->intIdCategoria != ""){
                $this->intIdCategoria = " AND t.idtopic = $this->intIdCategoria";
            }

            $this->con = new Mysql();
            $sql = "SELECT p.person_id,p.idpost,p.topics_id,p.description, p.title, DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date, p.image, p.route, p.status, t.idtopic, 
                            t.name as categoria, e.id_person,e.first_name, e.last_name 
                    FROM post p
                    INNER JOIN topics t, persona e
                    WHERE p.topics_id = t.idtopic AND p.person_id = e.id_person  AND p.status =1 $this->intIdCategoria
                    ORDER BY RAND() limit $this->cant";

            $request = $this->con->select_all($sql);
            if(count($request)>0){
                for ($c=0; $c < count($request) ; $c++) { 
                    if(filter_var($request[$c]['image'],FILTER_VALIDATE_URL) == false){
                        $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                    }
                }
            }
            return $request;
        }

        public function getArticuloBanner(){
            $this->con = new Mysql();
            $sql = "SELECT p.person_id,p.idpost,p.topics_id,p.description, p.title, DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date, p.image, p.route, p.status, t.idtopic, 
                            t.name as categoria, e.id_person,e.first_name, e.last_name 
                    FROM post p
                    INNER JOIN topics t, persona e
                    WHERE p.topics_id = t.idtopic AND p.person_id = e.id_person AND p.status =1
                    ORDER BY p.idpost DESC limit 1";

            $request = $this->con->select($sql);
            if(filter_var($request['image'],FILTER_VALIDATE_URL) == false){
                $request['image'] = BASE_URL.'/Assets/images/uploads/'.$request['image'];
            }
            return $request;
        }
    }
?>