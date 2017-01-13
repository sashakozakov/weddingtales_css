<?php
add_filter('auto_update_plugin', '__return_true');
add_filter('auto_update_theme', '__return_true');
add_filter('auto_update_translation', '__return_false');
add_filter('manage_edit-post-color_columns', 'my_custom_taxonomy_columns');
add_filter('manage_post-color_custom_column', 'my_custom_taxonomy_columns_content', 10, 3);
add_filter('show_admin_bar', '__return_false');
add_filter('image_send_to_editor', 'my_image_func', 10, 7);
add_filter('upload_mimes', 'file_type_allow', 1, 1);
add_action('restrict_manage_posts', 'rudr_posts_taxonomy_filter');
add_action('restrict_manage_posts', 'gecon_vendors_taxonomy_filter');
add_filter('manage_edit-vendor_columns', 'vendor_my_columns');

//add_filter('manage_edit-vendor_sortable_columns', 'vendor_my_sortable_columns');
add_action('manage_posts_custom_column', 'vendor_my_show_columns');

function vendor_my_columns($columns) {
    $columns['PreferredPremiumVendor'] = 'Preferred/Premium';
    return $columns;
}

function vendor_my_sortable_columns($columns) { // not in use
    $columns['PreferredPremiumVendor'] = 'Preferred/Premium';
    return $columns;
}

// add_action( 'pre_get_posts', 'my_preferredVendor_orderby' );
/* function my_preferredVendor_orderby( $query ) {
	if( ! is_admin() )
	return;
	
	$orderby = $query->get( 'orderby');
	if( 'preferredVendor' == $orderby ) {
		if( isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'vendor' ) {
			$query->set('meta_key','preferred_vendor');
			$query->set('orderby','meta_value');
		}
	}
}

*/

function vendor_my_show_columns($name) {
    global $post;
    switch ($name) {
            case 'PreferredPremiumVendor':
            $new_preferred_vendor_state = get_post_meta($post->ID, 'preferred_vendor_new', true);
            $new_premium_vendor_state = get_post_meta($post->ID, 'premium_vendor_new', true);
            echo ($new_preferred_vendor_state ? 'Yes' : 'No');
            echo "/";
            echo ($new_premium_vendor_state ? 'Yes' : 'No');
    }
}

function file_type_allow($mime_type_to_allow) {
    $mime_type_to_allow['svg'] = 'image/svg+xml'; //Adding svg extension
    return $mime_type_to_allow;
}

function my_image_func($html, $id, $alt, $title, $align, $url, $size) {
    $url = wp_get_attachment_url($id); // Grab the current image URL
    $field = get_field('photo_credits', $id, false);
    $html = '<figure id="attachment_' . $id . '" class="wp-caption ' . $align . '"><img src=' . $url . ' alt="' . $alt . '"/><figcaption class="wp-caption-text">' . $field . '</figcaption></figure>';
    return $html;
}

function my_custom_taxonomy_columns($columns) {
    $columns['my_term_id'] = __('Colors');
    return $columns;
}

function my_custom_taxonomy_columns_content($content, $column_name, $term_id) {
    if ('my_term_id' == $column_name) {
        $variable = get_field('color', 'post-color_' . $term_id);
        $content = '<div style="background-color:' . $variable . ';width:15px;height:15px;"></div>';
    }

    return $content;
}

function gecon_vendors_taxonomy_filter() {
    global $typenow; // this variable stores the current custom post type
    if ($typenow == 'vendor') { // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
        // $taxonomy_names = array('profession', 'is_preferred_vendor','is_premium_vendor');
        $taxonomy_names = array(
            'vendor-profession'
        );
        foreach ($taxonomy_names as $single_taxonomy) {
            $current_taxonomy = isset($_GET[$single_taxonomy]) ? $_GET[$single_taxonomy] : '';
            $taxonomy_object = get_taxonomy($single_taxonomy);
            $taxonomy_name = strtolower($taxonomy_object
                ->labels
                ->name);
            $taxonomy_terms = get_terms($single_taxonomy);
            if (count($taxonomy_terms) > 0) {
                echo "<select name='$single_taxonomy' id='$single_taxonomy' class='postform'>";
                echo "<option value=''>All $taxonomy_name</option>";
                foreach ($taxonomy_terms as $single_term) {
                    echo '<option value=' . $single_term->slug, $current_taxonomy == $single_term->slug ? ' selected="selected"' : '', '>' . $single_term->name . ' (' . $single_term->count . ')</option>';
                }

                echo "</select>";
            }
        }
    }
}

