<?php
function GetSQLValueString($theValue, $theType) {
  switch ($theType) {
    case "string":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_MAGIC_QUOTES) : "";
      break;
    case "int":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_SANITIZE_NUMBER_INT) : "";
      break;
    case "email":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_EMAIL) : "";
      break;
    case "url":
      $theValue = ($theValue != "") ? filter_var($theValue, FILTER_VALIDATE_URL) : "";
      break;      
  }
  return $theValue;
}

if(isset($_POST["action"])&&($_POST["action"]=="join")){
	require_once("conn.php");
	//找尋帳號是否已經註冊
	$query_RecFindUser = "SELECT username FROM memberdata WHERE username='{$_POST["username"]}'";
	$RecFindUser=$db_link->query($query_RecFindUser);
	if ($RecFindUser->num_rows>0){
		header("Location: member_join.php?errMsg=1&username={$_POST["username"]}");
	}else{
	//若沒有執行新增的動作	
		$query_insert = "INSERT INTO memberdata (customername, username, password, sex, birthday, customeremail, customerphone, customeraddress) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $db_link->prepare($query_insert);
		$stmt->bind_param("ssssssss", 
			GetSQLValueString($_POST["customername"], 'string'),
			GetSQLValueString($_POST["username"], 'string'),
			password_hash($_POST["password"], PASSWORD_DEFAULT),
			GetSQLValueString($_POST["sex"], 'string'),
			GetSQLValueString($_POST["birthday"], 'string'),
			GetSQLValueString($_POST["customeremail"], 'email'),
			GetSQLValueString($_POST["customerphone"], 'string'),
			GetSQLValueString($_POST["customeraddress"], 'string'));
		$stmt->execute();
		$stmt->close();
		$db_link->close();
		header("Location: member_join.php?loginStats=1");
	}
}

//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
    header("Location:productall.php?keyword={$_GET["keyword"]}");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Sweet Cake</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  
