<?php
$dir_name = $_POST['folder'];
// $ocr_files = scandir('ocr_text');
$files = scandir($dir_name);
// $current_files = array_merge($ocr_files, $img_files);
array_shift($files); // remove current directory from array
array_shift($files); // remove parent directory from array
$total_files = sizeof($files); #remove current directory and parent directory
if($total_files>5){
    $enable_pagination = true;
    $total_pages = ceil($total_files/5); #5 icons per page
    $per_page = 5;
    $current_page = $_POST['page'];
    $offset = $per_page*($current_page-1)-1;
    $offset = ($offset<0)?0:$offset;
    $limit = $offset+$per_page;
    $limit = ($limit>$total_files)?$total_files:$limit;
    // echo("CURRENT PAGE : ".$current_page."<br>");
    // echo("OFFSET : ".$offset."<br>");
    // echo("LIMIT : ".$limit."<br>");
    // echo("TOTAL FILES : ".$total_files."<br>");
}else{
    $current_page = 1;
    $offset = 0;
    $limit = $total_files;
    $enable_pagination = false;
    $per_page = $total_files;
}
?>
<div class="row mt-1">
        <?php for($pi=$offset; $pi<$limit; $pi++){ ?>
            <div class="col-2">
                <i class="fa fa-file" style="color: #518FF5; font-size: 50px;"></i>
                <p><?=$files[$pi]?></p>
                <button class="btn btn-sm btn-danger deleteFile" data-filename="<?=$files[$pi]?>" data-directory='<?=$dir_name?>' style="float: right; top: 0px; right: 10px; position: absolute;"><i class="fa fa-trash"></i></button>
            </div>    
        <?php } ?>
        <?php if($enable_pagination){ ?>
        <div class="col-12">
            <div class="btn-group">
                <?php for($tp=1; $tp<=$total_pages; $tp++) {?>
                    <button class="btn btn-default js-btn_pagination" id="js-btn_<?=$tp?>" type="button" data-folder='<?=$dir_name?>' data-page='<?=$tp?>'><?=$tp?></button>
                <?php } ?>
            </div>
        </div>
    <?php } ?>
</div>