<?php 

	class SuscripcionesModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

        public function selectSuscriptores(){
            $sql="SELECT idsuscription, name, email,DATE_FORMAT(datecreated, '%d/%b/%Y') as date FROM suscriptions";
            $request= $this->select_all($sql);
            return $request;
        }
	}
 ?>