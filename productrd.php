<?php
require_once("conn.php");
session_start();
//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
	 header("Location:productall.php?keyword={$_GET["keyword"]}");
//預設狀況下未加限制顯示筆數的SQL敘述句
}
$query_RecProduct = "SELECT * FROM product WHERE categoryid=1 ORDER BY productid DESC";
$stmt = $db_link->prepare($query_RecProduct);
$stmt->execute();            
$RecProduct = $stmt->get_result();
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
      .clear{
          clear: left;
      }
      .albumDiv .albuminfo {
	font-family: "微軟正黑體";
	font-size: 16pt;
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
      .form-signin{
          margin:0 auto;
          width:100%;
          max-width: 400px;
         
          padding: 15px;
      }
      .albumDiv {
          width: 360px;
          height: 300px;
          margin-right: 0px;
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
      <input class="form-control mr-sm-2" name="keyword" id="keyword" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">搜尋</button>
    </form>
       </div>
</nav>

<div class="container" style="margin-top:50px;margin-bottom:30px">

     <h1 style="margin-bottom:20px">主廚經典系列 | Recommend</h1>
      <hr>

<div class="col-md-12">
   <?php
            while($row_RecProduct=$RecProduct->fetch_assoc()){ 
            ?>
            <div class="albumDiv">
              <div class="picDiv "><a href="product.php?id=<?php echo $row_RecProduct["productid"];?>">
                <?php if($row_RecProduct["productimages"]==""){?>
                <img src="images/nopic.png" alt="暫無圖片" width="120" height="120" border="0" />
                <?php }else{?>
                <img src="proimg/<?php echo $row_RecProduct["productimages"];?>" alt="<?php echo $row_RecProduct["productname"];?>" width="300" height="200" border="0" />
                <?php }?>
                </a></div>
              <div class="albuminfo"><a href="product.php?id=<?php echo $row_RecProduct["productid"];?>"><?php echo $row_RecProduct["productname"];?></a><br />
                <span class="smalltext">特價 </span><span class="redword"><?php echo $row_RecProduct["productprice"];?></span><span class="smalltext"> 元</span> </div>
              
            </div>
              <?php } ?>
               <div class="clear">&nbsp;</div> 
    </div>
     </div>
     
<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>
</body>
</html>