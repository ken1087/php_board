<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
</head>
<link rel="stylesheet" href="styles/menu.css">

<body>
<?php
   require_once("session.php");
?>
<section class="model">
   <div id="refresh">새로 고침</div>
   <div id="write_review"><a href="writeform.php">선수 소개 등록</a></div>
   <article class="review">
      <div class="img_frame">
         <img class="user_image" src="images/a.jpg" alt="Gundam Pictures" />
         <div class="user_memo"><p>MG 건담 마크-II 에우고 RX-178</p></div>
         <div class="user_info">
            <img class="user_thumbnail" src="images/ab.jpg" alt="User image"/>
            <div class="user_email">a@k.com</div>
         </div>
      </div>
      <section class="review_reply">
         <div id="write_reply"><a href="writereplyform.php?reviewid=2"> 댓글 등록</a><div>
         <article class="reply">
            <div class="user_reply"><p>HG Revive 버전이 나왔지요.</p></div>
            <div class="user_info">
               <img class="user_thumbnail" src="images/ab.jpg" alt="User image"/>
               <div class="user_email">a@k.com</div>
               <div class="user_date">2015년 12월 27일</div>
         </div>
         </article>
      </section>   
   </article>
      <article class="reply">
               <div class="user_reply"><p>HG 새로운 버전이 나왔습니다.</p></div>
               <div class="user_info">
                  <img class="user_thumbnail" src="images/abc.jpg" alt="User image"/>
                  <div class="user_email">a@u.com</div>
                  <div class="user_date">2015년 12월 27일</div>
            </div>
      </article>
</section>
</br>
</body>
</html>