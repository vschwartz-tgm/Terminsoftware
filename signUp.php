<html>
<head>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap/js/bootstrap.min.js">
<link href="signUp_CSS.css" rel="stylesheet">
<link rel="icon" href="kalender.jpg">
<script src="/node_modules/angular/angular.js"></script>
<title>Terminreservierung</title>
</head>
<body>
<form action="/" method="get" style="border:1px solid #ccc">
  <div class="container">
    <h1>Sign Up</h1>
    <hr>
	
	<label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" id="uname" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" id="email" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="passwd" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

    <label>
      <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> Remember me
    </label>

    <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms & Privacy</a>.</p>
	  
    <div class="clearfix">
      <button type="button" class="cancelbtn" onclick ="window.location = 'index.html'">Cancel</button>
      <button type="submit" class="signupbtn" onclick = "saveData()">Sign Up</button>

    </div>
  </div>
</form>
</body>
</html>

	  


<? php
function saveData(){
	$myfile = fopen("login.txt", "w") or die("Unable to open file!");
	$txt = 	$_GET['uname'];
	fwrite($myfile, $txt);
}
?>