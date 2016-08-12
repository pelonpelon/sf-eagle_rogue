<?php
//add_action('admin_head', 'gavickpro_add_my_tc_button');

//function gavickpro_add_my_tc_button() {
    //global $typenow;
    //// check user permissions
    //if ( !current_user_can('edit_posts') && !current_user_can('edit_pages') ) {
     //return;
    //}
    //// verify the post type
    //if( ! in_array( $typenow, array( 'post', 'page' ) ) )
        //return;
	//// check if WYSIWYG is enabled
	//if ( get_user_option('rich_editing') == 'true') {
		//add_filter("mce_external_plugins", "gavickpro_add_tinymce_plugin");
		//add_filter('mce_buttons', 'gavickpro_register_my_tc_button');
	//}
//}


//function gavickpro_add_tinymce_plugin($plugin_array) {
  //$plugin_array['gavickpro_tc_button'] = plugins_url( '/text-button.js', __FILE__ ); // CHANGE THE BUTTON SCRIPT HERE
//return $plugin_array;
//}
//function gavickpro_register_my_tc_button($buttons) {
   //array_push($buttons, "gavickpro_tc_button");
   //return $buttons;
//}

//function my_mce_buttons_2( $buttons ) {
	/**
	 * Add in a core button that's disabled by default
	 */
	////$buttons[] = 'styleSelect';
	//$buttons[] = 'subscript';

	//return $buttons;
//}
//add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

//
//
// DEFAULT EDITOR MARKUP
//
//

// Default post editor text //
function diww_default_post_content( $content ) {
    $where = get_current_screen();
    if ( $where->action != 'add' ) { return; }
    $ID = get_the_ID();
    $post_type = $where->post_type;
    if ( $post_type == 'post' ) {
        //$template = get_page_by_title('_post_editor_default');
        //$content = $template->post_content;
        //$content = '[title align="left"]
            //[when]
            //<p>[who]</p>
            //[more]';
        $content = '[template title="_post_editor_default"]';
    }
    if ( $post_type == 'staff' ) {
        //$template = get_page_by_title('_staff_editor_default');
        //$content = $template->post_content;
        //$content = '[meta id=\'nickname\']
            //<ul class="social_media">
            //<li><a href="[meta id=\'facebook_url\']" target="_blank">Facebook</a></li>
            //<li><a href="[meta id=\'twitter_url\']" target="_blank">Twitter</a></li>
            //</ul>';
        $content = '[template title="_staff_editor_default"]';
    }
    return $content;
    //}
}
add_filter( 'default_content', 'diww_default_post_content' );

//
//
// EDITOR BUTTONS
//
//

