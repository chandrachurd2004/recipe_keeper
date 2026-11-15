<?php include "navbar.php";?>
<div class="container">

<p class='h1 text-center'>Signup</p>
<form id="signupform">

<div class="mb-3">
    <label for="exampleusername" class="form-label">Enter name</label>
    <input type="text" class="form-control" id="name">
  </div>

  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" id="email" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" id="Pass">
  </div>

 <button type="submit" class="btn btn-primary">Signup</button>
</form>

</div>
<script src='./bs/bootstrap.bundle.min.js'></script>
<script src='./js/jquery-4.0.0.js'></script>
<script>
$.ajax({
url:"https://recipe-keeper-backend-k8gq.onrender.com/get_user_basic_Detail.php",
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
	url: "https://recipe-keeper-backend-k8gq.onrender.com/signup.php",
		method : "POST",
		data : payload,
		success:function(res){
			let data = JSON.parse(res);
			if(data.success == true)
			{
				window.alert(data.message);
				window.location.href = "https://recipe-keeper-backend-k8gq.onrender.com/frontend/index.php";
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
