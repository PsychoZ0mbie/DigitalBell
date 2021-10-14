<?php 

	class UsuariosModel extends Mysql
	{
		private $intIdUsuario;
		private $strNombre;
		private $strApellido;
		private $intTelefono;
		private $strEmail;
		private $strPassword;
		private $strToken;
		private $intTipoId;
		private $intStatus;
		private $strNit;

		public function __construct()
		{
			parent::__construct();
		}	

		public function insertUsuario(string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;
			$return = 0;

			$sql = "SELECT * FROM persona WHERE 
					email = '{$this->strEmail}' or phone = '{$this->intTelefono}'";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				$query_insert  = "INSERT INTO persona(first_name,last_name,phone,email,password,rolid,status) 
								  VALUES(?,?,?,?,?,?,?)";
	        	$arrData = array($this->strNombre,
        						$this->strApellido,
        						$this->intTelefono,
        						$this->strEmail,
        						$this->strPassword,
        						$this->intTipoId,
        						$this->intStatus);
	        	$request_insert = $this->insert($query_insert,$arrData);
	        	$return = $request_insert;
			}else{
				$return = "exist";
			}
	        return $return;
		}

		public function selectUsuarios(){
			$whereAdmin ="";
			if($_SESSION['idUser'] != 1){
				$whereAdmin = " and p.id_person !=1";
			}
			$sql = "SELECT p.id_person, p.first_name, p.last_name, p.phone, p.email, p.status, r.idrol, r.rolname
			FROM persona p
			INNER JOIN rol r
			ON p.rolid = r.idrol
			WHERE p.status != 0".$whereAdmin;
			$request = $this->select_all($sql);
			return $request;
		}
		public function selectUsuariosPicker(){
			$sql = "SELECT id_person, first_name, last_name, rolid, status FROM persona WHERE rolid != 3 AND status = 1";
			$request = $this->select_all($sql);
			return $request;
		}

		public function selectUsuario(int $idpersona){
			$this->intIdUsuario = $idpersona;
			$sql = "SELECT p.id_person,p.first_name,p.last_name,p.phone,p.email,r.idrol,r.rolname,p.status, DATE_FORMAT(p.datecreated, '%d/%m/%Y') as fechaRegistro 
					FROM persona p
					INNER JOIN rol r
					ON p.rolid = r.idrol
					WHERE p.id_person = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
		}

		public function updateUsuario(int $idUsuario, string $nombre, string $apellido, int $telefono, string $email, string $password, int $tipoid, int $status){

			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strEmail = $email;
			$this->strPassword = $password;
			$this->intTipoId = $tipoid;
			$this->intStatus = $status;

			$sql = "SELECT * FROM persona WHERE (email = '{$this->strEmail}' AND id_person != $this->intIdUsuario)";
			$request = $this->select_all($sql);

			if(empty($request))
			{
				if($this->strPassword  != "")
				{
					$sql = "UPDATE persona SET first_name=?, last_name=?, phone=?, email=?, password=?, rolid=?, status=? 
							WHERE id_person = $this->intIdUsuario ";
					$arrData = array($this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->strPassword,
	        						$this->intTipoId,
	        						$this->intStatus);
				}else{
					$sql = "UPDATE persona SET first_name=?, last_name=?, phone=?, email=?, rolid=?, status=? 
							WHERE id_person = $this->intIdUsuario ";
					$arrData = array($this->strNombre,
	        						$this->strApellido,
	        						$this->intTelefono,
	        						$this->strEmail,
	        						$this->intTipoId,
	        						$this->intStatus);
				}
				$request = $this->update($sql,$arrData);
			}else{
				$request = "exist";
			}
			return $request;
		
		}

		public function deleteUsuario(int $intIdpersona)
		{
			$this->intIdUsuario = $intIdpersona;
			$sql = "DELETE FROM persona WHERE id_person = $this->intIdUsuario;set @autoid :=0; 
			update persona set id_person = @autoid := (@autoid+1);
			alter table persona Auto_Increment = 1";
			$request = $this->delete($sql);
			return $request;
		}

		public function updatePerfil(int $idUsuario, string $nombre, string $apellido, int $telefono, string $password){
			$this->intIdUsuario = $idUsuario;
			$this->strNombre = $nombre;
			$this->strApellido = $apellido;
			$this->intTelefono = $telefono;
			$this->strPassword = $password;

			if($this->strPassword != ""){
				$sql = "UPDATE persona SET first_name=?, last_name=?, phone=?, password=?
						WHERE id_person = $this->intIdUsuario";
				$arrData = array($this->strNombre,$this->strApellido,$this->intTelefono,$this->strPassword);

			}else{
				$sql = "UPDATE persona SET first_name=?, last_name=?, phone=?
						WHERE id_person = $this->intIdUsuario";
				$arrData = array($this->strNombre,$this->strApellido,$this->intTelefono);
			}
			$request = $this->update($sql,$arrData);
			return $request;
		}
	}
 ?>