function appthemes_add_quicktags() {
  $where = get_current_screen();
  $ID = get_the_ID();
  $post_type = $where->post_type;
  if ( $post_type == 'post' || $post_type == 'page' || $post_type == 'staff' ) {
    if (wp_script_is('quicktags')){

      $misc_tmpl = get_page_by_title('_misc');
      $misc_content = $misc_tmpl->post_content;
      $misc_content_dirty = do_shortcode($misc_content);
      $misc_content = str_replace(array("\r\n", "\n", "\r"), " ", $misc_content_dirty);
      $misc_content_dirty = str_replace("'", "\"", $misc_content);
      $misc_content = str_replace('> ', '>\n', $misc_content_dirty);

      $details_tmpl = get_page_by_title('_details');
      $details_content = $details_tmpl->post_content;
      $details_content_dirty = do_shortcode($details_content);
      $details_content = str_replace(array("\r\n", "\n", "\r"), " ", $details_content_dirty);
      $details_content_dirty = str_replace("'", "\"", $details_content);
      $details_content = str_replace('> ', '>\n', $details_content_dirty);

      $complete_tmpl = get_page_by_title('_complete');
      $complete_content = $complete_tmpl->post_content;
      $complete_content_dirty = do_shortcode($complete_content);
      $complete_content = str_replace(array("\r\n", "\n", "\r"), " ", $complete_content_dirty);
      $complete_content_dirty = str_replace("'", "\"", $complete_content);
      $complete_content = str_replace('> ', '>\n', $complete_content_dirty);

      $staffp_tmpl = get_page_by_title('_staffp');
      $staffp_content = $staffp_tmpl->post_content;
      $staffp_content = str_replace(array("\r\n", "\n", "\r"), " ", $staffp_content);
      $staffp_content_dirty = str_replace("'", "\"", $staffp_content);
      $staffp_content = str_replace('> ', '>\n', $staffp_content_dirty);

      $staffc_tmpl = get_page_by_title('_staffc');
      $staffc_content = $staffc_tmpl->post_content;
      $staffc_content = str_replace(array("\r\n", "\n", "\r"), " ", $staffc_content);
      $staffc_content_dirty = str_replace("'", "\"", $staffc_content);
      $staffc_content = str_replace('> ', '>\n', $staffc_content_dirty);

      $pcd_tmpl = get_page_by_title('_postcard_default');
      $pcd_content = $pcd_tmpl->post_content;
      $pcd_content = str_replace(array("\r\n", "\n", "\r"), " ", $pcd_content);
      $pcd_content_dirty = str_replace("'", "\"", $pcd_content);
      $pcd_content = str_replace('> ', '>\n', $pcd_content_dirty);
      $pcd_content = str_replace('] ', ']\n', $pcd_content);

      $pcbd_tmpl = get_page_by_title('_postcard_bands_default');
      $pcbd_content = $pcbd_tmpl->post_content;
      $pcbd_content = str_replace(array("\r\n", "\n", "\r"), " ", $pcbd_content);
      $pcbd_content_dirty = str_replace("'", "\"", $pcbd_content);
      $pcbd_content = str_replace('> ', '>\n', $pcbd_content_dirty);
      $pcbd_content = str_replace('] ', ']\n', $pcbd_content);

      $ped_tmpl = get_page_by_title('_post_editor_default');
      $ped_content = $ped_tmpl->post_content;
      $ped_content = str_replace(array("\r\n", "\n", "\r"), " ", $ped_content);
      $ped_content_dirty = str_replace("'", "\"", $ped_content);
      $ped_content = str_replace('> ', '>\n', $ped_content_dirty);
      $ped_content = str_replace('] ', ']\n', $ped_content);

      $pbed_tmpl = get_page_by_title('_post_bands_editor_default');
      $pbed_content = $pbed_tmpl->post_content;
      $pbed_content = str_replace(array("\r\n", "\n", "\r"), " ", $pbed_content);
      $pbed_content_dirty = str_replace("'", "\"", $pbed_content);
      $pbed_content = str_replace('> ', '>\n', $pbed_content_dirty);
      $pbed_content = str_replace('] ', ']\n', $pbed_content);

?>
      <script type="text/javascript">
      console.log('<?php echo $details_content; ?>');

        list = '<ul>\n';
        list += '  <li></li>\n';
        list += '  <li></li>\n';
        list += '</ul>\n';

        misc = '<?php echo $misc_content; ?>';
        details = '<?php echo $details_content; ?>';
        complete = '<?php echo $complete_content; ?>';
        staffp = '<?php echo $staffp_content; ?>';
        staffc = '<?php echo $staffc_content; ?>';
        pcd = '<?php echo $pcd_content; ?>';
        pcbd = '<?php echo $pcbd_content; ?>';
        ped = '<?php echo $ped_content; ?>';
        pbed = '<?php echo $pbed_content; ?>';

        function list_markup(){
          QTags.insertContent(list);
        }
        function misc_markup(){
          QTags.insertContent(misc);
        }
        function details_markup(){
          QTags.insertContent(details);
        }
        function complete_markup(){
          QTags.insertContent(complete);
        }
        function staffp_markup(){
          QTags.insertContent(staffp);
        }
        function staffc_markup(){
            QTags.insertContent(staffc);
        }
        function pcd_markup(){
            QTags.insertContent(pcd);
        }
        function pcbd_markup(){
            QTags.insertContent(pcbd);
        }
        function ped_markup(){
            QTags.insertContent(ped);
        }
        function pbed_markup(){
          QTags.insertContent(pbed);
        }

        QTags.addButton( 'eg_nbsp', 'nbsp', '&nbsp;', '', 'nbsp', '&nbsp;', 80 );
        QTags.addButton( 'eg_br', 'br', '<br />', '', 'br', 'br tag', 80 );
        QTags.addButton( 'eg_paragraph', 'p', '<p>', '</p>', 'p', 'Paragraph tag', 80 );
        QTags.addButton( 'eg_h2', 'h2', '<h2>', '</h2>', 'h2', 'h2 tag', 80 );
        QTags.addButton( 'eg_h3', 'h3', '<h3>', '</h3>', 'h3', 'h3 tag', 80 );
        QTags.addButton( 'eg_h4', 'h4', '<h4>', '</h4>', 'h4', 'h4 tag', 80 );
        QTags.addButton( 'eg_pre', 'pre', '<pre lang="php">', '</pre>', 'q', 'Preformatted text tag', 80 );
        QTags.addButton( 'eg_list', 'list', list_markup, '', '', 'ul>li>li', 80 );

        QTags.addButton( 'eg_style', 'style', ' style="color:aliceblue; "', '', 'style', 'style tag', 150 );
        QTags.addButton( 'eg_class', 'class', ' class="alignright "', '', 'class', 'class tag', 150 );

        QTags.addButton( 'eg_pcd', 'pcd', pcd_markup, '', '', 'pcd', 200 );
        QTags.addButton( 'eg_pcbd', 'pcbd', pcbd_markup, '', '', 'pcbd', 200 );
        QTags.addButton( 'eg_ped', 'ped', ped_markup, '', '', 'ped', 200 );
        QTags.addButton( 'eg_pbed', 'pbed', pbed_markup, '', '', 'pbed', 200 );
        QTags.addButton( 'eg_page', 'page', '\n[page title=""]', '', 'page', 'page tag', 200 );
        QTags.addButton( 'eg_template', 'template', '\n[template title="_post_editor_default"]', '', 'template', 'template tag', 200 );

        QTags.addButton( 'eg_misc', 'misc', misc_markup, '', '', 'Misc', 300 );
        QTags.addButton( 'eg_details', 'details', details_markup, '', '', 'Details', 300 );
        QTags.addButton( 'eg_complete', 'details+', complete_markup, '', '', 'Details for popup', 300 );
        QTags.addButton( 'eg_staffc', 'staffc', staffc_markup, '', '', 'staffc', 300 );
        QTags.addButton( 'eg_staffp', 'staffp', staffp_markup, '', '', 'staffp', 300 );
      </script>
<?php
    }
  }
}
add_action( 'admin_print_footer_scripts', 'appthemes_add_quicktags' );

