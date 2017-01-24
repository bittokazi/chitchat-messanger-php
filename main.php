<?php
session_start();
if(!isset($_SESSION['login_user'])) {
	header('Location: login.php');
	exit;
}
else {
	include('db.php');
	$un=$_SESSION['login_user'];
}
?>
<html>
<head>
<title>ChitChat Messenger</title>
	<link href="reset.css" rel="stylesheet" type="text/css" />
	<link href="style.css" rel="stylesheet" type="text/css" />
	<script src="jquery-1.11.3.js"></script>
	<script src="jquery-ui.js"></script>
	
	<link rel="stylesheet" href="scroll-bar/jquery.mCustomScrollbar.css" />
	<script src="scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
	
	<script>
    (function($){
        $(window).load(function(){
			$("#divid0").mCustomScrollbar();
            $("#divid1").mCustomScrollbar();
			$("#divid2").mCustomScrollbar();
        });
    })(jQuery);
	function status_update_enable() {
		document.getElementById('stts').style.display="none";
		document.getElementById('tf_stts').style.display="block";
		document.getElementById('tf_stts').select();
		document.getElementById('tf_stts').value=document.getElementById('stts').innerHTML;
	}
	function status_update_disable() {
		document.getElementById('tf_stts').style.display="none";
		document.getElementById('stts').style.display="block";
	}
