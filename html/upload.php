<?php

error_reporting(-1);
ini_set('display_errors', 'On');

$files = glob('./upload/*'); // get all file names
foreach($files as $file){ // iterate files
  if(is_file($file))
    unlink($file); // delete file
}

//print_r($_FILES);
$fileName = $_FILES['file']['name'];
$fileTmp =$_FILES['file']['tmp_name'];
$fileType = $_FILES['file']['type'];
$fileError = $_FILES['file']['error'];
//$fileContent = file_get_contents($_FILES['file']['tmp_name']);

 // Check file size
if ($_FILES["file"]["size"] > 16000000) {
    echo "Sorry, your file is too large.";
    $fileError = UPLOAD_ERR_INI_SIZE;
}
$fileName = "test.xlsx";
if($fileError == UPLOAD_ERR_OK){
  
  move_uploaded_file($fileTmp,"./upload/".$fileName);
  chmod("upload/".$fileName, 0755);
}else{
   switch($fileError){
     case UPLOAD_ERR_INI_SIZE:   
          $message = 'Error al intentar subir un archivo que excede el tamaño permitido.';
          break;
     case UPLOAD_ERR_FORM_SIZE:  
          $message = 'Error al intentar subir un archivo que excede el tamaño permitido.';
          break;
     case UPLOAD_ERR_PARTIAL:    
          $message = 'Error: no terminó la acción de subir el archivo.';
          break;
     case UPLOAD_ERR_NO_FILE:    
          $message = 'Error: ningún archivo fue subido.';
          break;
     case UPLOAD_ERR_NO_TMP_DIR: 
          $message = 'Error: servidor no configurado para carga de archivos.';
          break;
     case UPLOAD_ERR_CANT_WRITE: 
          $message= 'Error: posible falla al grabar el archivo.';
          break;
     case  UPLOAD_ERR_EXTENSION: 
          $message = 'Error: carga de archivo no completada.';
          break;
     default: $message = 'Error: carga de archivo no completada.';
              break;
    }
      echo json_encode(array(
               'error' => true,
               'message' => $message
            ));
}
?> 