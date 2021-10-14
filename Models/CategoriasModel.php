<?php 

	class CategoriasModel extends Mysql
	{
        public $intIdcategoria;
        public $strCategoria;
        public $strDescripcion;
        public $intStatus;
        public $strPortada;
        public $strRuta;

		public function __construct(){
		
			parent::__construct();
		}	
        public function insertCategoria($categoria, $descripcion,$portada,$ruta, $status){
    
            $return = "";
            $this->strCategoria = $categoria;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM topics WHERE name = '{$this->strCategoria}' ";
            $request = $this->select_all($sql);
    
            if(empty($request))
            {
                $query_insert  = "INSERT INTO topics(name,description,image,route,status) VALUES(?,?,?,?,?)";
                $arrData = array($this->strCategoria, $this->strDescripcion, $this->strPortada,$this->strRuta, $this->intStatus);
                $request_insert = $this->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = "exist";
            }
            return $return;
        }

        public function updateCategoria(int $idCategoria, string $categoria, string $descripcion, string $portada,string $ruta, int $status){

            $this->intIdcategoria = $idCategoria;
            $this->strCategoria = $categoria;
            $this->strDescripcion = $descripcion;
            $this->strPortada = $portada;
            $this->strRuta = $ruta;
            $this->intStatus = $status;
    
            $sql = "SELECT * FROM topics WHERE name ='{$this->strCategoria}' AND idtopic != $this->intIdcategoria";
            $request = $this->select_all($sql);
    
            if(empty($request)){
            
                $sql = "UPDATE topics SET name=?, description=?, image=?,route=?, status=? WHERE idtopic = $this->intIdcategoria";
                $arrData = array($this->strCategoria,
                                $this->strDescripcion,
                                $this->strPortada,
                                $this->strRuta,
                                $this->intStatus,
                                    );
                $request = $this->update($sql,$arrData);
            }else{
                $request = "exist";
            }
            return $request;
        }

        public function deleteCategoria(int $idcategoria){
		
			$this->intIdcategoria = $idcategoria;
			$sql = "SELECT * FROM post WHERE topics_id = $this->intIdcategoria";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "DELETE FROM topics WHERE idtopic = $this->intIdcategoria;set @autoid :=0; 
                update topics set idtopic = @autoid := (@autoid+1);
                alter table topics Auto_Increment = 1;";
				$request = $this->delete($sql);
				if($request)
				{
					$request = 'ok';	
				}else{
					$request = 'error';
				}
			}else{
				$request = 'exist';
			}
			return $request;
		}

        public function selectCategorias(){

            $sql = "SELECT * FROM topics";
            $request = $this->select_all($sql);
            return $request;
        }

        public function selectCategoria(int $idCategoria){
			//BUSCAR CATEGORIA
			$this->intIdCategoria = $idCategoria;
			$sql = "SELECT * FROM topics WHERE idtopic = $this->intIdCategoria";
			$request = $this->select($sql);
			return $request;
		}

        public function getCategoriasFooter(){
            $this->con = new Mysql();
            $sql = "SELECT * FROM topics WHERE status != 2 LIMIT 5";

            $request = $this->con->select_all($sql);

            if(count($request)>0){
                for ($c=0; $c < count($request) ; $c++) { 
                    $request[$c]['image'] = BASE_URL.'/Assets/images/uploads/'.$request[$c]['image'];
                }
            }
            return $request;
        }
	}


    
 ?>