</script>
</head>
<body>
	<div id="wrapper">
		<div class="left">
			<div class="user-section">
			<h5 style="float:left; padding: 8px; font-size:18px; width: 238px;">Welcome back, <?php echo $un; ?></h5>
			<p style="float:left;    margin-top: 3px;
    margin-left: 12px;"><a href="logout.php"><img src="images/so.png" height="30px" width="30px" /></a></p>
			<div style="clear:both;"></div>
			<div style="float:left; padding: 8px; font-size:18px;">
			<div id="stts" style="    line-height: 1.3em; height:45px; width:280px; resize: none; font-size:12px; overflow:hidden;" onclick="status_update_enable()">
			<?php 
				$sql="SELECT * FROM status_update WHERE username='".$un."' ORDER BY id DESC LIMIT 0,1";
				$result=$mysqli->query($sql);
				if($result->num_rows > 0) {
					while($row = $result->fetch_assoc()) {
						echo $row['status'];
					}
				}
				else {
					echo 'Update Your Status? Click to Update';
				}
			?>
			</div>
			<textarea id="tf_stts" style="height:45px; width:280px; resize: none; display:none;" onblur="status_update_disable()" onkeypress="clk_enter_status(event)"></textarea>
			</div>
			</div>
			<div style="clear:both;"></div>
			<div id="link-cont">
				<div class="link" id="linkid0" style="background:#57B4EA" onclick="changelinkdiv(0)">Friend List</div>
				<div class="link" id="linkid1" onclick="changelinkdiv(1)">Chat Rooms</div>
				<div class="link" id="linkid2" onclick="changelinkdiv(2)">Settings</div>
				<div class="link" id="linkid3" onclick="changelinkdiv(3)">Help</div>
			</div>
			<div style="clear:both;"></div>
			<div id="main-div">
				<div class="content" id="divid0">
					<div style="float:left; margin-top:10px; margin-left:10px">
					Search Friend: <input type="text" id="search-friend" class="tb-fs" />
					<button class="btn-menu" onclick="add_friend_box()" style="margin-top:5px;">Add Friend</button>
					<button class="btn-menu" onclick="load_friend_list()" style="margin-top:5px;">Refresh</button>
					<button class="btn-menu" onclick="user_profile_ss('<?php echo $un; ?>')" style="margin-top:5px;">My Profile</button>
					</div>
					<div id="friend-list" style="float:left; padding:10px;">
						<img src="loader.gif" />
					</div>
				</div>
				<div class="content-h" id="divid1">
					<div style="float:left; margin-top:10px; margin-left:10px">
					<button class="btn-menu" onclick="add_create_room_box()" style="">Create Room</button>
					<button class="btn-menu" onclick="search_room_box()" style="">Search Room</button>
					<button class="btn-menu" onclick="load_rooms()" style="">Refresh</button>
					</div>
					<div style="clear:both;"></div>
					<div style="float:left; margin-top:10px; margin-left:10px">
						<h2 style="float:left;">My Rooms</h2>
						<div style="clear:both;"></div>
						<div id="my-rooms" style="float:left; padding:10px;">
						<img src="loader.gif" />
						</div>
						<h2 style="float:left;">Recent Rooms</h2>
						<div style="clear:both;"></div>
						<div id="recent-rooms" style="float:left; padding:10px;">
						<img src="loader.gif" />
						</div>
					</div>
				</div>
				<div class="content-h" id="divid2">
				<?php
			$sql="SELECT * FROM user_profile WHERE username='$un'";
			$result=$mysqli->query($sql);
			if($result->num_rows > 0) {
				while($row = $result->fetch_assoc()) {
					
					$propic=$row['photo'];
					echo'
					<p><img id="pp" src="uploads/pp_'.$propic.'" height="200px" width="200px" /></p>
					<p>Update Profile Image: &nbsp;&nbsp;<input type="file" name="ione" id="ione" style=""/> <button onclick="edit_picture()">Upload</button></p>
			<p>Full Name: &nbsp; <input type="text" id="tname" onkeyup="check_final_box(this.value,\'tname\',\'r1\')" onblur="check_final_box(this.value,\'tname\',\'r1\')" value="'.$row['name'].'" /><b id="r1" style="display:none; color:red">*</b></p>
			<p>Address: &nbsp; &nbsp; &nbsp;<input type="text" id="tadd" onkeyup="check_final_box(this.value,\'tadd\',\'r2\')" onblur="check_final_box(this.value,\'tadd\',\'r2\')" value="'.$row['address'].'" /><b id="r2" style="display:none; color:red">*</b></p>
			<p>Phone: &nbsp; &nbsp; &nbsp; &nbsp;<input type="text" id="tphone" onkeyup="check_final_box(this.value,\'tphone\',\'r3\')" onblur="check_final_box(this.value,\'tphone\',\'r3\')" value="'.$row['cell'].'" /><b id="r3" style="display:none; color:red">*</b></p>
			<p>Email: &nbsp; &nbsp; &nbsp;  &nbsp;  <input type="text" id="temail" onkeyup="check_final_box(this.value,\'temail\',\'r4\')" onblur="check_final_box(this.value,\'temail\',\'r4\')" value="'.$row['email'].'" /><b id="r4" style="display:none; color:red">*</b></p>
			<p>DOB: &nbsp; D:
			<select id="day">';
				for($i=1; $i<31; $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			echo'
			</select>
			M:
			<select id="month">
			';
				for($i=1; $i<12; $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			echo'
			</select>
			Y:
			<select id="year">
			';
				for($i=1990; $i<date('Y'); $i++) {
					echo'<option value="'.$i.'">'.$i.'</option>';
				}
			echo'
			</select>
			</p>
			<p id="allmsg" style="color:white;"></p>
			<p><button onclick="edit_info()" style="" class="btn-menu" >Save</button>
					';
				
				}
			}
			?>
				</div>
				<div class="content-h" id="divid3">
					<?php
						echo '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">';
						echo '<h5>Room Commands: </h5>';
						echo 'All the commands will be sent through chat<br>';
						echo '<h6>To kick a user write: k>username<br>';
						echo 'To make Moderator write: m>username<br>';
						echo 'To DeMod a Moderator write: dm>username<br>';
						echo 'To Ban a user write: b>username<br>';
						echo 'To UnBan a user write: ub>username<br></h6>';
						echo'</div>';
					?>
				</div>
			</div>
		</div>
		<div class="right" id="chat_main">
			<div class="chat-box" style="display:none;" onmousedown="_init_drag(0)" id="cb0" onmousemove="_drag(0)" onmouseup="_release(0)">
				<div class="title" style="cursor: all-scroll; float:left;">
					<p id="cr_name0" style="float:left; margin-left:10px;">Access Denied</p>
					<p style="float:right; margin-right:10px;">
						<button onclick="_remove_crbx('+num_el+')">Close</button>
					</p>
				</div>
				<div style="float:left; height: 324px; overflow:hidden; width: 449px;">
					<div id="cr_text0" style="float:left; border-right: 2px solid black; height: 298px; width: 307px; overflow-y: scroll;">
					
					</div>
					<h3 style="float:right;">
					Users Online
					</h3>
					<div id="user_online0" style="float:right; border-right: 2px solid black; height: 280px; width: 137px; overflow-y: scroll; margin-right:-14px">
					</div>
					<div style="float:left; border-top:2px solid black; width:100%;">
					<input type="text" id="room_msg0" style="float:left; margin-left:3px; margin-top:3px; width:200px;" /> 
					<button onclick="send_room_text(0)" style="float:left; margin-left:5px; margin-top:3px; padding:3px; height:21px;">Send</button>
					<div id="stmsg" style="float:left; margin-left:5px; margin-top:3px; padding:3px;"></div>
					</div>
				</div>
			</div>
			<div class="chat-box" style="display:none;" onmousedown="_init_drag(1)" id="cb1" onmousemove="_drag(1)" onmouseup="_release(1)">
			<div class="title">
					<button onclick="_remove(1)">Close</button>
				</div>
			</div>
		</div>
		<div style="position: fixed;
    height: 100%;
    width: 100%;
    left: 301px;
	z-index:0;
    top: 0;">
			<div style="    width: 300px;
    margin: 0 auto;
    left: -110px;
    top: 220px;
    position: relative;">
				<img height="200px" width="200px" src="images/lines.gif"/>
			</div>
		</div>
	</div>
	<script>
	var x_pos=[],y_pos=[],num_el=2,posX,posY,mov=0,removed_div=[],remove_div_i=0,box_type=[];
	var crbx=0,srbx=0,afbx=0,pcbx=0;
	var group_loader,removed_group_chat=[],room_chat_names=[];
	var user_profile=[],private_chat_names=[],num_msg_room=[],last_msg=[],post_list_n=[];
	function _drag(i) {
		if(mov==1) {
		$( "#cb"+i ).draggable();
		}
	}
	function _release(n) {
		mov=0;
	}
	function _init_drag(n) {
		for(var i=0; i<num_el; i++) {
			if(n==i) { 
				document.getElementById('cb'+n).style.zIndex="100";
				document.getElementById('cb'+n).getElementsByClassName('title')[0].style.background="#254d74";
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
		mov=1;
	}
	function _remove(n) {
		$("#cb"+n).remove();
		removed_div[remove_div_i]=n;
		remove_div_i++;
	}
	function _remove_crbx(n) {
		$("#cb"+n).remove();
		leave_room(room_chat_names[n]);
		removed_div[remove_div_i]=n;
		remove_div_i++;
		crbx=0;
	}
	function _remove_srbx(n) {
		$("#cb"+n).remove();
		removed_div[remove_div_i]=n;
		remove_div_i++;
		srbx=0;
	}
	function _remove_afbx(n) {
		$("#cb"+n).remove();
		removed_div[remove_div_i]=n;
		remove_div_i++;
		afbx=0;
	}
	function _remove_pcbx(n) {
		$("#cb"+n).remove();
		removed_div[remove_div_i]=n;
		remove_div_i++;
		pcbx=0;
	}
	
function clk_enter_room(e,n) {
    if (e.keyCode == 13) {
        send_room_text(n);
        return false;
    }
}
function clk_enter_private(e,n) {
    if (e.keyCode == 13) {
        send_private_text(n);
        return false;
    }
}
function clk_enter_status(e) {
    if (e.keyCode == 13) {
		var stxt=document.getElementById('tf_stts').value;
        status_update(stxt);
        return false;
    }
}


	function status_update(txt) {
		document.getElementById('tf_stts').style.display="none";
		document.getElementById('stts').style.display="block";
		document.getElementById('stts').innerHTML=document.getElementById('tf_stts').value;
		document.getElementById('stts').style.color="red";
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
			if(xmlhttp.responseText=="ok") {
				document.getElementById('stts').style.color="black";
			}
			else {
				document.getElementById('stts').innerHTML="Update Failed";
			}
		}
	}
xmlhttp.open("POST", "status_update.php?idd="+Math.random(), true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("stts="+txt);
	}

	function add_create_room_box() {
		if(crbx==0) {
			box_type[num_el]="room_add";
			crbx=1;
		document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')"><div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;"><p style="float:left; margin-left:10px;">Create Chat Room</p><p style="float:right; margin-right:10px;"><button onclick="_remove_crbx('+num_el+')">Close</button></p></div>'+
		'<div id="crmain" style="float:left; height: 324px; overflow:scroll;     width: 449px;">'+
		'<p style="padding:10px;">Chat Room Name: <input type="text" id="crnm" /></p>'+
		'<p style="padding:10px;">Chat Room Description: <textarea id="crds"></textarea></p>'+
		'<p style="padding:10px;"><button onclick="create_chat_room()">Create Chat Room</button></p>'+
		'<p style="padding:10px;" id="crmsg"></p></div></div>';
		num_el++;
		}
		for(var i=0; i<num_el; i++) {
			if(box_type[i]=="room_add") { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
				document.getElementById('cb'+i).style.zIndex="100"; 
				document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
				}
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
	}
	
	//search room
	function search_room_box() {
		if(srbx==0) {
			box_type[num_el]="room_search";
			srbx=1;
		document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')"><div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;"><p style="float:left; margin-left:10px;">Search Chat Room</p><p style="float:right; margin-right:10px;"><button onclick="_remove_srbx('+num_el+')">Close</button></p></div>'+
		'<div id="crmain_sr" style="float:left; height: 324px; overflow:scroll;     width: 449px;">'+
		'<p style="padding:10px;">Room Name: <input type="text" id="srnm_srnm" onkeypress="search_rooms_action()" /></p>'+
		'<p id="srmain" style="padding:10px;"></p>'+
		'</div></div>';
		num_el++;
		}
		for(var i=0; i<num_el; i++) {
			if(box_type[i]=="room_search") { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
				document.getElementById('cb'+i).style.zIndex="100";
				document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
				}
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//add friend box
	function add_friend_box() {
		if(afbx==0) {
			box_type[num_el]="add_friend";
			afbx=1;
		document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')"><div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;"><p style="float:left; margin-left:10px;">Add Friend</p><p style="float:right; margin-right:10px;"><button onclick="_remove_afbx('+num_el+')">Close</button></p></div>'+
		'<div id="afmain_af" style="float:left; height: 324px; overflow:scroll;     width: 449px;">'+
		'<p style="padding:10px;">Username: <input type="text" id="af_af" onkeypress="add_friend_action()" /></p>'+
		'<p id="afmain" style="padding:10px;"></p>'+
		'</div></div>';
		num_el++;
		}
		for(var i=0; i<num_el; i++) {
			if(box_type[i]=="add_friend") { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="100"; 
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
				}
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
	}
	
	function add_friend_action() {
		document.getElementById("afmain").innerHTML = '<img src="loader.gif" />';
		var rtext;
		rtext=document.getElementById("af_af").value;
		if(rtext!="") {
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("afmain").innerHTML = 'No Result Found';
			}
			else {
				document.getElementById("afmain").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "search_user.php?rid="+rtext, true);
xmlhttp.send();
		}
		else {
			document.getElementById("afmain").innerHTML = 'Name cannot be Empty';
		}
	}
	
	
	
	function add_friend_request(uid,did) {
		document.getElementById("upmain"+did).innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("upmain"+did).innerHTML = 'Failed';
			}
			else {
				document.getElementById("upmain"+did).innerHTML="hol";
			}
			get_profile_action(did,uid);
			load_friend_list();
		}
	}
xmlhttp.open("GET", "add_friend_request.php?rid="+uid+"&idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	
	
	
	
	
	//friend_list
	function load_friend_list() {
		document.getElementById("friend-list").innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="") {
				document.getElementById("friend-list").innerHTML = 'Friend List Empty';
			}
			else {
				document.getElementById("friend-list").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "friend_list.php?idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	function load_friend_list_silent() {
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
			if(xmlhttp.responseText=="") {
				document.getElementById("friend-list").innerHTML = 'Friend List Empty';
			}
			else {
				document.getElementById("friend-list").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "friend_list.php?idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	
	
	
	
	
	//delete friend request
	function delete_friend_request(uid,did) {
		document.getElementById("upmain"+did).innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("upmain"+did).innerHTML = 'Failed';
			}
			else {
				document.getElementById("upmain"+did).innerHTML="hol";
			}
			get_profile_action(did,uid);
			load_friend_list();
		}
	}
xmlhttp.open("GET", "delete_friend_request.php?rid="+uid+"&idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	
	
	
	
	
	//online friends
	function online_friend() {
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
			if(xmlhttp.responseText=="no") {
				load_friend_list_silent();
			}
			else {
				load_friend_list_silent();
			}
		}
	}
xmlhttp.open("GET", "online_friend.php?idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	
	
	
	
	
	//user post list
	function user_post_list(uid, div) {
		document.getElementById('upmain'+div).style.display="none";
		document.getElementById('postmain'+div).style.display="block";
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
				if(xmlhttp.responseText=="") {
					document.getElementById('postmain'+div).innerHTML = 'No post Has Been Made !!!';
				}
				else {
					document.getElementById('postmain'+div).innerHTML=xmlhttp.responseText;
				}
			}
		}
		xmlhttp.open("GET", "user_post_list.php?divd="+div+"&uid="+uid+"&p="+post_list_n[div]+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	function prev_postlist(uid, div) {
		post_list_n[div]=post_list_n[div]-9;
		user_post_list(uid, div);
	}
	function next_postlist(uid, div) {
		post_list_n[div]=post_list_n[div]+9;
		user_post_list(uid, div);
	}
	function go_back_profile(div) {
		document.getElementById('upmain'+div).style.display="block";
		document.getElementById('postmain'+div).style.display="none";
	}
	function go_back_postlist(div) {
		document.getElementById('singlemain'+div).style.display="none";
		document.getElementById('postmain'+div).style.display="block";
	}
	
	//show single post
	function show_post(sid, div) {
		document.getElementById('postmain'+div).style.display="none";
		document.getElementById('singlemain'+div).style.display="block";
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
				if(xmlhttp.responseText=="") {
					document.getElementById('singlemain'+div).innerHTML = 'Nothing Found';
				}
				else {
					document.getElementById('singlemain'+div).innerHTML=xmlhttp.responseText;
				}
			}
		}
		xmlhttp.open("GET", "show_post.php?divd="+div+"&uid="+sid+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	
	
	
	
	
	
	
	//Like Post
	function like_post(sid, div) {
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
				if(xmlhttp.responseText=="ok") {
					show_post(sid, div);
				}
				else {
					show_post(sid, div);
				}
			}
		}
		xmlhttp.open("GET", "like_post.php?uid="+sid+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	
	//ADD comment 
	function add_comment(sid, div) {
		var rtext=document.getElementById('p_comment'+div).value;
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
				if(xmlhttp.responseText=="ok") {
					show_post(sid, div);
				}
				else {
					show_post(sid, div);
				}
			}
		}
		xmlhttp.open("POST", "add_comment.php?uid="+sid+"&idd="+Math.random(), true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send("rtext="+rtext);
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	//user_profile
	function user_profile_ss(uid) {
		var rmv=0;
		for(var i=0; i<num_el; i++) {
			var removed=0;
			for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0 && box_type[i]=="user_profile" && user_profile[i]==uid) {
					rmv=1;
					
					
					for(var k=0; k<num_el; k++) {
						if(i==k) { 
							document.getElementById('cb'+i).style.zIndex="100"; 
							document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
						}
						else { 
							var removed=0;
							for(j=0; j<remove_div_i; j++) {
								if(k==removed_div[j]) { removed=1; break;  }
							}
							if(removed==0) {
								document.getElementById('cb'+k).style.zIndex="1";
								document.getElementById('cb'+k).getElementsByClassName('title')[0].style.background="#254d74";
							}
						}
					}
					
					
					break;
				}
		}
		if(rmv==0) {
			user_profile[num_el]=uid;
			post_list_n[num_el]=0;
			box_type[num_el]="user_profile";
		document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')"><div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;"><p style="float:left; margin-left:10px;">User Profile: '+uid+'</p><p style="float:right; margin-right:10px;"><button onclick="_remove_afbx('+num_el+')">Close</button></p></div>'+
		'<div id="upmain_up'+num_el+'" style="float:left; height: 324px; overflow:scroll;     width: 449px;">'+
		'<div id="upmain'+num_el+'" style="padding:10px;"></div>'+
		'<div id="postmain'+num_el+'" style="padding:10px; display:none;"></div>'+
		'<div id="singlemain'+num_el+'" style="padding:10px; display:none;"></div>'+
		'</div></div>';
		get_profile_action(num_el,uid);
		num_el++;
		
		for(var i=0; i<num_el; i++) {
			if(num_el-1==i) { 
				document.getElementById('cb'+(num_el-1)).style.zIndex="100"; 
				document.getElementById('cb'+(num_el-1)).getElementsByClassName('title')[0].style.background="red";
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
		
		}
	}
	
	function get_profile_action(did,uid) {
		document.getElementById("upmain"+did).innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("upmain"+did).innerHTML = 'No Result Found';
			}
			else {
				document.getElementById("upmain"+did).innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "get_profile.php?divd="+did+"&rid="+uid+"&idd="+Math.random(), true);
xmlhttp.send();
	}
	
	
	
	
	
	
	
	
	
	
	//star private chat box
	function open_private_chat(uname) {
		var rmv=0;
		for(var i=0; i<num_el; i++) {
			var removed=0;
			for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0 && box_type[i]=="private_chat" && private_chat_names[i]==uname) {
					rmv=1;
					
					
					for(var k=0; k<num_el; k++) {
						if(i==k) { 
							document.getElementById('cb'+i).style.zIndex="100"; 
							document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
						}
						else { 
							var removed=0;
							for(j=0; j<remove_div_i; j++) {
								if(k==removed_div[j]) { removed=1; break;  }
							}
							if(removed==0) {
								document.getElementById('cb'+k).style.zIndex="1";
								document.getElementById('cb'+k).getElementsByClassName('title')[0].style.background="#254d74";
							}
						}
					}
					
					break;
				}
		}
		if(rmv==0) {
			private_chat_names[num_el]=uname;
			box_type[num_el]="private_chat";
			document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')">'+
		'<div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;">'+
					'<p id="pc_name'+num_el+'" style="float:left; margin-left:10px;">Private Chat - '+uname+'</p>'+
					'<p style="float:right; margin-right:10px;">'+
						'<button onclick="_remove_pcbx('+num_el+')">Close</button>'+
					'</p>'+
				'</div>'+
				'<div style="float:left; height: 324px; overflow:hidden; width: 449px;">'+
					'<div id="pc_text'+num_el+'" style="float:left; border-right: 2px solid black; height: 298px; width: 307px; overflow-y: scroll;">'+
					
					'</div>'+
					'<h3 style="float:right;">'+
					'User List'+
					'</h3>'+
					'<div id="pc_online'+num_el+'" style="float:right; border-right: 2px solid black; height: 280px; width: 137px; overflow-y: scroll; margin-right:-14px">'+
					
					'</div>'+
					'<div style="float:left; border-top:2px solid black; width:100%;">'+
					'<input type="text" id="private_msg'+num_el+'" onkeypress="return clk_enter_private(event,'+num_el+')" style="float:left; margin-left:3px; margin-top:3px; width:200px;" />'+
					'<button onclick="send_private_text('+num_el+')" style="float:left; margin-left:5px; margin-top:3px; padding:3px; height:21px;">Send</button>'+
					'<label for="pione'+num_el+'"> <span style="float:left; margin-left:5px; margin-top:3px; padding:3px; height:20px; width:20px;"><img src="pu.png" height="15px" width="15px" /></span></label> '+
					'<input type="file" onchange="send_private_image('+num_el+')" name="pione'+num_el+'" id="pione'+num_el+'" style="visibility:hidden; float:left; margin-left:0px; margin-top:3px; padding:0px; height:0px; width:0px;"/>'+
					'<div id="pcmsg'+num_el+'" style="float:left; margin-left:5px; margin-top:3px; padding:3px;"></div>'+
					'</div>'+
				'</div>'+
		'</div>';
		num_el++;
		for(var i=0; i<num_el; i++) {
			if(num_el-1==i) { 
				document.getElementById('cb'+(num_el-1)).style.zIndex="100"; 
				document.getElementById('cb'+(num_el-1)).getElementsByClassName('title')[0].style.background="red";
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
		}
	}
	
	//send private messege
	function send_private_text(id) {
		var rtext;
		rtext=document.getElementById("private_msg"+id).value;
		uid=private_chat_names[id];
		document.getElementById("pcmsg"+id).innerHTML="Sending...";
		if(rtext!="") {
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
			if(xmlhttp.responseText=="ok") {
				document.getElementById("pcmsg"+id).innerHTML = 'Sent';
				document.getElementById("private_msg"+id).value="";
			}
			else if(xmlhttp.responseText=="empty") {
				document.getElementById("pcmsg"+id).innerHTML="Empty!";
			}
			else {
				document.getElementById("pcmsg"+id).innerHTML="Not Sent!";
			}
		}
	}
xmlhttp.open("POST", "send_private_text.php?rid="+uid, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("rtext="+rtext);
		}
		else {
			document.getElementById("pcmsg"+id).innerHTML="Empty!";
		}
	}
	
	//load private chat
	function load_private_text(uname, id) {
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
				if(xmlhttp.responseText=="no") {
					document.getElementById("pc_text"+id).innerHTML = "Error Loading Chat History";
				}
				else {
					document.getElementById("pc_text"+id).innerHTML=xmlhttp.responseText;
					var elem = document.getElementById("pc_text"+id);
					elem.scrollTop = elem.scrollHeight;
				}
			}
		}
		xmlhttp.open("GET", "load_private_text.php?user_id="+uname, true);
		xmlhttp.send();
	}
	
	
	
	//open popup window on new message
	function new_message_popup() {
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
				if(xmlhttp.responseText=="") {
					
				}
				else {
					var str=xmlhttp.responseText;
					str=str.split("++--++");
					for (var i=0; i<str.length; i++) {
						if(str[i]!="") {
							open_private_chat(str[i]);
						}
					}
				}
			}
		}
		xmlhttp.open("GET", "new_message_pupup.php?idd="+Math.random(), true);
		xmlhttp.send();
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	function add_cb() {
		document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmousemove="_drag('+num_el+')" onmouseup="_release('+num_el+')"><button onclick="_remove('+num_el+')">Close</button></div>';
		num_el++;
	}
	
	function changelinkdiv(id) {
		var i=4,n=0;
		while (n<i) {
			if(n!=id) {
				document.getElementById("linkid"+n).style.background = "white";
				document.getElementById("linkid"+n).style.color = "black";
				document.getElementById("divid"+n).className = "content-h";
			}
			else {
				document.getElementById("linkid"+n).style.background = "#57B4EA";
				document.getElementById("linkid"+n).style.color = "white";
				document.getElementById("divid"+n).className = "content";
			}
			n++;
		}
	}
	
	function create_chat_room() {
		var cname,cdesc;
		cname=document.getElementById("crnm").value;
		cdesc=document.getElementById("crds").value;
		if(cname=="" || cdesc=="") {
			document.getElementById("crmsg").innerHTML="name or description missing";
		}
		else {
			add_room_action(cname, cdesc)
		}
	}
	
	function add_room_action(n,d) {
	

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
			if(xmlhttp.responseText=="ok") {
				document.getElementById("crmain").innerHTML = '<h3> CHAT ROOM CREATED SUCCESSFULLY </h3>';
				load_rooms();
			}
			else if(xmlhttp.responseText=="exist") {
				document.getElementById("crmsg").innerHTML="Room name Already Exist. please give another name";
			}
			else {
				document.getElementById("crmsg").innerHTML="Something Went Wrong";
			}
		}
	}
xmlhttp.open("POST", "create_room.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("crnm="+n+"&crds="+d);
	}
	
	function load_rooms() {
		document.getElementById("my-rooms").innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("my-rooms").innerHTML = '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">You Have No Rooms</div>';
			}
			else {
				document.getElementById("my-rooms").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "load_rooms.php", true);
xmlhttp.send();
load_recent_rooms();
	}
	
	//load recent rooms
	function load_recent_rooms() {
		document.getElementById("recent-rooms").innerHTML = '<img src="loader.gif" />';
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("recent-rooms").innerHTML = '<div style="padding:5px; width:250px; border-bottom:1px solid black; float:left;">You Have No Rooms</div>';
			}
			else {
				document.getElementById("recent-rooms").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "recent_rooms.php", true);
xmlhttp.send();
	}
	
	//search rooms action
	function search_rooms_action() {
		document.getElementById("srmain").innerHTML = '<img src="loader.gif" />';
		var rtext;
		rtext=document.getElementById("srnm_srnm").value;
		if(rtext!="") {
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
			if(xmlhttp.responseText=="no") {
				document.getElementById("srmain").innerHTML = 'No Result Found';
			}
			else {
				document.getElementById("srmain").innerHTML=xmlhttp.responseText;
			}
		}
	}
