<?php include "navbar.php";?>

<div class="container">

<p class='h1 mx-auto' style='width:18rem'>Add Product</p>
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


 <input type="submit"  value="submit" class="btn btn-primary">
</form>

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


let map = new Set();
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/backend/get_level1_catagorization.php",
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
	payload['recipe_name'] = $("#name").val();
	payload['recipe_description'] = $("#description").val();
	payload['recipe_step'] = $("#step").val();
	payload['recipe_ingredient'] = $("#ingredient").val();
	payload['map'] = [...map].join(); 

$.ajax({
        url: "https://recipe-keeper-backend-k8gq.onrender.com/backend/recipe_add.php",
        method: "POST",
        data: payload,
        success: function(res) {
            let data = JSON.parse(res);

            if(data.success == true) {
		    window.alert("recipe added successfully");
		    window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php";

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
        url: "https://recipe-keeper-backend-k8gq.onrender.com/backend/get_level2_catagorization.php",
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
        url: "https://recipe-keeper-backend-k8gq.onrender.com/backend/get_level3_catagorization.php",
        method: "GET",
        data: { "l2_id": level2Id },
        success: function(res) {
            let data = JSON.parse(res);

            if(data.success == true) {
                let htmlstr = ``;
                for(let d of data.data) {
                    // Note: Calling selectedCat2 for level 2 items instead of selectedCat1

			htmlstr += `<input type='checkbox' value='${d.catagory3_id}' class='my-check'> ${d.catagory3_name} <br>`;
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
