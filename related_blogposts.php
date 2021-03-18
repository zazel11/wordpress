/** To make it work paste this file into your current theme's root folder and paste the following line:

'include('related-blogposts.php');'

to the functions.php **/

<?php

/**
 * Add a custom product data tab
 */

add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab' );
function woo_new_product_tab( $tabs ) {
	
	// Adds the new tab
	
	$tabs['related-blogposts'] = array(
		'title' 	=> __( 'Related blogposts', 'woocommerce' ),
		'priority' 	=> 50,
		'callback' 	=> 'drb_related_blogposts'
	);

	return $tabs;

}

  // Returns the blogposts with the same tags as the product's.

function drb_related_blogposts($content) {
   
   
   $producttags = explode(", ", strip_tags(wc_get_product()->get_tags()));
	
   $the_query = new WP_Query( 'tag='.$post_tag );
   
  
 if ( $the_query->have_posts() ) :
        while ( $the_query->have_posts()) : $the_query->the_post(); 
        $tags = get_the_tags();
        $tags =  str_replace(","," ",(join(', ', array_map(function($t) { return $t->name; }, $tags?$tags : array()))));

	foreach ($producttags as &$producttag) {
		
			if (strpos($tags, $producttag) !== false) 
					{
					echo '<div class="tabs_blog">';
					set_post_thumbnail_size( 150, 150);
					   echo '<div class="tabs_thumbnail">';
					   the_post_thumbnail();
					   echo '</div>';
							echo '<div class="tabs_info">';
								echo '<div class="tabs_title"><a href="'.get_permalink().'">'.get_the_title().'</a></div>';
								  echo '<div class="tabs_date">'.the_date().'</div>'; 
								  echo '<div class="tabs_excerpt">'.the_excerpt().'</div>';
								  echo '<div class="tabs_readmore"><a href="'.get_permalink().'"> Read More </a></div>';
								  echo $tags;
								  echo $producttag;
							echo '</div>';
					   echo '</div>';
					}
			else
					{
					 __('No News');
					} 

	}
   	  endwhile; 
      wp_reset_postdata();
    else : 
  __('No News'); 
 endif; 
}

?>