xmlhttp.open("GET", "search_room.php?rid="+rtext, true);
xmlhttp.send();
		}
		else {
			document.getElementById("srmain").innerHTML = 'Name cannot be Empty';
		}
	}
	
	function load_room_text(rname, id) {
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
				if(xmlhttp.responseText=="no") {
					document.getElementById("cr_text"+id).innerHTML = "Error Loading Chat History";
				}
				else {
					var str=xmlhttp.responseText; str=str.split("<br>");
					var str2=str[str.length-2].split(":");
					document.getElementById("cr_text"+id).innerHTML="";
					if(num_msg_room[id]==1) {
						last_msg[id]=str2[0];
						num_msg_room[id]++;
					}
					for(var i=str.length-1,j=0; i>=0; i--,j++) {
						str2=str[i-1].split(":");
						if(str2[0]==last_msg[id]) { break; }
						else {
							document.getElementById("cr_text"+id).innerHTML=str2[1]+' : '+str2[2]+'<br>'+
							document.getElementById("cr_text"+id).innerHTML;
						}
					}
					
					//document.getElementById("cr_text"+id).innerHTML=xmlhttp.responseText;
					
					var elem = document.getElementById("cr_text"+id);
					elem.scrollTop = elem.scrollHeight; 
				}
			}
		}
		xmlhttp.open("GET", "load_room_text.php?room_id="+rname+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	
	
	//leave room
	function leave_room(rname) {
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
		xmlhttp.open("GET", "leave_room.php?room_id="+rname+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	
	
	//load room users
	function load_user_online(rid,id) {
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
				if(xmlhttp.responseText=="no") {
					document.getElementById("user_online"+id).innerHTML = "Error";
				}
				else {
					document.getElementById("user_online"+id).innerHTML=xmlhttp.responseText;
				}
			}
		}
		xmlhttp.open("GET", "online_user.php?rid="+rid,true);
		xmlhttp.send();
	}
	
	
	//show room info
	function show_room_info(sid, div) {
		document.getElementById('cr_text'+div).style.display="none";
		document.getElementById('room_info'+div).style.display="block";
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
				if(xmlhttp.responseText=="") {
					document.getElementById('room_info'+div).innerHTML = 'Nothing Found';
				}
				else {
					document.getElementById('room_info'+div).innerHTML=xmlhttp.responseText;
				}
			}
		}
		xmlhttp.open("GET", "show_room_info.php?divd="+div+"&uid="+sid+"&idd="+Math.random(), true);
		xmlhttp.send();
	}
	//goback room
	function go_back_room(div) {
		document.getElementById('cr_text'+div).style.display="block";
		document.getElementById('room_info'+div).style.display="none";
	}
	
	
	
	
	//open room
	function open_room(rname, rid) {
		var rmv=0;
		for(var i=0; i<num_el; i++) {
			var removed=0;
			for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0 && box_type[i]=="chat_room" && room_chat_names[i]==rid) {
					rmv=1;
					
					
					for(var k=0; k<num_el; k++) {
						if(i==k) { 
							document.getElementById('cb'+i).style.zIndex="100"; 
							document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="red";
						}
						else { 
							var removed=0;
							for(j=0; j<remove_div_i; j++) {
								if(k==removed_div[j]) { removed=1; break;  }
							}
							if(removed==0) {
								document.getElementById('cb'+k).style.zIndex="1";
								document.getElementById('cb'+k).getElementsByClassName('title')[0].style.background="#254d74";
							}
						}
					}
					
					
					break;
				}
		}
		if(rmv==0) {
			room_chat_names[num_el]=rid;
			num_msg_room[num_el]=1;
			last_msg[num_el]=0;
			box_type[num_el]="chat_room";
			document.getElementById('chat_main').innerHTML=document.getElementById('chat_main').innerHTML+'<div class="chat-box" onmousedown="_init_drag('+num_el+')" id="cb'+num_el+'" onmouseup="_release('+num_el+')">'+
		'<div class="title" onmousemove="_drag('+num_el+')" style="cursor: all-scroll; float:left;">'+
					'<p id="cr_name'+num_el+'" style="float:left; margin-left:10px;">'+rname+'</p>'+
					'<p style="float:right; margin-right:10px;">'+
						'<button onclick="_remove_crbx('+num_el+')">Close</button>'+
					'</p>'+
				'</div>'+
				'<div style="float:left; height: 324px; overflow:hidden; width: 449px;">'+
					'<div id="cr_text'+num_el+'" style="float:left; border-right: 2px solid black; height: 298px; width: 307px; overflow-y: scroll;">'+
					
					'</div>'+
					'<div id="room_info'+num_el+'" style="float:left; border-right: 2px solid black; height: 298px; width: 307px; overflow-y: scroll; display:none;">'+
					
					'</div>'+
					'<h3 style="float:right;">'+
					'Users Online'+
					'</h3>'+
					'<div id="user_online'+num_el+'" style="float:right; border-right: 2px solid black; height: 280px; width: 137px; overflow-y: scroll; margin-right:-14px">'+
					
					'</div>'+
					'<div style="float:left; border-top:2px solid black; width:100%;">'+
					'<input type="text" id="room_msg'+num_el+'" onkeypress="return clk_enter_room(event,'+num_el+')" style="float:left; margin-left:3px; margin-top:3px; width:200px;" />'+
					'<button onclick="send_room_text('+num_el+')" style="float:left; margin-left:5px; margin-top:3px; padding:3px; height:21px;">Send</button>'+
					'<label for="ione'+num_el+'"> <span style="float:left; margin-left:5px; margin-top:3px; padding:3px; height:20px; width:20px;"><img src="pu.png" height="15px" width="15px" /></span></label> '+
					'<input type="file" onchange="send_room_image('+num_el+')" name="ione'+num_el+'" id="ione'+num_el+'" style="visibility:hidden; float:left; margin-left:0px; margin-top:3px; padding:0px; height:0px; width:0px;"/>'+
					'<div style="float:left; margin-left:5px; margin-top:7px; padding:0px;"><img onclick="show_room_info('+rid+','+num_el+')" src="images/info.png" height="15px" width="15px" /></div>'+
					'<div id="stmsg'+num_el+'" style="float:left; margin-left:5px; margin-top:3px; padding:3px;"></div>'+
					'</div>'+
				'</div>'+
		'</div>';
		num_el++;
		for(var i=0; i<num_el; i++) {
			if(num_el-1==i) {
				document.getElementById('cb'+(num_el-1)).style.zIndex="100";
				document.getElementById('cb'+(num_el-1)).getElementsByClassName('title')[0].style.background="red";
			}
			else { 
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0) {
					document.getElementById('cb'+i).style.zIndex="1";
					document.getElementById('cb'+i).getElementsByClassName('title')[0].style.background="#254d74";
				}
			}
		}
		load_recent_rooms();
		}
	}
	//send room image
	function send_room_image(id) {
		var rid=room_chat_names[id];
		var formData = new FormData();
		formData.append("ione", document.getElementById("ione"+id).files[0]);
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
			if(xmlhttp.responseText=="ok") {
				document.getElementById("stmsg"+id).innerHTML = 'Sent';
				document.getElementById("room_msg"+id).value="";
			}
			else if(xmlhttp.responseText=="empty") {
				document.getElementById("stmsg"+id).innerHTML="Empty!";
			}
			else {
				document.getElementById("stmsg"+id).innerHTML="Not Sent!";
			}
		}
	}
