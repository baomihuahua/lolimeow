<?php
/**
 * Template Name: 图床
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
					
<div class="col-md-8 ml-auto mr-auto">

<div class="card card-nav-tabs text-center">
  <div class="card-header card-header-primary">
    MeowData专用图床  - SM.MS提供支持
  </div>
  <div class="card-body">
    <h4 class="card-title">上传图片</h4>
	 <div id="uploadinfo"></div>
	 <div id="urls"></div>  
	 <div id="path"></div> 
	 <div id="delete"></div> 

	 
	 
<div class="form-group form-file-upload form-file-multiple">
	<a href="javascript:;" >
		 <div class="custom-file">
  <input type="file" class="custom-file-input" id="image" accept="image/*" multiple="multiple">
  <label class="custom-file-label" for="image">请选择图片上传</label>
</div>
</a>	
  </div>
 <img class="card-img-bottom" id="img1" src="https://www.meowdata.com/wp-content/themes/lolimeow/assets/images/logo.png" alt="MeowData专用图床" style="max-width: 300px;">
 <div id="img2"></div>	
  </div>
  


	
	</div>

						
                    </div>
 
                </div>
            </div>	   </div>	
			
</main>	
<script src="<?php echo meowdata('style_src') ;?>/assets/js/ajaxscript.js"></script>
<?php get_footer(); ?>
