<?php

error_reporting(-1);
ini_set('display_errors', 'On');

include 'simplexlsx.class.php';
include 'xlsxwriter.class.php';


  $xlsx = new SimpleXLSX('./upload/test.xlsx');

  $items = $xlsx->rows();

  $newDomain = "http://distribuidorelectronica.com";
  //fill array with wrong domains
  foreach ($items as $item) {

    $url = $item[0];

    if (!filter_var($url, FILTER_VALIDATE_URL) === false) {

      $parse  = parse_url($url, PHP_URL_PATH);
      $path[] = array($newDomain.$parse);
      
      $ruta = pathinfo($parse);
    }
    if (!is_dir(__DIR__ . '/'.$ruta['dirname'])) {

      mkdir(__DIR__ . '/'.$ruta['dirname'], 0755, true);
    }
    $file = basename($item[0]); 
    $image = file_get_contents($item[0]);
    
    file_put_contents(__DIR__ .$ruta['dirname']."/".$file, $image);    

  }

  return true;

?>