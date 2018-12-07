
</div>
<!--JavaScript at end of body for optimized loading-->
        <script type="text/javascript" src="js/materialize.min.js"></script>
    
        <script type="text/javascript">
			function requestActive() {
				var xmlhttp = new XMLHttpRequest();
			    xmlhttp.onreadystatechange = function() {
			        if (this.readyState == 4 && this.status == 200) {
			            
			        }
			    };
			    xmlhttp.open("GET", "active.php", true);
			    xmlhttp.send();
			}
			setInterval(requestActive, 1000);
		</script>
    </body>
  </html>