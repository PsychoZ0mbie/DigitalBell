let tableArticulo;
let rowTable;
let divLoading = document.querySelector("#divLoading");
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-dialog").length) {
        e.stopImmediatePropagation();
    }
});
tableArticulo = $('#tableArticulos').dataTable( {
    "aProcessing":true,
    "aServerSide":true,
    "language": {
        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
    },
    "ajax":{
        "url": " "+base_url+"/Articulos/getArticulos",
        "dataSrc":""
    },
    "columns":[
        {"data":"idpost"},
        {"data":"title"},
        {"data":"autor"},
        {"data":"categoria"},
        {"data":"status"},
        {"data":"date"},
        {"data":"options"}
    ],
    'dom': 'lBfrtip',
    'buttons': [
        {
            "extend": "copyHtml5",
            "text": "<i class='far fa-copy'></i> Copiar",
            "titleAttr":"Copiar",
            "className": "btn btn-secondary",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "excelHtml5",
            "text": "<i class='fas fa-file-excel'></i> Excel",
            "titleAttr":"Exportar a Excel",
            "className": "btn btn-success",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "pdfHtml5",
            "text": "<i class='fas fa-file-pdf'></i> PDF",
            "titleAttr":"Exportar a PDF",
            "className": "btn btn-danger",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        },{
            "extend": "csvHtml5",
            "text": "<i class='fas fa-file-csv'></i> CSV",
            "titleAttr":"Exportar a CSV",
            "className": "btn btn-info",
            "exportOptions": { 
                "columns": [ 0, 1, 2, 3, 4] 
            }
        }
    ],
    "responsieve":"true",
    "bDestroy": true,
    "iDisplayLength": 10,
    "order":[[0,"asc"]]  
});

window.addEventListener('load',function(){
   if(document.querySelector("#fileImage")){
        let foto = document.querySelector("#fileImage");
        foto.onchange = function(e) {
            let uploadFoto = document.querySelector("#fileImage").value;
            let fileimg = document.querySelector("#fileImage").files;
            let nav = window.URL || window.webkitURL;

            if(uploadFoto !=''){
                let type = fileimg[0].type;
                if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png'){
                    swal("Error", "El archivo no es válido." , "error");
                    foto.value="";
                    return false;
                }else{  
                    //console.log(this.files[0]);
                    let objeto_url = nav.createObjectURL(this.files[0]);
                    console.log(objeto_url);
                    document.querySelector('#imgFile').setAttribute("src",objeto_url);
                }
            }else{
                swal("Error", "No seleccionó imágen." , "error");
            }
        }
    }

    if(document.querySelector("#urlImage")){
        let foto = document.querySelector("#urlImage");
        foto.onchange = function(e) {
            let url = document.querySelector("#urlImage").value;
            if(url !=''){
                /*if(url.match(/\.(jpeg|jpg|png)$/) !=null){
                    //swal("Error", "La url no contiene una imágen.","error");
                    return false;
                }else{
                    
                }*/
                document.querySelector('#imgUrl').setAttribute("src",url);
            }

        }
    }

    let formArticulo = document.querySelector("#formArticulo");
    formArticulo.onsubmit = function(e) {
        e.preventDefault();

        let strNombre = document.querySelector('#txtNombre').value;
        let strDescripcion = document.querySelector('#txtDescripcion').value;
        let urlImage = document.querySelector('#urlImage').value;
        let intCategoria = document.querySelector('#listCategoria').value;
        let intStatus = document.querySelector('#listStatus').value;        
        if(strNombre == '' || strDescripcion == '' || intStatus == '' || intCategoria == ''){
        
            swal("Atención", "Todos los campos son obligatorios." , "error");
            return false;
        }
        if(strNombre.length > 80){
            swal("Atención", "El título permite máximo 80 carácteres" , "error");
            return false;
        }

        divLoading.style.display = "flex";
        tinyMCE.triggerSave();
        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl = base_url+'/Articulos/setArticulo'; 
        let formData = new FormData(formArticulo);
        request.open("POST",ajaxUrl,true);
        request.send(formData);
        request.onreadystatechange = function(){
           if(request.readyState == 4 && request.status == 200){
                
                let objData = JSON.parse(request.responseText);
                if(objData.status)
                {
                    if(rowTable == ""){
                        tableArticulo.api().ajax.reload();
                    }else{
                        htmlStatus = intStatus == 1 ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
                        rowTable.cells[1].textContent = strNombre;
                        rowTable.cells[2].textContent = document.querySelector("#listCategoria").selectedOptions[0].text;
                        rowTable.cells[4].innerHTML = htmlStatus;
                        rowTable = "";
                    }
                    $('#modalformArticulos').modal("hide");
                    formArticulo.reset();
                    swal("Articulos", objData.msg ,"success");
                    //removePhoto();
                }else{
                    swal("Error", objData.msg , "error");
                }              
            }
            divLoading.style.display = "none";
            return false; 
        }

    }
    fntCategorias();
    fntAutor();
},false);

if(document.querySelector(".methodImage")){
    let op = document.querySelectorAll(".methodImage");
    op.forEach(function(op){
        op.addEventListener('click',function(){
            if(this.value == "url"){
                document.querySelector("#cargaUrl").classList.remove("d-none");
                document.querySelector("#cargaArchivo").classList.add("d-none");
            }else{
                document.querySelector("#cargaArchivo").classList.remove("d-none");
                document.querySelector("#cargaUrl").classList.add("d-none");
            }
        });  
    });
}

