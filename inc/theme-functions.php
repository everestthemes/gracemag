<?php
/**
 * Functions which enhance the theme
 *
 * @package Grace_Mag
 */

/**
 * Funtion To Get Google Fonts
 */
if ( !function_exists( 'grace_mag_fonts_url' ) ) :

    /**
     * Return Font's URL.
     *
     * @since 1.0.0
     * @return string Fonts URL.
     */
    function grace_mag_fonts_url() {

        $fonts_url = '';
        $fonts     = array();
        $subsets   = 'latin,latin-ext';

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Roboto font: on or off', 'grace-mag')) {

            $fonts[] = 'Roboto:400,400i,500,500i,700,700i';
        }
        
        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */
        if ('off' !== _x('on', 'Roboto Condensed font: on or off', 'grace-mag')) {

            $fonts[] = 'Roboto+Condensed:400,400i,700,700i';
        }

        /* translators: If there are characters in your language that are not supported by Merriweather, translate this to 'off'. Do not translate into your own language. */

        if ('off' !== _x('on', 'Josefin Sans font: on or off', 'grace-mag')) {

            $fonts[] = 'Josefin+Sans:400,400i,600,600i,700,700i';
        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urlencode( implode( '|', $fonts ) ),
                'subset' => urlencode( $subsets ),
            ), '//fonts.googleapis.com/css' );
        }

        return $fonts_url;
    }
endif;

/**
 * Function to get customizer options
 */
if ( !function_exists( 'grace_mag_mod' ) ) {
    
    function grace_mag_mod( $id, $default ) {

        global $theme_prefix;

        if( empty( $id || $default ) ) {
            return;
        }

        $field_id = $theme_prefix . '_' . $id;

        $theme_mod = '';

        if( !empty( $default ) ) {

            $theme_mod = get_theme_mod( $field_id, $default );
        } else {

            $theme_mod = get_theme_mod( $field_id );
        }

        return $theme_mod;
    }
}

/**
 * Customize Readmore Link.
 */
function post_excerpt_more( $more ) {
  	return '...';
}
add_filter( 'excerpt_more', 'post_excerpt_more' );

/**
* Filter the except length to 40 words default.
*/
if( !function_exists( 'grace_mag_excerpt_length' ) ) {
   /*
    * Excerpt Length
    */
   function grace_mag_excerpt_length( $length ) {
       
       if( is_admin() ) {
           return $length;
       }

       $excerpt_length = grace_mag_mod( 'excerpt_length', 25 );

       if( absint( $excerpt_length ) > 0 ) {
           $excerpt_length = absint( $excerpt_length );
       }
       return $excerpt_length;
   }
}
add_filter( 'excerpt_length', 'grace_mag_excerpt_length' );

/**
 * Fallback For Main Menu
 */
if ( !function_exists( 'grace_mag_navigation_fallback' ) ) {
	/**
     * Return unordered list.
     *
     * @since 1.0.0
     * @return unordered list.
     */
    function grace_mag_navigation_fallback() {
        ?>
        <ul class="primary-menu">
            <?php
            if( current_user_can( 'edit_theme_options' ) ) {
                ?>
                <li><a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>"><?php esc_html_e( 'Add Menu', 'grace-mag' ); ?></a></li>
                <?php
            } else {
                wp_list_pages( array( 'title_li' => '', 'depth' => 3 ) ); 
            }
            ?>
        </ul>
        <?php
    }
}

/**
 * News Ticker Posts Query
 */
if( !function_exists( 'grace_mag_news_ticker_posts_query' ) ) {
    
    function grace_mag_news_ticker_posts_query() {
        
        $news_ticker_category = grace_mag_mod( 'top_header_news_ticker_category', '' );
        
        $news_ticker_posts_no = grace_mag_mod( 'top_header_news_ticker_post_number', 4 );
        
        $news_ticker_args = array(
          'post_type'      => 'post',  
        );
        
        if( !empty( $news_ticker_category ) ) {
            $news_ticker_args['category_name'] = $news_ticker_category;
        }
        
        if( !empty( $news_ticker_posts_no ) ) {
            $news_ticker_args['posts_per_page'] = absint( $news_ticker_posts_no );
        }
        
        $news_ticker_query = new WP_Query( $news_ticker_args );
        
        return $news_ticker_query;
    }         
}

/**
 * Banner Posts Query
 */
if( !function_exists( 'grace_mag_banner_posts_query' ) ) {
    
    function grace_mag_banner_posts_query() {
        
        $banner_category = grace_mag_mod( 'banner_category', '' );
        
        $banner_posts_no = grace_mag_mod( 'banner_post_number', 4 );
        
        $banner_args = array(
          'post_type'      => 'post',  
        );
        
        if( !empty( $banner_category ) ) {
            $banner_args['category_name'] = $banner_category;
        }
        
        if( !empty( $banner_posts_no ) ) {
            $banner_args['posts_per_page'] = absint( $banner_posts_no );
        }
        
        $banner_query = new WP_Query( $banner_args );
        
        return $banner_query;
    }         
}

/*
 * Hook - Plugin Recommendation
 */
if ( ! function_exists( 'grace_mag_recommended_plugins' ) ) :
    /**
     * Recommend plugins.
     *
     * @since 1.0.0
     */
    function grace_mag_recommended_plugins() {

        $plugins = array(
            array(
                'name'     => esc_html__( 'Everest Toolkit', 'grace-mag' ),
                'slug'     => 'everest-toolkit',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Universal Google AdSense And Ads Manager', 'grace-mag' ),
                'slug'     => 'universal-google-adsense-and-ads-manager',
                'required' => false,
            ),
            array(
                'name'     => esc_html__( 'Contact Form 7', 'grace-mag' ),
                'slug'     => 'contact-form-7',
                'required' => false,
            ),
        );

        tgmpa( $plugins );
    }

endif;
add_action( 'tgmpa_register', 'grace_mag_recommended_plugins' );

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function grace_mag_search_form( $form ) {
    $form = '<form role="search" method="get" id="search-form" class="search-form" action="' . home_url( '/' ) . '" >
        <span class="screen-reader-text">' . _x( 'Search for:', 'label', 'grace-mag' ) . '</span>
        <input type="search" class="search-field" placeholder="' . esc_attr_x( 'Type Something', 'placeholder', 'grace-mag' ) . '" value="' . get_search_query() . '" name="s" />
        <input type="submit" id="submit" value="Search">
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'grace_mag_search_form' );