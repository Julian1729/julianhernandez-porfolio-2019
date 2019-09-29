<?php

require('compiler.php');
$data = require('page-data.php');

$data['posts'] = array();

if ( have_posts() ) :

  while ( have_posts() ) : the_post();

    array_push($data['posts'], array(
      'permalink' => get_permalink(),
      'title' => get_the_title(),
      'excerpt' => get_the_excerpt()
    ));

  endwhile;

  $data['next_posts_link'] = get_next_posts_link('Older');
  $data['previous_posts_link'] = get_previous_posts_link('Newer');

endif;

get_header();

echo $pug->renderFile('index', $data, $options);

get_footer();
