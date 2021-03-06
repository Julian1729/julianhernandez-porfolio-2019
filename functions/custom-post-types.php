<?php

/**
 * Create Custom Post Types
 */

// PORTFOLIO POST TYPE
function jh_portfolio_register(){

  $labels = array(
		'name' => _x('Portfolio', 'post type general name'),
		'singular_name' => _x('Portfolio Item', 'post type singular name'),
		'add_new' => _x('Add New', 'portfolio item'),
		'add_new_item' => __('Add New Portfolio Item'),
		'edit_item' => __('Edit Portfolio Item'),
		'new_item' => __('New Portfolio Item'),
		'view_item' => __('View Portfolio Item'),
		'search_items' => __('Search Portfolio'),
		'not_found' =>  __('Nothing found'),
		'not_found_in_trash' => __('Nothing found in Trash'),
		'parent_item_colon' => ''
  );

	$args = array(
  	'labels' => $labels,
  	'public' => true,
  	'publicly_queryable' => true,
  	'show_ui' => true,
  	'query_var' => true,
  	'rewrite' => true,
  	'capability_type' => 'post',
  	'hierarchical' => false,
  	'menu_position' => null,
  	'supports' => array('title','editor','thumbnail')
  );

  register_post_type('portfolio', $args);
  flush_rewrite_rules();

}

add_action('init', 'jh_portfolio_register');

// meta fields

function jh_year_completed(){
  global $post;
  $custom = get_post_custom($post->ID);
  $yearCompleted = $custom['year_completed'][0];
  ?>
  <input name='year_completed' value='<?php echo $yearCompleted; ?>' />
  <?php
}

function jh_role(){
  global $post;
  $custom = get_post_custom($post->ID);
  $role = $custom['role'][0];
  ?>
  <p><input name='role' value='<?php echo $role; ?>' /></p>
  <?php
}

function jh_background_color(){
  global $post;
  $custom = get_post_custom($post->ID);
  $bgColor = $custom['background_color'][0];
  ?>
  <input name='background_color' value='<?php echo $bgColor; ?>'/>
  <?php
}

function jh_environment(){
  global $post;
  $custom = get_post_custom($post->ID);
  $env = $custom['environment'][0];
  ?>
  <input name='environment' value='<?php echo $env; ?>'/>
  <?php
}

function jh_project_url(){
  global $post;
  $custom = get_post_custom($post->ID);
  $link = $custom['project_url'][0];
  ?>
  <input name='project_url' value='<?php echo $link; ?>'/>
  <?php
}

function jh_add_meta_boxes(){
  add_meta_box('year_completed_meta', 'Year Completed', 'jh_year_completed', 'portfolio', 'side', 'low');
  add_meta_box('role_meta', 'Role', 'jh_role', 'portfolio', 'normal', 'low');
  add_meta_box('background_color_meta', 'Background Color', 'jh_background_color', 'portfolio', 'side', 'low');
  add_meta_box('environment', 'Environment', 'jh_environment', 'portfolio', 'side', 'low');
  add_meta_box('project_url', 'Project URL', 'jh_project_url', 'portfolio', 'side', 'low');
}

add_action('admin_init', 'jh_add_meta_boxes');

function jh_save_details(){
  global $post;
  update_post_meta($post->ID, 'year_completed', $_POST['year_completed']);
  update_post_meta($post->ID, 'role', $_POST['role']);
  update_post_meta($post->ID, 'background_color', $_POST['background_color']);
  update_post_meta($post->ID, 'environment', $_POST['environment']);
  update_post_meta($post->ID, 'project_url', $_POST['project_url']);
}

add_action('save_post', 'jh_save_details');

// register technology taxonomies
function jh_technologies(){
  // Add new taxonomy, NOT hierarchical (like techonologies)
  $labels = array(
    'name' => _x( 'Technologies Used', 'taxonomy general name' ),
    'singular_name' => _x( 'Technology', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Technologies' ),
    'popular_items' => __( 'Popular Technologies' ),
    'all_items' => __( 'All Technologies' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Technology' ),
    'update_item' => __( 'Update Technology' ),
    'add_new_item' => __( 'Add New Technology' ),
    'new_item_name' => __( 'New Technology Name' ),
    'separate_items_with_commas' => __( 'Separate names with commas' ),
    'add_or_remove_items' => __( 'Add or remove technologies' ),
    'choose_from_most_used' => __( 'Choose from the most used techonologies' ),
    'menu_name' => __( 'Technologies' ),
  );

  register_taxonomy('technologies','portfolio',array(
    'hierarchical' => false,
    'labels' => $labels,
    'show_ui' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'tag' ),
  ));
}

add_action( 'init', 'jh_technologies', 0 );
