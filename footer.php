 <?php if (is_active_sidebar('section-widget-1')) { ?>
 <div class="right-menu">
     <div class="right-menu-wrapper">
         <a class="right-menu-close jsRightMenuCLose"></a>
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
