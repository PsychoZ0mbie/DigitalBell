<?php 

	class ContactoModel extends Mysql
	{
		public function __construct()
		{
			parent::__construct();
		}

        public function selectContactos(){
            $sql="SELECT idcontact, 
                        name, 
                        email, 
                        DATE_FORMAT(datecreated, '%d/%b/%Y') as date 
                        FROM contact";
            $request= $this->select_all($sql);
            return $request;
        }
        public function selectContacto($idcontacto){
            $sql ="SELECT idcontact, 
                    name, 
                    email, 
                    message,
                    DATE_FORMAT(datecreated, '%d/%M/%Y %r') as date 
                    FROM contact
                    WHERE idcontact = $idcontacto";
            $request = $this->select($sql);
            return $request;
        }
	}
 ?>