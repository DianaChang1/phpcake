<?php
require_once("conn.php");
//購物車開始
require_once("mycart.php");
session_start();
$cart =& $_SESSION['cart']; // 將購物車的值設定為 Session
if(!is_object($cart)) 
    $cart = new myCart1();//原本myCart改成myCart1並到mycart.php改成myCart1，以免跟別的網站共用
//若有搜尋關鍵字時未加限制顯示筆數的SQL敘述句
if(isset($_GET["keyword"])&&($_GET["keyword"]!="")){
	 header("Location:productall.php?keyword={$_GET["keyword"]}");
}
$query_RecMember = "SELECT * FROM memberdata WHERE username='{$_SESSION["loginMember"]}'";
$RecMember = $db_link->query($query_RecMember);	
$row_RecMember = $RecMember->fetch_assoc();
?>
<html>
<head>
<title>Sweet Cake</title>
  <meta charset="utf-8">
<link href="style.css" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
  <script language="javascript">
function checkForm(){	
	if(document.cartform.customername.value==""){
		alert("請填寫姓名!");
		document.cartform.customername.focus();
		return false;
	}
	if(document.cartform.customeremail.value==""){
		alert("請填寫電子郵件!");
		document.cartform.customeremail.focus();
		return false;
	}
	if(!checkmail(document.cartform.customeremail)){
		document.cartform.customeremail.focus();
		return false;
	}	
	if(document.cartform.customerphone.value==""){
		alert("請填寫電話!");
		document.cartform.customerphone.focus();
		return false;
	}
	if(document.cartform.customeraddress.value==""){
		alert("請填寫地址!");
		document.cartform.customeraddress.focus();
		return false;
	}
	return confirm('確定送出嗎？');
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
      .infoDiv{
          margin-top: 200px;
          width:300px;
      }
      p{
          margin-bottom: 0.5rem;
           margin-top: 0.5rem;  
      }
      tr p{
           font-size: 16pt;
      }
     .dataDiv p{
           font-size: 13pt;
      }
      .titleDiv{
          font-size: 17pt;
      }
      .smalltext {
	font-size: 15px;
	color: #000000;
}
      .actionDiv {
	margin-top: -40px;
    font-size:14pt;
}
      .actionDiv a:hover {
          font-size:18pt;
          text-decoration:none;
	color: #FFFFFF;
	background-color: #0037cc;
}
      .clear{
          clear: left;
      }
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
          margin-right: 50px;
      }
    </style>
  <style>
      hr{
          margin-top: 0px;
      }
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
       @media (min-width:1200px){
           .container{
               max-width: 900px;
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
		  <?php if($cart->itemcount > 0) {?>
         <div class="container" style="margin-top:50px;margin-bottom:30px">
          <div class="subjectDiv"> <img src="images/16-cube-blue.png" width="25" height="25" align="absmiddle"> 購物車內容</div>
          <form action="" method="post" name="form" id="form">
          <table width="78%" border="0" align="center" cellpadding="2" cellspacing="1">
              <tr>
                <th  bgcolor="#f2b2b2"><p align="center">編號</p></th>
                <th  bgcolor="#f2b2b2"><p align="center">產品名稱</p></th>
                <th  bgcolor="#f2b2b2"><p align="center">數量</p></th>
                <th  bgcolor="#f2b2b2"><p align="center">單價</p></th>
                <th  bgcolor="#f2b2b2"><p align="center">小計</p></th>
              </tr>
              
          <?php
                  $i=0;                        
        foreach($cart->get_contents() as $item) { 
                  $i++;   
              ?>
                    
              <tr>
                <td align="center" bgcolor="#f7e9e9" class="tdbline"><p><?php echo $i;?>.</p></td>
                <td bgcolor="#f7e9e9" class="tdbline" align="center"><p><?php echo $item['info'];?></p></td>
                <td align="center" bgcolor="#f7e9e9" class="tdbline"><p>
                  <input name="updateid[]" type="hidden" id="updateid[]" value="<?php echo $item['id'];?>">
                  <input name="qty[]" type="text" id="qty[]" value="<?php echo $item['qty'];?>" size="1">
                  </p></td>
                <td align="center" bgcolor="#f7e9e9" class="tdbline"><p>$ <?php echo number_format($item['price']);?></p></td>
                <td align="center" bgcolor="#f7e9e9" class="tdbline"><p>$ <?php echo number_format($item['subtotal']);?></p></td>
              </tr>
          <?php }?>
              <tr>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>運費</p></td>
                <td align="center" bgcolor="#f7e9e9"><p>-滿800免運-</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>$ <?php echo number_format($cart->deliverfee);?></p></td>
              </tr>
              <tr>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>總計</p></td>
                <td valign="baseline" bgcolor="#f7e9e9"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p>&nbsp;</p></td>
                <td align="center" valign="baseline" bgcolor="#f7e9e9"><p class="redword">$ <?php echo number_format($cart->grandtotal);?></p></td>
              </tr>          
            </table>
               </form>
            
              <div class="subjectDiv" style="margin-top:20px"> <img src="images/16-cube-blue.png" width="25" height="25" align="absmiddle"> 顧客資訊</div>
            
              <form action="cartreport.php" method="post" name="cartform" id="cartform" onSubmit="return checkForm();">
               <div class="form-group">
            <label class="control-label col-sm-2 textsize" for="customername">姓名:</label>
        <div class="col-sm-12">
        <input type="text" class="form-control" id="customername" value="<?php echo $row_RecMember["customername"];?>" name="customername">
        </div>
        </div>
            <div class="form-group">
<label class="control-label col-sm-2 textsize" for="customeremail">電子郵件:</label>
<div class="col-sm-12">
<input type="email" class="form-control" id="customeremail" value="<?php echo $row_RecMember["customeremail"];?>" name="customeremail">
</div>
</div>      
    <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="customerphone">電話:</label>
    <div class="col-sm-12">
    <input type="tel" class="form-control" id="customerphone" value="<?php echo $row_RecMember["customerphone"];?>" name="customerphone">
    </div>
    </div>      
             <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="customeraddress">住址:</label>
    <div class="col-sm-12">
    <input type="text" class="form-control" id="customeraddress" value="<?php echo $row_RecMember["customeraddress"];?>"name="customeraddress">
    </div>
    </div>   
              <div class="form-group">
    <label class="control-label col-sm-2 textsize" for="paytype">付款方式:</label>
    <div class="col-sm-12">
    <select name="paytype" class="form-control" id="paytype">
<option value="ATM匯款" selected>ATM匯款</option>
<option value="線上刷卡">線上刷卡</option>
   <option value="貨到付款">貨到付款</option>
</select>
    </div>
    </div>          
            <hr width="100%" size="1" />
            <p align="center">
              <input name="cartaction" type="hidden" id="cartaction" value="update">
                  <input type="submit" name="updatebtn" id="button3" value="送出訂購單">
                  <input type="button" name="backbtn" id="button4" value="回上一頁" onClick="window.history.back();">
              </p>
             </form>           
          </div>   
           <div class="jumbotron text-center" style="width:100%;float:left;margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
</div>
              
 
           <?php }else{ ?>
           <div class="container" style="margin-top:50px;margin-bottom:30px">
            <div class="subjectDiv"> <img src="images/16-cube-blue.png" width="25" height="25" align="absmiddle"> 購物車內容</div>
            <div style="height:220px">
            <center>
                <div class="infoDiv">目前購物車是空的。
            </div>
            </center>
            
            </div>
         </div> 
         <div class="jumbotron text-center" style="width:100%;float:left;margin-bottom:0 ;background-color:#343333;">
  <p  style="color:#ffffff;padding-top:0.5rem;">Sweet Cake&copy;All Rights Reserved</p>
    </div><?php } ?>
          

</body>
</html>
<?php $db_link->close();?>