<?php
/**
 * Block Name: Testimonial List
 *
 * This is the template that displays the testimonial block.
 */

?>
<div class="bg-w">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">           
                <?php
                $pagination = get_field('choose_pagination'); 
                $heading = get_field('heading'); 
                $post_limit = get_field('limit');
                $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : '1';
                $args = array(
                    'post_type' => 'testimonial',
                    'post_status' => 'publish',
                    'posts_per_page' => $post_limit,
                    'paged' =>  $paged
                );
                $testimonial_posts = new WP_Query( $args );
                query_posts( $args );                
                ?>

                <?php if ( $testimonial_posts->have_posts() ) : ?>
					<div class="testimonial-list row"> 
                    <h2><?php  echo $heading; ?></h2> 
                                         
                        <?php while ( $testimonial_posts->have_posts() ) : $testimonial_posts->the_post(); ?>
                        <div class="testimonial-list__item col-lg-12">                            
                            <p class="testimonial-list__bio"><?php echo get_post_meta( get_the_ID(), 'bio', true); ?></p>
                            <h3 class="testimonial-list__name"><?php echo get_post_meta( get_the_ID(), 'name', true); ?></h3>
                            <h4 class="testimonial-list__location"><?php echo get_post_meta( get_the_ID(), 'location', true); ?></h4>                            
                        </div>
                        <?php endwhile; ?>
                    </div>
                    <?php   
                     if($pagination == "load_more"){
                        echo "<button class='loadmore_testimonial'>Load More</button>";
                    }
                    else{
                        the_posts_pagination( array(
                        'mid_size'=>3,
                        'prev_text' => _( '« Previous'),
                        'next_text' => _( 'Next »'),
                        ) );
                    }
                        ?>
                    <?php endif; ?>                    
            </div>
		</div>
	</div>

