<?php include "navbar.php";?>

<div class="container fs-4">
<p class="h1 text-center mt-3 mb-3">Welcome to Recipe Keeper</p>

<p style="text-align:justify">
Welcome to your ultimate culinary companion! Recipe Keeper is a digital cookbook and recipe management platform designed to help food lovers, home cooks, and culinary enthusiasts organize, discover, and share their favorite dishes all in one place.   Whether you are looking to preserve a generations-old family secret, plan your weekly meals, or filter recipes based on specific ingredients, Recipe Keeper makes the kitchen experience seamless and inspiring.
</p>

<dl>
<dt>
<p class="h3  mt-5 mb-3">
What Can You Do on Recipe Keeper?
</p>
</dt>
<dd>
<ul>
	<li><strong>Organize Your Personal Cookbook:</strong> Store all your favorite recipes digitally so you never lose a handwritten recipe card again.</li>

	<li><strong>Smart Recipe Filtering: </strong>Easily filter recipes using our advanced categorization tools to find dishes that match your cravings or available ingredients.</li>
	
	<li><strong>Share with the Community:</strong> Publish your own unique recipes, give credit to creators, and explore delicious dishes added by other food enthusiasts.</li>

	<li><strong>Seamless Management:</strong> Easily view, update, or remove your recipes as your kitchen repertoire grows.</li>
</ul>

</dd>

</dl>



<p class="h3  mt-5 mb-3" >Why Choose Recipe Keeper?</p>

<p style="text-align:justify">In a busy world, finding what to cook shouldn't feel like a chore. Recipe Keeper bridges the gap between chaotic bookmarks and messy paper notes. By bringing everything into a clean, searchable, and interactive interface, we empower you to spend less time searching and more time cooking and enjoying great food.</p>

<p class="text-center my-3"><strong>"A recipe has no soul. You, as the cook, must bring soul to the recipe." — Thomas Keller</strong></p>

</div>
<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>

<?php include "footer.php";?>
<script>
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_user_basic_Detail.php",
method:"GET",
success:function(res){
	let data = JSON.parse(res);
	if(data.user_name != null)
	{
		window.location.href = "home.php";
	}
},
	error:function(err){
		console.log(err);
	}
});

</script>
</body>
</html>
