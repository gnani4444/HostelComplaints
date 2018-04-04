<?php
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
	<title>Logout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="google-signin-client_id" content="460810948645-nbiiqnluuq9ojhmrn033a45k8v063jkh.apps.googleusercontent.com">
        <script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
<div class="g-signin2" data-onsuccess="onSignIn"></div>
<br>
Do you want to logout?
<a href="#" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      alert('User signed out.');
      window.open('../index.php','_self');
    });
  }
</script>
Or
<a href="../index.php">Take me Back</a>

<script src="https://apis.google.com/js/platform.js" async defer></script>
</body>
</html>


