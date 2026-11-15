<footer>
<div class="mx-auto " style="width:18rem">
&copy; Recipe keeeper 2026
</div>
</footer>
<script>
$("#logout").on("click",function(){
	$.ajax({
	url : "https://recipe-keeper-backend-k8gq.onrender.com/logout.php",
		method : "GET",
		success:function(res){
			let data = JSON.parse(res);
			if(data.success == true)
			{
				document.cookie = "login=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
				alert("logout successfull");
				window.location.href = "http://127.0.0.1:8081/25mmcf27/WadProject/frontend/"
			}
			else
			{
				alert("logout unsuccessfull");
				window.location.href = "home.php"
			
			}


		},
			error: function(err){
				console.log(err);
			}

});
});

</script>
