<?php get_header(); ?>
	<div id="featured-text">
		<div class="slide">
			<h2 class="title"><a href="#">Vindicatum</a></h2>
			<p>Icecrown - Alliance</p>
		</div> 
	</div>
	
	<?php if ( get_option('instyle_blog_style') == 'false' ){ ?>
		<div id="services" class="clearfix">
			<?php for ($i=1; $i <= 2; $i++) { ?>
				<?php query_posts('page_id=' . get_pageId(html_entity_decode(get_option('instyle_home_page_'.$i)))); while (have_posts()) : the_post(); ?>
					<?php 
						global $more; $more = 0; 
						$et_instyle_settings = get_post_meta($post->ID,'et_instyle_settings',true) ? maybe_unserialize( get_post_meta($post->ID,'et_instyle_settings',true) ) : '';
						$et_bg_img = $et_instyle_settings != '' ? $et_instyle_settings['et_fs_bg_images'] : '';
						if ($et_bg_img <> '') $et_bgs = explode( ",", html_entity_decode( $et_bg_img, ENT_QUOTES ) );
						$et_service_width = 265;
						$et_service_height = 145;
					?>
					<div class="service<?php if ( $i==3 ) echo ' last'; ?>">
						<div class="service-description-bottom">
							<div class="service-description">
								<div class="description">
									<p><?php echo apply_filters('the_content',et_create_dropcaps(get_the_content(''))); ?></p>
								</div> 	<!-- end .description-->
								<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','InStyle'); ?></span></a>
							</div> 	<!-- end .service-description -->
						</div> 	<!-- end .service-description-bottom -->
					</div> 	<!-- end .service -->
				<?php endwhile; wp_reset_query(); ?>
			<?php } ?>

		</div> <!-- end #services -->
	<?php } else { ?>
		<div id="content-top"></div>
		<div id="content" class="clearfix">
			<div id="content-area">
				<?php 
					$args=array(
						'showposts'=> (int) get_option('instyle_homepage_posts'),
						'paged'=>$paged,
						'category__not_in' => (array) get_option('instyle_exlcats_recent'),
					);
					if (get_option('instyle_duplicate') == 'false'){
						global $ids;
						$args['post__not_in'] = $ids;
					}
					query_posts($args);
				?>
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
					<div class="post clearfix">
						<h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
						<?php get_template_part('includes/postinfo'); ?>
						
						<?php 
							$thumb = '';
							$width = 211;
							$height = 211;
							$classtext = '';
							$titletext = get_the_title();
							
							$thumbnail = get_thumbnail($width,$height,$classtext,$titletext,$titletext,false,'Entry');
							$thumb = $thumbnail["thumb"]; 
						?>
						
						<?php if($thumb <> '' && get_option('instyle_thumbnails_index') == 'on') { ?>
							<div class="post-thumbnail alignleft">
								<a href="<?php the_permalink(); ?>">
									<?php print_thumbnail($thumb, $thumbnail["use_timthumb"], $titletext, $width, $height, $classtext); ?>
									<span class="post-overlay"></span>
								</a>	
							</div> 	<!-- end .post-thumbnail -->
						<?php } ?>
						
						<div class="description">
							<?php if ( get_option('instyle_blog_style') == 'on' ){ ?>
								<?php echo apply_filters('the_content',et_create_dropcaps(get_the_content(''))); ?>
							<?php } else { ?>
								<p><?php echo et_create_dropcaps(truncate_post(775,false)); ?></p>
							<?php } ?>
						</div> 	<!-- end .description-->
						<a href="<?php the_permalink(); ?>" class="readmore"><span><?php esc_html_e('read more','InStyle'); ?></span></a>
					</div> <!-- end .post -->
				<?php endwhile; ?>
					<?php 
						if(function_exists('wp_pagenavi')) { wp_pagenavi(); }
						else { get_template_part('includes/navigation'); } 
					?>
				<?php else : ?>
					<?php get_template_part('includes/no-results'); ?>					
				<?php endif; wp_reset_query(); ?>
			</div> <!-- end #content-area -->
			
			<?php get_sidebar(); ?>
		</div> <!--end #content-->
		<div id="content-bottom"></div>
	<?php } ?>

<?php get_footer(); ?>