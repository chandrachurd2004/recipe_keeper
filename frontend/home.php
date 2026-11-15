<?php 
include "navbar.php";
?>

<p class='h1 pt-3 text-center'>Welcome <span id="user"></span></p>
<p class='h3 pt-3 text-center'>Let's make your time special with these exiting recipes</p>

<div class="container mt-5">
<div id="recipe" >
</div>
</div>

<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>
<script>
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/backend/get_user_basic_Detail.php",
	method:"GET",
	success:function(res){
		let data = JSON.parse(res);
		if(data.user_name == null)
		{
			window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/index.php";
		}
		$("#user").html(data.user_name);
	},
	error:function(err){
		console.log(err);
	}
});

function load(){

$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/backend/recipe_display_all.php",
	method:"GET",
	success:function(res){

		let data = JSON.parse(res);

		let i  = 1;

		let htmlstr = `<div class="row g-3">`;
		for (d of data.data)
		{
			if(i == 3)
			{
				htmlstr += `</div><div class="mt-3 row g-3">`;
				i = 1;
			}
			htmlstr += `
			<div class="col-12 col-md-6">
				<div class="card h-100"> 
				<div class="card-body">
				<h5 class="card-title">${d.recipe_name}</h5>
				<p class="card-text">${d.recipe_description}</p>
				<p class="h6">added by :${d.user_name}</p>
				<a id="${d.recipe_id}" onclick="view(this)" class="btn btn-primary">View</a>
				<a id="${d.recipe_id}" onclick="update(this)" class="btn btn-warning">Update</a>
				<a id="${d.recipe_id}" onclick="del(this)" class="btn btn-danger">Delete</a>
				</div>
				</div>
				</div>`;
			i++;
		}

		if(i != 1)
		{
			htmlstr += `</div>`;
		}
			$("#recipe").html(htmlstr);
	},
	error:function(err){
		console.log(err);
	}
});

}
load();

$('#submitform').on("submit",function(e){
	e.preventDefault();
	let search = $('#search').val();
	if(search == "")
	{
		load();
		return;
	}

	$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/backend/recipe_search.php",
	method:"POST",
	data:{"recipe_name" : search},
	success:function(res){

		let data = JSON.parse(res);
		if(data.data.length == 0 )
		{
			window.alert("nothing found");
			return;
		}


		let i  = 1;

		let htmlstr = `<p class='h2'>Search Result</p> <div class="row g-3">`;
		for (d of data.data)
		{
			if(i == 3)
			{
				htmlstr += `</div><div class="mt-3 row g-3">`;
				i = 1;
			}
			htmlstr += `
			<div class="col-12 col-md-6">
				<div class="card h-100">
				<div class="card-body">
				<h5 class="card-title">${d.recipe_name}</h5>
				<p class="card-text">${d.recipe_description}</p>
				<p class="h6">added by :${d.user_name}</p>
				<a id="${d.recipe_id}" onclick="view(this)" class="btn btn-primary">View</a>
				<a id="${d.recipe_id}" onclick="update(this)" class="btn btn-warning">Update</a>
				<a id="${d.recipe_id}" onclick="del(this)" class="btn btn-danger">Delete</a>
				</div>
				</div>
				</div>`;
			i++;
		}

		if(i != 1)
		{
			htmlstr += `</div>`;
		}
			$("#recipe").html(htmlstr);
		$("#clearSearch").css("display","block");
	},
	error:function(err){
		console.log(err);
	}
});


});

$("#clearSearch").on("click",function(){


	 $('#search').val("");

	load();
	$("#clearSearch").css("display","none");
});


function view(t)
{
	document.cookie = "recipe_id="+t.id;
	window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/recipe_detail.php";

}


function update(t)
{

	document.cookie = "recipe_id="+t.id;
	window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/recipe_update.php";

}



function del(t)
{

	if(confirm("are your sure"))
	{
		//del

		$.ajax({
		url:"https://recipe-keeper-backend-k8gq.onrender.com/backend/recipe_delete.php",
			method:"POST",
			data:{"recipe_id" : t.id},
			success:function(res){
				let data = JSON.parse(res);
				if(data.success == true)
				{
					window.alert("recipe deleted successfully");
					window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php";
				}


			},
			error:function(err){
				console.log(err);
			}
	});

	}

}

</script>

<?php include "footer.php";?>
</body>
</html>
