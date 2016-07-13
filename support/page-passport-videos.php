<?php

//* Template Name: Passport Videos Page

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_full_width_content' );

remove_action( 'genesis_loop', 'genesis_do_loop' );
add_action( 'genesis_after_header', 'passport_videos_loop' );

function passport_videos_loop() { 
        if(have_posts()) : while(have_posts()) : the_post();

            $icon = get_field('icon');
            $content = get_field('content');
            
            echo '<div class="passport-videos-hero">';
            the_post_thumbnail('post-image');
                echo '<div class="row">
                        <div class="col-md-8 col-md-offset-2 passport-videos-hero-content">';
                        echo '<div class="fa '. $icon .'"></div>
                              <div>'. $content .'</div>';
                    echo '</div>
                    </div>
            </div>';

        endwhile; endif;
?>
<div class="site-inner">
    <div class="content-sidebar-wrap">
        <main class="content" id="genesis-content">
            <div class="breadcrumb" itemprop="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">You are here: 
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="<?php echo get_home_url(); ?>" itemprop="item">
                        <span itemprop="name">Home</span>
                    </a>
                </span>
                <span aria-label="breadcrumb separator"> / </span>
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="<?php echo get_home_url(); ?>/passport" itemprop="item">
                        <span itemprop="name">Passport</span>
                    </a>
                </span>
                <span aria-label="breadcrumb separator"> / </span><?php echo get_the_title(); ?>
            </div>
        </main>
    </div>
    <div class="content-sidebar-wrap">
        <main class="content" id="genesis-content">
            <div itemtype="http://schema.org/CreativeWork" itemscope="itemscope" class="passport-videos-page">
                <div class="entry-content" itemprop="text">

<?php 
$custom_terms = get_terms('video_cat');

foreach($custom_terms as $custom_term) {
    wp_reset_query();
    $args = array(
        'post_type' => 'training_videos',
        'tax_query' => array(
            array(
                'taxonomy' => 'video_cat',
                'field' => 'slug',
                'terms' => $custom_term->slug,
            ),
        ),
        'orderby' => 'menu_order',
        'order'   => 'ASC',
     );

    
     $loop = new WP_Query($args);
     if($loop->have_posts()) {
        echo '<h2>'.$custom_term->name.'</h2>';
        echo '<div class="row">';
        while($loop->have_posts()) : $loop->the_post();
            echo '<div class="col-md-3">
                    <div class="video-cat-blocks">
                        <a href="'.get_permalink().'"></a>
                        <h3>'.get_the_title().'</h3>
                    </div>
                  </div>';
        endwhile;
        echo '</div>';
     }
}
?>       

                </div>
            </div>
        </main>
    </div>
</div>
<?php }

genesis();