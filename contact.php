<?php
session_start();
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

if(isset($_POST["action"])&&($_POST["action"]=="add")){
	require_once("conn.php");
	//若沒有執行新增的動作	
		$query_insert = "INSERT INTO question (sign_name, phone, email, content) VALUES (?, ?, ?, ?)";
		$stmt = $db_link->prepare($query_insert);
		$stmt->bind_param("ssss", 
			GetSQLValueString($_POST["sign_name"], 'string'),
			GetSQLValueString($_POST["phone"], 'string'),
			GetSQLValueString($_POST["email"], 'email'),
			GetSQLValueString($_POST["content"], 'string'));
		$stmt->execute();
		$stmt->close();
		$db_link->close();
		header("Location: contact.php?loginStats=1");
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
if(document.form1.sign_name.value=="")
{
alert('提示:\n\n請輸入姓名!');
document.form1.sign_name.focus();
return false;
}
if(document.form1.phone.value==""){
alert('提示:\n\n請輸入聯絡電話!');
document.form1.phone.focus();
return false;
}
else if(document.form1.phone.value!="")
{
    uid=document.form1.phone.value;
		if(!(uid.length==8 || uid.length==10)){
			alert( "電話輸入錯誤，請重新輸入!" );
			document.form1.phone.focus();
			return false;}
		if(!(uid.charAt(0)==0)){
			alert("電話輸入錯誤，請重新輸入!" );
			document.form1.phone.focus();
			return false;
}
} 
if(document.form1.email.value==""){
alert('提示:\n\n請輸入E-mail!');
document.form1.email.focus();
return false;
}

if(document.form1.content.value==""){
alert('提示:\n\n請輸入詢問內容!');
    document.form1.content.focus();
return false;
}
else
return confirm('確定送出嗎？');
}

</script>    
    
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
alert('回覆成功!感謝您寶貴的意見!');
window.location.href='contact.php';
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
        <?php if(isset($_SESSION["loginMember"])&&($_SESSION["loginMember"]!="")){?>
       <a class="nav-link defined" href="membercenter.php">會員中心</a>
    <?php }else{ ?>
        <a class="nav-link defined" href="member.php">會員登入</a>
        <?php }?>
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
      <h1 style="margin-bottom:20px">聯絡我們 | Contact Us</h1>
      <hr>
      <div class="page_content">
       <form name="form1" class="form-horizontal" method="post" action="" onsubmit="return check();">

<div class="form-group">
<label class="control-label col-sm-2 textsize" for="sign_name">姓名:</label>
<div class="col-sm-12">
<input type="text" class="form-control" id="sign_name" placeholder="請輸入姓名" name="sign_name">
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-2 textsize" for="phone">聯絡電話:</label>
<div class="col-sm-12"> 
<input type="tel" class="form-control" id="phone" placeholder="請輸入聯絡電話" name="phone">
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-2 textsize" for="email">E-mail:</label>
<div class="col-sm-12">
<input type="email" class="form-control" id="email" name="email" placeholder="請輸入Email">
</div>
</div>

<div class="form-group">
<label class="control-label col-sm-2 textsize" for="content">詢問內容:</label>
<div class="col-sm-12"> 
<textarea name="content" class="form-control" id="content" cols="50" rows="10"></textarea>
</div>
</div>
        <center>
     <div class="col-sm-offset-2 col-sm-10">
    <button type="reset" class="btn btn-outline-secondary btn-default" style="margin-right:10px">重新填寫</button>
<button type="submit" class="btn btn-outline-secondary btn-default">確認送出</button>
</div>
 </center>
<input type="hidden" name="action" value="add">
</form>
</div>
</div>  
         
     </div>
    </div>
  </div>


<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>

</body>
</html>