<script language="javascript">
function check()
{
if(document.form.username.value==""){		
		alert("請填寫帳號!");
		document.form.username.focus();
		return false;
	}else{
		uid=document.form.username.value;
		if(uid.length<5 || uid.length>12){
			alert( "您的帳號長度只能5至12個字元!" );
			document.form.username.focus();
			return false;}
		if(!(uid.charAt(0)>='a' && uid.charAt(0)<='z')){
			alert("您的帳號第一字元只能為小寫字母!" );
			document.form.username.focus();
			return false;}
		for(idx=0;idx<uid.length;idx++){
			if(uid.charAt(idx)>='A'&&uid.charAt(idx)<='Z'){
				alert("帳號不可以含有大寫字元!" );
				document.form.username.focus();
				return false;}
			if(!(( uid.charAt(idx)>='a'&&uid.charAt(idx)<='z')||(uid.charAt(idx)>='0'&& uid.charAt(idx)<='9')||( uid.charAt(idx)=='_'))){
				alert( "您的帳號只能是數字,英文字母及「_」等符號,其他的符號都不能使用!" );
				document.form.username.focus();
				return false;}
			if(uid.charAt(idx)=='_'&&uid.charAt(idx-1)=='_'){
				alert( "「_」符號不可相連 !\n" );
				document.form.username.focus();
				return false;}
		}
}
    if(!check_passwd(document.form.password.value,document.form.passwordcheck.value)){
		document.form.password.focus();
		return false;
    }

    if(document.form.customername.value==""){
		alert("請填寫姓名!");
		document.form.customername.focus();
		return false;}
	if(document.form.birthday.value==""){
		alert("請填寫生日!");
		document.form.birthday.focus();
		return false;}
    if(document.form.customeremail.value==""){
		alert("請填寫電子郵件!");
		document.cartform.customeremail.focus();
		return false;
	}
	if(!checkmail(document.form.customeremail)){
		document.form.customeremail.focus();
		return false;
	}	
	if(document.form.customerphone.value==""){
       alert("請填寫電話號碼!");
		document.form.customerphone.focus();
		return false;}
    if(document.form.customeraddress.value==""){
       alert("請填寫住址!");
		document.form.customeraddress.focus();
		return false;}
	return confirm('確定送出嗎？');
}
    function check_passwd(pw1,pw2){
	if(pw1==''){
		alert("密碼不可以空白!");
		return false;}
	for(var idx=0;idx<pw1.length;idx++){
		if(pw1.charAt(idx) == ' ' || pw1.charAt(idx) == '\"'){
			alert("密碼不可以含有空白或雙引號 !\n");
			return false;}
		if(pw1.length<5 || pw1.length>10){
			alert( "密碼長度只能5到10個字母 !\n" );
			return false;}
		if(pw1!= pw2){
			alert("密碼二次輸入不一樣,請重新輸入 !\n");
			return false;}
	}
	return true;
}
  function checkmail(myEmail) {
	var filter  = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	if(filter.test(myEmail.value)){
		return true;
	}
	alert("電子郵件格式不正確");
	return false;
}
</script>    
    
  <style type="text/css">
      .subjectDiv {
	font-family: "微軟正黑體";
	font-size: 25pt;
	font-weight: bold;
	color: #000000;
	padding: 5px;
	clear: both;
        border-top-width: 1px;
	border-bottom-width: 1px;
	border-bottom-style: dotted;
          border-top-style: dotted;
	border-bottom-color: #666666;
          	border-top-color: #666666;
	margin-bottom: 30px;
}
      .smalltext {
	font-size: 12px;
	color: #999999;
	font-family: Georgia, "Times New Roman", Times, serif;
	vertical-align: baseline;
    margin-left: 15px;
}
      .errDiv {
	font-family: "微軟正黑體";
	font-size: 13pt;
	color: #FFFFFF;
	background-color: #FF0000;
    width:50%;
	padding: 4px;
	text-align: center;
}
      .menu{
           display: block;
      }
      .menuall{
         width: 110px;
      }
      .menurecommend,.menuclassic{
         width: 220px;
      }
      .defined{
      
          font-size:23px; 
      }
      .textsize{
          font-size:1.3rem; 
          margin-left: 0px;
      }
      .page_content{
          background-color: #eae4d9;
          border:1px dashed #343333;
          margin-top: 30px;
          padding-bottom: 15px;
      }
    </style>
  <style>
      /*.navbar{
          padding:0;
      }*/
    
      .jumbotron{
              padding: 0.5rem 1rem;
              border-radius: 0rem;
          }
      @media (min-width:576px){
          /*.test{
              margin-left:33%;
          }*/
          .jumbotron{
              padding: 0.5rem 1rem;
              border-radius: 0rem;
          }
      }
  .fakeimg {
      height: 200px;
      background: #aaa;
  }
   
  </style>
</head>
<body style="background-color:#f5f5f5;">
<?php if(isset($_GET["loginStats"]) && ($_GET["loginStats"]=="1")){?>
<script language="javascript">
alert('會員新增成功\n請用申請的帳號密碼登入。');
window.location.href='member.php';		  
</script>
<?php }?>
<img src="images/headercake.jpg"  alt="Cinque Terre"  width="100%" > 
<nav class="navbar navbar-expand-sm bg-dark navbar-dark " role="navigation">
  
       <div class="navbar-header">
           <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" >
    <span class="navbar-toggler-icon"></span>
  </button>
          
            </div>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="nav navbar-nav test " >
 <li class="nav-item">
        <a class="nav-link defined" href="index.php">關於我們</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle defined" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          產品介紹
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
          <a class="dropdown-item" href="productall.php">所有產品/All</a>
          <a class="dropdown-item" href="productrd.php">主廚推薦系列/Recommend</a>
          <a class="dropdown-item" href="productcc.php">經典系列/Classic</a>
        </div>
      </li>
      <li class="menu">
        <a class="nav-link defined" href="FAQ.php">購物說明</a>
      </li>
      <li class="nav-item">
        <a class="nav-link defined" href="member.php">會員登入</a>
      </li>
      <li class="nav-item">
        <a class="nav-link defined" href="contact.php">聯絡我們</a>
      </li>    
    </ul>
  

        <form class="form-inline my-2 my-lg-0 ml-auto">
      <input class="form-control mr-sm-2" type="search" id="keyword" name="keyword" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">搜尋</button>
    </form>
       </div>
</nav>