function rudr_posts_taxonomy_filter() {
    global $typenow; // this variable stores the current custom post type
    if ($typenow == 'post') { // choose one or more post types to apply taxonomy filter for them if( in_array( $typenow  array('post','games') )
        $taxonomy_names = array(
            'post-settings',
            'post-color'
        );
        foreach ($taxonomy_names as $single_taxonomy) {
            $current_taxonomy = isset($_GET[$single_taxonomy]) ? $_GET[$single_taxonomy] : '';
            $taxonomy_object = get_taxonomy($single_taxonomy);
            $taxonomy_name = strtolower($taxonomy_object
                ->labels
                ->name);
            $taxonomy_terms = get_terms($single_taxonomy);
            if (count($taxonomy_terms) > 0) {
                echo "<select name='$single_taxonomy' id='$single_taxonomy' class='postform'>";
                echo "<option value=''>All $taxonomy_name</option>";
                foreach ($taxonomy_terms as $single_term) {
                    echo '<option value=' . $single_term->slug, $current_taxonomy == $single_term->slug ? ' selected="selected"' : '', '>' . $single_term->name . ' (' . $single_term->count . ')</option>';
                }

                echo "</select>";
            }
        }
    }
}

// 1) Widget Custom categories
// Creating the widget
class widget_custom_categories extends WP_Widget
 {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'widget_custom_categories',

        // Widget name will appear in UI
        __('Custom Article Categories Widget', 'weddingtales') ,

        // Widget description
        array(
            'description' => __('Custom Article Categories Widget', 'weddingtales') ,
        ));
    }

    // Creating widget front-end
    // This is where the action happens
    public

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        $terms = get_terms('article-category');
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                $term_link = get_term_link($term->term_id, 'article-category');
                echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }

    // Widget Backend
    public

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('New title', 'weddingtales');
        }

        // Widget admin form
        
?>



    <p>



      <label for="<?php
        echo $this->get_field_id('title'); ?>"><?php
        _e('Title:'); ?></label>



      <input class="widefat" id="<?php
        echo $this->get_field_id('title'); ?>" name="<?php
        echo $this->get_field_name('title'); ?>" type="text" value="<?php
        echo esc_attr($title); ?>" />



    </p>



    <?php
    }

    // Updating widget replacing old instances with new
    public

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class wpb_widget ends here
// Creating the widget
class widget_custom_post_categories extends WP_Widget
 {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'widget_custom_post_categories',

        // Widget name will appear in UI
        __('Custom Post Categories Widget', 'weddingtales') ,

        // Widget description
        array(
            'description' => __('Custom Post Categories Widget', 'weddingtales') ,
        ));
    }

    // Creating widget front-end
    // This is where the action happens
    public

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        $terms = get_terms('category');
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                $term_link = get_term_link($term->term_id, 'category');
                $parent = $term->parent;
                if ($parent == '0') {
                    echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
                }
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }

    // Widget Backend
    public

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('New title', 'weddingtales');
        }

        // Widget admin form
        
?>



    <p>



      <label for="<?php
        echo $this->get_field_id('title'); ?>"><?php
        _e('Title:'); ?></label>



      <input class="widefat" id="<?php
        echo $this->get_field_id('title'); ?>" name="<?php
        echo $this->get_field_name('title'); ?>" type="text" value="<?php
        echo esc_attr($title); ?>" />



    </p>



    <?php
    }

    // Updating widget replacing old instances with new
    public

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class wpb_widget ends here
// 2) Widget Recent Articles
// Creating the widget
class widget_recent_articles extends WP_Widget
 {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'widget_recent_articles',

        // Widget name will appear in UI
        __('Recent Articles Widget', 'weddingtales') ,

        // Widget description
        array(
            'description' => __('Recent Articles Widget', 'weddingtales') ,
        ));
    }

    // Creating widget front-end
    // This is where the action happens
    public

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        $queryObject = new WP_Query('post_type=article&posts_per_page=5');
        if ($queryObject->have_posts()) {
            echo '<ul>';
            while ($queryObject->have_posts()) {
                $queryObject->the_post(); ?>



        <li>



          <a href="<?php
                the_permalink(); ?>"><?php
                the_title(); ?></a>



          <p><?php
                the_field('subtitle') ?></p>



        </li>



        <?php
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }

    // Widget Backend
    public

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('New title', 'weddingtales');
        }

        // Widget admin form
        
