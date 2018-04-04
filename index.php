<!DOCTYPE html>
<html>
<head>
	<title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
	<meta name="google-signin-client_id" content="460810948645-nbiiqnluuq9ojhmrn033a45k8v063jkh.apps.googleusercontent.com">
	<script src="https://apis.google.com/js/platform.js" async defer></script>
	<script type="text/javascript">
		function update_user_data(response) 
			{
			      $.ajax({
			            type: "POST",
			            data: {response: response},
			            url: 'check_user.php',
			            success: function(msg) {
			            	document.write(msg);
			            	/*alert(msg);*/
			               /*$.(#div1).html(msg);*/
			            }
			      });
			}
		function Google_signIn(googleUser) {
			  var profile = googleUser.getBasicProfile();
			  var arra = [profile.getId(),profile.getName(), profile.getEmail(), profile.getImageUrl()];
			  
			  //pass information to server to insert or update the user record
			  update_user_data(arra);
			}
		function signOut() {
		   var auth2 = gapi.auth2.getAuthInstance();
		   auth2.signOut().then(function () {
		     console.log('User signed out.');
		   });
		 }

	</script>

</head>
<body>
	<div id="div1"></div>
<div class="g-signin2" data-longtitle="true" data-onsuccess="Google_signIn" data-theme="light" data-width="200"></div>
<script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
</body>
</html>