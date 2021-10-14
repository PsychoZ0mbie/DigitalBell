<?php 

	class RolesModel extends Mysql
	{
        public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
		public function __construct()
		{
			parent::__construct();
		}
        
        public function selectRoles(){
			$whereAdmin = "";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and idrol !=1";
			}
            $sql ="SELECT * FROM rol WHERE status != 0".$whereAdmin;
            $request = $this->select_all($sql);
            return $request;
        }

        public function insertRol(string $rol, string $descripcion, int $status){

			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE rolname = '{$this->strRol}' ";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO rol(rolname,description,status) VALUES(?,?,?)";
	        	$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
			return $return;
		}

        public function updateRol(int $idrol, string $rol, string $descripcion, int $status){
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE rolname = '$this->strRol' AND idrol != $this->intIdrol";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$sql = "UPDATE rol SET rolname = ?, description = ?, status = ? WHERE idrol = $this->intIdrol ";
				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
		    return $request;			
		}
        public function deleteRol(int $idrol){
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM persona WHERE rolid = $this->intIdrol";
			$request = $this->select_all($sql);
			if(empty($request))
			{
				$sql = "DELETE FROM rol WHERE idrol = $this->intIdrol;set @autoid :=0; 
				update rol set idrol = @autoid := (@autoid+1);
				alter table rol Auto_Increment = 1";
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

        public function selectRol($idrol){ 
		  
			//BUSCAR ROLE
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}
	}
 ?>