<footer>
<div id="footer">
<div id="footer-top">
	<div class="width-limit">
    	<?php /*wp_nav_menu( array( 
			'theme_location' => 'footer', 
			'container' => 'false'
		) ); */ ?>
        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('footerwidgets') ); ?>
        <!--/quicklinks-->
		
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('contact') ); ?>
        <!--/contact-->
        <div class="clear"></div>
    </div>
</div>
<!--/#footer-top-->
    
<div id="footer-bottom">
	<div class="width-limit">
    	<div class="left">
        	<a id="footer_arhu" class="footer_link_img" href="http://www.arhu.umd.edu/">College of Arts and Humanities</a>
            <a id="footer_mith" class="footer_link_img" href="http://mith.umd.edu">MITH: Maryland Institute for Technology in the Humanities</a>
		</div>
        <!--/left-->
        
        <div class="right">
        <?php wp_nav_menu( array(
			'theme_location' => 'footer-textlinks',
			'container' => 'false'
		) ); ?>
			<div class="copyright">Copyright &copy; 2009-2010, Maryland Institute for Technology in the Humanities<br /><a href="<?php bloginfo('rss2_url'); ?>">Subscribe to MITH (RSS)</a>
            </div>
        </div>
        <!--/right-->
        <div class="clear"></div>
	</div>
</div>
<!--/#footer-bottom-->
</div>
</footer>
<?php wp_footer(); ?>
<!-- /footer -->
<div id="fb-root"></div>

<!-- facebook and google plus scripts -->

<script type="text/javascript">
  (function() {
	var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	po.src = 'https://apis.google.com/js/plusone.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

</body>
</html>
