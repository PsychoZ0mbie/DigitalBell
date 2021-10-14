<?php 
    class Dashboard extends Controllers{
        public function __construct(){
            parent::__construct();
            session_start();
			//session_regenerate_id(true);
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
				die();
			}
            getPermisos(1);
        }

        public function dashboard(){
            if(!empty($_SESSION['permisosMod']['r'])){
            
            
            $data['page_tag'] = "Dashboard | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Dashboard | ".NOMBRE_EMPRESA;
			$data['page_name'] = "dashboard"; 
            $data['page_functions'] = "functions_dashboard.js"; 
            $data['usuarios'] = $this->model->selectUsuarios();
            $data['articulos'] = $this->model->selectArticulos();
            $data['suscripciones'] = $this->model->selectSuscripciones();
            $data['contactos'] = $this->model->selectContactos();
            $this->views->getView($this,"dashboard",$data);
            }
        }
    }
?>