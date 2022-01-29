<?php 
    class Articulos extends Controllers{
        public function __construct(){
            session_start();

			if(empty($_SESSION['login'])){
				header('Location: '.base_url());
				die();
			}
			parent::__construct();
			getPermisos(4);
        }

        public function articulos(){
            if(empty($_SESSION['permisosMod']['r'])){
				header("Location:".base_url().'/dashboard');
			}
			$data['page_tag'] = "Panel de control";
			$data['page_title'] = "Blog";
			$data['page_name'] = "blog";
			$data['page_functions'] = "functions_articulos.js";
			$this->views->getView($this,"articulos",$data);
        }

		public function setArticulo(){
            if($_SESSION['permisosMod']['w']){
                if($_POST){
                    if(empty($_POST['txtNombre']) || empty($_POST['listCategoria']) || empty($_POST['txtDescripcion']) || empty($_POST['listStatus'])){
                        $arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
                    }else{

                        $intIdArticulo = intval($_POST['idArticulo']);
						$strTitulo = strClean($_POST['txtNombre']);
						$strTituloC = strClean($_POST['txtTitulo']);
                        $intNombre = $_SESSION['idUser'];
						$intCategoria = intVal($_POST['listCategoria']);
                        $strDescipcion = strClean($_POST['txtDescripcion']);
						$intStatus = intval($_POST['listStatus']);
						$nombre_foto="";

						/*if($_POST['checkImage'] == "url"){
							$imgPortada= filter_var($_POST['urlImage'], FILTER_SANITIZE_URL);
						}else{
							$foto = $_FILES['fileImage'];
							$nombre_foto = $foto['name'];
							$type = $foto['type'];
							$url_tmp = $foto['tmp_name'];
							$imgPortada = 'upload.png';

							if($nombre_foto != ''){
								$imgPortada = 'img_'.md5(date('d-mY H:m:s')).'.jpg';
							}
						}*/

						$ruta = strtolower(clear_cadena($strTitulo));
						$ruta = str_replace(" ","-",$ruta);
						$ruta = str_replace("?","",$ruta);
						$ruta = str_replace("¿","",$ruta);

                        if($intIdArticulo == 0)
                        {
                            //Crear
                            if($_SESSION['permisosMod']['w']){

                                $request_articulo = $this->model->insertArticulo($intNombre, $intCategoria,$strTitulo,$strTituloC, $strDescipcion,$ruta,$intStatus);
                                $option = 1;
                            }
                        }else{
                            //Actualizar
                            if($_SESSION['permisosMod']['u']){
								/*if($nombre_foto == ''){
									if($_POST['foto_actual'] != 'upload.png' && $_POST['foto_remove'] == 0 ){
										$imgPortada = $_POST['foto_actual'];
									}
								}*/
                                $request_articulo = $this->model->updateArticulo($intIdArticulo, $intCategoria,$strTitulo,$strTituloC,$strDescipcion,$ruta,$intStatus);
								$option = 2;
                            }
                        }

                        if($request_articulo > 0 ){
                            if($option == 1)
                            {
                                $arrResponse = array('status' => true, 'idpost'=> $request_articulo,'msg' => 'Datos guardados correctamente.');
                                //if($nombre_foto != ''){uploadImage($foto,$imgPortada);}
                            }else{
                                $arrResponse = array('status' => true, 'idpost'=> $intIdArticulo,'msg' => 'Datos Actualizados correctamente.');
                                /*if($nombre_foto != ''){uploadImage($foto,$imgPortada);}

                                if(($nombre_foto =='' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'upload.png') || ($nombre_foto != '' && $_POST['foto_actual'] != 'upload.png')){
                                    deleteFile($_POST['foto_actual']);
                                }*/
                            }
                        }else if($request_articulo == 'exist'){
                            
                            $arrResponse = array('status' => false, 'msg' => 'El artículo ya existe o se encuentra en la papelera.');
                        }else{
                            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
                        }
                    }
                    echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
                }
                die();
            }	
		}

		public function getArticulos(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectArticulos($_SESSION['userData']['idrol'],$_SESSION['idUser']);
				for ($i=0; $i < count($arrData); $i++) {

					$btnView = '';
					$btnEdit = '';
					$btnDelete = '';

                    if($arrData[$i]['status'] == 1)
					{
						$arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
					}else{
						$arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
					}
	
					if($_SESSION['permisosMod']['r']){
						$url = base_url()."/publicaciones/articulo/".$arrData[$i]['idpost']."/".$arrData[$i]['route'];
						$btnView = '<a class="btn btn-info btn-sm title="Ver" href="'.$url.'"><i class="far fa-eye"></i></a>';
					}
					if($_SESSION['permisosMod']['u']){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo('.$arrData[$i]['idpost'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idpost'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getPapelera(){
			if($_SESSION['permisosMod']['r']){

                $arrData = $this->model->selectPapelera($_SESSION['userData']['idrol'],$_SESSION['idUser']);
				for ($i=0; $i < count($arrData); $i++) {
	
					$btnRecovery = '';
					$btnDelete = '';
	
					if($_SESSION['permisosMod']['u']){
						$btnRecovery = '<button class="btn btn-info btn-sm " onClick="fntRecoveryInfo('.$arrData[$i]['idpost'].')" title="Recuperar"><i class="fas fa-undo"></i></button>';
					}else{
						$btnRecovery = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-undo"></i></button>';
					}
					if($_SESSION['permisosMod']['d']){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelfEver('.$arrData[$i]['idpost'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}

					$arrData[$i]['options'] = '<div class="text-center">'.$btnRecovery.' '.$btnDelete.'</div>';
				}
				echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function getArticulo($idArticulo){
			if($_SESSION['permisosMod']['r']){
				$idArticulo = intval($idArticulo);
				if($idArticulo > 0){
					$arrData = $this->model->selectArticulo($idArticulo);
					if(empty($arrData)){
						$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
					}else{
					    $arrTags = $this->model->selectTag($idArticulo);
						$arrImg = $this->model->selectImage($idArticulo);
						
						if(count($arrTags) > 0){
							for ($i=0; $i < count($arrTags) ; $i++) { 
								$arrTags[$i]['tagtitle'] = $arrTags[$i]['title']; 
								$arrTags[$i]['idtag'] = $arrTags[$i]['tag_id']; 
							}
						}
						if(count($arrImg) > 0){
							for ($i=0; $i < count($arrImg); $i++) { 
								$arrImg[$i]['url'] = media()."/images/uploads/".$arrImg[$i]['name'];
							}
						}
						$arrData['tags'] = $arrTags;
						$arrData['img'] = $arrImg;
						$arrResponse = array('status' => true, 'data' => $arrData);
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function getRecoveryArticulo($idArticulo){
			if($_SESSION['permisosMod']['u']){
				//$idArticulo = intval($_POST['idArticulo']);
				$idArticulo = intval($idArticulo);
				if($idArticulo > 0){
					$arrData = $this->model->recovery($idArticulo);
					if(empty($arrData)){
						$arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un problema, inténtelo más tarde.");
					}else{
						$arrResponse = array("status"=>true,"msg"=>"Se ha recuperado tu artículo.");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
		public function deleteRecovery($idArticulo){
			if($_SESSION['permisosMod']['d']){

				$idArticulo = intval($idArticulo);
				if($idArticulo > 0){
					$arrData = $this->model->deleteRecoveryInfo($idArticulo);
					if($arrData=="ok"){
						$arrResponse = array("status"=>true,"msg"=>"Se ha elimiado.");
					}else{
						$arrResponse = array("status"=>false,"msg"=>"Error, inténtelo más tarde.");
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function delArticulo(){
			if($_POST){
				if($_SESSION['permisosMod']['d']){

					$intIdArticulo = intval($_POST['idArticulo']);

					$requestDelete = $this->model->deleteArticulo($intIdArticulo);
					if($requestDelete == 'ok'){
						$arrResponse = array('status' => true, 'msg' => 'Se ha enviado a la papelera');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error, inténtelo más tarde.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}

		public function setImage(){
			if($_POST){
				if(empty($_POST['idArticulo'])){
					$arrResponse = array('status' => false, 'msg' => 'Error, inténtelo más tarde.');
				}else{
					$idArticulo = intval($_POST['idArticulo']);
					$foto      = $_FILES['foto'];
					$imgNombre = 'post_'.bin2hex(random_bytes(6)).'.jpg';
					$request_image = $this->model->insertImage($idArticulo,$imgNombre);
					if($request_image){
						$uploadImage = uploadImage($foto,$imgNombre);
						$arrResponse = array('status' => true, 'imgname' => $imgNombre, 'msg' => 'Imágen cargada.');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error, inténtelo más tarde.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		public function delFile(){
			if($_POST){
				if(empty($_POST['idarticulo']) || empty($_POST['file'])){
					$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
				}else{
					//Eliminar de la DB
					$idArticulo = intval($_POST['idarticulo']);
					$imgNombre  = strClean($_POST['file']);
					$request_image = $this->model->deleteImage($idArticulo,$imgNombre);

					if($request_image){
						$deleteFile =  deleteFile($imgNombre);
						$arrResponse = array('status' => true, 'msg' => 'Archivo eliminado');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function setTag($name){
			if($name!=""){
				$name = strtolower(strClean(clear_cadena($name)));
				$name = str_replace(" ","",$name);
				$name = str_replace("#","",$name);

				$arrData = $this->model->insertTag($name);

				if($arrData == "exist"){
					$arrResponse = array("status"=>false,"msg"=>"La etiqueta ya existe!");
				}else{
					if($arrData > 0){
						$arrResponse = array("status"=>true,"msg"=>"Etiqueta creada, revisa la lista de etiquetas para agregarla.");
					}else{
						$arrResponse = array("status"=>false,"msg"=>"Ha ocurrido un error, inténtelo más tarde.");
					}
				}
			}else{
				$arrResponse = array("status"=>false,"msg"=>"No se puede agregar etiquetas vacías!");
			}
			
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		public function getSelectTags(){
			$htmlOptions = "";
			$arrData = $this->model->selectTags();
			if(count($arrData) > 0 ){
				for ($i=0; $i < count($arrData); $i++) { 
					$htmlOptions .= '<option value="'.$arrData[$i]['id'].'">#'.$arrData[$i]['title'].'</option>';
				}
			}
			echo $htmlOptions;
			die();	
		}
		public function setSelectTag(){
			if($_POST){
				if(empty($_POST['idpost']) || empty($_POST['idtag'])){
					$arrResponse = array("status"=>false, "msg" =>"Ha ocurrido un error, inténtelo más tarde");
				}else{
					$idArticulo = intval($_POST['idpost']);
					$idtag = intval($_POST['idtag']);

					$arrData = $this->model->insertSelectTag($idArticulo,$idtag);
					if($arrData == "exist"){
						$arrResponse = array("status"=>false, "msg" =>"La etiqueta ya se agregó!");
					}else{
						$arrResponse = array("status"=>true, "msg" =>"Se agregó la etiqueta.");
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
		public function delSelectTag(){
			if($_POST){
				if(empty($_POST['idpost']) && empty($_POST['idtag'])){
					$arrResponse = array("status"=>false, "msg" =>"Ha ocurrido un error, inténtelo más tarde");
				}else{
					$idArticulo = intval($_POST['idpost']);
					$idtag = intval($_POST['idtag']);

					$arrData = $this->model->deleteTag($idArticulo,$idtag);
					if($arrData == "ok"){
						$arrResponse = array("status"=>true, "msg" =>"La etiqueta se ha eliminado");
					}else{
						$arrResponse = array("status"=>false, "msg" =>"Ha ocurrido un error, inténtelo más tarde");
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}
    }
?>