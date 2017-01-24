<?php
session_start();
if(isset($_SESSION['login_user'])) {
	header('Location: main.php');
	exit;
}
else {
	
}
?>
<html>
<head>
<title>Login to ChitChat</title>
<link href="reset.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script>
var s=2;
function check_login() {
	var str=document.getElementById("tun").value;
	var str1=document.getElementById("tpw").value;
	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			if(xmlhttp.responseText=="yes") {
				document.getElementById("unmsg").innerHTML="Username OK";
				document.getElementById("unmsg").style.background="green";
				document.getElementById("main").style.display="none";
				document.getElementById("main2").style.display="block";
				 document.getElementById("smsg").innerHTML="Login Successfull. You Will be Redirected in "+s+" Seconds...";
				redirect();
			}
			else if(xmlhttp.responseText=="no") {
				document.getElementById("unmsg").innerHTML="Username or Password do not match";
				document.getElementById("unmsg").style.background="red";
			}
			else {
				document.getElementById("unmsg").innerHTML="Username or Password Field Empty";
				document.getElementById("unmsg").style.background="red";
			}
		}
	}
xmlhttp.open("GET","chk_login.php?un="+str+"&pw="+str1+"",true);
xmlhttp.send();
}
function redirect() {
	setInterval(function(){ document.getElementById("smsg").innerHTML="Login Successfull. You Will be Redirected in "+s+" Seconds..."; s--; }, 1000);
	setInterval(function(){ window.location="main.php" }, 2000);
}

function clk_enter(e) {
    if (e.keyCode == 13) {
        check_login();
        return false;
    }
}
</script>
</head>
<body>
	<div style="height:100%; width:100%; background:url('images/bg.jpg');  float: left; background-size: 100% 100%; background-repeat: no-repeat;">
	<div style="margin:0 auto; width:466px; position:relative; text-align:center; color:white;">
		<h2 style="margin-top:40px;"><img src="images/login.png" height="150px" width="150px" /></h2>
		<div id="main" style="background: rgba(50, 50, 50, 0.6); margin-top:30px; width:400; padding:30px; position:relative; border:1px solid black; text-align:center;     -webkit-box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);
    -moz-box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);
    box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);">
				<p id="unmsg"></p>
				<p style="font-size: 21px;">Username: &nbsp; <input type="text" id="tun" onkeypress="return clk_enter(event)" style="border-color: #cccccc;
    border-radius: 7px;
    border-style: dashed;
    border-width: 1px;
    font-size: 16px;
    padding: 6px;
    text-align: left;" /></p><br>
				<p style="font-size: 21px;">Password: &nbsp; <input type="password" id="tpw" onkeypress="return clk_enter(event)" style="border-color: #cccccc;
    border-radius: 7px;
    border-style: dashed;
    border-width: 1px;
    font-size: 16px;
    padding: 6px;
    text-align: left;" /></p><br>
				<p><button onclick="check_login()" class="btn">LOGIN</button>&nbsp; &nbsp; &nbsp;
				<button class="btn"><a style="text-decoration:none; color:white;" href="reg.php">Register</a></button></p>
		</div>
		<div id="main2" style="margin-top:30px; width:400; padding:20px; position:relative; color:white; border:1px solid black; text-align:center; display:none; background: rgba(50, 50, 50, 0.6);
-webkit-box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);
    -moz-box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);
    box-shadow: 10px 10px 7px 2px rgba(0,0,0,0.3);">
			<h3 id="smsg"></h3>
		</div>
	</div>
</body>
</html>