<div class="container" style="margin-top:50px;margin-bottom:30px">
  <div class="row">
    <div class="col-lg-12">
     <div class="form_content">
      <h1 style="margin-bottom:20px">加入會員 | Join Us</h1>
      <hr>
      <?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
          <div class="errDiv">帳號 <?php echo $_GET["username"];?> 已經有人使用！</div>
          <?php }?>
   <div class="subjectDiv" style="margin-top:20px"> <img src="images/16-cube-blue.png" width="25" height="25" align="absmiddle"> 帳號資料</div>
       <form name="form" id="form" class="form-horizontal" method="POST" action="" onsubmit="return check();">
<div class="form-group">
<label class="control-label col-sm-2 textsize" for="username">會員帳號:</label>
        <div class="col-sm-12">
        <input type="text" class="form-control" id="username" placeholder="請輸入會員帳號" name="username">
        </div>
         <span class="smalltext">請填入5~12個字元以內的英文字母、數字、以及各種符號組合</span>
        </div>
           <div class="form-group">
<label class="control-label col-sm-2 textsize" for="password">會員密碼:</label>
        <div class="col-sm-12">
        <input type="password" class="form-control" id="password" placeholder="請輸入會員密碼" name="password">
        </div>
        <span class="smalltext">請填入5~10個字元以內的英文字母、數字、以及各種符號組合</span>
        </div>
        
        <div class="form-group">
<label class="control-label col-sm-2 textsize" for="passwordcheck">確認密碼:</label>
        <div class="col-sm-12">
        <input type="password" class="form-control" id="passwordcheck" placeholder="請再次輸入會員密碼" name="passwordcheck">
        </div>
         <span class="smalltext">再輸入一次密碼</span>
        </div> 
          <div class="subjectDiv" style="margin-top:20px"> <img src="images/16-cube-blue.png" width="25" height="25" align="absmiddle"> 個人資料</div>  
                 <div class="form-group">
<label class="control-label col-sm-2 textsize" for="customername">真實姓名:</label>
        <div class="col-sm-12">
        <input type="text" class="form-control" id="customername" placeholder="請輸入您的姓名" name="customername">
        </div>
        </div>
          <div class="form-group">
<label class="control-label col-sm-2 textsize" for="sex">性別:</label><br>
       <div style="margin-left:14px">
           <div class="form-check-inline">
      <label class="form-check-label" for="sex">
        <input type="radio" class="form-check-input" id="sex" name="sex" value="男" checked>男
      </label>
    </div>
    <div class="form-check-inline">
      <label class="form-check-label" for="sex">
        <input type="radio" class="form-check-input" id="sex" name="sex" value="女">女
      </label>
    </div>
           
       </div>
        
        </div>
          <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="birthday">生日:</label>
    <div class="col-sm-12">
    <input type="text" class="form-control" id="birthday" placeholder="請輸入生日" name="birthday">
    </div>
      <span class="smalltext">為西元格式(YYYY-MM-DD)。</span>
    </div> 
            <div class="form-group">
<label class="control-label col-sm-2 textsize" for="customeremail">電子郵件:</label>
<div class="col-sm-12">
<input type="email" class="form-control" id="customeremail" placeholder="請輸入電子郵件" name="customeremail">
</div>
  <span class="smalltext">請確定此電子郵件為可使用狀態，以方便未來系統使用，如補寄會員密碼信。</span>
</div>    
    <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="customerphone">電話:</label>
    <div class="col-sm-12">
    <input type="tel" class="form-control" id="customerphone" placeholder="請輸入電話" name="customerphone">
    </div>
    </div>      
             <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="customeraddress">住址:</label>
    <div class="col-sm-12">
    <input type="text" class="form-control" id="customeraddress" placeholder="請輸入住址" name="customeraddress">
    </div>
    </div>   
        <center>
     <div class="col-sm-offset-2 col-sm-10">
            <input name="action" type="hidden" id="action" value="join">
            <button type="reset" class="btn btn-outline-secondary btn-default" style="margin-right:10px">重新填寫</button>
   <button type="submit" class="btn btn-outline-secondary btn-default">送出申請</button>
    <button  class="btn btn-outline-secondary btn-default" style="margin-right:10px" onClick="window.history.back();">回上一頁</button>

</div>
 </center>
</form>

</div>  
         
     </div>
    </div>
  </div>


<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>

</body>
</html>
