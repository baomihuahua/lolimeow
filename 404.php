<?php
/**
 * @package lolimeow@boxmoe themes
 * @link https://www.boxmoe.com
 */
//=======安全设置，阻止直接访问主题文件=======
if (!defined('ABSPATH')) {echo'Look your sister';exit;}
//=========================================
get_header();
?>
<main class="w-100">
         <!--404 error start-->
         <div class="container d-flex flex-column overflow-hidden">
            <div class="row align-items-center justify-content-center py-md-8 text-center">
               <div class="col-lg-6 col-12">
                  <h2>Oops page not found</h2>
                  <p>你访问页面不存在！</p>
                  <a href="./index.html" class="btn btn-primary">Go back to home</a>
               </div>
            </div>
         </div>
      </main>
<?php
get_footer();
