<?php
/**
 * Initialize the custom theme options.
 */
add_action( 'init', 'custom_theme_options' );

/**
 * Build the custom settings & update OptionTree.
 */
function custom_theme_options() {
  
  /* OptionTree is not loaded yet, or this is not an admin request */
  if ( ! function_exists( 'ot_settings_id' ) || ! is_admin() )
    return false;
    
  /**
   * Get a copy of the saved settings array. 
   */
  $saved_settings = get_option( ot_settings_id(), array() );
  
  /**
   * Custom settings array that will eventually be 
   * passes to the OptionTree Settings API Class.
   */
  $custom_settings = array( 
    'contextual_help' => array( 
      'sidebar'       => ''
    ),
    'sections'        => array( 
      array(
        'id'          => 'header',
        'title'       => __( 'Header Section', 'opt-export.xml' )
      ),
      array(
        'id'          => 'footer_section',
        'title'       => __( 'Footer Section', 'opt-export.xml' )
      )
    ),
    'settings'        => array( 
      array(
        'id'          => 'header_mail',
        'label'       => __( 'Header Mail', 'opt-export.xml' ),
        'desc'        => __( 'Description for the header email field.', 'opt-export.xml' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_phone_no',
        'label'       => __( 'Header Phone No', 'opt-export.xml' ),
        'desc'        => __( 'Description for the phone no', 'opt-export.xml' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_fax_no',
        'label'       => __( 'Header Fax No', 'opt-export.xml' ),
        'desc'        => __( 'Add the fax number of the site', 'opt-export.xml' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'header_logo',
        'label'       => __( 'Header Logo', 'opt-export.xml' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'header',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_text',
        'label'       => __( 'Footer Text', 'opt-export.xml' ),
        'desc'        => __( 'Description for the footer column', 'opt-export.xml' ),
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_logo',
        'label'       => __( 'Footer Logo', 'opt-export.xml' ),
        'desc'        => __( 'Image for the about us', 'opt-export.xml' ),
        'std'         => '',
        'type'        => 'upload',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_content',
        'label'       => __( 'Footer Content', 'opt-export.xml' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_copyright',
        'label'       => __( 'Footer Copyright', 'opt-export.xml' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'text',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'footer_privacy_policy',
        'label'       => __( 'Footer Privacy Policy', 'opt-export.xml' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'page-select',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and'
      ),
      array(
        'id'          => 'social_networks',
        'label'       => __( 'Social Networks', 'opt-export.xml' ),
        'desc'        => '',
        'std'         => '',
        'type'        => 'list-item',
        'section'     => 'footer_section',
        'rows'        => '',
        'post_type'   => '',
        'taxonomy'    => '',
        'min_max_step'=> '',
        'class'       => '',
        'condition'   => '',
        'operator'    => 'and',
        'settings'    => array( 
          array(
            'id'          => 'link_class',
            'label'       => __( 'Link Class', 'opt-export.xml' ),
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          ),
          array(
            'id'          => 'network_links',
            'label'       => __( 'Link', 'opt-export.xml' ),
            'desc'        => '',
            'std'         => '',
            'type'        => 'text',
            'rows'        => '',
            'post_type'   => '',
            'taxonomy'    => '',
            'min_max_step'=> '',
            'class'       => '',
            'condition'   => '',
            'operator'    => 'and'
          )
        )
      )
    )
  );
  
  /* allow settings to be filtered before saving */
  $custom_settings = apply_filters( ot_settings_id() . '_args', $custom_settings );
  
  /* settings are not the same update the DB */
  if ( $saved_settings !== $custom_settings ) {
    update_option( ot_settings_id(), $custom_settings ); 
  }
  
  /* Lets OptionTree know the UI Builder is being overridden */
  global $ot_has_custom_theme_options;
  $ot_has_custom_theme_options = true;
  
}