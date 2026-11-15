<?php 
include "navbar.php";
?>

<div class="container">

<p class="fs-3 mt-5">Select Catagory From Below to Search</p>

<div id="recipe" class="mt-5">
</div>
<button id="button" disabled class="btn btn-primary">Search</button>
</div>

<div class="container">
<p class="h1 mt-5">Result</p>
<div id="result">
<p class="h4 fs-bold">Select to See result</p>
</div>
</div>

<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>
<script>

let map = new Set();

$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_user_basic_Detail.php",
	method:"GET",
	success:function(res){
		let data = JSON.parse(res);
		if(data.user_name == null)
		{
			window.location.href = "index.php";
		}
		$("#user").html(data.user_name);
	},
	error:function(err){
		console.log(err);
	}
});

$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_level1_catagorization.php",
	method:"GET",
	success:function(res){
		let data = JSON.parse(res);
		let str=`<hr>`;
		for (d of data.data)
		{
			str+= `<button type="button" class="btn" id="${d.catagory1_id}" onclick="cat2_fetch(this)"><strong class="fs-4">${d.catagory1_name}</strong></button>`;
			str+=`<div id="cat1_${d.catagory1_id}"></div>`;
			str+=`<hr>`;
		}

		$("#recipe").html(str);
	},
	error:function(err){
		console.log(err);
	}
});
function cat2_fetch(t)
{
	let cat1 = t.id;
	let divs = "#cat1_"+t.id
		$.ajax({
		url:"https://recipe-keeper-backend-k8gq.onrender.com/get_level2_catagorization.php",
			method:"GET",
			data:{"l1_id":cat1},
			success:function(res){
				let data = JSON.parse(res);
				let str = ``;
				for(d of data.data)
				{

					str+= `<button type="button" class="btn" id="${d.catagory2_id}" onclick="cat3_fetch(this)"><span class="fs-5">${d.catagory2_name}</span></button>`;
					
			str+=`<div id="cat2_${d.catagory2_id}"></div>`;
				}
				$(divs).html(str);
			},
			error:function(err){
				console.log(err);
			}
	});

}

function cat3_fetch(t)
{
	let l2 = t.id;
	let divs = "#cat2_"+l2;
	$.ajax({
	url:"https://recipe-keeper-backend-k8gq.onrender.com/get_level3_catagorization.php",
		method:"GET",
		data:{"l2_id":l2},
		success:function(res){
			let data = JSON.parse(res);
			let str = ``;
			for(d of data.data)
			{
				str+= `<input type="checkbox" id="${d.catagory3_id}" onclick="updatearr(this)"> ${d.catagory3_name}<br>`;
			}

			$(divs).html(str);
			$("#button").prop("disabled",false);
		},
		error:function(err){
			console.log(err);
		}
	});

}


$("#button").on("click",function(){

const str = [...map].join(', ');

	$.ajax({
	url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_filter.php",
		method:"POST",
		data :{"map":str},
		success:function(res){

			let htmlstr = ``;
			let data = JSON.parse(res);
			console.log(data);
			if(data.data.length == 0 )
			{

				htmlstr = "<p class='h4 fs-bold'>data not found with selected set of catagory</p>"
				
			$("#result").html(htmlstr);
				return ;
			}

			let i  = 1;

			htmlstr = `<div class="row g-3">`;
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
			$("#result").html(htmlstr);
		},
		error:function(err){
			console.log(err);
		}
});

});

function updatearr(t)
{
	let catId = Number(t.id);
	if(t.checked)
	{
		map.add(catId);
	}
	else
	{
		map.delete(catId); 
	}
}

function view(t)
{
	document.cookie = "recipe_id="+t.id;
	window.location.href = "recipe_detail.php";

}


function update(t)
{

	document.cookie = "recipe_id="+t.id;
	window.location.href = "recipe_update.php";

}



function del(t)
{

	if(confirm("are your sure"))
	{
		//del

		$.ajax({
		url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_delete.php",
			method:"POST",
			data:{"recipe_id" : t.id},
			success:function(res){
				let data = JSON.parse(res);
				if(data.success == true)
				{
					window.alert("recipe deleted successfully");
					window.location.href = "home.php";
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

