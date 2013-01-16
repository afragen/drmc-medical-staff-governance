<?php

//http://www.unfocus.com/2010/08/10/including-page-templates-from-a-wordpress-plugin/
class DRMCmsgTemplate {

	public function __contruct() {
		add_filter( 'taxonomy_template', array($this, 'get_custom_taxonomy_template' ));
		add_filter( 'single_template', array($this, 'get_custom_single_template' ));

	}

	public function locate_plugin_template($template_names, $load = false, $require_once = true ) {
	    if ( !is_array($template_names) )
	        return '';
    
	    $located = '';
    
	    $this_plugin_dir = WP_PLUGIN_DIR.'/'.str_replace( basename( __FILE__), "", plugin_basename(__FILE__) );
    
	    foreach ( $template_names as $template_name ) {
	        if ( !$template_name )
	            continue;
	        if ( file_exists(STYLESHEETPATH . '/' . $template_name)) {
	            $located = STYLESHEETPATH . '/' . $template_name;
	            break;
	        } else if ( file_exists(TEMPLATEPATH . '/' . $template_name) ) {
 	           $located = TEMPLATEPATH . '/' . $template_name;
	            break;
	        } else if ( file_exists( $this_plugin_dir .  $template_name) ) {
  	          $located =  $this_plugin_dir . $template_name;
  	          break;
 	       }
 	   }
    
	    if ( $load && '' != $located )
	        load_template( $located, $require_once );
    
	    return $located;
	}


	public function get_custom_taxonomy_template($template) {
	    // Twenty Ten adds a 'pretty' link at the end of the excerpt. We don't need it for the taxonomy.
        remove_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );
	    remove_filter( 'get_the_excerpt', 'twentyten_auto_excerpt_more' );
    
	    $taxonomy = get_query_var('taxonomy');
    
	    if ( 'custom_taxonomy_name' == $taxonomy ) {
	        $term = get_query_var('term');
    
	        $templates = array();
			if ( $taxonomy && $term )
                $templates[] = "taxonomy-$taxonomy-$term.php";
			if ( $taxonomy )
                $templates[] = "taxonomy-$taxonomy.php";
    
	        $templates[] = "taxonomy.php";
			$template = locate_plugin_template($templates);
		}
	    // return apply_filters('taxonomy_template', $template);
	    return $template;
	}

	public function get_custom_single_template($template) {
		global $wp_query;
	    $object = $wp_query->get_queried_object();
    
	    if ( 'custom_post_type_name' == $object->post_type ) {
	        $templates = array('single-' . $object->post_type . '.php', 'single.php');
	        $template = locate_plugin_template($templates);
		}
	    // return apply_filters('single_template', $template);
	    return $template;
	}
}