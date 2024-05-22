
<?php

//https://www.webslesson.info/2021/06/file-upload-in-javascript-using-fetch-api-with-php.html

// WordPress Environment
require_once("../../../../wp-load.php");


$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

$new_name = time();

$filename = $_FILES['file']['name'];
$upload_dir = wp_upload_dir();
$target = $upload_dir['basedir'] . '-ahrm' . '/' . date("Y") . '/' . date("m") . '/';

if ( wp_mkdir_p( $target ) === TRUE ) {
  $location =  $target. '/'.$filename;
  if(move_uploaded_file($_FILES['file']['tmp_name'], $location) ){
    $data = array(
      'image_source'		=>	$target .'/'. $new_name . '.' . $extension
    );
    echo json_encode($data);
  } else {
    echo "failure";
  }
} else {
  echo "blah ";
}

?>

