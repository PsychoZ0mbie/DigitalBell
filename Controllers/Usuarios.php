<?php 

	class Usuarios extends Controllers{
		public function __construct()
		{
			
			parent::__construct();
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url());
				die();
			}
			getPermisos(2);
		}

		public function Usuarios(){
			if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Usuarios | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Usuarios | ".NOMBRE_EMPRESA;
			$data['page_name'] = "usuarios";
			$data['page_functions'] = "functions_usuarios.js";
			$this->views->getView($this,"usuarios",$data);
		}

		public function setUsuario(){
			if($_POST){
				if(empty($_POST['txtNombre']) || empty($_POST['txtApellido']) || empty($_POST['txtTelefono']) || empty($_POST['txtEmail']) || empty($_POST['listRolid']) || empty($_POST['listStatus']) )
				{
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{ 
					$idUsuario = intval($_POST['idUsuario']);
					$strNombre = ucwords(strClean($_POST['txtNombre']));
					$strApellido = ucwords(strClean($_POST['txtApellido']));
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$strEmail = strtolower(strClean($_POST['txtEmail']));
					$intTipoId = intval(strClean($_POST['listRolid']));
					$intStatus = intval(strClean($_POST['listStatus']));
					$request_user = "";
				
					if($idUsuario == 0)
					{
						$option = 1;
						$strPassword =  empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['w']){
							$request_user = $this->model->insertUsuario($strNombre, 
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$strPassword, 
																		$intTipoId, 
																		$intStatus );
						}
					}else{
						$option = 2;
						$strPassword =  empty($_POST['txtPassword']) ? "" : hash("SHA256",$_POST['txtPassword']);
						if($_SESSION['permisosMod']['u']){
							$request_user = $this->model->updateUsuario($idUsuario, 
																		$strNombre,
																		$strApellido, 
																		$intTelefono, 
																		$strEmail,
																		$strPassword, 
																		$intTipoId, 
																		$intStatus);
						}

					}

					if($request_user > 0 )
					{
						if($option == 1){
							$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
						}else{
							$arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
						}
					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => '¡Atención! el email ó el teléfono ya está registrado, ingrese otro.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

        public function getUsuarios(){
			if($_SESSION['permisosMod']['r']){
				$arrData = $this->model->selectUsuarios();
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';
	
					if($arrData[$i]['status'] == 1){
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
					if($_SESSION['permisosMod']['r']){
						$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onClick="fntViewUsuario('.$arrData[$i]['id_person'].')" title="Ver usuario"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] ==1) || ($_SESSION['userData']['idrol'] ==1 and $arrData[$i]['idrol']!=1 )){	
							$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onClick="fntEditUsuario(this,'.$arrData[$i]['id_person'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
						}else{
							$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
						}		
					}
					if($_SESSION['permisosMod']['d']){
						if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and ($_SESSION['userData']['id_person'] != $arrData[$i]['id_person'] )){
							$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onClick="fntDelUsuario('.$arrData[$i]['id_person'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
						}else{
							$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
						}
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getUsuario($idpersona){
			if($_SESSION['permisosMod']['r']){
				$idusuario = intval($idpersona);
				if($idusuario > 0){
					$arrData = $this->model->selectUsuario($idusuario);
					if(empty($arrData)){
					
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getSelectUsuario(){
			$htmlOptions = "";
			$arrData = $this->model->selectUsuariosPicker();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($arrData[$i]['status'] == 1 ){
						$htmlOptions .= '<option value="'.$arrData[$i]['id_person'].'">'.$arrData[$i]['first_name'].' '.$arrData[$i]['last_name'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}
		public function delUsuario(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){
					$intIdUsuario = intval($_POST['idUsuario']);
					$requestDelete = $this->model->deleteUsuario($intIdUsuario);
					if($requestDelete == 'ok')
					{
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el usuario.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function perfil(){
			$data['page_tag'] = "Perfil";
			$data['page_title'] = "Perfil";
			$data['page_name'] = "perfil";
			$data['page_functions'] = "functions_usuarios.js";
			$this->views->getView($this,"perfil",$data);
		}
		

		public function putPerfil(){
			if($_POST){
				if(empty($_POST['txtNombre'])  || empty($_POST['txtTelefono']) ||empty($_POST['txtId'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					$idUsuario = $_SESSION['idUser'];
					$strNombre = strClean($_POST['txtNombre']);
					$intTelefono = intval(strClean($_POST['txtTelefono']));
					$intDepartment = intval($_POST['listDepartamento']);
					$intCity = intval($_POST['listCiudad']);
					$intId = intval($_POST['listId']);
					$strDireccion = strClean($_POST['txtDir']);
					$strId = strClean($_POST['txtId']);
					$foto = "";
					$foto_perfil="";

					$request = $this->model->selectUsuario($idUsuario);
					if($_FILES['profile-img']['name'] ==""){
						$foto_perfil =$request['picture'];
					}else{
						deleteFile($request['picture']);
						$foto = $_FILES['profile-img'];
						$foto_perfil = 'perfil_'.bin2hex(random_bytes(6)).'.jpg';
					}
					
						
					
					

					$strPassword = "";
					if(!empty($_POST['txtPassword'])){
						$strPassword = hash("SHA256",$_POST['txtPassword']);
					}
	
					$request_user = $this->model->updatePerfil($idUsuario,
																$strNombre,
																$foto_perfil,
																$intTelefono,
																$strDireccion,
																$intDepartment,
																$intCity,
																$intId,
																$strId,
																$strPassword);
					
					if($request_user){
						if($foto!=""){
							uploadImage($foto,$foto_perfil);
						}
						sessionUser($_SESSION['idUser']);
						$arrResponse = array('status'=> true, 'msg' => 'Datos Actualizados correctamente.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar los datos');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function getSelectId(){
			$htmlOptions = "";
			$arrData = $this->model->selectId();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					if($_SESSION['userData']['type_id'] == $arrData[$i]['id']){
						$htmlOptions .= '<option value="'.$arrData[$i]['id'].'" selected>'.$arrData[$i]['type'].'</option>';
					}else{
						$htmlOptions .= '<option value="'.$arrData[$i]['id'].'">'.$arrData[$i]['type'].'</option>';
					}
				}
			}
			echo $htmlOptions;
			die();	
		}
		
		public function getSelectDepartamentos(){
			$htmlDepartamento="";
			$htmlCiudad="";
			$arrDepartment = $this->model->selectDepartamento();
			$arrCity = $this->model->selectCiudad($_SESSION['userData']['department_id']);
			if(count($arrDepartment) > 0){
				for ($i=0; $i < count($arrDepartment) ; $i++) { 
					if($_SESSION['userData']['department_id']== $arrDepartment[$i]['id_departamento']){
						$htmlDepartamento .= '<option value="'.$arrDepartment[$i]['id_departamento'].'" selected>'.$arrDepartment[$i]['departamento'].'</option>';
					}else{
						$htmlDepartamento .= '<option value="'.$arrDepartment[$i]['id_departamento'].'">'.$arrDepartment[$i]['departamento'].'</option>';
					}
				}
			}
			if(count($arrCity) > 0){
				for ($i=0; $i < count($arrCity); $i++) { 
					if($_SESSION['userData']['city_id']== $arrCity[$i]['id_municipio']){
						$htmlCiudad .= '<option value="'.$arrCity[$i]['id_municipio'].'" selected>'.$arrCity[$i]['municipio'].'</option>';
					}else{
						$htmlCiudad .= '<option value="'.$arrCity[$i]['id_municipio'].'">'.$arrCity[$i]['municipio'].'</option>';
					}
				}
				$arrResponse = array("department" =>$htmlDepartamento, "city"=>$htmlCiudad);
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getSelectCity($department){
			$htmlCiudad="";
			$arrData = $this->model->selectCiudad($department);
			if(count($arrData)>0){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlCiudad .= '<option value="'.$arrData[$i]['id_municipio'].'" selected>'.$arrData[$i]['municipio'].'</option>';
				}
			}
			echo $htmlCiudad;
		}
	}
 ?>