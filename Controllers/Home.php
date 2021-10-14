<?php 
    require_once('Models/TCategoria.php');
    require_once('Models/TArticulo.php');
    
    class Home extends Controllers{
        use TCategoria, TArticulo;
        public function __construct(){
            parent::__construct();
            session_start();
        }

        public function home(){
            $data['page_tag'] = NOMBRE_EMPRESA;
			$data['page_title'] = NOMBRE_EMPRESA;
			$data['page_name'] = "inicio"; 
            $data['topics'] = $this->getCategoriaT(); 
            $data['post'] = $this->getArticulosT(); 
            $data['random'] = $this->getArticuloRandom("",3);
            $data['banner'] =$this->getArticuloBanner();
            $this->views->getView($this,"home",$data);
        }

    }
?>