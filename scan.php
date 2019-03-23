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
                <a href="<?=$dir_name?>/<?=$files[$pi]?>" class="js-popup_modal" data-filename="<?=$files[$pi]?>" data-directoryname="<?=$dir_name?>">
                    <i class="fa fa-file" style="color: #518FF5; font-size: 50px;"></i>
                </a>
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
<div class="modal" id="infoModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <p class="modal-title" id="js-modal_fname"></p>
        <button class="btn btn-sm btn-danger deletePopupFile" style="float: right; top: 20px; right: 50px; position: absolute; border-radius: 60%" title="delete"><i class="fa fa-trash"></i></button>
        <button type="button" class="close" data-dismiss="modal" title="close">&times;</button>
      </div>
      <div class="modal-body" id="js-modal_file_content">
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.js-popup_modal', function(e){
        e.preventDefault();
        var fileName = $(this).data('filename');
        var dirName = $(this).data('directoryname');
        var url = $(this).attr('href');
        var myModal = $('#infoModal').modal('show');
        loadModalContent(url, fileName, dirName, $(this), myModal);
    });

    function loadModalContent(url, fileName, dirName, element, myModal) {
    $.ajax({
        type: 'get',
        url: url,
        dataType: 'html',
        beforeSend: function() {
            myModal.find("#js-modal_file_content").html('<div class="text-center"> <i class="fa fa-spin fa-spinner"></i> </div>');
        },
        success: function(data) {
            $('#js-modal_fname').text(fileName);
            $('.deletePopupFile').attr('filename',fileName);
            $('.deletePopupFile').attr('directoryname',dirName);
            $('#js-modal_file_content').html('<embed src="'+dirName+'/'+fileName+'" frameborder="0" width="100%" height="auto">');
        },
        error: function() {
            myModal.find("#js-modal_file_content").html('<div class="error"> Error </div>');
        }
    })
    return false;
}
</script>