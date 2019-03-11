<?php
$full_path = $_POST['dir_name'].'/'.$_POST['filename'];
if(is_file($full_path)){
    if(unlink($full_path)){
        $response['msg'] = 'File : '.$_POST['filename'].' deleted';
    }else{
        $response['msg'] = 'Unable to delete file';
    }
}else{
    $response['msg'] = 'File not found';
}
echo json_encode($response);
?>