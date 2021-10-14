<?php 
    class Suscripciones extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
				die();
			}
            getPermisos(7);
        }

        public function suscripciones(){
            $data['page_tag'] = "Suscripciones | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Suscripciones | ".NOMBRE_EMPRESA;
			$data['page_name'] = "suscripciones"; 
            $data['page_functions'] = "functions_suscripciones.js"; 
            $this->views->getView($this,"suscripciones",$data);
        }

        public function getSuscriptores(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectSuscriptores();

				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

    }
?>