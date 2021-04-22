<?php
require_once("config.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($mysqli->connect_error) {
	die('Database Connect Error (' . $mysqli->connect_errno . '): '.$mysqli->connect_error);
	exit;
}
function dberror(){
	die('Database Error (' . $mysqli->errno . '): '.$mysqli->error);
	exit;
}
if($result = $mysqli->query('show tables like "'.TBL_PREFIX.'notes";')){
	if($result->num_rows < 1){
		echo "Created Table";
		if(!$mysqli->query("CREATE TABLE ".DB_NAME.".".TBL_PREFIX."notes (
			time int(10) unsigned NOT NULL,
			ip varchar(15) NOT NULL DEFAULT '',
			value longtext NOT NULL DEFAULT '',
			u varchar(255) NOT NULL DEFAULT ''
			) ENGINE=MyISAM;'")){
		dberror();
			}
	}
}else{
	dberror();
}
if(isset($_POST['v']) && !empty($_POST['v'])){
	if($stmt = $mysqli->prepare("INSERT INTO ".TBL_PREFIX."notes (time,ip,value,u) VALUES('".time()."','".$_SERVER['REMOTE_ADDR']."',?,?);")){
		$stmt->bind_param("ss",$_POST['v'],$_POST['u']);
		$stmt->execute();
		echo "1";
		exit;
	}else{
		dberror();
	}
	exit;
}
$s = strtolower(trim(urldecode(substr($_SERVER['PHP_SELF'],strlen($_SERVER["SCRIPT_NAME"])+1))));
$text = "";
if($stmt = $mysqli->prepare("SELECT value FROM ".TBL_PREFIX."notes WHERE u=? ORDER BY time DESC LIMIT 1;")){
	$stmt->bind_param("s",$s);
	$stmt->execute();
	$stmt->bind_result($text);
	$stmt->fetch();
}else{
	dberror();
}
$mysqli->close();
?>
<html><head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>
<script type="text/javascript">
(function(){
		var w,j;
		$(function() {
				j=$("#j");
				j.focus();
				j.keyup(u);
				w=$(window);
				r();
				w.resize(r);
				w.unload(u);
		});
		function r(e){
			var i=w.height();
			if(i>240)
				j.height(i-24+"px");
			i=w.width();
			if(i>240)
				j.width(i-24+"px");
			u();
		}
		function u(e){
			$.post('<? echo $_SERVER["SCRIPT_NAME"]; ?>',{v:j.val(),u:"<? echo $s; ?>"},function(d){});
		}
})();
</script>
<style>
body{background-color:#666;font:bold 12px Verdana,Arial,sans serif;width:95%;}
textarea{width:100%;padding:12px;font:13px Courier New,Courier,monospace;background-color:#FFF;border:2px solid #636E76;overflow:auto;}
</style>
</head><body><textarea rows="20" cols="20" id="j"><? echo $text; ?></textarea></body></html>