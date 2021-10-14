<?php 
    require_once("Models/TUsuarios.php");
    class Contacto extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
				die();
			}
			getPermisos(8);
        }

        public function contacto(){
            if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
            $data['page_tag'] = "Mensajes | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Mensajes | ".NOMBRE_EMPRESA;
			$data['page_name'] = "mensajes"; 
            $data['page_functions'] = "functions_contacto.js";
            $this->views->getView($this,"contacto",$data);
        }

        public function getContactos(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectContactos();
                for ($i=0; $i < count($arrData); $i++) {
	
					$btnView = '';
	
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewMensaje" onClick="fntViewMensaje('.$arrData[$i]['idcontact'].')" title="Ver mensaje"><i class="far fa-eye"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function getContacto($idcontacto){
            if($_SESSION['permisosMod']['r']){
                if($idcontacto>0){
                    $arrData = $this->model->selectContacto($idcontacto);
                }
                if(empty($arrData)){
                    $arrResponse = array('status'=>false, 'msg'=> "Datos no encontrados");
                }else{
                    $arrResponse = array('status'=>true, 'data'=> $arrData);
                }
                echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
            }
            die();
        }
    }
?>