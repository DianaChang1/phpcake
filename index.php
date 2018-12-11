<?php
require_once("conn.php");
session_start();
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
      <input class="form-control mr-sm-2" id="keyword" name="keyword"type="search" placeholder="Search" aria-label="Search" >
      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">搜尋</button>
    </form>
       </div>
</nav>

<div class="container" style="margin-top:50px;margin-bottom:30px">
  <div class="row">
    <div class="col-lg-12">
      <h1 style="margin-bottom:20px">一顆豆的啟發 | INSPIRE</h1>
      <hr>
     <img src="images/about_img.png"  width="100%" >
      <p style="margin-top:10px;font-size:1.5rem;">自幼父母離異，國小時期就被送到了育幼院，雖然環境與週遭的朋友有差異，但我並沒有因此感到消極反而利用這些令我挫折的人、事、物來勉勵自己！記憶中有個令我永遠無法忘懷的一件事，也是激發我往甜點之路邁進的一大轉捩點。</p>
<p style="margin-top:10px;font-size:1.5rem;">其實我最討厭放學時間，因為每當放學時總會看到同學們的家長在門口等待或是同學三五成群的一起去雜貨店買零食，而我什麼都沒有只能孤零零的回到有著園長、老師的育幼院，有天一如往常的走在回家的路上，赫然發現乾涸的水溝內有著其他小孩掉下的一顆甘納豆，當下我毫不猶豫的撿起那顆不知身在那多久的甘納豆，放入口中時那甜膩的滋味使我心中的苦澀頓時煙消雲散，從那刻起，便在心中埋下了日後一定要做出令人感動的甜點，也能帶給人們幸福感的小小期許。</p>
      <br>
      <h1>關於我們 | ABOUT US</h1>
      <hr>
  <p style="margin-top:10px;font-size:1.5rem;">在草創初期的Sweet Cake隱身於老家廚房內，沒有招牌沒有店面，靠的是顧客口耳相傳，每天八點準時提著蛋糕開始推銷於每間公家機關，公司行號及學校，而晚上又要繼續製作明日所需的蛋糕，每天製作到凌晨是稀鬆平常的事，因此一天的休息時間就只有吃飯及那短短四小時不到的睡眠時間，所幸在堅持品質的原則下，令顧客們都讚不絕口，'吃好逗相報'下的好口碑，讓Sweet Cake終於能在花蓮占有一席之地。</p>
<p style="margin-top:10px;font-size:1.5rem;">10年前決定將Sweet Cake移至現址（花蓮市中華路330號），立起招牌，讓顧客能夠有個明顯的購買地點而不用再鑽進羊腸小徑內尋找蛋糕店在哪！而這17年除了所堅持的品質外還有的就是不裝潢！17年來如一日，許多 客人進門的第一句話就是：『老闆！你的店很不像店誒！！』，但是我們寧願省下裝潢費而把費用拿來尋找更好的食材及使用更優質的原料來滿足每位顧客的味蕾，而我們希望的是：『大家在Sweet Cake買到的不是蛋糕而 是一份真誠的用心以及幸福感！』</p>
     
    </div>
  </div>
</div>

<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>

</body>
</html>
