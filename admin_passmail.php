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
//重新產生密碼亂碼
function MakePass($length) { 
	$possible = "0123456789"; 
	$str = ""; 
	while(strlen($str)<$length){ 
	  $str .= substr($possible, rand(0, strlen($possible)), 1); 
	}
	return($str); 
}
require_once("conn.php");
session_start();
//檢查是否經過登入，若有登入則重新導向
//執行會員登入
if(isset($_POST["username"])){
	$muser = GetSQLValueString($_POST["username"], 'string');
	//找尋該會員資料
	$query_RecFindUser = "SELECT username, customeremail,customername FROM memberdata WHERE username='{$muser}'";
	$RecFindUser = $db_link->query($query_RecFindUser);	
	if ($RecFindUser->num_rows==0){
		header("Location: admin_passmail.php?errMsg=1&username={$muser}");
	}else{	
	//取出帳號密碼的值
		$row_RecFindUser=$RecFindUser->fetch_assoc();
        $name = $row_RecFindUser["customername"];
		$username = $row_RecFindUser["username"];
		$usermail = $row_RecFindUser["customeremail"];	
		//產生新密碼並更新
		$newpasswd = MakePass(4);
		$mpass = password_hash($newpasswd, PASSWORD_DEFAULT);
		$query_update = "UPDATE memberdata SET password='{$mpass}' WHERE username='{$username}'";
		$db_link->query($query_update);
        
        $mailcontent=<<<msg
	親愛的 $name 您好：

	--------------------------------------------------
	您的帳號：$username 
	您的密碼：$newpasswd 
	--------------------------------------------------
	希望能再次為您服務 
	
	網路購物公司 敬上
msg;
	$mailFrom="=?UTF-8?B?" . base64_encode("網路購物系統") . "?= <service@e-happy.com.tw>";
	$mailto =$usermail;
	$mailSubject="=?UTF-8?B?" . base64_encode("網路購物系統訂單通知"). "?=";
	$mailHeader="From:".$mailFrom."\r\n";
	$mailHeader.="Content-type:text/html;charset=UTF-8";
	if(!@mail($mailto,$mailSubject,nl2br($mailcontent),$mailHeader)) die("郵寄失敗！");
	//清空購物車
		header("Location: admin_passmail.php?mailStats=1");
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
  <link href="style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <style type="text/css">
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
      .form-signin{
          margin:0 auto;
          width:100%;
          max-width: 400px;
         
          padding: 15px;
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
<?php if(isset($_GET["mailStats"]) && ($_GET["mailStats"]=="1")){?>
<script>alert('密碼信補寄成功！');window.location.href='member.php';</script>
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

     <h1 style="margin-bottom:20px">會員登入 | Member Login</h1>
      <hr>


   <form class="form-signin page_content" style="margin-top:50px;" method="post">
   <center>
       <h1 class="h2 mb-3 font-weight-normal" style="padding-top:15px;"><?php if(isset($_GET["errMsg"]) && ($_GET["errMsg"]=="1")){?>
           <div class="errDiv">  帳號錯誤！</div>
          <?php }else{?><b>忘記密碼?!</b><?php }?></h1>
   </center>
      <p>請輸入您申請的帳號，系統將自動產生一個四位數的密碼寄到您註冊的信箱。</p>
      <label for="username" >帳號</label>
      <input type="text" id="username" name="username" class="form-control" placeholder="Username">
      <button class="btn btn-lg btn-primary btn-block" type="submit" style="margin-top:20px">送出</button>
       <hr size="1" >
       <center style="background-color:#f59191;padding:4px 0px">
           <h3>還沒有會員帳號?</h3>
          <p>註冊帳號免費又容易</p>
       </center>
          <p align="right"><a href="member_join.php">馬上申請會員</a></p>
    </form> 
     </div>
<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>
</body>
</html>