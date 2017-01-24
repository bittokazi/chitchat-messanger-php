<?php
session_start();
if(isset($_SESSION['login_user'])) {
	header('Location: main.php');
	exit;
}
else {
	if(!isset($_COOKIE['un'])) { $un=''; } else { $un=$_COOKIE['un']; }
	if(!isset($_COOKIE['fullname'])) { $fullname=''; } else { $fullname=$_COOKIE['fullname']; }
	if(!isset($_COOKIE['address'])) { $address=''; } else { $address=$_COOKIE['address']; }
	if(!isset($_COOKIE['email'])) { $email=''; } else { $email=$_COOKIE['email']; }
	if(!isset($_COOKIE['phone'])) { $phone=''; } else { $phone=$_COOKIE['phone']; }
	if(!isset($_COOKIE['website'])) { $website=''; } else { $website=$_COOKIE['website']; }
}
?>
<html>
<head>
<title>Register</title>
<link href="reset.css" rel="stylesheet" type="text/css" />
<link href="style.css" rel="stylesheet" type="text/css" />
<script>
var un=0,pw=0;
function check_username() {
	un=0;
	var str=document.getElementById("tun").value;
	
	var b = str.replace(/[^a-z0-9_]/,'');
		if(str.length!=b.length) {
			document.getElementById("unmsg").innerHTML="Username can contain only letters, numbers and Underscore";
			document.getElementById("unmsg").style.background="red";
			un=0;
			return;
		}
	
	if(str.length>4) {
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
				un=1;
			}
			else if(xmlhttp.responseText=="no") {
				document.getElementById("unmsg").innerHTML="Username Exist";
				document.getElementById("unmsg").style.background="red";
				un=0;
			}
			else {
				document.getElementById("unmsg").innerHTML="Username Field Empty";
				document.getElementById("unmsg").style.background="red";
				un=0;
			}
		}
	}
xmlhttp.open("GET","chk_un.php?un="+str,true);
xmlhttp.send();
	}
	else {
		document.getElementById("unmsg").innerHTML="Username Must be Minimum 5 letter";
		document.getElementById("unmsg").style.background="red";
		un=0;
	}
}
function check_password() {
	var str=document.getElementById("tpw").value;
	var str2=document.getElementById("tpw2").value;
	if(str.length>4) {
		document.getElementById("pwmsg").innerHTML="Password OK";
		document.getElementById("pwmsg").style.background="green";
		if(str==str2) {
			pw=1;
		}
	}
	else {
		document.getElementById("pwmsg").innerHTML="Password Must be Minimum 5 letter";
		document.getElementById("pwmsg").style.background="red";
		pw=0;
	}
}
function check_password2() {
	var str=document.getElementById("tpw").value;
	var str2=document.getElementById("tpw2").value;
	if(str.length>4) {
		if(str==str2) {
			document.getElementById("pwmsg2").innerHTML="Password Matches";
			document.getElementById("pwmsg2").style.background="green";
			pw=1;
		}
		else {
			document.getElementById("pwmsg2").innerHTML="Password do not match";
			document.getElementById("pwmsg2").style.background="red";
			pw=0;
		}
	}
	else {
		document.getElementById("pwmsg2").innerHTML="Password Must be Minimum 5 letter";
		document.getElementById("pwmsg2").style.background="red";
		pw=0;
	}
}
function go_reg() {
	if(un==1 && pw==1) {
		document.getElementById("reg1").style.display="none";
		document.getElementById("reg2").style.display="block";
		document.getElementById("reg4").style.display="none";
		document.getElementById("nxtmsg").innerHTML="OK";
		document.getElementById("nxtmsg").style.background="green";
	}
	else {
		document.getElementById("nxtmsg").innerHTML="Give Username,Password correctly";
		document.getElementById("nxtmsg").style.background="red";
	}
}