xmlhttp.open("POST", "upoad_chat_photo.php?rid="+rid+"&idd="+Math.random(), true);
xmlhttp.send(formData);
	}
	
	
	
	//send private image
	function send_private_image(id) {
		var rid=private_chat_names[id];
		var formData = new FormData();
		formData.append("ione", document.getElementById("pione"+id).files[0]);
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
			if(xmlhttp.responseText=="ok") {
				document.getElementById("pcmsg"+id).innerHTML = 'Sent';
				//document.getElementById("room_msg"+id).value="";
			}
			else if(xmlhttp.responseText=="empty") {
				document.getElementById("pcmsg"+id).innerHTML="Empty!";
			}
			else {
				document.getElementById("pcmsg"+id).innerHTML="Not Sent!";
			}
		}
	}
xmlhttp.open("POST", "upoad_chat_photo_private.php?rid="+rid+"&idd="+Math.random(), true);
xmlhttp.send(formData);
	}
	
	function send_room_text(id) {
		var rtext;
		rtext=document.getElementById("room_msg"+id).value;
		rid=room_chat_names[id];
		document.getElementById("stmsg"+id).innerHTML="Sending...";
		if(rtext!="") {
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
			if(xmlhttp.responseText=="ok") {
				document.getElementById("stmsg"+id).innerHTML = 'Sent';
				document.getElementById("room_msg"+id).value="";
			}
			else if(xmlhttp.responseText=="empty") {
				document.getElementById("stmsg"+id).innerHTML="Empty!";
			}
			else {
				document.getElementById("stmsg"+id).innerHTML="Not Sent!";
			}
		}
	}
