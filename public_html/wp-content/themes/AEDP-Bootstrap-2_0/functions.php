<?php

/* Functions AEDP Bootstrap 2.0 */

add_theme_support( 'post-thumbnails' ); 

if ( function_exists('register_sidebar') )
register_sidebar(array(
'name'=>'Sidebar-1',
'id' => 'sidebar-1',
'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
'after_widget' => '</div>',
'before_title' => '<h3>',
'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Directory Sidebar',
		'id' => 'directory-sidebar',
		'description' => 'Appears as the sidebar on the directory page',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Blog Sidebar',
		'id' => 'blog-sidebar',
		'description' => 'Appears as the sidebar on the blog page',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Transformance Sidebar',
		'id' => 'transformance-sidebar',
		'description' => 'Appears as the sidebar on the transformance page',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Events Sidebar',
		'id' => 'events-sidebar',
		'description' => 'Appears as the sidebar on the events page',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Single Event Page Sidebar',
		'id' => 'single-event-sidebar',
		'description' => 'Appears as the sidebar on a single event page',
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
register_sidebar(array(
		'name' => 'Footer',
		'id' => 'footer-widget-area',
		'description' => 'Footer Widget Area',
		'before_widget' => '<div id="%1$s" class="widget-container col-sm-3 footer-nav %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
));
function custom_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');

register_nav_menu( 'HeaderNav', 'HeaderNav' );

// Bootstrap pagination function
 
function wp_bs_pagination($pages = '', $range = 4)
 
{  
     $showitems = ($range * 2) + 1;  
     global $paged;
 
     if(empty($paged)) $paged = 1; 
 
     if($pages == '')
 
     {
         global $wp_query; 
		 $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
     if(1 != $pages)
     {
        echo '<div class="text-center">'; 
        echo '<nav><ul class="pagination"><li class="disabled hidden-xs"><span><span aria-hidden="true">Page '.$paged.' of '.$pages.'</span></span></li>';
        if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link(1)."' aria-label='First'>&laquo;<span class='hidden-xs'> First</span></a>
		</li>";
         if($paged > 1 && $showitems < $pages) echo "<li><a href='".get_pagenum_link($paged - 1)."' aria-label='Previous'>&lsaquo;<span class='hidden-xs'> Previous</span></a></li>";
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<li class=\"active\"><span>".$i." <span class=\"sr-only\">(current)</span></span>
    </li>":"<li><a href='".get_pagenum_link($i)."'>".$i."</a></li>";
             }
         }
         if ($paged < $pages && $showitems < $pages) echo "<li><a href=\"".get_pagenum_link($paged + 1)."\"  aria-label='Next'><span class='hidden-xs'>Next </span>&rsaquo;</a></li>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li><a href='".get_pagenum_link($pages)."' aria-label='Last'><span class='hidden-xs'>Last </span>&raquo;</a></li>";
         echo "</ul></nav>";
         echo "</div>";
     }
 
}

/* Membership Plugin - BCC Admin on Membership Expire
Bcc admin on PMPro member only emails
You can change the conditional to check for a certain $email->template or some other condition before adding the BCC.
*/
function my_pmpro_email_headers($headers, $email)
{		
	//bcc emails not already going to admin_email
        if($email->membership_expired.html != "help.aedpinstitute@gmail.com")
	{
		//add bcc
		$headers[] = "Bcc:" . "help.aedpinstitute@gmail.com";		
	}
 
	return $headers;
}
add_filter("pmpro_email_headers", "my_pmpro_email_headers", 10, 2);

/*Remove the "Your Profile" section of the TML user profile page */

remove_filter( 'show_user_profile', 'pmpromd_show_extra_profile_fields' , 10 );

/* Change the text "Mailchimp Opt-In Lists" on the profile page to something more of our liking */

function change_strings( $translated_text, $text, $domain ) {
	switch ( $translated_text ) {
		case 'Opt-in MailChimp Lists' :
			$translated_text = __( 'Newsletter Lists', '' );
			break;
	}
	return $translated_text;
}
add_filter( 'gettext', 'change_strings', 20, 3 );

/* CUSTOMIZED BUSINESS DIRECTORY QUICKSEARCH BAR */

function wpbdp_custom_search_form() {
    $html = '';
    $html .= sprintf('<form id="wpbdmsearchform" action="" method="GET" class="wpbdp-search-form">
                      <input type="hidden" name="action" value="search" />
                      <input type="hidden" name="page_id" value="%d" />
                      <input type="hidden" name="dosrch" value="1" />',
                      wpbdp_get_page_id('main'));
    $html .= '<input id="intextbox" maxlength="150" name="q" size="20" type="text" value="" />';
    $html .= sprintf('<input id="wpbdmsearchsubmit" class="submit wpbdp-button wpbdp-submit" type="submit" value="%s" />',
                     _x('Search Listings', 'templates', 'WPBDM'));
/*  $html .= sprintf('<a href="%s" class="advanced-search-link">%s</a>',
                     esc_url( add_query_arg('action', 'search', wpbdp_get_page_link('main')) ),
                     _x('Advanced Search', 'templates', 'WPBDM')); */
    $html .= '</form>';

    return $html;
}

/**
 * Enqueue scripts and styles.
 */
function aedp_bs_scripts() {

  /* Latest compiled and minified CSS */
  wp_enqueue_style( 'AEDP-Bootstrap-2_0-bootstrap', get_template_directory_uri() . '/inc/css/bootstrap.min.css' );

  wp_enqueue_style( 'aedp-icons', get_template_directory_uri().'/inc/css/font-awesome.min.css' );

  wp_enqueue_style( 'AEDP-Bootstrap-2_0-style', get_stylesheet_uri() );

  wp_enqueue_script('AEDP-Bootstrap_2_0-bootstrapjs', get_template_directory_uri().'/inc/js/bootstrap.min.js', array('jquery') );

  wp_enqueue_script( 'aedp-main', get_template_directory_uri() . '/inc/js/main.js', array('jquery'), '1.5.4', true );

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'aedp_bs_scripts' );

/*REMOVE THE WORD "PROTECTED" FROM PW PAGES IN WORDPRESS */
add_filter('protected_title_format', 'blank');
function blank($title) {
       return '%s';
}

/* TELL PMPRO HOW MANY TRIES TO ATTEMPT CHARGING A CARD AT THE PAYMENT GATEWAY BEFORE CANCELLING THE MEMBER */
define('PMPRO_FAILED_PAYMENT_LIMIT', 3);

?>