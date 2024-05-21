
<?php

// WordPress environment
require_once("../../../../wp-load.php");

$filename = $_FILES['file']['name'];

$upload_dir = wp_upload_dir();

$location = $upload_dir['basedir'] . '\uploads/'.$filename;

if(move_uploaded_file($_FILES['file']['tmp_name'], $location) ){
  echo "sucess";
} else {
  echo "failure";
}

?>