?>



      <p>



        <label for="<?php
        echo $this->get_field_id('title'); ?>"><?php
        _e('Title:'); ?></label>



        <input class="widefat" id="<?php
        echo $this->get_field_id('title'); ?>" name="<?php
        echo $this->get_field_name('title'); ?>" type="text" value="<?php
        echo esc_attr($title); ?>" />



      </p>



      <?php
    }

    // Updating widget replacing old instances with new
    public

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class wpb_widget ends here
// 3) Widget Gallery categories
// Creating the widget
class widget_gallery_categories extends WP_Widget
 {
    function __construct() {
        parent::__construct(

        // Base ID of your widget
        'widget_custom_post_categories',

        // Widget name will appear in UI
        __('Gallery Categories Widget', 'weddingtales') ,

        // Widget description
        array(
            'description' => __('Gallery Categories Widget', 'weddingtales') ,
        ));
    }

    // Creating widget front-end
    // This is where the action happens
    public

    function widget($args, $instance) {
        $title = apply_filters('widget_title', $instance['title']);

        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if (!empty($title)) echo $args['before_title'] . $title . $args['after_title'];

        // This is where you run the code and display the output
        $terms = get_terms(array(
            'taxonomy' => 'category',
            'hide_empty' => 1,
            'parent' => '7',
        ));
        if (!empty($terms) && !is_wp_error($terms)) {
            echo '<ul>';
            foreach ($terms as $term) {
                $term_link = get_term_link($term->term_id, 'category');
                echo '<li><a href="' . $term_link . '">' . $term->name . '</a></li>';
            }

            echo '</ul>';
        }

        echo $args['after_widget'];
    }

    // Widget Backend
    public

    function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        }
        else {
            $title = __('New title', 'weddingtales');
        }

        // Widget admin form
        
?>



    <p>



      <label for="<?php
        echo $this->get_field_id('title'); ?>"><?php
        _e('Title:'); ?></label>



      <input class="widefat" id="<?php
        echo $this->get_field_id('title'); ?>" name="<?php
        echo $this->get_field_name('title'); ?>" type="text" value="<?php
        echo esc_attr($title); ?>" />



    </p>



    <?php
    }

    // Updating widget replacing old instances with new
    public

    function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        return $instance;
    }
} // Class wpb_widget ends here
// Register and load all the widgets
function my_load_widget() {
    register_widget('widget_custom_categories');
    register_widget('widget_custom_post_categories');
    register_widget('widget_recent_articles');
    register_widget('widget_gallery_categories');
}

add_action('widgets_init', 'my_load_widget');
/*

* Breadcrumb NavXT

*

* Rename and translate 'Home'

*/
pll_register_string('breadcrumb_title', 'Home', 'weddingtales');
add_filter('bcn_breadcrumb_title', function ($title, $type, $id) {
    if ($type[0] === 'home') {
        $title = pll__('Home');
    }

    return $title;
}

, 42, 3);
/**
 * Get image placeholder
 *
 * usage: get_thumb_placeholder()
 */

function get_thumb_placeholder() {
    $image_url = get_template_directory_uri() . "/images/placeholder-thumb.png";
    return $image_url;
}

/**
 * Get taxonomies terms for current post.
 *
 * usage: echo wt_get_post_terms('taxonomy_slug');
 */

function wt_get_post_terms($taxonomy_slug) {
    $terms = get_terms($taxonomy_slug);
    foreach ($terms as $term) {
        $out[] = '<a href="' . esc_url(get_term_link($term)) . '">' . $term->name . '</a> ';
    }

    return implode('', $out);
}

// this works for 'post-color' taxonomy
function wt_get_post_terms_color() {
    $terms = get_terms('post-color');
    foreach ($terms as $term) {
        $color = get_field('color', $term);
        $out[] = '<a href="' . esc_url(get_term_link($term)) . '"><span class="meta_color" style="background-color:' . $color . '"></span></a> ';
    }

    return implode('', $out);
}

