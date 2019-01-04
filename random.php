<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


include 'fungsi.php';
$ini_r_key= random_keyword();
$ini_r_key=array_slice($ini_r_key, 0, 5000);
$http_home_domain= home_url();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />

<title>Random Document - <?php echo $_SERVER['SERVER_NAME']; ?></title>


<meta property="og:site_name" content="<?php echo $_SERVER['SERVER_NAME']; ?>"/>
<meta name="description" content="<?php echo $_SERVER['SERVER_NAME']; ?>"/>
<meta name="keywords" content="<?php echo $_SERVER['SERVER_NAME']; ?>"/>
<meta property="og:description" content="<?php echo $_SERVER['SERVER_NAME']; ?>"/>


	<link href='https://fonts.googleapis.com/css?family=Work+Sans:400,300,600,400italic,700' rel='stylesheet' type='text/css'>
	

</head>
<body>
	<footer id="fh5co-footer" role="contentinfo">
		<div class="container">

			<div class="row copyright">
				<div class="col-md-12 text-center">
					

<?php


foreach($ini_r_key as $items){
$title= danang($items);
$ex = explode(' ',$title);
$id_post= strlen($title);
$slug_posting = title2URL($title);//spasi to -
$permalink= $http_home_domain.'/'.trim($slug_posting).'.pdf';//permalink type

?>

					<a href="<?php echo $permalink;?>">.</a>

<?php } ?>			
			<div style="clear: both;">&nbsp;</div>
			

</div>
			</div>
<a href=/sitemap.xml>.</a>

		</div>
	</footer>
</body>
</html>