tinymce.init({
    relative_urls: 0,
    remove_script_host: 0,
	selector: '#txtDescripcion',
	width: "100%",
    height: 400,    
    statubar: true,
    plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
        "save table directionality emoticons template paste"
    ],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
});

function fntViewInfo(idcategoria){
    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Articulos/getArticulo/'+idcategoria;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status)
            {
                let estado = objData.data.status == 1 ? 
                        '<span class="badge badge-success">Activo</span>' : 
                        '<span class="badge badge-danger">Inactivo</span>';
                
                let url = base_url+'/Publicaciones/articulo/'+objData.data.idpost+'/'+objData.data.route;
                document.querySelector('#link').setAttribute("href",url)
                document.querySelector("#celId").innerHTML = objData.data.idpost;
                document.querySelector("#celNombre").innerHTML = objData.data.title;
                document.querySelector("#celAutor").innerHTML = objData.data.autor;
                document.querySelector("#celCategoria").innerHTML = objData.data.categoria;
                //document.querySelector("#celDescripcion").innerHTML = objData.data.description;
                document.querySelector("#celEstado").innerHTML = estado;
                document.querySelector("#celFecha").innerHTML = objData.data.date;
                document.querySelector("#imgArticulo").innerHTML = '<img src="'+objData.data.image+'"></img>';
                $('#modalViewArticulo').modal('show');
                
            }else{
                swal("Error", objData.msg , "error");
            }
        }
    }
}

function fntEditInfo(element, idarticulo){

    rowTable = element.parentNode.parentNode.parentNode;

    document.querySelector('#titleModal').innerHTML ="Actualizar artículo";
    document.querySelector('.modal-header').classList.replace("headerRegister", "headerUpdate");
    document.querySelector('#btnActionForm').classList.replace("btn-primary", "btn-info");
    document.querySelector('#btnText').innerHTML ="Actualizar";

    let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    let ajaxUrl  = base_url+'/Articulos/getArticulo/'+idarticulo;
    request.open("GET",ajaxUrl ,true);
    request.send();
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            let objData = JSON.parse(request.responseText);
            if(objData.status){
                document.querySelector('#idArticulo').value = objData.data.idpost;
                document.querySelector("#txtNombre").value = objData.data.title;
                document.querySelector("#txtDescripcion").value = objData.data.description;
                document.querySelector('#listCategoria').value = objData.data.topics_id;

                document.querySelector("#urlImage").value = objData.data.image;
                document.querySelector('#imgUrl').setAttribute("src",objData.data.image); 
            
                //document.querySelector("#fileImage").value = objData.data.image;
                document.querySelector('#imgFile').setAttribute("src",objData.data.image); 
                
                tinymce.activeEditor.setContent(objData.data.description); 
                $('#listNombre').selectpicker('render');
                $('#listCategoria').selectpicker('render');
                if(objData.data.status == 1){
                    document.querySelector("#listStatus").value = 1;
                }else{
                    document.querySelector("#listStatus").value = 2;
                }
                
                $('#listStatus').selectpicker('render');

            }else{
                swal("Error", objData.msg , "error");
            }
        }
        $('#modalFormArticulos').modal('show');
    }
}

function fntDelInfo(idarticulo){

    swal({
        title: "Eliminar artículo",
        text: "¿Está seguro de eliminar el artículo?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Si, eliminar",
        cancelButtonText: "No, cancelar",
        closeOnConfirm: false,
        closeOnCancel: true
    }, function(isConfirm) {
        
        if (isConfirm) 
        {
            let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
            let ajaxUrl = base_url+'/Articulos/delArticulo/'+idarticulo;
            let strData = "idArticulo="+idarticulo;
            request.open("POST",ajaxUrl,true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send(strData);
            request.onreadystatechange = function(){
                if(request.readyState == 4 && request.status == 200){
                    let objData = JSON.parse(request.responseText);
                    if(objData.status)
                    {
                        swal("Eliminado", objData.msg , "success");
                        tableArticulo.api().ajax.reload();
                    }else{
                        swal("Atención", objData.msg , "error");
                    }
                }
            }
        }

    });
}

function fntAutor(){
    if(document.querySelector('#listNombre')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Usuarios/getSelectUsuario';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listNombre').innerHTML = request.responseText;
                $('#listNombre').selectpicker('render');
            }
        }
    }
}

function fntCategorias(){
    if(document.querySelector('#listCategoria')){

        let request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        let ajaxUrl  = base_url+'/Categorias/getSelectCategorias';
        request.open("GET",ajaxUrl ,true);
        request.send(); 
    
        request.onreadystatechange = function(){
            if(request.readyState ==4 && request.status ==200){
                document.querySelector('#listCategoria').innerHTML = request.responseText;
                $('#listCategoria').selectpicker('render');
            }
        }
    }
}

/*function removePhoto(){
    document.querySelector('#foto').value ="";
    document.querySelector('.delPhoto').classList.add("notBlock");
    if(document.querySelector('#img')){
        document.querySelector('#img').remove();
    }
}*/

function openModal(){
    rowTable ="";
    document.querySelector('#idArticulo').value ="";
    document.querySelector('.modal-header').classList.replace("headerUpdate", "headerRegister");
    document.querySelector('#btnActionForm').classList.replace("btn-info", "btn-primary");
    document.querySelector('#btnText').innerHTML ="Guardar";
    document.querySelector('#titleModal').innerHTML = "Nuevo Articulo";
    document.querySelector("#formArticulo").reset();
	$('#modalFormArticulos').modal('show');
}