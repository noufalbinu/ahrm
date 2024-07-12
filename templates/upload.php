
<?php

//https://www.webslesson.info/2021/06/file-upload-in-javascript-using-fetch-api-with-php.html

// WordPress Environment
require_once("../../../../wp-load.php");


$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);



$new_name = date("d-m-y") . '-' . time();

$filename = $_FILES['file']['name'];

$upload_dir = wp_upload_dir();

$target = $upload_dir['basedir'] . '-ahrm' . '/' . date("Y") . '/' . date("m");

$targetlink = $upload_dir['baseurl'] . '-ahrm' . '/' . date("Y") . '/' . date("m");
$targetpath = '/uploads-ahrm' . '/' . date("Y") . '/' . date("m");

if ( wp_mkdir_p( $target ) === TRUE ) {

  $location =  $target. '/'. $new_name . '.' . $ext;

  if(move_uploaded_file($_FILES['file']['tmp_name'], $location) ){
    $data = array(
      'image_source'		=>	$targetlink .'/'. $new_name . '.' . $ext,
      'image_path'		=>	$targetpath .'/'. $new_name . '.' . $ext
    );
    echo json_encode($data);
  } else {
    echo "failure";
  }
} else {
  echo "blah ";
}

?>

