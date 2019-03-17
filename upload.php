<?php
include('functions.php');
$config = include('config.php');

$key = $config['secure_key'];
$uploadhost = $config['output_url'];
$redirect = $config['redirect_url'];
$image_formats = ['image/png','image/jpeg','image/gif','image/svg+xml'];
$finfo = finfo_open(FILEINFO_MIME_TYPE);

// if ($_SERVER["REQUEST_URI"] == "/robot.txt") { die("User-agent: *\nDisallow: /"); }

if (isset($_REQUEST['key'])) {
    if ($_REQUEST['key'] == $key) {
        $parts = explode(".", $_FILES["d"]["name"]);
        $target = getcwd() . "/" . $_REQUEST['name'] . "." . end($parts);
        if (move_uploaded_file($_FILES['d']['tmp_name'], $target)) {
            $target_parts = explode("/", $target);
            echo $uploadhost . end($target_parts);
        } else {
            echo "Sorry, there was a problem uploading your file. (Ensure your directory has 777 permissions)";
        }
    } else {
        echo 'Wrong key.';
    }
} else {
    echo 'Missed key.';
}
?>