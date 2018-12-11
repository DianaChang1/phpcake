<?php
require_once("conn.php");
session_start();
//檢查是否經過登入，若有登入則重新導向
//執行會員登入
if(isset($_POST["username"]) && isset($_POST["password"])){
	//繫結登入會員資料
	$query_RecLogin = "SELECT username, password FROM memberdata WHERE username=?";
	$stmt=$db_link->prepare($query_RecLogin);
	$stmt->bind_param("s", $_POST["username"]);
	$stmt->execute();
	//取出帳號密碼的值綁定結果
	$stmt->bind_result($username, $passwd);	
	$stmt->fetch();
	$stmt->close();
	//比對密碼，若登入成功則呈現登入狀態
	if(password_verify($_POST["password"],$passwd)){
		//設定登入者的名稱
		$_SESSION["loginMember"]=$username;
		//使用Cookie記錄登入資料
		if(isset($_POST["rememberme"])&&($_POST["rememberme"]=="true")){
			setcookie("remUser", $_POST["username"], time()+365*24*60);
			setcookie("remPass", $_POST["password"], time()+365*24*60);
		}else{
			if(isset($_COOKIE["remUser"])){
				setcookie("remUser", $_POST["username"], time()-100);
				setcookie("remPass", $_POST["password"], time()-100);
			}
		}
			header("Location:productall.php");	
		}
	else{
		header("Location: member.php?errMsg=1");
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
           <div class="errDiv">  登入帳號或密碼錯誤！</div>
          <?php }else{?>Please sign in<?php }?></h1>
   </center>
      
      <label for="username" >帳號</label>
      <input type="text" id="username" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_COOKIE["remUser"]) && ($_COOKIE["remUser"]!="")) echo $_COOKIE["remUser"];?>">
      <label for="password">密碼</label>
      <input type="password" id="password" name="password" class="form-control" placeholder="Password" value="<?php if(isset($_COOKIE["remPass"]) && ($_COOKIE["remPass"]!="")) echo $_COOKIE["remPass"];?>">
   
        <label>
          <input type="checkbox"name="rememberme" id="rememberme" value="true" checked> 記住我的帳號密碼
        </label>
        <p align="center"><a href="admin_passmail.php">忘記密碼，補寄密碼信。</a></p>
    
      <button class="btn btn-lg btn-primary btn-block" type="submit">登入</button>
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