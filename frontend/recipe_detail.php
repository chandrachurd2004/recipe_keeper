<?php include "navbar.php";?>
<div class="container">

<div id="recipe_display">
</div>

<div id="recipe_map">
<p class="h5"><strong><u>Catagory of this recipe : NONE</u></strong></p>
</div>
<a class="btn btn-warning" onclick="update()">Update</a>
<a class="btn btn-danger" onclick="del()">Delete</a>

</div>
<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>
<script>

const recipeid = getCookie('recipe_id');
function update()
{
	document.cookie = "recipe_id="+recipeid;
	window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/recipe_update.php";
}
function del()
{

	if(confirm("are your sure"))
	{
		//del

		$.ajax({
		url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_delete.php",
			method:"POST",
			data:{"recipe_id" : recipeid},
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
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_user_basic_Detail.php",
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

function get_details_map(r_id)
{

	$.ajax({
	url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_display_particular_map.php",
		method:"POST",
		data : {recipe_id : r_id},
		success:function(res){
			let data = JSON.parse(res);
			let i = 0 ;
			let html_str = `<u><strong>Catagory of this recipe</strong></u> : <br><p>`;
			for(d of data.data)
			{
				html_str += `${i+1}`+". "+d.catagory3_name + `<br>`;
				i++;

				//console.log(d.catagory3_name);
			}
			html_str += `</p>`;
			if(i > 0 )
			{
				$("#recipe_map").html(html_str)
			}
		},
		error:function(err){
			console.log(err);
		}
});

}

function get_details(r_id)
{
	$.ajax({
	url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_display_particular.php",
		method:"POST",
		data : {recipe_id : r_id},
		success:function(res){
			let data = JSON.parse(res);
			let sen = data.data[0].recipe_ingredient.split(/\\n|\n/).map(item => item.trim()).filter(item => item.length > 0);
			let sen1 = data.data[0].recipe_step.split(/\n/).map(item => item.trim()).filter(item => item.length > 0);
			let htmlstr = `<p class='h1 mt-5'>Recipe Name : ${data.data[0].recipe_name}</p>`;

			htmlstr += `<strong><p class='text-end fs-4'>added by : ${data.data[0].user_name}</p></strong>`;

			htmlstr += `<p class='h4'><u><strong>Recipe Description</strong></u> : ${data.data[0].recipe_description}</p>`;
			htmlstr += `<p class='h4'><u><strong>Recipe Ingredient </strong></u></p> <p>${sen.join("<br>")}</p>`;
			htmlstr += `<p class='h4'><u><strong>Recipe Step</strong></u></p> <p>${sen1.join("<br>")}</p>`;

			$("#recipe_display").html(htmlstr);


			get_details_map(r_id);
		},
		error:function(err){
			console.log(err);
		}
});

}


function getCookie(name) {
	const cookies = document.cookie.split(';');
	for (let cookie of cookies) {
		cookie = cookie.trim();
		if (cookie.startsWith(name + '=')) {
			return decodeURIComponent(cookie.substring(name.length + 1));
		}
	}
	return null;
}

// Get and display the username cookie
if(recipeid > 0)
{
	document.cookie = "recipe_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/frontend";
	get_details(recipeid);
}
else
{
	document.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php";
}

</script>
<?php include "footer.php";?>
</body>
</html>
