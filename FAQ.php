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
      p{
          margin-top:10px;
          font-size:1.5rem;
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
      h3{
          font-weight:bold;
          margin-top:40px;
          margin-bottom:30px;
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
      <input class="form-control mr-sm-2" type="search" name="keyword" id="keyword" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-info my-2 my-sm-0" type="submit">搜尋</button>
    </form>
       </div>

 
</nav>

<div class="container" style="margin-top:50px;margin-bottom:30px">
  <div class="row">
    <div class="col-lg-12">
      <h1 style="margin-bottom:20px">購物說明 購物前麻煩詳閱 | FAQ</h1>
      <hr>
      <h5>宅配須知</h5>
      <h3 >折扣說明</h3>
        <p>經典系列產品滿5盒享有9折優惠</p>
        <p>主廚推薦系列產品能合併計算盒數不另外折扣</p>
        <p>同天同地址寄送滿10盒享有9折免運費(不含離島)</p>
        <p>同天同地址寄送滿30盒享有8折免運費(不含離島)</p>
        <h3>運費說明</h3>
        <p>單寄1盒雅嵐達諾，米勒希芒，納格拉運費150元</p>
        <p>1-3盒(不含雅嵐達諾，米勒希芒及納格拉) 運費150元</p>
        <p>2-9盒(含雅嵐達諾，米勒希芒及納格拉)運費210元</p>
        <p>4-12盒 運費210元</p>
        <p>13-24盒運費270元</p>
        <p>離島運費另計</p>
        <h3>塑膠袋相關事宜</h3>
        <p>為因應政府環保政策，即日起宅配物件將不再主動提供塑膠袋，如需塑膠袋</p>
        <p>請於備註欄上註明是否加購塑膠袋</p>
        <p>塑膠袋一個1元</p>
        <p>10盒以下隨盒數收取費用(ex:訂3盒收3元，訂8盒收8元，以此類推)</p>
        <p>10盒以上每筆訂單收取10元的加購費用</p>
<p>如需購買袋子的捧油們，如果是匯款的捧油麻煩依照上面的規則自己加上袋子的金額唷</p>
<p>貨到付款的捧油們，我們會直接幫您加在到貨收款的金額內唷 </p>
    <h3>配送日期說明</h3> 
    <p>黑貓宅急便目前星期日為公休日(沒有收件也沒有送件)</p>
<p>因此現在宅配到貨時間 為星期二-星期六，麻煩宅配捧油們</p>
<p>不要選擇星期日或星期一的日期哦</p>
    <h3>付款方式</h3> 
    <p>貨到付款&ATM轉帳</p>
<p>單筆訂單超過1萬元必須先行轉帳哦</p>
<p>轉帳完畢後需撥打電話至038322169，將會有專人為您查帳</p>
   
    </div>
  </div>
</div>

<div class="jumbotron text-center" style="margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;font-size:1rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>

</body>
</html>
