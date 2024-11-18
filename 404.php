<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package boxmoe
 */

get_header();
?>
<main class="w-100">
         <!--404 error start-->
         <div class="container d-flex flex-column overflow-hidden">
            <div class="row align-items-center justify-content-center py-md-8 text-center">
               <div class="col-lg-6 col-12">
                  <h2>Oops page not found</h2>
                  <p>你访问页面不存在！</p>
                  <a href="/" class="btn btn-primary">Go back to home</a>
               </div>
            </div>
         </div>
      </main>
<?php
get_footer();
