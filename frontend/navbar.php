<!DOCTYPE html>
<html>
<head>
	<title>Recipe Keeper</title>
	<link rel="stylesheet" href="./bs/bootstrap.min.css">
</head>
<body>


<nav class="navbar navbar-expand-lg bg-body-tertiary">

  <div class="container-fluid">
    <a class="navbar-brand" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php">Recipe Keeper</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
<?php
if(isset($_COOKIE['login']))
{
?>

	<li class="nav-item">
	  <a class="nav-link" aria-current="page" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php">Home</a>
	</li>

	<li class="nav-item">
	  <a class="nav-link" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/add.php">add</a>
	</li>
<?php
}
?>
	</ul>
<?php
if(isset($_COOKIE['login']))
{
?>

<?php
	if(basename($_SERVER['PHP_SELF']) == "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php")
	{

?>

	<a class="btn btn-outline-success me-3" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/filter.php">Search by Filter</a>
      <form class="d-flex" role="search" id="submitform">
	<input class="form-control me-2" type="search" placeholder="Search by Recipe Name" id="search" aria-label="Search"/>
	<button class="btn btn-outline-success" type="submit">Search</button>
      </form>

	<button class="btn btn-outline-warning ms-2" style="display:none" id="clearSearch" >Clear Search Result</button>
<?php
	}
?>
      <ul class="navbar-nav mb-2 mb-lg-0">
	<li class="nav-item">
	  <a class="btn btn-danger ms-2" href="#" id="logout">Logout</a>
	</li>

</ul>

<?php
}
else
{
?>


      <ul class="navbar-nav  mb-2 mb-lg-0">
<li class="nav-item">
	  <a class="nav-link" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/login.php">Login</a>
	</li>
<li class="nav-item">
	  <a class="nav-link" href="https://recipe-keeper-backend-k8gq.onrender.com/frontend/signup.php">signup</a>
	</li>

</ul>

<?php
}
?>
    </div>
  </div>
</nav>
