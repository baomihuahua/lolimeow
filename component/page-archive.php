<?php 
/*
 * Template Name: 文章归档
*/
get_header();
?>
<section class="section-profile-cover section-blog-cover section-shaped my-0 " <?php if( meowdata('banneron') ) {echo md_banner();} ?>>
      <div class="shape shape-style-1 shape-primary alpha-4">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="separator separator-bottom separator-skew" >
        <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none">
          <polygon class="fill-white" points="2560 0 2560 100 0 100"></polygon>
        </svg>
      </div>
    </section> 
<main class="meowblog">	
<div class="main-container">
<div class="container">
<div class="row">
<div class="col-lg-10 col-md-10 ml-auto mr-auto">


 
 
 
 <?php zww_archives_list(); ?>
 
 
 
 
<script>
    $(function(){
        $(".biji-content").hide();
        //按钮点击事件
        $(".openoff").click(function(){
            var txts = $(this).parents("li");
            if ($(this).text() == "[ 展开 ]"){
                $(this).text("[ 收起 ]");
                txts.find(".biji-tit").hide();
                txts.find(".biji-content").show();
            }else{
                $(this).text("[ 展开 ]");
                txts.find(".biji-tit").show();
                txts.find(".biji-content").hide();
            }
        })
    });
</script>
 
 


</div>	
</div>	
</div>	
</div>	
</main>	
<?php  get_footer(); ?>