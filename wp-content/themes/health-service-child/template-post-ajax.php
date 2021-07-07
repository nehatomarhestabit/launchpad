<?php
/**
 * Template Name: Post Ajax Listing  
 */
 
get_header(); ?>

<div class="sp-100 bg-w">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">           
                <?php
                $args = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'posts_per_page' => '2',
                    'paged' => 1,
                );
                $blog_posts = new WP_Query( $args );
                ?>

                <?php if ( $blog_posts->have_posts() ) : ?>
                    <div class="blogposts row">
                        <?php while ( $blog_posts->have_posts() ) : $blog_posts->the_post(); ?>
                            <div class="blogposts__item col-lg-6">                            
                                <?php echo get_the_post_thumbnail( $blog_posts->ID, 'full' ); ?>
								<div class="blogposts__info">
                                	<h2 class="blogposts__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                	<div class="blogposts__text"><?php the_excerpt(); ?></div>
								</div>
                            </div>
                        <?php endwhile; ?>
						
                    </div>
				 	<button class="loadmore">Load More</button>
                   
                <?php endif; ?>
                </div>
		
		<?php //get_sidebar(); ?>
		</div>
	</div>
<?php get_footer();
?>