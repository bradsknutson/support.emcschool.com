<?php

//* Template Name: Training Videos

add_filter( 'genesis_pre_get_option_site_layout', '__genesis_return_sidebar_content' );

//* Remove the entry meta in the entry header
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );

//* Remove the author box on single posts
remove_action( 'genesis_after_entry', 'genesis_do_author_box_single', 8 );

//* Remove the entry meta in the entry footer
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_open', 5 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_entry_footer', 'genesis_entry_footer_markup_close', 15 );

//* Remove the comments template
remove_action( 'genesis_after_entry', 'genesis_get_comments_template' );

//* Onboarding Chat

add_action( 'genesis_after_footer', 'do_onboarding_chat_code' );
function do_onboarding_chat_code() {
    echo '<div class="onboarding-chat fa fa-user">';
    the_field('onboarding_chat_code', 104 );
    echo '</div>';
}

remove_action( 'genesis_sidebar', 'genesis_do_sidebar' );
add_action( 'genesis_after_sidebar_widget_area', 'do_video_page_sidebar' );
function do_video_page_sidebar() {
	echo genesis_html5() ? '<section class="widget widget_text">' : '<div class="widget widget_text">';
	echo '<div class="widget-wrap">';

		echo '<div class="video-sidebar-nav">';


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
                    echo '<p>'. $custom_term->name .'</p>';
                    echo '<ul>';
                    while( $loop->have_posts()) : $loop->the_post();
                        echo '<li><a href="'. get_permalink() .'">'. get_the_title() .'</a></li>';
                    endwhile;
                    echo '</ul>';
                 }
            }


		echo '</div>';

	echo '</div>';
	echo genesis_html5() ? '</section>' : '</div>';
}


add_action( 'genesis_before_content_sidebar_wrap', 'do_video_page_breadcrumbs' );
function do_video_page_breadcrumbs() {

    echo '<div class="content-sidebar-wrap">
        <main id="genesis-content">
            <div class="breadcrumb" itemprop="breadcrumb" itemscope="" itemtype="http://schema.org/BreadcrumbList">You are here: 
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="'. get_home_url() .'" itemprop="item">
                        <span itemprop="name">Home</span>
                    </a>
                </span>
                <span aria-label="breadcrumb separator"> / </span>
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="'. get_home_url() .'/passport" itemprop="item">
                        <span itemprop="name">Passport</span>
                    </a>
                </span>
                <span aria-label="breadcrumb separator"> / </span>
                <span class="breadcrumb-link-wrap" itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a href="'. get_home_url() .'/training-videos" itemprop="item">
                        <span itemprop="name">Passport Training Videos</span>
                    </a>
                </span>
                <span aria-label="breadcrumb separator"> / </span>'. get_the_title() .'
            </div>
        </main>
    </div>';
    
}

//* Run the Genesis loop
genesis();