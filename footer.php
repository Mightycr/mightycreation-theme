 <?php if (is_active_sidebar('section-widget-1')) { ?>
 <div class="right-menu">
     <a class="right-menu-close jsRightMenuCLose"></a>
     <div class="right-menu-wrapper">
         <?php dynamic_sidebar('section-widget-1'); ?>
     </div>
 </div>
 <!-- ./right-menu-->
 <?php } ?>

 <div id="loading-page" class="loading-page">
     <a class="logo"></a>
 </div>
 <!-- ./loading-page-->

 <?php wp_footer(); ?>

 </body>

 </html>
