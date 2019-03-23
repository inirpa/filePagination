<script src="jquery.min.js"></script>
<script type="text/javascript" src="bootstrap.min.js"></script>
<link rel="stylesheet" href="./css/font-awesome.css">
<link rel="stylesheet" href="./css/bootstrap.min.css">
<style type="text/css">
	.active_folder{color: #D3931D; font-size: 50px;}
	.inactive_folder{color: #C3AB83; font-size: 50px;}
    .js-btn_pagination{border-left: 1px solid white;}
</style>
<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col col-md-3">
            <a href="#" class="js-list_files" id="js-ocr_files" data-folder="ocr_text">
            	<i class="fa fa-folder inactive_folder" id="js-icon_ocr"></i>
            </a>
            <h5>ocr files</h5>
        </div>

        <div class="col col-md-3">
            <a href="#" class="js-list_files" id="js-imgtaken" data-folder="taken_image">
            	<i class="fa fa-folder inactive_folder" id="js-icon_imgtaken"></i>
            </a>
            <h5>image taken</h5>
        </div>
    </div>
</div>
<div class="container">	
	<div id="fileList">
	</div>
</div>
<div class="modal" id="myModal">
  <div class="modal-dialog">
	<div class="modal-content">
	  <div class="modal-header">
		<h4 class="modal-title">Done</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	  </div>
	  <div class="modal-body">
		<p id="op_msg">Operation completed</p>
		<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	  </div>
	</div>
  </div>
</div>
<script type="text/javascript">
    $(document).on('click', '.js-list_files', function(){
        var folder = $(this).data('folder');
        if(folder == 'ocr_text'){
            $('#js-icon_ocr').removeClass('inactive_folder');
            $('#js-icon_ocr').addClass('active_folder');

            $('#js-icon_imgtaken').addClass('inactive_folder');
            $('#js-icon_imgtaken').removeClass('active_folder');
        }else{
            $('#js-icon_imgtaken').removeClass('inactive_folder');
            $('#js-icon_imgtaken').addClass('active_folder');

            $('#js-icon_ocr').addClass('inactive_folder');
            $('#js-icon_ocr').removeClass('active_folder');
        }
        scanFiles(folder);
    });
    
    function scanFiles(folder, page=1) {
        $.ajax({
            method:'POST',
            url : 'scan.php',
            data : {folder:folder, page:page},
            dataType : 'html',
            success: function(response){
                $('#fileList').html(response);
                $('#js-btn_'+page).addClass('btn-primary');
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('click','.deleteFile', function(){
        var file_name = $(this).data('filename');
        var dir_name = $(this).data('directory');
        $.ajax({
            method:'POST',
            url:'delete.php',
            data:{filename:file_name, dir_name:dir_name},
            dataType:'json',
            success:function(response){
                $('#op_msg').html('File '+file_name+' deleted.');
                $('#myModal').modal('toggle');
                scanFiles(dir_name);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on('click','.deletePopupFile', function(){
        var file_name = $(this).attr('filename');
        var dir_name = $(this).attr('directoryname');
        $.ajax({
            method:'POST',
            url:'delete.php',
            data:{filename:file_name, dir_name:dir_name},
            dataType:'json',
            success:function(response){
                $('#op_msg').html('File '+file_name+' deleted.');
                $('#myModal').modal('toggle');
                $('#infoModal').modal('toggle');
                scanFiles(dir_name);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).on('click', '.js-btn_pagination', function(){
        var folder = $(this).data('folder');
        var page = $(this).data('page');
        var limit = 5;
        scanFiles(folder, page, limit);
    });
</script>