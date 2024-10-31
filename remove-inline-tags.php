<?php 
/*
Plugin Name: Remove Inline Tags
Plugin URI: http://wordpress.org/plugins/remote-inline-tags
Description: This simple Plugin removes all inline style tags from the content of posts/pages/custom post types.
Author: phpusain
Version: 1.0
Network: true
*/

class Remove_Inline_Tags {
	function __construct(){
	    add_action('add_meta_boxes', array(&$this, 'show_filtered_content'), 1, 2);
		add_filter('the_content', array(&$this, 'filter_content'));
	}
	
    function clean_content($content){	
		// Search $content for style='' and style="" and remove
		$patterns = array('/(<[^>]+) style=".*?"/i', "/(<[^>]+) style='.*?'/i");
		$content = preg_replace($patterns, '$1', $content);
		
		return apply_filters('Remove_Inline_Tags_strip_styles', $content);
	}
	
	function filter_content($content){
	    $content = $this->clean_content($content);
	    return $content;
	}
	
	function show_filtered_content($post_type, $post){
	    $post->post_content = $this->clean_content($post->post_content);
	}
}
$Remove_Inline_Tags = new Remove_Inline_Tags();
?>