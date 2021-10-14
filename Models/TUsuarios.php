<?php
    require_once("Libraries/Core/Mysql.php");
    
    trait TUsuarios{
        private $con;
        private $strNombre;
        private $strEmail;
        private $strMensaje;
        private $strIp;
        private $strDispositivo;
        private $strUserAgent;
        private $intIdRol;
        private $strPassword;

        public function setSuscriptor($nombre,$email){
            $this->con = new Mysql();
            $this->strNombre = $nombre;
            $this->strEmail = $email;
            $sql = "SELECT * FROM suscriptions WHERE email='$this->strEmail'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                $query_insert = "INSERT INTO suscriptions (name,email)
                        VALUES (?,?)";
                $arrData = array($this->strNombre,$this->strEmail);
                $request_insert = $this->con->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = false;
            }
            return $return;
        }

        public function insertUsuario($usuario,$email,$password,$tipoId){
            $this->con = new Mysql();
            $this->strNombre = $usuario;
            $this->strEmail = $email;
            $this->strPassword = $password;
            $this->intIdRol = $tipoId;
            $sql ="SELECT * FROM persona WHERE email ='$this->strEmail'";
            $request = $this->con->select_all($sql);
            if(empty($request)){
                $query_insert ="INSERT INTO persona (first_name, email, password, rolid)
                                VALUES (?,?,?,?)";
                $arrData =array($this->strNombre,
                                $this->strEmail,
                                $this->strPassword,
                                $this->intIdRol);
                $request_insert = $this->con->insert($query_insert,$arrData);
                $return = $request_insert;
            }else{
                $return = 'exist';
            }
            return $return;
        }

        public function setMensaje($nombre,$email,$message,$dirIp,$dispositivo,$userAgent){
            $this->con = new Mysql();
            $this->strNombre = $nombre;
            $this->strEmail = $email;
            $this->strMensaje = $message;
            $this->strIp = $dirIp;
            $this->strDispositivo = $dispositivo;
            $this->strUserAgent = $userAgent;
            $query_insert = "INSERT INTO contact (name,email,message,ip,device,useragent)
                    VALUES (?,?,?,?,?,?)";
            $arrData = array($this->strNombre,
                            $this->strEmail,
                            $this->strMensaje,
                            $this->strIp,
                            $this->strDispositivo,
                            $this->strUserAgent);
            $request_insert = $this->con->insert($query_insert,$arrData);

            return $request_insert;
        }
        public function insertComentario($idperson,$idpost,$strComentario){
            $this->con = new Mysql();
            $query_insert = "INSERT INTO comment (person_id, post_id, comment)
                            VALUES(?,?,?)";
            $arrData = array($idperson,$idpost,$strComentario);
            $request_insert =$this->con->insert($query_insert,$arrData);
            return $request_insert;
        }

        public function updateComentario($idcomentario,$strComentario){
            $this->con = new Mysql();
            $query_update = "UPDATE comment SET comment=? WHERE idcomment = $idcomentario";
            $arrData = array($strComentario);
            $request_update =$this->con->update($query_update,$arrData);
            return $request_update;
        }
        public function deleteComentario($idComentario){
            $this->con = new Mysql();
			$sql = "DELETE FROM comment WHERE idcomment = $idComentario;set @autoid :=0; 
			update comment set idcomment = @autoid := (@autoid+1);
			alter table comment Auto_Increment = 1";
			$request = $this->con->delete($sql);
			return $request;
		}
        public function getComentarios($idpost){
            $this->con = new Mysql();
            $sql ="SELECT c.idcomment, 
                        c.person_id, 
                        c.post_id, 
                        p.rolid, 
                        r.idrol, 
                        r.rolname, 
                        c.comment, 
                        p.id_person, 
                        p.first_name, 
                        p.last_name, 
                        DATE_FORMAT(c.datecreated, '%d/%b/%Y') as date 
            FROM comment c 
            INNER JOIN persona p, rol r 
            WHERE c.person_id = id_person AND c.post_id = $idpost AND p.rolid = r.idrol 
            ORDER BY idcomment DESC";
            $request = $this->con->select_all($sql);
            return $request;
        }
        public function getRegistros($idpost){
            $this->con = new Mysql();
            $sql ="SELECT COUNT(*) as registros
            FROM comment c
            WHERE post_id = $idpost";
            $request = $this->con->select($sql);
            $return = $request['registros'];
            return $return;
        }
        public function selectComentario($id){
            $this->con = new Mysql();
            $sql = "SELECT * FROM comment WHERE idcomment = $id";
            $request = $this->con->select($sql);
            return $request;
        }
    }
?>