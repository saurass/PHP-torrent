
</div>


<!-- Modal Structure -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <h4>Select File !!!</h4>
        <div id="browser">
        	<?php require 'scan.php' ?>
        </div>
	</div>
</div>



        <script type="text/javascript" src="js/materialize.min.js"></script>
    
        <script type="text/javascript">
			function requestActive() {
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            // refreshFiles();
			        }
			    };
			    xmlhttp.open("GET", "activate.php?act=<?php isset($_GET['act']) ? $abc=0 : $abc=1; echo $abc; ?>", true);
			    xmlhttp.send();
			}
			// setInterval(requestActive, 10000);
			requestActive();

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
			setInterval(refreshFiles, 10000);

			function next(dir){
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            document.getElementById('browser').innerHTML = this.responseText;
			        }
			    };
			    xmlhttp.open("GET", "scan.php?next_dir=" + dir, true);
			    xmlhttp.send();
			}


			function upload(dir){
				$('.modal').modal('close');
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            alert(this.responseText);
			        }
			    };
			    xmlhttp.open("GET", "upload.php?next_dir=" + dir, true);
			    xmlhttp.send();
			}

			function dwdStart(filehash) {
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            
			        }
			    };
			    xmlhttp.open("GET", "dwdstart.php?file_hash=" + filehash, true);
			    xmlhttp.send();
			}


			$(document).ready(function(){
    			$('.modal').modal();
  			});


		</script>
    </body>
  </html>