// returns 1 if profession has preferred vendors in it
 // otherwise return 0
 function profession_has_preferred_vendors($prof_term) {
		$my_args = array(
			'post_type'  => 'vendor',
			'tax_query' => array(
				array(
					'taxonomy' => 'vendor-profession',
					'field'    => 'term_id',
					'terms'    => $prof_term->term_id,
				),
			),
			'meta_query' => array(
				array(
					'key'     => 'preferred_vendor_new',
					'value'   => 1,
				),
			 ),
		);
		//print_r($my_args);
		$preferred_vendors_for_profession = new WP_Query( $my_args );
		if ( $preferred_vendors_for_profession->have_posts() ) {
			//print_r($preferred_vendors_for_profession);
				return 1;
		}
		
		return 0;
	}
	
		
		
function wt_get_post_vendor_profession() {
    $terms = get_terms('vendor-profession');
    $i = 1; ?>

  <section class="vendor__categories clearfix">



    <div class="row vendor__categories__list">

      <?php
    foreach ($terms as $term) {
    		/// ********************* gecon ********************* ///
    		if ( !profession_has_preferred_vendors($term) ) { 
					continue;//here we will show profession only if profession has preferred vendors
				}
				/// ********************* gecon ********************* ///
    	
        if ($image = get_field('vendor_category_image', $term)) {
            $image_url = $image;
        }
        else {
            $image_url = get_thumb_placeholder();
        }

?>

        <div class="large-3 medium-3 small-6 columns vendor-item text-center">

          <div class="vendor__categories__item">

            <a href="<?php
        echo esc_url(get_term_link($term)); ?>" class="vendor__categories__item--image" style="background-image:url(<?php
        echo $image_url; ?>)" >

            </a>

            <a class="vendor__categories__item--title matchHeight" href="<?php
        echo esc_url(get_term_link($term)); ?>">

              <div>

                <?php
        echo $term->name; ?>

              </div>

            </a>



            <?php
        $innerPostArgs = array(
            'post_type' => 'vendor',
            'hide_empty' => 1,
            'tax_query' => array(
                array(
                    'taxonomy' => $term->taxonomy,
                    'field' => 'slug',
                    'terms' => $term->slug,
                ) ,
            ) ,
        );
        $innerPost = new WP_Query($innerPostArgs); ?>



              <?php
        if ($innerPost->have_posts()): ?>

                <?php
            while ($innerPost->have_posts()):
                $innerPost->the_post() ?>



                  <?php
                if ($preferred_vendor = get_field('preferred_vendor')): ?>



                    <div class="child_blocks preferred_vendor">

                    <?php
                else: ?>

                      <div class="child_blocks no_preferred_vendor">

                      <?php
                endif; ?>

                    </div>



                 <?php
            endwhile; ?>

                <?php
        endif; ?>





              </div> <!-- end vendor__categories__item -->











              <?php
        // if ($i % 4 == 0) {
        //   // echo '</div></div>';
        //   // echo '<div class="row vendor__categories__list">';
        //   echo '</div>';
        // } else{
        // }
        //   echo '</div>';
        // $i++;
        
?>







            </div>



            <?php
    } ?>



          </div>







        </section>



        <?php
}

/**
 * Get list of taxonomy terms.
 *
 * usage: echo wt_get_taxonomy_terms('taxonomy_slug');
 */

function wt_get_taxonomy_terms($taxonomy_slug) {
    $terms = get_terms($taxonomy_slug);
    if (!empty($terms) && !is_wp_error($terms)) {
        $term_list = '<ul>';
        foreach ($terms as $term) {
            $term_list .= '<li><a href="' . esc_url(get_term_link($term)) . '">' . $term->name . '</a></li>';
        }

        $term_list .= '</ul>';
    }

    return $term_list;
}

// this works for 'post-color' taxonomy
function wt_get_taxonomy_terms_color() {
    $terms = get_terms('post-color');
    if (!empty($terms) && !is_wp_error($terms)) {
        $term_list = '<ul>';
        foreach ($terms as $term) {
            $color = get_field('color', $term);
            $term_list .= '<li><a href="' . esc_url(get_term_link($term)) . '"><span class="meta_color" style="background-color:' . $color . '"></span></a></li>';
        }

        $term_list .= '</ul>';
    }

    return $term_list;
}

/*

* Tests if any of a post's assigned categories are descendants of target category

*

* example: if ( post_is_in_descendant_category( 7 ) ) { // do something }

*/

if (!function_exists('post_is_in_descendant_category')) {
    function post_is_in_descendant_category($cats, $_post = null) {
        foreach ((array)$cats as $cat) {

            // get_term_children() accepts integer ID only
            $descendants = get_term_children((int)$cat, 'category');
            if ($descendants && in_category($descendants, $_post)) return true;
        }

        return false;
    }
}

