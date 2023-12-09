<?php
include("includes/config.php");
include_once("includes/isAuthentificated.php");
//session_destroy(); LOGOUT
$con=ConnexionBD::getInstance();
?>


<html>
<head>
	<title>Groovy</title>
    <link rel="stylesheet" type="text/css" href="assets/css/style.css?v5">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;400&display=swap');
    </style>
   <link rel='stylesheet' type='text/css' href='assets/css/album.css?v2'>
    <link rel='stylesheet' type='text/css' href='assets/css/artist.css?v1'>
    <link rel='stylesheet' type="text/css" href="assets/css/updateDetails.css">
    <link rel='stylesheet' type="text/css" href="assets/css/settings.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>


</head>

<body>

	<div id="mainContainer">

		<div id="topContainer">

			<?php include("includes/navBarContainer.php"); ?>

			<div id="mainViewContainer">

				<div id="mainContent">
