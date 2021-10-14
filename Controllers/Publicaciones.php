<?php 
    require_once('Models/TCategoria.php');
    require_once('Models/TArticulo.php');
    require_once('Models/TUsuarios.php');
    require_once("Models/LoginModel.php");
    class Publicaciones extends Controllers{
        use TCategoria, TArticulo, TUsuarios;
        public $login;
        public function __construct(){
            parent::__construct();
            session_start();
            $this->login = new LoginModel();
        }

        public function categoria($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                
                $arrParams = explode(",",$params);
				$idcategoria = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoCategoria = $this->getArticulosCategoriasT($idcategoria,$ruta);

                $categoria = strClean($params);
                $data['page_tag'] = $infoCategoria['categoria']." | ".NOMBRE_EMPRESA;
			    $data['page_title'] = $infoCategoria['categoria']." | ".NOMBRE_EMPRESA;
			    $data['page_name'] = "categoria"; 
                $data['topics'] = $infoCategoria['categoria'];
                $data['random'] = $this->getArticuloRandom("",3); 
                $data['post'] = $infoCategoria['articulos']; 
                $this->views->getView($this,"categoria",$data);
            }
        }

        public function articulo($params){
            if(empty($params)){
                header("Location:".base_url());
            }else{
                
                $arrParams = explode(",",$params);
				$idarticulo = intval($arrParams[0]);
				$ruta = strClean($arrParams[1]);
				$infoArticulo = $this->getArticuloT($idarticulo,$ruta);

                if(empty($infoArticulo)){
                    header("Location:".base_url());
                }

                $data['page_tag'] = $infoArticulo['title']." | ".NOMBRE_EMPRESA;
			    $data['page_title'] = $infoArticulo['title']." | ".NOMBRE_EMPRESA;
			    $data['page_name'] = "articulo"; 
                $data['topics'] = $this->getCategoriaT(); 
                $data['random'] = $this->getArticuloRandom($infoArticulo['idtopic'],3);
                $data['post'] = $infoArticulo; 
                $data['comentarios'] = $this->getComentarios($infoArticulo['idpost']);
                $data['registros'] =$this->getRegistros($infoArticulo['idpost']);
                $this->views->getView($this,"articulo",$data);
            }
        }

        public function categorias(){
            $data['page_tag'] = "Categorías | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Categorías | ".NOMBRE_EMPRESA;
			$data['page_name'] = "categorías"; 
            $data['topics'] = $this->getCategoriasT(); 
            $this->views->getView($this,"categorias",$data);
        }

        public function suscripcion(){
            if($_POST){
                $nombre =ucwords(strClean($_POST['nameSuscripcion']));
                $email =strtolower(strClean($_POST['emailSuscripcion']));
                
                $request = $this->setSuscriptor($nombre,$email);
                
                if($request > 0){

                    $arrResponse = array('status'=> true, 'msg' => "Gracias por tu suscripción");
                    $dataUsuario = array('nombreUsuario'=> $nombre, 'email_remitente' => EMAIL_REMITENTE, 
                                        'asunto' =>'Suscripcion - '.NOMBRE_REMITENTE, 'email_usuario'=>$email);

                    $sendEmail = sendEmail($dataUsuario, 'email_suscripcion');
                }else{
                    $arrResponse = array('status'=> false, 'msg' => "El email ya está registrado");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

            }
            die();
        }
        public function nosotros(){
            $data['page_tag'] = "Nosotros | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Nosotros | ".NOMBRE_EMPRESA;
			$data['page_name'] = "nosotros"; 
            $this->views->getView($this,"nosotros",$data);
        }
        public function contacto(){
            $data['page_tag'] = "Contacto | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Contacto | ".NOMBRE_EMPRESA;
			$data['page_name'] = "contacto"; 
            $this->views->getView($this,"contacto",$data);
        }
        public function mas(){
            $data['page_tag'] = "Más | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Más | ".NOMBRE_EMPRESA;
			$data['page_name'] = "mas"; 
            $this->views->getView($this,"mas",$data);
        }
        public function mensaje(){
            if($_POST){
                $nombre =ucwords(strClean($_POST['txtNombreContacto']));
                $email =strtolower(strClean($_POST['txtEmailContacto']));
                $message = strClean($_POST['txtComentarios']);
                $userAgent = $_SERVER['HTTP_USER_AGENT'];
                $dirIp= $_SERVER['REMOTE_ADDR'];
                $dispositivo = "PC";
                if(preg_match("/mobile/i",$userAgent)){
                    $dispositivo = "Móvil";
                }else if(preg_match("/tablet/i",$userAgent)){
                    $dispositivo = "Tablet";
                }else if(preg_match("/iPhone/i",$userAgent)){
                    $dispositivo = "iPhone";
                }else if(preg_match("/iPad/i",$userAgent)){
                    $dispositivo = "iPad";
                } 
                
                $request = $this->setMensaje($nombre,$email,$message,$dirIp,$dispositivo,$userAgent);
                if($request > 0){

                    $arrResponse = array('status'=> true, 'msg' => "Su mensaje se ha enviado correctamente ");
                    $dataUsuario = array('nombreUsuario'=> $nombre, 
                                        'email_remitente' =>EMAIL_CONTACTO,
                                        'asunto' =>'Nuevo mensaje',
                                        'email_usuario'=>$email,
                                        'mensaje'=>$message,
                                        'email_copia'=>EMAIL_CONTACTO); 
                                        

                    $sendEmail = sendEmail($dataUsuario, 'email_contacto');
                }else{
                    $arrResponse = array('status'=> false, 'msg' => "No es posible enviar el mensaje");
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);

            }
            die();
        }
        public function registro(){
			if($_POST){
				if(empty($_POST['txtUsuario']) || empty($_POST['txtEmailRegister']) || empty($_POST['txtPasswordRegister'])){
					$arrResponse = array('status' => false, 'msg' => 'Error de datos' );
				}else{
					$strUsuario  =  ucwords(strClean($_POST['txtUsuario']));
					$strEmail  =  strtolower(strClean($_POST['txtEmailRegister']));
					$password = strClean($_POST['txtPasswordRegister']);
					$strPassword = hash("SHA256",$password);
                    $tipoId = 3;
					$requestUser = $this->insertUsuario($strUsuario,$strEmail,$strPassword,$tipoId);

                    if($requestUser >0){
                        $arrResponse =array('status'=> true,'msg'=>'Te has registrado correctamente.');
                        $dataUsuario = array('nombreUsuario'=> $strUsuario, 'email_remitente' => EMAIL_REMITENTE, 
                        'asunto' =>'Bienvenido a DigitalBell', 'email_usuario'=>$strEmail,'password'=>$password);

                        $_SESSION['idUser'] = $requestUser;
                        $_SESSION['login'] = true;
                        $this->login->sessionLogin($requestUser);
                        $sendEmail = sendEmail($dataUsuario, 'email_bienvenida');
                    }elseif($requestUser == 'exist'){
                        $arrResponse = array('status' => false, 'msg' => 'El email ya está registrado, inténtelo con otro.' );
                    }else{
                        $arrResponse = array('status' => false, 'msg' => 'No es posible registrarse, inténtelo más tarde' );
                    }
					
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			
			die();
		}
        public function comentario(){
            if($_POST){
                if(empty($_POST['txtComentario'])){
                    $arrResponse = array('status' => false, 'msg' => 'Error de datos' );
                }else{
                    $strComentario = strClean($_POST['txtComentario']);
                    $idpost = intval($_POST['idPost']);
                    $idperson = intval($_SESSION['userData']['id_person']);
                    $idComentario = intval($_POST['idComentario']);
                    $request ="";

                    if($idComentario == 0){
                        $option = 1;
                        $request = $this->insertComentario($idperson,$idpost,$strComentario);
                    }else{
                        $option = 2;
                        $request = $this->updateComentario($idComentario,$strComentario);
                    }

                    if($request > 0){
                        if($option == 1){
                            $arrResponse =array('status' => true, 'msg' => "Se ha publicado un nuevo comentario");
                        }elseif($option == 2){
                            $arrResponse =array('status' => true, 'msg' => "Se actualizó el comentario");
                        }else{
                            $arrResponse =array('status' => false, 'msg' => "error, inténtelo más tarde");
                        }
                    }
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        
        public function getComentario($idComentario){
            $idcomment = intval($idComentario);
            if($idcomment > 0){
                $arrData=$this->selectComentario($idcomment);
                if(empty($arrData)){
                    $arrResponse = array('status'=>false,'msg'=>'Error, inténtelo más tarde.');
                }else{
                    $arrResponse = array('status'=>true,'data'=>$arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
        public function delComentario($idcomment){
            $idComentario = intval($idcomment);
			$requestDelete = $this->deleteComentario($idComentario);
            if($requestDelete == 'ok')
            {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el comentario');
            }else{
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el comentario.');
            }
            echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            die();
        }
        
    }
?>