<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="./node_modules/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="node_modules/MDB Free/css/bootstrap.min.css">
	<link rel="stylesheet" href="./node_modules/MDB Free/css/mdb.min.css">
<style>
	body{
					background:#E0E0E0
				}
.styleIt{
	color:#424242;
}
</style>
</head>
<body>

<div class='container animated fadeIn'>
<div class="row justify-content-center">
			<div style="background:#E0E0E0;" class="jumbotron ">
				<h1 style="text-align:center" >Results</h1>
				<blockquote>The Web’s Effective Result Query</blockquote>
			</div>
			</div>
				
<?php

$pdo = new PDO('mysql:host=127.0.0.1;dbname=Search','root','');

$search = $_GET['q'];
$searche = explode(" ", $search);

$x = 0;
$construct = "";
$params = array();
foreach ($searche as $term) {
	$x++;
	if ($x == 1) {

		$construct .= "title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";

	} else {

		$construct .= " AND title LIKE CONCAT('%',:search$x,'%') OR description LIKE CONCAT('%',:search$x,'%') OR keywords LIKE CONCAT('%',:search$x,'%')";

	}
	$params[":search$x"] = $term;
}

$results = $pdo->prepare("SELECT * FROM `index` WHERE $construct");
$results->execute($params);

if ($results->rowCount() == 0) {
	echo "No Results found! <hr>";
} else {
	echo $results->rowCount()." <h3 class='styleIt'>results found!</h3> <hr>";
}

foreach ($results->fetchAll() as $result) {
	echo $result["title"]."<br>";
	if ($result["description"] == "") {
		echo "No Description Available"."<br>";
	} else {
	echo "<blockquote>".$result["description"]."</blockquote> <br>";
		}
	echo $result["url"]."<br>";
	echo "<hr>";

} ?></div>
<!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="./node_modules/MDB Free/js/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="./node_modules/MDB Free/js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="./node_modules/MDB Free/js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="./node_modules/MDB Free/js/mdb.min.js"></script>
</body>
</html>
