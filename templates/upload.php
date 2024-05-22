
<?php

// WordPress Environment
require_once("../../../../wp-load.php");

$filename = $_FILES['file']['name'];

print_r($filename);

$upload_dir = wp_upload_dir();

$target = $upload_dir['basedir'] . '-ahrm' . '/' . date("Y") . '/' . date("m") . '/';

if ( wp_mkdir_p( $target ) === TRUE ) {
  $location =  $target. '/'.$filename;
  if(move_uploaded_file($_FILES['file']['tmp_name'], $location) ){
    echo "sucess";
  } else {
    echo "failure";
  }
} else {
  echo "blah ";
}

?>

