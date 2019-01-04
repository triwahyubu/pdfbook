<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


$cURI = explode("/", $_SERVER["REQUEST_URI"]);
$replace=array("+","-","%20","_",".pdf","pdf","download","epub","mobi");
$this_title= str_replace($replace,' ',$cURI[count($cURI)-1]);

?>
<html>
<head>
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title><?php echo $this_title ?></title>
<meta http-equiv="refresh" content="0;url=http://thebooksout.com/downloads/<?php echo title3URL($this_title) ?>.pdf">

</head>
<body>

<p align="middle"><img src="images/loading.gif" vspace="200">
</body>
</html>