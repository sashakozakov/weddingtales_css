<?php

/*
  AJ Shortcodes
*/

  define ( 'JS_PATH1' , get_template_directory_uri().'/framework/shortcodes/submenu-button.js');


  add_action('admin_head', 'aj_add_my_tc_button');

  function aj_add_my_tc_button() {
    global $typenow;

    // check user permissions
    if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
      return;
    }

    // verify the post type
    //if( ! in_array( $typenow, array( 'post', 'page' ) ) )
    //  return;

    // check if WYSIWYG is enabled
    if ( get_user_option('rich_editing') == 'true') {
      add_filter("mce_external_plugins", "aj_add_tinymce_plugin");

      add_filter('mce_buttons', 'aj_register_my_tc_button');
    }

  }


// Declare script for new button

  function aj_add_tinymce_plugin($plugin_array) {
    $plugin_array['aj_tc_button'] = JS_PATH1;
    return $plugin_array;
  }

  function aj_tc_css() {
    wp_enqueue_style('aj-tc', get_template_directory_uri().'/framework/shortcodes/css/shortcodes.css' );

  }

  add_action('admin_enqueue_scripts', 'aj_tc_css');


// Register new button in the editor

  function aj_register_my_tc_button($buttons) {
   array_push($buttons, "aj_tc_button");
   return $buttons;
 }


## Text with Icon -------------------------------------------------- #

 function shortcode_text_with_icon( $atts ) {

  $value = shortcode_atts( array(
    'icon' => '',
    'color' => '',
    'text' => '',
    'block-title' => '',
    'block-text' => '',
    'image-url' => '',
    'image-position' => ''
    ), $atts );

  $block = (!empty($value['block-title']) && !empty($value['block-text'])) ? '<cite><span>'.$value['block-title'].'</span>'. $value['block-text'] .'</cite>' : '';

  if (!empty($value['image-url'])) {
    $image = '<div class="image" style="background-image:url('.$value['image-url'].')"></div>';

    $output ='<div class="text-with-image image-'.$value['image-position'].'">'.$image.'<blockquote class="text-with-icon color-'.$value['color']. ' icon-' .$value['icon'].'"><span>' .$value['text']. '</span>' .$block. '</blockquote></div>';

  } else{

    $output ='<blockquote class="text-with-icon no-image color-'.$value['color']. ' icon-' .$value['icon'].'"><span>' .$value['text']. '</span>' .$block. '</blockquote>';
  }


  return $output;
}

add_shortcode('text-with-icon', 'shortcode_text_with_icon');
