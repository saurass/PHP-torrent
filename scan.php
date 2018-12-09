<pre>
<?php
$alphabets = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	for($i = 0; $i < 26; $i++) {
		$dir = $alphabets[$i].":";
		if(is_dir($dir)) {
			// $init = "next($dir)";
			echo "<a onclick=\"next('$dir')\" href='#'>$dir</a><br>";
		}
	}
	echo "<br>";
if(isset($_GET['next_dir'])){
	$dir = $_GET['next_dir'];
	// echo "<button onclick=\"next('$dir')\">Go Back</button><br>";

	if (is_dir($dir)) {
		$all = scandir($dir);
	} else {
		die("Unable to locate Directory Here");
	}

	$i = 0;
	foreach ($all as $key) {
		if($i==0) {
			$i++;
			continue;
		}
		if(is_numeric(substr($key, 0, 2)))
			$disp = substr($key, 3);
		else
			$disp = $key;
		if(is_dir($dir."/".$key) and !is_file($dir."/".$key)){
			// $nxt = "next('$dir/$key')";
			echo "<a onclick=\"next('$dir/$key')\" href='#'>$disp</a><br>";
		} else {
			// $upl = "upload('$dir/$key')";
			echo "<a style='color: red;' onclick=\"upload('$dir/$key')\" href='#'>$disp</a><br>";
		}
	}
}

?>
</pre>