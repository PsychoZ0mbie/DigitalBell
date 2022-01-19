<?php 

	class ArticulosModel extends Mysql{
	
        public $intIdPost;
        public $intNombre;
        public $intCategoria;
        public $strTitulo;
        public $strTituloC;
        public $strDescripcion;
        public $intStatus;
        public $strPortada;
        public $strRuta;
        public $intIdTag;

		public function __construct(){
		
			parent::__construct();
		}	
        public function insertArticulo($nombre, $categoria,$titulo,$tituloC,$descripcion,$ruta,$status){
    
            $return = "";
            $this->intNombre = $nombre;
            $this->intCategoria = $categoria;
            $this->strTitulo = $titulo;
            $this->strTituloC = $tituloC;
            $this->strDescripcion = $descripcion;
            //$this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM post WHERE title = '{$this->strTitulo}' AND titlec = '{$this->strTituloC}' AND person_id = $this->intNombre";
            $request = $this->select_all($sql);
    
            if(empty($request)){
                $query_insert  = "INSERT INTO post(person_id,topics_id,title,titlec,description,route,status) VALUES(?,?,?,?,?,?,?)";
                $arrData = array($this->intNombre, $this->intCategoria, $this->strTitulo,$this->strTituloC, $this->strDescripcion,$this->strRuta, $this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateArticulo($idpost, $categoria,$titulo,$tituloC, $descripcion,$ruta,$status){
            
            $this->intIdPost = $idpost;
            $this->intCategoria = $categoria;
            $this->strTitulo = $titulo;
            $this->strTituloC = $tituloC;
            $this->strDescripcion = $descripcion;
            //$this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM post WHERE title ='{$this->strTitulo}' AND idpost != $this->intIdPost";
            $request = $this->select_all($sql);
    
            if(empty($request)){
            
                $sql = "UPDATE post SET topics_id=?, title=?,titlec=? description=?, route=?, status=? WHERE idpost = $this->intIdPost";
                $arrData = array($this->intCategoria,
                                $this->strTitulo,
                                $this->strTituloC,
                                $this->strDescripcion,
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

        public function selectArticulos(int $id,int $user){
            if($id == 1){
                $post ="AND u.id_person = p.person_id";
            }else{
                $post ="AND u.id_person = p.person_id AND u.id_person = $user";
            }

            $sql = "SELECT 
            p.idpost,
            p.title, 
            p.titlec,
            p.person_id, 
            p.topics_id, 
            p.status,
            p.route,
            DATE_FORMAT(p.datecreated, '%Y-%m-%d') as date, 
            u.id_person, 
            u.first_name, 
            t.idtopic, 
            t.name as categoria
            FROM post p
            INNER JOIN persona u, topics t
            WHERE p.topics_id = t.idtopic  AND p.status !=0 $post";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectPapelera(int $id,int $user){
            if($id == 1){
                $post ="AND u.id_person = p.person_id";
            }else{
                $post ="AND u.id_person = p.person_id AND u.id_person = $user";
            }

            $sql = "SELECT 
            p.idpost,
            p.title, 
            p.titlec,
            p.person_id, 
            p.topics_id, 
            p.status,
            p.route,
            DATE_FORMAT(p.datecreated, '%Y-%m-%d') as date, 
            u.id_person, 
            u.first_name, 
            t.idtopic, 
            t.name as categoria
            from post p
            inner join persona u, topics t
            where p.topics_id = t.idtopic  AND p.status = 0 $post";
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
                    t.idtopic, 
                    p.title, 
                    p.titlec,
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
        public function recovery($idArticulo){
            $this->intIdPost = $idArticulo;
            $sql="UPDATE post SET status = ? WHERE idpost = $this->intIdPost";
            $array = array(2);
            $request = $this->update($sql,$array);
            return $request;
        }
        public function deleteRecoveryInfo($idArticulo){
            $this->intIdPost = $idArticulo;
            $sql = "DELETE FROM post WHERE idpost = $this->intIdPost";
            $request = $this->delete($sql);
            return $request;
        }

        public function insertImage(int $idpost, string $imagen){
			$this->intIdPost = $idpost;
			$this->strPortada = $imagen;
			$query_insert  = "INSERT INTO image(post_id,name) VALUES(?,?)";
	        $arrData = array($this->intIdPost,
                            $this->strPortada);
	        $request_insert = $this->insert($query_insert,$arrData);
	        return $request_insert;
		}
        public function deleteImage(int $idpost, string $imagen){
			$this->intIdPost = $idpost;
			$this->strPortada = $imagen;
			$query  = "DELETE FROM image 
						WHERE post_id = $this->intIdPost
						AND name = '{$this->strPortada}'";
	        $request_delete = $this->delete($query);
	        return $request_delete;
		}
        public function selectImage($idpost){
            $sql = "SELECT * FROM image WHERE post_id = $idpost";
            $query = $this->select_all($sql);
            return $query;
        }
        public function insertTag($name){
            $sql="SELECT * FROM tag WHERE title = '$name'";
            $query = $this->select_all($sql);
            if(empty($query)){
                $query_insert = "INSERT INTO tag(title) VALUES (?)";
                $arrData = array($name);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }
        public function selectTags(){
            $sql="SELECT * FROM tag ORDER BY title";
            $query= $this->select_all($sql);
            return $query;
        }
        public function selectTag($idpost){
            $sql = "SELECT p.tag_id, 
                            t.id, 
                            t.title 
                    FROM posttag p
                    INNER JOIN tag t
                    WHERE p.post_id=$idpost AND p.tag_id = t.id";
            $query = $this->select_all($sql);
            return $query;
        }
        public function insertSelectTag($idArticulo,$idtag){
            $this->intIdPost = $idArticulo;
            $this->intIdTag = $idtag;

            $sql = "SELECT * FROM posttag WHERE tag_id = $this->intIdTag AND post_id = $this->intIdPost";
            $query = $this->select_all($sql);

            if(empty($query)){
                $query_insert = "INSERT INTO posttag(tag_id,post_id) VALUES (?,?)";
                $arrData = array($this->intIdTag,$this->intIdPost);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return ="exist";
            }
            return $return;
        }
        public function deleteTag($idArticulo,$idtag){
            $this->intIdPost = $idArticulo;
            $this->intIdTag = $idtag;
            $sql = "DELETE FROM posttag WHERE tag_id = $this->intIdTag AND post_id = $this->intIdPost";
            $request = $this->delete($sql);
            return $request;
        }
	}


    
 ?>