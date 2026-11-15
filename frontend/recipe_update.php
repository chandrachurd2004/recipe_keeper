<?php include "navbar.php";?>
<div class="container">

<p class='h1 text-center' >Update Product</p>
<form id="addform">

<div class="mb-3">
    <label class="form-label">Enter Recipe Name</label>
    <input type="text" class="form-control" id="name">
  </div>


<div class="mb-3">
    <label  class="form-label">Enter Recipe Description</label>
<textarea id="description" class="form-control"></textarea>
  </div>

<div class="mb-3">
    <label class="form-label">Enter Recipe Ingredients</label>
<textarea id="ingredient" class="form-control"></textarea>
  </div>

<div class="mb-3">
    <label  class="form-label">Enter Recipe Step</label>
<textarea id="step" class="form-control"></textarea>
  </div>
<br>

<div class="mb-3">
    <label  class="form-label">Select Catagory</label>
<div id="cat1"> </div>
  </div>


 <input type="submit"  value="Update" class="btn btn-primary">
</form>

</div>
<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>
<script>

let map = new Set();

let recipeid = getCookie("recipe_id");
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


function populate_map(recipeid)
{
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/edit_recipe_map_get.php?recipe_id"+recipeid,
	method:"GET",
	data : {recipe_id : recipeid},
	success:function(res){
		let data = JSON.parse(res);
		map = new Set(data.data.split(",").map(Number));
	},
	error:function(err){
		console.log(err);
	}
});


}

function populate(recipeid)
{

$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/recipe_display_particular.php",
	method:"POST",
	data : {recipe_id : recipeid},
	success:function(res){
		let data = JSON.parse(res);
		$("#name").val(data.data[0].recipe_name);
		$("#description").val(data.data[0].recipe_description);
		$("#ingredient").val(data.data[0].recipe_ingredient);
		$("#step").val(data.data[0].recipe_step);
		populate_map(recipeid)

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
	document.cookie = "recipe_id=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/25mmcf27/WadProject/frontend";
	populate(recipeid);
}
else
{
	document.location.href = "home.php";
}






$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_level1_catagorization.php",
	method: "GET",
	success:function(res){
		let data = JSON.parse(res);
		if(data.success == true)
		{
			let htmlstr = `<hr>`;
			for(let d of data.data )
			{
				htmlstr += `<button type="button" id='${d.catagory1_id}' class="btn" onclick="selectedCat1(this)">${d.catagory1_name}</button>`;
				htmlstr += `<br>
					<div id="cat2_${d.catagory1_id}"></div>
					<hr>`;
			}
			$("#cat1").html(htmlstr);
		}
	},
		error:function(err){
			console.log(err);
		}
});

$("#addform").on("submit",function(event){
	event.preventDefault();
	let payload = {};
	payload['recipe_id'] = recipeid;
	payload['recipe_name'] = $("#name").val();
	payload['recipe_description'] = $("#description").val();
	payload['recipe_step'] = $("#step").val();
	payload['recipe_ingredient'] = $("#ingredient").val();
	payload['map'] = [...map].join(); 

$.ajax({
        url: "https://recipe-keeper-backend-k8gq.onrender.com/recipe_edit.php",
        method: "POST",
        data: payload,
        success: function(res) {
            let data = JSON.parse(res);

            if(data.success == true) {
		    window.alert("recipe updated successfully");
		    window.location.href = "home.php";

            }
        },
        error: function(err) {
            console.log(err);
        }
    });



});

function selectedCat1(t) {
    let level1Id = t.id;

    $.ajax({
        url: "https://recipe-keeper-backend-k8gq.onrender.com/get_level2_catagorization.php",
        method: "GET",
        data: { "l1_id": level1Id },
        success: function(res) {
            let data = JSON.parse(res);

            if(data.success == true) {
                let htmlstr = ``;
                for(let d of data.data) {
                    // Note: Calling selectedCat2 for level 2 items instead of selectedCat1
                    htmlstr += `<button type="button" id='${d.catagory2_id}' class="btn" onclick="selectedCat2(this)">${d.catagory2_name}</button>`;
                    htmlstr += `<br><div id="cat3_${d.catagory2_id}"></div>`;
                }
                
                let targetDiv = "#cat2_" + level1Id;
                $(targetDiv).html(htmlstr);
            }
        },
        error: function(err) {
            console.log(err);
        }
    });
}

// Separate function for handling level 2 category clicks
function selectedCat2(t) {
    let level2Id = t.id;

    //console.log("Level 2 category clicked ID:", level2Id);
    // Add your Level 3 AJAX call here if needed
       $.ajax({
        url: "https://recipe-keeper-backend-k8gq.onrender.com/get_level3_catagorization.php",
        method: "GET",
        data: { "l2_id": level2Id },
        success: function(res) {
            let data = JSON.parse(res);

            if(data.success == true) {
                let htmlstr = ``;
                for(let d of data.data) {
                    // Note: Calling selectedCat2 for level 2 items instead of selectedCat1

			if(map.has(d.catagory3_id))
			{
			htmlstr += `<input type='checkbox' checked value='${d.catagory3_id}' class='my-check'> ${d.catagory3_name} <br>`;
			}
			else
			{
			htmlstr += `<input type='checkbox' value='${d.catagory3_id}' class='my-check'> ${d.catagory3_name} <br>`;
			}
                }
		let target = "#cat3_"+level2Id;
		$(target).html(htmlstr);
                
            }
        },
        error: function(err) {
            console.log(err);
        }
    });

}

$(document).on("change", ".my-check", function() {
    let catId = Number(this.value);
    if(this.checked)
    {
        map.add(catId);
    }
    else
    {
        map.delete(catId); 
    }
});

</script>

<?php include "footer.php";?>
</body>
</html>