function confirm_reg() {
if(document.getElementById("mcheck").checked == true) {
document.getElementById("allmsg1").innerHTML="ok";
document.getElementById("allmsg1").style.background="green";
	//document.getElementById("loader_img").style.display="block";
	var xmlhttp;
	var str22
	str22=document.getElementById("ione").value;
	var formData = new FormData();
	formData.append("ione", document.getElementById("ione").files[0])
	var usn=document.getElementById("tun").value;
	var upw=document.getElementById("tpw").value;
	var ufn=document.getElementById("tname").value;
	var uadd=document.getElementById("tadd").value;
	var uemail=document.getElementById("temail").value;
	var uphone=document.getElementById("tphone").value;
	//var uweb=document.getElementById("twebsite").value;
	var uweb=document.getElementById("day").value+'/'+document.getElementById("month").value+'/'+document.getElementById("year").value;
	var error_num=0;
	
	document.getElementById("allmsg").innerHTML="";
	
	if (ufn=="") { document.getElementById("tname").style.border="1px solid red"; document.getElementById("r1").style.display="inline-block"; error_num++; }
	else { document.getElementById("tname").style.border="1px solid green"; document.getElementById("r1").style.display="none"; }
		
	if (uadd=="") { document.getElementById("tadd").style.border="1px solid red"; document.getElementById("r2").style.display="inline-block"; error_num++; }
	else { document.getElementById("tadd").style.border="1px solid green"; document.getElementById("r2").style.display="none"; }
	
	if (uemail=="") { document.getElementById("temail").style.border="1px solid red"; document.getElementById("r4").style.display="inline-block"; error_num++; }
	else { document.getElementById("temail").style.border="1px solid green"; document.getElementById("r4").style.display="none"; }
	
	if (uphone=="") { document.getElementById("tphone").style.border="1px solid red"; document.getElementById("r3").style.display="inline-block"; error_num++; }
	else { document.getElementById("tphone").style.border="1px solid green"; document.getElementById("r3").style.display="none"; }
	
	//if (uweb=="") { document.getElementById("twebsite").style.border="1px solid red"; document.getElementById("r5").style.display="inline-block"; error_num++; }
	//else { document.getElementById("twebsite").style.border="1px solid green"; document.getElementById("r5").style.display="none"; }
	
	if(error_num>0) { 
	document.getElementById("reg4").style.display="none";
	document.getElementById("reg2").style.display="block"; 
	document.getElementById("allmsg").innerHTML="* Complete required fields<br>"; document.getElementById("allmsg").style.background="red"; }
	
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
			if(xmlhttp.responseText=="fl") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"File extension must be .png .jpg .bmp";
				document.getElementById("allmsg").style.background="red";
				document.getElementById("reg4").style.display="none";
				document.getElementById("reg2").style.display="block";
			}
			else if(xmlhttp.responseText=="fs") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"File Size more than 20kb";
				document.getElementById("allmsg").style.background="red";
				document.getElementById("reg4").style.display="none";
				document.getElementById("reg2").style.display="block";
			}
			else if(xmlhttp.responseText=="fe") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"File ERROR";
				document.getElementById("allmsg").style.background="red";
				document.getElementById("reg4").style.display="none";
				document.getElementById("reg2").style.display="block";
			}
			else if(xmlhttp.responseText=="yes") {
				document.getElementById("allmsg").innerHTML="Registration complete";
				document.getElementById("allmsg").style.background="Green";
				document.getElementById("reg4").style.display="none";
				document.getElementById("reg2").style.display="none";
				document.getElementById("reg3").style.display="block";
			}
			else if(xmlhttp.responseText=="all") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"Select Image file please";
				document.getElementById("allmsg").style.background="red";
				document.getElementById("reg4").style.display="none";
				document.getElementById("reg2").style.display="block";
			}
		}
   }
xmlhttp.open("POST","confirm_reg.php?un="+usn+"&pw="+upw+"&fullname="+ufn+"&address="+uadd+"&email="+uemail+"&phone="+uphone+"&website="+uweb+"",true);
xmlhttp.send(formData);
}
else {
document.getElementById("allmsg1").innerHTML="please confirm term and condition";
document.getElementById("allmsg1").style.background="red";
}
}

function check_final_box(vvv,did,rr) {
	if (vvv=="") { document.getElementById(did).style.border="1px solid red"; document.getElementById(rr).style.display="inline-block"; error_num++; }
	else { document.getElementById(did).style.border="1px solid green"; document.getElementById(rr).style.display="none"; }
}

function go_back() {
	document.getElementById("reg1").style.display="block";
	document.getElementById("reg2").style.display="none";
}

function go_next() {
	document.getElementById("reg4").style.display="block";
	document.getElementById("reg2").style.display="none";
}








function check_cookies() {
	var str=document.getElementById("tun").value;
	var ufn=document.getElementById("tname").value;
	var uadd=document.getElementById("tadd").value;
	var uemail=document.getElementById("temail").value;
	var uphone=document.getElementById("tphone").value;
	var uweb="null";
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
			
		}
	}
xmlhttp.open("GET","save_cookies.php?un="+str+"&fullname="+ufn+"&address="+uadd+"&email="+uemail+"&phone="+uphone+"&website="+uweb+"",true);
xmlhttp.send();
}

