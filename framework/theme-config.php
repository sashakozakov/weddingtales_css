<?php
class WeddingTalesThemeInitConfig {

         public function __construct() {
                $this->init();
       }

         /**
         * Main Init Config Function
         */
        public function init() {

                require_once 'custom-config.php';

                // Init Post Types

                $this->init_post_types( $post_types );

                // Init Taxonomies

                $this->init_taxonomies( $taxonomies );

                // Init Post Formats

                $this->init_post_formats( $post_formats );

                // Init Sidebars

                $this->init_sidebars( $sidebars );

        }

         /**
         * Registers Post Types
         *
         * @param  array $post_types
         */
        private function init_post_types( $post_types ) {

                foreach ( $post_types as $type => $options ) {

                        $this->add_post_type( $type, $options['config'], $options['singular'], $options['multiple'] );

                }

        }

   	/**
         * Register Post Type Wrapper
         *
         * @param string $name
         * @param array $config
         * @param string $singular
         * @param string $multiple
         */
        private function add_post_type( $name, $config, $singular = 'Entry', $multiple = 'Entries' ) {

                if ( !isset($config['labels']) ) {

                        $config['labels'] = array(
                                'name' => ex_pll__($multiple, 'weddingtales'),
                                'singular_name' => ex_pll__($singular, 'weddingtales'),
                                'not_found'=> ex_pll__('No ' . $multiple . ' Found', 'weddingtales'),
                                'not_found_in_trash'=> ex_pll__('No ' . $multiple . ' found in Trash', 'weddingtales'),
                                'edit_item' => ex_pll__('Edit ', $singular, 'weddingtales'),
                                'search_items' => ex_pll__('Search ' . $multiple, 'weddingtales'),
                                'search_items' => ex_pll__('Search ' . $multiple, 'weddingtales'),
                                'view_item' => ex_pll__('View ', $singular, 'weddingtales'),
                                'new_item' => ex_pll__('New ' . $singular, 'weddingtales'),
                                'add_new' => ex_pll__('Add New', 'weddingtales'),
                                'add_new_item' => ex_pll__('Add New ' . $singular, 'weddingtales'),
                        );
			/* register poly lang strings */
                        if ( function_exists('pll__') ) {
                                array_walk( $config['labels'], function($v,$k) use ($name) { pll_register_string($name .'_' .$k,$v); });
                        }


                }

                register_post_type($name, $config);

        }

        /**
         * Registers taxonomies
         *
         * @param  array $taxonomies
         */
        private function init_taxonomies( $taxonomies ) {

                foreach ( $taxonomies as $type => $options ) {

                        $this->add_taxonomy( $type, $options['for'], $options['config'], $options['singular'], $options['multiple'] );

                }

        }

         /* Register taxonomy wrapper
         *
         * @param string $name
         * @param mixed $object_type
         * @param array $config
         * @param string $singular
         * @param string $multiple
         */
        private function add_taxonomy( $name, $object_type, $config, $singular = 'Entry', $multiple = 'Entries' ) {

                if ( !isset($config['labels']) ) {

                        $config['labels'] = array(
                                'name' => ex_pll__($multiple, 'weddingtales'),
                                'singular_name' => ex_pll__($singular, 'weddingtales'),
                                'search_items' =>  ex_pll__('Search ' . $multiple),
                                'all_items' => ex_pll__('All ' . $multiple),
                                'parent_item' => ex_pll__('Parent ' . $singular),
                                'parent_item_colon' => ex_pll__('Parent ' . $singular . ':'),
                                'edit_item' => ex_pll__('Edit ' . $singular),
                                'update_item' => ex_pll__('Update ' . $singular),
                                'add_new_item' => ex_pll__('Add New ' . $singular),
                                'new_item_name' => ex_pll__('New ' . $singular . ' Name'),
                                'menu_name' => ex_pll__($singular),
                        );
			/* register poly lang strings */
                        if ( function_exists('pll__') ) {
                                array_walk( $config['labels'], function($v,$k) use ($name) { pll_register_string($name .'_' .$k,$v); });
                        }

                }


                register_taxonomy($name, $object_type, $config);

        }

        /**
         * Registers Post Formats
         *
         * @param  array $post_formats
         */
        private function init_post_formats( $post_formats ) {

                add_theme_support('post-formats', $post_formats);

        }

                private function init_sidebars( $sidebars ) {

                foreach ( $sidebars as $id => $title ) {

                        register_sidebar(
                                array(
                                        'id' => $id,
                                        'name' => __($title, 'weddingtales'),
                                        'description' => __($title, 'weddingtales'),
                                        'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="widget-inner">',
                                        'after_widget' => '</div></div>',
                                        'before_title' => '<h3>',
                                        'after_title' => '</h3>'
                                )
                        );

                }

        }



}

new WeddingTalesThemeInitConfig();
