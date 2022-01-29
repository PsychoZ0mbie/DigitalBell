<?php 

	class LoginModel extends Mysql
	{
        private $intIdUsuario;
        private $strUsuario;
        private $strPassword;
        private $strToken;

		public function __construct()
		{
			parent::__construct();
        }	
        
        public function loginUser(string $usuario, string $password)
		{
			$this->strUsuario = $usuario;
			$this->strPassword = $password;
			$sql = "SELECT id_person,email,status FROM persona WHERE 
					email = '$this->strUsuario' and 
					password = '$this->strPassword' and 
					status != 0 ";
			$request = $this->select($sql);
			return $request;
        }
        
        public function sessionLogin(int $iduser){
            $this->intIdUsuario = $iduser;
            //BUSCAR ROL
            $sql = "SELECT p.id_person,
                            p.first_name,
                            p.picture,
                            p.phone,
                            p.address,
                            p.email,
                            p.department_id,
                            p.city_id,
                            P.type_id,
                            p.identification,
                            p.status,
                            r.idrol,
                            r.rolname,
                            b.person_id,
                            b.topic_id,
                            b.logo,
                            b.name,
                            b.keywords,
                            b.description,
                            b.phone as pcorp,
                            b.email as ecorp
                    FROM persona p
                    INNER JOIN rol r, business b 
                    WHERE p.id_person = $this->intIdUsuario AND b.person_id = p.id_person AND p.rolid = r.idrol";
            $request = $this->select($sql);
            $_SESSION['userData'] = $request;
            return $request;
        }

        public function getUserEmail(string $email){
            $this->strUsuario = $email;
            $sql = "SELECT id_person, first_name, status FROM persona WHERE
                    email='$this->strUsuario' and status=1";
            $request = $this->select($sql);
            return $request;
        }

        public function setTokenUser(int $idpersona,string $token){
            $this->intIdUsuario = $idpersona;
            $this->strToken = $token;
            $sql = "UPDATE persona SET token = ? WHERE id_person = $this->intIdUsuario";
            $arrData = array($this->strToken);
            $request = $this->update($sql,$arrData);
            return $request;
        }

        public function getUsuario(string $email, string $token){
            $this->strUsuario=$email;
            $this->strToken = $token;
            $sql ="SELECT id_person FROM persona WHERE
                    email = '$this->strUsuario' and token= '$this->strToken' and status =1";
            $request =$this->select($sql);
            return $request;
        }

        public function insertPassword(int $idpersona, string $pass){
            $this->intIdUsuario = $idpersona;
            $this->strPassword = $pass;
            $sql = "UPDATE persona SET password = ?, token = ? WHERE id_person = $this->intIdUsuario";
            $arrData = array($this->strPassword,"");
            $request = $this->update($sql,$arrData);
            return $request;
        }
	}
 ?>