xmlhttp.open("POST", "send_room_text.php?rid="+rid, true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("rtext="+rtext);
		}
		else {
			document.getElementById("stmsg"+id).innerHTML="Empty!";
		}
	}
	
	
	function load_room_chat_text() {
		group_loader = setInterval(function(){
			for(var i=0; i<num_el; i++) {
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0 && box_type[i]=="chat_room") {
					setTimeout( load_room_text(room_chat_names[i], i), 200);
					setTimeout( load_user_online(room_chat_names[i], i), 3000);
				}
			}
		},3000);
	}
	
	
	function load_private_chat_text() {
		group_loader = setInterval(function(){
			for(var i=0; i<num_el; i++) {
				var removed=0;
				for(j=0; j<remove_div_i; j++) {
					if(i==removed_div[j]) { removed=1; break;  }
				}
				if(removed==0 && box_type[i]=="private_chat") {
					setTimeout( load_private_text(private_chat_names[i], i), 200);
				}
			}
			new_message_popup();
		},3000);
	}
	
	
	function refresh_online_friend() {
		group_loader = setInterval(function(){
			online_friend();
		},30000);
	}
	
	refresh_online_friend();
	load_room_chat_text();
	load_friend_list();
	load_private_chat_text();
	load_rooms();
	
	
	
	
	
	
	
	
	
	
	
	
	function edit_info() {
	var xmlhttp;
	var ufn=document.getElementById("tname").value;
	var uadd=document.getElementById("tadd").value;
	var uemail=document.getElementById("temail").value;
	var uphone=document.getElementById("tphone").value;
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
</body>
</html>