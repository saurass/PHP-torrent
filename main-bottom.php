
</div>


<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>Select File !!!</h4>
        <p>Give a title-name to publish file and just upload your file</p>
        <div class="row">
		    <!-- <div class="input-field col s12 m12 l12"> -->
		        <input id="title_name" type="text">
		        <label class="active" for="title_name">File Title</label>
		    <!-- </div> -->


	        <div class = "input-field">
	            <span>Browse</span>
	            <input type = "file" id="share_file">
	        </div>
	    
	    </div>
	</div>
    <div class="modal-footer">
        <a href="#!" id="upload_file_btn" onclick="uploadFile();" class="modal-close waves-effect waves-green btn-flat">Agree</a>
    </div>



</div>



<!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="js/materialize.min.js"></script>
    
        <script type="text/javascript">
			function requestActive() {
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            refreshFiles();
			        }
			    };
			    xmlhttp.open("GET", "active.php", true);
			    xmlhttp.send();
			}
			setInterval(requestActive, 10000);

			function refreshFiles(){
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            document.getElementById('files_container').innerHTML = this.responseText;
			        }
			    };
			    xmlhttp.open("GET", "response.php", true);
			    xmlhttp.send();
			}

$('#upload_file_btn').on('click', function() {
    var file_data = $('#share_file').prop('files')[0];   
    var form_data = new FormData();     
    var title = $('#title_name').val();             
    form_data.append('file', file_data);
    form_data.append('title', title);
    // alert(form_data);                             
    $.ajax({
        url: 'upload.php', // point to server-side PHP script 
        dataType: 'text',  // what to expect back from the PHP script, if anything
        cache: false,
        contentType: false,
        processData: false,
        data: form_data,                         
        type: 'post',
        success: function(php_script_response){
            alert(php_script_response); // display response from the PHP script, if any
        }
     });
});


			$(document).ready(function(){
    $('.modal').modal();
  });


function shareNow(){
	var title_name = document.getElementById('title_name').value;
	var file = document.getElementById('share_file').value;
}


		</script>
    </body>
  </html>