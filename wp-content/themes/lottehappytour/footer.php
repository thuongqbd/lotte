<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>
			<div class="container">
				<div class="group footer">
					<div class="page-footer">
						<div class="logo-footer">
							<a class="logo" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/logo-footer.png" alt=""/></a>
							<a class="facebook" href="#"><img src="<?php echo get_template_directory_uri(); ?>/images/facebook.png" alt=""/></a>
						</div>
					</div>
				</div>
			</div>
		</div><!-- main -->
	</div><!-- main -->
</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>