setInterval(function(){ check_cookies(); }, 7000);
</script>
</head>
<body>
<div style="min-height:100%; width:100%; background:url('images/bg.jpg');  float: left; background-size: 100% 100%; background-repeat: no-repeat;">
	<div style="margin:0 auto; width:466px; position:relative; text-align:center; color:white;">
		<h2 style="margin-top:40px;"><img src="images/reg.png" height="150px" width="150px" /></h2>
		<div id="reg1" style="display:block;">
			<div class="box-log">
				<p style="margin-left: -5px; font-size:21;">Username: &nbsp; <input class="text-fld" type="text" id="tun" onkeyup="check_username()" onblur="check_username()" value="<?php echo $un; ?>" /></p>
				<p id="unmsg" style="color:white;"></p><br>
				<p style="font-size:21;">Password: &nbsp; <input class="text-fld" type="password" id="tpw" onblur="check_password()" /></p>
				<p id="pwmsg" style="color:white;"></p><br>
				<p style="margin-left: 9px; font-size:21;">Re-Type: &nbsp; <input class="text-fld" type="password" id="tpw2" onblur="check_password2()" onkeyup="check_password2()" /></p>
				<p id="pwmsg2" style="color:white;"></p><br>
				<p><button onclick="go_reg()" class="btn">Next</button>
				<p id="nxtmsg"></p>
			</div>
		</div>
		
		<div id="reg2" style="display:none;">
			<div class="box-log">
			<div style="float:left; text-align:right;">
			<p style="font-size:21; padding-right:9px;">Upload Image:</p><br>
			<p style="font-size:21; padding-top:9px; padding-right:9px;">Full Name:</p><br>
			<p style="font-size:21; padding-top:14px; padding-right:9px;">Address:</p><br>
			<p style="font-size:21; padding-top:14px; padding-right:9px;">Phone:</p><br>
			<p style="font-size:21; padding-top:14px; padding-right:9px;">Email:</p><br>
			<p style="font-size:21; padding-top:14px; padding-right:9px;">DOB:</p><br>
			
			</div>
			<div style="float:left; text-align:left;">
			<p style="font-size:21;"><input type="file" name="ione" id="ione" style=""/></p><br>
			<p style="font-size:21;"><input class="text-fld" type="text" id="tname" onkeyup="check_final_box(this.value,'tname','r1')" onblur="check_final_box(this.value,'tname','r1')" value="<?php echo $fullname; ?>" /><b id="r1" style="display:none; color:red">*</b></p><br>
			<p style="font-size:21;"><input class="text-fld" type="text" id="tadd" onkeyup="check_final_box(this.value,'tadd','r2')" onblur="check_final_box(this.value,'tadd','r2')" value="<?php echo $address; ?>" /><b id="r2" style="display:none; color:red">*</b></p><br>
			<p style="font-size:21;"><input class="text-fld" type="text" id="tphone" onkeyup="check_final_box(this.value,'tphone','r3')" onblur="check_final_box(this.value,'tphone','r3')" value="<?php echo $phone; ?>" /><b id="r3" style="display:none; color:red">*</b></p><br>
			<p style="font-size:21;"><input class="text-fld" type="text" id="temail" onkeyup="check_final_box(this.value,'temail','r4')" onblur="check_final_box(this.value,'temail','r4')" value="<?php echo $email; ?>" /><b id="r4" style="display:none; color:red">*</b></p><br>
			<p style="font-size:10;">D:
			<select class="text-fld" id="day">
			<?php
				for($i=1; $i<31; $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			?>
			</select>
			M:
			<select class="text-fld" id="month">
			<?php
				for($i=1; $i<12; $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			?>
			</select>
			Y:
			<select class="text-fld" id="year">
			<?php
				for($i=1990; $i<date('Y'); $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			?>
			</select>
			</p><br>
			</div>
			<div style="clear:both"></div>
			<div style="float:left; text-align:center; width:395px;">
			<p id="allmsg" style="color:white;"></p><br>
			<p><button onclick="go_back()" class="btn">Back</button>
			&nbsp; &nbsp; <button onclick="go_next()" class="btn">Next</button></p>
			</div>
			</div>
		</div>
		<div id="reg3" style="display:none;">
			<div class="box-log">
				<h3>Registration Successfull. <a href="login.php" style="color:red; text-decoration:none;">Login Here</a></h3>
			</div>
		</div>
		<div id="reg4" style="display:none;">
		<div class="box-log">
			<p style="font-size:15;">We may collect any or all of the information that you give us depending on the type of transaction you enter into, including your name, address, telephone number, and email address, together with data about your use of the website. Other information that may be needed from time to time to process a request may also be collected as indicated on the website.</p><br>
			<p><input type="checkbox" id="mcheck"/> I Agree to the term and conditions</p><br>
			<p id="allmsg1" style="color:white;"></p><br>
			<p><button onclick="go_reg()" class="btn">Back</button>
			&nbsp; &nbsp; <button onclick="confirm_reg()" class="btn">Register</button></p>
		</div>
		</div>
	</div>
</div>
</body>
</html>