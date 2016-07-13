<?php

//* Template Name: Home Page

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_loop', 'home_loop' );

function home_loop() { ?>
    <div itemtype="http://schema.org/CreativeWork" itemscope="itemscope" class="products-page">
        <div class="entry-content" itemprop="text">

            <?php 
                if(have_posts()) : while(have_posts()) : the_post();

                    // check if the repeater field has rows of data
                    if( have_rows('sub_page_blocks') ):

                        // loop through the rows of data
                        while ( have_rows('sub_page_blocks') ) : the_row();
                               
                            $icon = get_sub_field('icon');
                            $link = get_sub_field('link');

                            echo '<div class="col-md-4">
                                    <div class="home-block">';
                                    echo '<span class="helper"></span>';
                                    echo '<img src="'. $icon .'" />';
                                    echo '<a href="'. $link .'" class="passport-block-link"></a>';
                            echo '  </div>
                                 </div>';

                        endwhile;

                    else :

                        // no rows found

                    endif;
                               
                               
                    
                endwhile; endif;	
            ?>
        </div>
    </div>
<?php }

genesis();