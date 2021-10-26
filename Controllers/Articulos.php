<?php 
    class Articulos extends Controllers{
        public function __construct(){
            session_start();
			session_regenerate_id(true);
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
			$data['page_tag'] = "Publicaciones | ".NOMBRE_EMPRESA;
			$data['page_title'] = "Publicaciones | ".NOMBRE_EMPRESA;
			$data['page_name'] = "publicaciones";
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
                        $intNombre = $_SESSION['idUser'];
						$intCategoria = intVal($_POST['listCategoria']);
                        $strDescipcion = strClean($_POST['txtDescripcion']);
						$intStatus = intval($_POST['listStatus']);
						$nombre_foto="";
						if($_POST['checkImage'] == "url"){
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
						}	

						$ruta = strtolower(clear_cadena($strTitulo));
						$ruta = str_replace(" ","-",$ruta);
						$ruta = str_replace("?","",$ruta);
						$ruta = str_replace("¿","",$ruta);

                        if($intIdArticulo == 0)
                        {
                            //Crear
                            if($_SESSION['permisosMod']['w']){

                                $request_articulo = $this->model->insertArticulo($intNombre, $intCategoria,$strTitulo, $strDescipcion,$imgPortada,$ruta,$intStatus);
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
                                $request_articulo = $this->model->updateArticulo($intIdArticulo, $intCategoria,$strTitulo, $strDescipcion,$imgPortada,$ruta,$intStatus);
								$option = 2;
                            }
                        }

                        if($request_articulo > 0 ){
                            if($option == 1)
                            {
                                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
                                if($nombre_foto != ''){uploadImage($foto,$imgPortada);}
                            }else{
                                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
                                if($nombre_foto != ''){uploadImage($foto,$imgPortada);}

                                if(($nombre_foto =='' && $_POST['foto_remove'] == 1 && $_POST['foto_actual'] != 'upload.png') || ($nombre_foto != '' && $_POST['foto_actual'] != 'upload.png')){
                                    deleteFile($_POST['foto_actual']);
                                }
                            }
                        }else if($request_articulo == 'exist'){
                            
                            $arrResponse = array('status' => false, 'msg' => '¡Atención! El artículo ya existe.');
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

                $arrData = $this->model->selectArticulos();
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
						$btnView = '<button class="btn btn-info btn-sm " onClick="fntViewInfo('.$arrData[$i]['idpost'].')" title="Ver categoría"><i class="far fa-eye"></i></button>';
					}
					if($_SESSION['permisosMod']['u'] && $_SESSION['idUser'] == $arrData[$i]['person_id'] || $_SESSION['userData']['idrol']==1){
						$btnEdit = '<button class="btn btn-primary btn-sm " onClick="fntEditInfo(this,'.$arrData[$i]['idpost'].')" title="Editar Categoría"><i class="fas fa-pencil-alt"></i></button>';
					}else{
						$btnEdit = '<button class="btn btn-secondary btn-sm" disabled ><i class="fas fa-pencil-alt"></i></button>';
					}
					if($_SESSION['permisosMod']['d'] && $_SESSION['idUser'] == $arrData[$i]['person_id'] || $_SESSION['userData']['idrol']==1){
						$btnDelete = '<button class="btn btn-danger btn-sm " onClick="fntDelInfo('.$arrData[$i]['idpost'].')" title="Eliminar Categoría"><i class="far fa-trash-alt"></i></button>';
					}else{
						$btnDelete = '<button class="btn btn-secondary btn-sm" disabled ><i class="far fa-trash-alt"></i></button>';
					}
					$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
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
					    //$arrData['route'] = urlencode($arrData['route']);
						if(filter_var($arrData['image'],FILTER_VALIDATE_URL)== false){
							$arrData['image'] = media().'/images/uploads/'.$arrData['image'];
							//dep($arrData['image']);
						}
						$arrResponse = array('status' => true, 'data' => $arrData);
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
						$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el artículo');
					}else{
						$arrResponse = array('status' => false, 'msg' => 'Error al eliminar el artículo.');
					}
					echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				}
			}
			die();
		}
    }
?>