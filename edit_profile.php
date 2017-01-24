<?php
session_start();
if(isset($_SESSION['login_user'])) {
	include('db.php');
	$un=$_SESSION['login_user'];
}
else {
	header("Location: index.php");
	exit;
}
?>
<html>
<head>
<title>Dashboard</title>
<script>
function edit_info() {
	var xmlhttp;
	var ufn=document.getElementById("tname").value;
	var uadd=document.getElementById("tadd").value;
	var uemail=document.getElementById("temail").value;
	var uphone=document.getElementById("tphone").value;
	var uweb=document.getElementById("twebsite").value;
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
	
	if (uweb=="") { document.getElementById("twebsite").style.border="1px solid red"; document.getElementById("r5").style.display="inline-block"; error_num++; }
	else { document.getElementById("twebsite").style.border="1px solid green"; document.getElementById("r5").style.display="none"; }
	
	if(error_num>0) { document.getElementById("allmsg").innerHTML="* Complete required fields<br>"; document.getElementById("allmsg").style.background="red"; }
	
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
			if(xmlhttp.responseText=="error") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"Couldnt update";
				document.getElementById("allmsg").style.background="red";
			}
			else if(xmlhttp.responseText=="ok") {
				document.getElementById("allmsg").innerHTML="Update Successfull";
				document.getElementById("allmsg").style.background="Green";
			}
		}
   }
   xmlhttp.open("GET","edit_pro_action.php?edit=info&fullname="+ufn+"&address="+uadd+"&email="+uemail+"&phone="+uphone+"&website="+uweb+"",true);
   xmlhttp.send();
}

function check_final_box(vvv,did,rr) {
	if (vvv=="") { document.getElementById(did).style.border="1px solid red"; document.getElementById(rr).style.display="inline-block"; error_num++; }
	else { document.getElementById(did).style.border="1px solid green"; document.getElementById(rr).style.display="none"; }
}

var pp=0;
function edit_picture() {
	var xmlhttp;
	var str22
	str22=document.getElementById("ione").value;
	var formData = new FormData();
	formData.append("ione", document.getElementById("ione").files[0])
	document.getElementById("allmsg").innerHTML="";
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
			}
			else if(xmlhttp.responseText=="fs") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"File Size more than 20kb";
				document.getElementById("allmsg").style.background="red";
			}
			else if(xmlhttp.responseText=="fe") {
				document.getElementById("allmsg").innerHTML=document.getElementById("allmsg").innerHTML+"File ERROR";
				document.getElementById("allmsg").style.background="red";
			}
			else {
				document.getElementById("allmsg").innerHTML="Profile Picture Update Successfull";
				document.getElementById("allmsg").style.background="Green";
				document.getElementById("pp").src="uploads/pp_"+xmlhttp.responseText+"?pp="+pp;
				pp++;
			}
		}
	}
xmlhttp.open("POST","edit_pro_action.php?edit=picture",true);
xmlhttp.send(formData);
}
</script>
</head>
<body style="background: #E0E0D1; margin:0; padding:0;">
	<div style="margin:0 auto; width:900px; position:relative; text-align:center;">
		<div style="height:150px; width:896px; border:2px solid black; background:#FCFCFA; float:left;">
		<h1 style="font-size:55px;"><a style="text-decoration:none; color:black;" href="dash.php">Dashboard</a></h1>
		</div>
		<div style="width:900px; background:#FCFCFA; margin-top:-2px; float:left;">
			<div style="width:580px; height:400px; border:2px solid black; float:left; padding:10px; font-size:15px; text-align:left;">
			<?php
			$sql="SELECT * FROM user_info WHERE username='$un'";
			$result=$mysqli->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					
					$propic=$row['picture'];
					echo'
					<p>Upload Image: &nbsp;&nbsp;&nbsp;<input type="file" name="ione" id="ione" style=""/> <button onclick="edit_picture()">Upload</button></p>
			<p>Full Name: &nbsp; &nbsp; &nbsp; <input type="text" id="tname" onkeyup="check_final_box(this.value,\'tname\',\'r1\')" onblur="check_final_box(this.value,\'tname\',\'r1\')" value="'.$row['firstname'].'" /><b id="r1" style="display:none; color:red">*</b></p>
			<p>Address: &nbsp; &nbsp; &nbsp; <input type="text" id="tadd" onkeyup="check_final_box(this.value,\'tadd\',\'r2\')" onblur="check_final_box(this.value,\'tadd\',\'r2\')" value="'.$row['address'].'" /><b id="r2" style="display:none; color:red">*</b></p>
			<p>Phone: &nbsp; &nbsp; &nbsp; <input type="text" id="tphone" onkeyup="check_final_box(this.value,\'tphone\',\'r3\')" onblur="check_final_box(this.value,\'tphone\',\'r3\')" value="'.$row['phone'].'" /><b id="r3" style="display:none; color:red">*</b></p>
			<p>Email: &nbsp; &nbsp; &nbsp; <input type="text" id="temail" onkeyup="check_final_box(this.value,\'temail\',\'r4\')" onblur="check_final_box(this.value,\'temail\',\'r4\')" value="'.$row['email'].'" /><b id="r4" style="display:none; color:red">*</b></p>
			<p>Website: &nbsp; &nbsp; &nbsp; <input type="text" id="twebsite" onkeyup="check_final_box(this.value,\'twebsite\',\'r5\')" onblur="check_final_box(this.value,\'twebsite\',\'r5\')" value="'.$row['website'].'" /><b id="r5" style="display:none; color:red">*</b></p>
			<p id="allmsg" style="color:white;"></p>
			<p><button onclick="edit_info()" style="background: none; border-radius: 20px; padding: 10px; font-size: 18px;">Save</button>
					';
				}
			}
			?>
			</div>
			<div style="width:294px; height:420px; border:2px solid black; float:left; margin-left:-2px;">
				<p><img id="pp" src="uploads/pp_<?php echo $propic; ?>" height="250px" width="250px" /></p>
				<p>Welcome Back, <?php echo $un; ?></p>
				<p><a style="text-decoration:none; color:black;" href="logout.php">Logout?</a></p>
			</div>
		</div>
	</div>
</body>
</html>