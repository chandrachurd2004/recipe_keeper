<?php include "navbar.php";?>
<div class="container">

<p class='h1 mx-auto' style='width:18rem'>Login</p>
<form id="signupform">

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="Pass">
  </div>

 <button type="submit" class="btn btn-primary">Login</button>
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
		if(data.user_name != null)
		{
			window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php";
		}

	},
	error:function(err){
		console.log(err);
	}
});

$("#signupform").on("submit",function(event){
	event.preventDefault();
	let payload = {};
	payload['user_name'] = $("#name").val();
	payload['user_email'] = $("#email").val();
	payload['user_password'] = $("#Pass").val();
	console.log(payload);
	$.ajax({
	url: "https://recipe-keeper-backend-k8gq.onrender.com/backend/login.php",
		method : "POST",
		data : payload,
		success:function(res){
			let data = JSON.parse(res);
			if(data.success == true)
			{
document.cookie = "login=true;";
				window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/home.php";
			}
			else
			{
				alert(data.message);
			}
		},
			error:function(err){
				console.log(err);
			}
	});

});
</script>

<?php include "footer.php";?>
</body>
</html>
