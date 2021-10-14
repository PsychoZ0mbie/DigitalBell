<?php 

	class ArticulosModel extends Mysql{
	
        public $intIdPost;
        public $intNombre;
        public $intCategoria;
        public $strTitulo;
        public $strDescripcion;
        public $intStatus;
        public $strPortada;
        public $strRuta;

		public function __construct(){
		
			parent::__construct();
		}	
        public function insertArticulo($nombre, $categoria,$titulo, $descripcion,$portada,$ruta,$status){
    
            $return = "";
            $this->intNombre = $nombre;
            $this->intCategoria = $categoria;
            $this->strTitulo = $titulo;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM post WHERE title = '{$this->strTitulo}' ";
            $request = $this->select_all($sql);
    
            if(empty($request)){
                $query_insert  = "INSERT INTO post(person_id,topics_id,title,description,image,route,status) VALUES(?,?,?,?,?,?,?)";
                $arrData = array($this->intNombre, $this->intCategoria, $this->strTitulo, $this->strDescripcion, $this->strPortada,$this->strRuta, $this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateArticulo($idpost, $categoria,$titulo, $descripcion,$portada,$ruta,$status){
            
            $this->intIdPost = $idpost;
            $this->intCategoria = $categoria;
            $this->strTitulo = $titulo;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM post WHERE title ='{$this->strTitulo}' AND idpost != $this->intIdPost";
            $request = $this->select_all($sql);
    
            if(empty($request)){
            
                $sql = "UPDATE post SET topics_id=?, title=?, description=?, image=?,route=?, status=? WHERE idpost = $this->intIdPost";
                $arrData = array($this->intCategoria,
                                $this->strTitulo,
                                $this->strDescripcion,
                                $this->strPortada,
                                $this->strRuta,
                                $this->intStatus
                                    );
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteArticulo(int $idarticulo){
			$this->intIdPost = $idarticulo;
			$sql = "UPDATE post SET status = ? WHERE idpost = $this->intIdPost";
			$arrData = array(0);
			$request = $this->update($sql,$arrData);
			return $request;
		}

        public function selectArticulos(){

            $sql = "SELECT 
            p.idpost,
            p.title, 
            p.person_id, 
            p.topics_id, 
            p.status,
            DATE_FORMAT(p.datecreated, '%d/%b/%Y') as date, 
            u.id_person, 
            concat(u.first_name,' ',u.last_name) as autor, 
            t.idtopic, 
            t.name as categoria
            from post p
            inner join persona u, topics t
            where p.topics_id = t.idtopic and u.id_person = p.person_id AND p.status !=0";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectArticulo(int $idArticulo){
			//BUSCAR CATEGORIA
			$this->intIdPost = $idArticulo;
			$sql = "SELECT p.idpost, 
                    p.person_id, 
                    p.topics_id, 
                    u.id_person, 
                    t.idtopic, p.title, 
                    p.description,concat(u.first_name,' ',u.last_name) as autor, 
                    p.image, 
                    p.status,
                    p.route,
                    DATE_FORMAT(p.datecreated, '%d/%b/%Y %r') as date, 
                    t.name as categoria
            from post p
            inner join persona u, topics t
            where p.topics_id = t.idtopic and u.id_person = p.person_id and p.idpost=$this->intIdPost";
			$request = $this->select($sql);
			return $request;
		}
	}


    
 ?>