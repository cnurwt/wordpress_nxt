<?php 
while ( $all_servicess->have_posts() ) :

    $all_servicess->the_post(); ?>

        <article id="services-<?php the_ID(); ?>" <?php post_class('mtl-services'); ?>>
         
            <div class="services-grid-inner">
            	
            	<?php $this->render_thumbnail(); ?>

                <div class="services-grid-text-wrap">
               		<?php $this->render_title(); ?>
	                <?php $this->render_meta(); ?>
	                <?php $this->render_excerpt(); ?>
	                <?php $this->render_readmore(); ?>
                </div>

            </div><!-- .services-inner -->
           
        </article>

        <?php

endwhile; 

wp_reset_postdata();