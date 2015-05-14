<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux_Framework_sample_config' ) ) {

        class Redux_Framework_sample_config {

            public $args = array();
            public $sections = array();
            public $theme;
            public $ReduxFramework;

            public function __construct() {

                if ( ! class_exists( 'ReduxFramework' ) ) {
                    return;
                }

                // This is needed. Bah WordPress bugs.  ;)
                if ( true == Redux_Helpers::isTheme( __FILE__ ) ) {
                    $this->initSettings();
                } else {
                    add_action( 'plugins_loaded', array( $this, 'initSettings' ), 10 );
                }

            }

            public function initSettings() {

                // Just for demo purposes. Not needed per say.
                $this->theme = wp_get_theme();

                // Set the default arguments
                $this->setArguments();

                // Set a few help tabs so you can see how it's done
                $this->setHelpTabs();

                // Create the sections and fields
                $this->setSections();

                if ( ! isset( $this->args['opt_name'] ) ) { // No errors please
                    return;
                }

                // If Redux is running as a plugin, this will remove the demo notice and links
                //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );

                // Function to test the compiler hook and demo CSS output.
                // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
                //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);

                // Change the arguments after they've been declared, but before the panel is created
                //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );

                // Change the default value of a field after it's been set, but before it's been useds
                //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

                // Dynamically add a section. Can be also used to modify sections/fields
                //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

                $this->ReduxFramework = new ReduxFramework( $this->sections, $this->args );
            }

            /**
             * This is a test function that will let you see when the compiler hook occurs.
             * It only runs if a field    set with compiler=>true is changed.
             * */
            function compiler_action( $options, $css, $changed_values ) {
                echo '<h1>The compiler hook has run!</h1>';
                echo "<pre>";
                print_r( $changed_values ); // Values that have changed since the last save
                echo "</pre>";
                //print_r($options); //Option values
                //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

                /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
            }

            /**
             * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
             * Simply include this function in the child themes functions.php file.
             * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
             * so you must use get_template_directory_uri() if you want to use any of the built in icons
             * */
            function dynamic_section( $sections ) {
                //$sections = array();
                $sections[] = array(
                    'title'  => __( 'Section via hook', 'redux-framework-demo' ),
                    'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
                    'icon'   => 'el el-icon-paper-clip',
                    // Leave this as a blank section, no options just some intro text set above.
                    'fields' => array()
                );

                return $sections;
            }

            /**
             * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
             * */
            function change_arguments( $args ) {
                //$args['dev_mode'] = true;

                return $args;
            }

            /**
             * Filter hook for filtering the default value of any given field. Very useful in development mode.
             * */
            function change_defaults( $defaults ) {
                $defaults['str_replace'] = 'Testing filter hook!';

                return $defaults;
            }

            // Remove the demo link and the notice of integrated demo from the redux-framework plugin
            function remove_demo() {

                // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
                if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                    remove_filter( 'plugin_row_meta', array(
                        ReduxFrameworkPlugin::instance(),
                        'plugin_metalinks'
                    ), null, 2 );

                    // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                    remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
                }
            }



            public function setSections() {
                // General Settings
                $this->sections[] = array(
                    'icon' => 'el-icon-cogs',
                    'title' => __('General', 'grateful'),
                    'fields' => array(
                        array(
                            'id'                          => 'tracking_code',
                            'type'                        => 'textarea',
                            'title'                       => __('Tracking Code', 'grateful'),
                            'desc'                        => __('Paste your Google Analytics (or other) tracking code here.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'section-carousel-post',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Post Carousel Slider Settings', 'grateful'),
                            'desc'                  => __('Post carousel slider common settings.', 'grateful'),
                        ),

                        array(
                            'id'                        => 'post_carousel_slider',
                            'type'                      => 'switch',
                            'title'                     => __('Display Posts Carousel Slider', 'grateful'),
                            'desc'                      => __('Display post carousel slider in main page.', 'grateful'),
                            'default'                   => 1,
                        ), 

                        array(
                            'id'                    => 'carousel_slider_post_per_page',
                            'type'                  => 'slider',
                            'title'                 => __('Carousel Slider Post Per Page ', 'grateful'),
                            'desc'                  => __('Displays the number of post carousel slider ', 'grateful'),
                            'default'               => 6,
                            'min'                   => 6,
                            'step'                  => 1,
                            'max'                   => 20,
                            'required'              => array('post_carousel_slider','equals','1'),
                            'display_value'         => 'text'
                        ),

                        array(
                            'id'                    => 'section-general-post',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Post Settings', 'grateful'),
                            'desc'                  => __('Post common settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'post_excerpt_length',
                            'type'                  => 'slider',
                            'title'                 => __('Post Excerpt Length', 'grateful'),
                            'default'               => 65,
                            'min'                   => 20,
                            'step'                  => 1,
                            'max'                   => 65,
                            'display_value'         => 'text'
                        ),

                        array(
                            'id'                        => 'display_author_name',
                            'type'                      => 'switch',
                            'title'                     => __('Display Author Name', 'grateful'),
                            'desc'                     => __('Display author name in each post.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'display_post_date',
                            'type'                      => 'switch',
                            'title'                     => __('Display Post Date', 'grateful'),
                            'desc'                     => __('Display post date in each post.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'display_category',
                            'type'                      => 'switch',
                            'title'                     => __('Display Category', 'grateful'),
                            'desc'                     => __('Display category in each post in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'display_reading_time',
                            'type'                      => 'switch',
                            'title'                     => __('Display Reading Time', 'grateful'),
                            'desc'                     => __('Display reading time in each post.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'display_modified_time',
                            'type'                      => 'switch',
                            'title'                     => __('Display Post Modified Time', 'grateful'),
                            'desc'                     => __('Display post modified time in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'post_nav',
                            'type'                      => 'switch',
                            'title'                     => __('Display Post Navigation', 'grateful'),
                            'desc'                     => __('Display post navigation in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'related_posts',
                            'type'                      => 'switch',
                            'title'                     => __('Display Related Posts', 'grateful'),
                            'desc'                     => __('Display related posts in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'tags_posts',
                            'type'                      => 'switch',
                            'title'                     => __('Display Tags posts', 'grateful'),
                            'desc'                     => __('Display Tags in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'share_buttons',
                            'type'                      => 'switch',
                            'title'                     => __('Display Share Buttons', 'grateful'),
                            'desc'                     => __('Display share buttons in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'about_author',
                            'type'                      => 'switch',
                            'title'                     => __('Display About Author', 'grateful'),
                            'desc'                     => __('Display About Author in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),

                        array(
                            'id'                        => 'comments_posts',
                            'type'                      => 'switch',
                            'title'                     => __('Display Comment posts', 'grateful'),
                            'desc'                     => __('Display Comment Form in post detail.', 'grateful'),
                            'default'                   => 1,
                        ),
                    )
                );

                // General Settings
                $this->sections[] = array(
                    'icon' => 'el-icon-website',
                    'title' => __('Appearance', 'grateful'),
                    'fields' => array(
                        array(
                            'id'                => 'logo_type',
                            'type'              => 'button_set',
                            'title'             => __('Logo Type', 'grateful'), 
                            'desc'              => sprintf(__('Use site <a href="%s" target="_blank">title & desription</a> or use image logo.', 'grateful'), admin_url('/options-general.php') ),
                            'options'           => array('1' => __('Site Title', 'grateful'), '2' => __('Image', 'grateful')),
                            'default'           => '2'
                        ),

                        array(
                            'id'                => 'logo_image',
                            'type'              => 'media', 
                            'url'               => true,
                            'required'          => array('logo_type', 'equals', '2'),
                            'title'             => __('Image Logo', 'grateful'),
                            'desc'              => __('Upload your logo or type the URL on the text box.', 'grateful'),
                            'default'           => array('url' => get_template_directory_uri() .'/images/logo.png'),
                        ),

                        array(
                            'id'                =>'favicon',
                            'type'              => 'media', 
                            'title'             => __('Favicon', 'grateful'),
                            'output'            => 'true',
                            'mode'              => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                            'desc'              => __('Upload your favicon.', 'grateful'),
                            'default'           => array('url' => get_template_directory_uri().'/images/favicon.png'),
                        ),

                        array(
                            'id'                        => 'custom_css',
                            'type'                      => 'ace_editor',
                            'title'                     => __('Custom CSS Codes', 'grateful'),
                            'mode'                      => 'css',
                            'theme'                     => 'monokai',
                            'desc'                      => __('Type your custom CSS codes here, alternatively you can also write down you custom CSS styles on the custom.css file located on the theme root directory.', 'moticia'),
                            'default'                   => ''
                        ),
                    )
                );


                // Typography Settings
                $this->sections[] = array(
                    'icon'    => 'el-icon-text-width',
                    'title'   => __('Typography', 'grateful'),
                    'fields'  => array(

                        array(
                            'id'                => 'body_text',
                            'type'              => 'typography',
                            'title'             => __('Body Text', 'grateful'),
                            'desc'              => __('Font for body text.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => false,
                            'output'            => array('body'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '18px',
                                'font-weight'       => '400',
                                'color'             => '#555555'
                            )
                        ),

                        array(
                            'id'                => 'site_title_font',
                            'type'              => 'typography',
                            'title'             => __('Site Title Logo', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => true,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#logo h2.site-title'),
                            'default'           => array(
                                'font-family'       => 'Montserrat',
                                'font-size'         => '30px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                                'text-transform'    => 'uppercase'
                            )
                        ),

                        array(
                            'id'                => 'site_desc_font',
                            'type'              => 'typography',
                            'title'             => __('Site Description Below Logo', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => true,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#logo .slogan'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '14px',
                                'font-weight'       => '400',
                                'color'             => '#888888',
                            )
                        ),

                        array(
                            'id'                => 'main_menu_font',
                            'type'              => 'typography',
                            'title'             => __('Main Menu', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'text-align'        => false,
                            'output'            => array('.widget_nav_menu ul li a'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '13px',
                                'font-weight'       => '400',
                                'color'             => '#ffffff',
                            )
                        ),

                        array(
                            'id'                    => 'section-heading',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Heading', 'grateful'),
                            'desc'                  => __('heading font settings.', 'grateful'),
                        ),

                        array(
                            'id'                => 'post_title',
                            'type'              => 'typography',
                            'title'             => __('Post & Page Title', 'grateful'),
                            'desc'              => __('Post & page title in detail page.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'all_styles'        => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('.page-title h1', '.post-title h1'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '50px',
                                'font-weight'       => '400',
                                'color'             => '#000000',
                                'text-transform'    => 'none'
                            )
                        ),

                        array(
                            'id'                => 'sticky_font',
                            'type'              => 'typography',
                            'title'             => __('Sticky Post Label', 'grateful'),
                            'desc'             => __('Sticky post label text.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent article.hentry label.sticky'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '11px',
                                'font-weight'       => '400',
                                'color'             => '#ffffff',
                                'text-transform'    => 'uppercase'
                            )
                        ),

                        array(
                            'id'                => 'pagination',
                            'type'              => 'typography',
                            'title'             => __('Pagination', 'grateful'),
                            'desc'              => __('Font for pagination links.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => false,
                            'output'            => array('.page-navigation'),
                            'default'           => array(
                                'font-family'       => 'Fira Sans',
                                'font-size'         => '12px',
                                'font-weight'       => '400',
                                'color'             => '#555555'
                            )
                        ),

                        array(
                            'id'                => 'heading_h1',
                            'type'              => 'typography',
                            'title'             => __('Heading H1 (Post & Page Title)', 'grateful'),
                            'desc'             => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent .post-content h1'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '30px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                                'text-transform'    => 'none'
                            )
                        ),

                        array(
                            'id'                => 'heading_h2',
                            'type'              => 'typography',
                            'title'             => __('Heading H2', 'grateful'),
                            'desc'             => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent .post-content h2'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '25px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                            'id'                => 'heading_h3',
                            'type'              => 'typography',
                            'title'             => __('Heading H3', 'grateful'),
                            'desc'              => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'all_styles'        => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'letter-spacing'    => true,
                            'output'            => array('.post-title h3', '.post-title', '#rightcontent .post-content h3'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '45px',
                                'font-weight'       => '400',
                                'color'             => '#000000',
                                'text-transform'    => 'none'
                            )
                        ),

                        array(
                            'id'                => 'heading_h4',
                            'type'              => 'typography',
                            'title'             => __('Heading H4', 'grateful'),
                            'desc'             => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent .post-content h4'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '16px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                           'id'                => 'heading_h5',
                            'type'              => 'typography',
                            'title'             => __('Heading H5', 'grateful'),
                            'desc'             => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent .post-content h5'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '13px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                           'id'                => 'heading_h6',
                            'type'              => 'typography',
                            'title'             => __('Heading H6', 'grateful'),
                            'desc'             => __('Also used for post & page title.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'text-transform'    => true,
                            'output'            => array('#rightcontent .post-content h6'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '11px',
                                'font-weight'       => '400',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                            'id'                    => 'section-posts',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Post Section', 'grateful'),
                            'desc'                  => __('Post font settings.', 'grateful'),
                        ),

                        array(
                           'id'                => 'posts_meta',
                            'type'              => 'typography',
                            'title'             => __('Post Meta', 'grateful'),
                            'desc'             => __('Also used for post Meta (Author, date, categories, etc.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'letter-spacing'    => true,
                            'text-transform'    => true,
                            'output'            => array('.meta'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '11px',
                                'font-weight'       => '400',
                                'color'             => '#a1887f',
                                'letter-spacing'    => '2px',
                                'text-transform'    => 'uppercase'
                            )
                        ),

                        array(
                           'id'                => 'tags_post',
                            'type'              => 'typography',
                            'title'             => __('Tags', 'grateful'),
                            'desc'             => __('Also used for post & page Tags.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'output'            => array('.post-tags a', '.post-tags span'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '14px',
                                'font-weight'       => '400',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                            'id'                => 'posts_section_heading',
                            'type'              => 'typography',
                            'title'             => __('Post Section Heading', 'grateful'),
                            'desc'              => __('Heading in Author Short Description and Comments.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'letter-spacing'    => true,
                            'output'            => array('#rightcontent h3.widget-title'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '24px',
                                'font-weight'       => '400',
                                'color'             => '#000000',
                                'text-transform'    => 'none'
                            )
                        ),

                        array(
                            'id'                => 'post_format_quote_text',
                            'type'              => 'typography',
                            'title'             => __('Normal Blockquote', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => true,
                            'output'            => array('article.format-quote blockquote'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-weight'       => '400',
                                'font-style'        => 'italic',
                                'font-size'         => '40px',
                                'color'             => '#ffffff',
                                'line-height'       => '110%'
                            )
                        ),

                        array(
                            'id'                => 'post_quote_text',
                            'type'              => 'typography',
                            'title'             => __('Normal Blockquote', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => true,
                            'output'            => array('article.hentry .post-content blockquote'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-weight'       => '400',
                                'font-style'        => 'italic',
                                'font-size'         => '25px',
                                'color'             => '#555',
                                'line-height'       => '100%'
                            )
                        ),

                        array(
                            'id'                => 'post_quote_cite_text',
                            'type'              => 'typography',
                            'title'             => __('Quote Source Text', 'grateful'),
                            'desc'              => __('Text "Quote Name" in post format "quote" content.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'letter-spacing'    => true,
                            'output'            => array('article.post-quote cite'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '11px',
                                'color'             => '#ffffff',
                                'text-transform'    => 'uppercase',
                                'letter-spacing'    => '1px'
                            )
                        ),
                        
                        array(
                            'id'                    => 'section-sidebar',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Sidebar Section', 'grateful'),
                            'desc'                  => __('Sidebar font settings.', 'grateful'),
                        ),

                        array(
                            'id'                => 'sidebar_section_heading',
                            'type'              => 'typography',
                            'title'             => __('Sidebar Section Heading', 'grateful'),
                            'desc'              => __('Heading in Section Sidebar.', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'text-align'        => false,
                            'letter-spacing'    => true,
                            'output'            => array('#leftcontent h3.widget-title'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '12px',
                                'font-weight'       => '400',
                                'color'             => '#333333',
                                'letter-spacing'    => '2px',
                                'text-transform'    => 'uppercase'
                            )
                        ),

                        array(
                            'id'                => 'sidebar_paragraph_text',
                            'type'              => 'typography',
                            'title'             => __('Sidebar Paragraph Text', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'text-align'        => false,
                            'output'            => array('#leftcontent', '.sidebar-widgets', '#jPanelMenu-menu'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '13px',
                                'font-weight'       => '400',
                                'color'             => '#777777',
                            )
                        ),

                        array(
                            'id'                    => 'section-form',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Form Section', 'grateful'),
                            'desc'                  => __('Form font settings.', 'grateful'),
                        ),

                        array(
                            'id'                => 'form_field_font',
                            'type'              => 'typography',
                            'title'             => __('Form Field Text', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'output'            => array('form input[type="text"]', 'form input[type="password"]', 'form input[type="email"]', 'form textarea', 'form input[type="url"]', '::-webkit-input-placeholder'),
                            'default'           => array(
                                'font-family'       => 'Fira Sans',
                                'font-size'         => '14px',
                                'font-weight'       => '400',
                                'color'             => '#555555',
                            )
                        ),

                        array(
                            'id'                => 'form_label_font',
                            'type'              => 'typography',
                            'title'             => __('Form Label Text', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'output'            => array('form.wpcf7-form label', 'form p label', 'form div.input label'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '11px',
                                'font-weight'       => '400',
                                'color'             => '#555555',
                            )
                        ),

                        array(
                            'id'                => 'form_button_font',
                            'type'              => 'typography',
                            'title'             => __('Form Button Text', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-transform'    => true,
                            'output'            => array('.button.submit-button', 'form input[type="submit"]', 'form button[type="submit"]'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '18px',
                                'font-weight'       => '400',
                                'color'             => '#ffffff',
                            )
                        ),

                        array(
                            'id'                    => 'section-comments',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Comments Section', 'grateful'),
                            'desc'                  => __('Comments font settings.', 'grateful'),
                        ),

                        array(
                            'id'                => 'author_comments_font',
                            'type'              => 'typography',
                            'title'             => __('Comment Author & Author Name', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'letter-spacing'    => true,
                            'text-transform'    => false,
                            'output'            => array('.comments-list ul li .author', '.single-author .info h5'),
                            'default'           => array(
                                'font-family'       => 'Playfair Display',
                                'font-size'         => '16px',
                                'font-weight'       => '700',
                                'color'             => '#000000',
                            )
                        ),

                        array(
                            'id'                => 'date_comments_font',
                            'type'              => 'typography',
                            'title'             => __('Comment Date', 'grateful'),
                            'google'            => true,
                            'subsets'           => true,
                            'preview'           => true,
                            'line-height'       => false,
                            'text-align'        => false,
                            'letter-spacing'    => true,
                            'text-transform'    => false,
                            'output'            => array('.comments-list ul li .author span time'),
                            'default'           => array(
                                'font-family'       => 'Lato',
                                'font-size'         => '14px',
                                'font-weight'       => '400',
                                'color'             => '#7e7e7e',
                            )
                        ),
                    )
                );
                
                // Color Settings
                $this->sections[] = array(
                    'icon'    => 'el-icon-brush',
                    'title'   => __('Colors', 'grateful'),
                    'fields'  => array(
                        array(
                            'id'                    => 'main_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Main Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('#rightcontent .post-content a'),
                            'default'               => array(
                                                        'regular'  => '#0d47a1',
                                                        'hover'    => '#00897b',
                            )
                        ),

                        array(
                            'id'                    => 'sidebar_bg',
                            'type'                  => 'background',
                            'title'                 => __('Sidebar Background Color', 'grateful'),
                            'output'                => array('#main-wrapper .before'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#ffffff',
                                                    )
                        ),

                        array(
                            'id'                        => 'sidebar_border',
                            'type'                      => 'border',
                            'title'                     => __('Sidebar Right Border', 'grateful'),
                            'output'                    => array('#main-wrapper .before:after'),
                            'all'                       => false,
                            'top'                       => false,
                            'bottom'                     => false,
                            'left'                      => false,
                            'default'                   => array(
                                'border-color'          => '#ffffff',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                        => 'sidebar_heading_border',
                            'type'                      => 'border',
                            'title'                     => __('FSidebar Widget Title Border Bottom', 'grateful'),
                            'output'                    => array('#leftcontent .widget-title:after', '#jPanelMenu-menu h3.widget-title:after'),
                            'all'                       => false,
                            'bottom'                       => false,
                            'right'                     => false,
                            'left'                      => false,
                            'default'                   => array(
                                'border-color'          => '#aaaaaa',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                    => 'sidebar_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Sidebar Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.sidebar-widgets a'),
                            'default'               => array(
                                                        'regular'  => '#666666',
                                                        'hover'    => '#00897b',
                            )
                        ),

                        array(
                            'id'                    => 'sidebar_social_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Sidebar Social Icon Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.sidebar-widgets div.social a'),
                            'default'               => array(
                                                        'regular'  => '#777777',
                                                        'hover'    => '#ff5722',
                            )
                        ),

                        array(
                            'id'                    => 'paginate_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Page Navigation Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.post-nav span', '.page-navigation a'),
                            'default'               => array(
                                                        'regular'  => '#aaaaaa',
                                                        'hover'    => '#cd0216',
                            )
                        ),

                        array(
                            'id'                    => 'section-main-menu',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Main Menu', 'grateful'),
                            'desc'                  => __('Main menu color settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'menu_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Main Menu Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.widget_nav_menu ul li a'),
                            'default'               => array(
                                                        'regular'  => '#444444',
                                                        'hover'    => '#ff5722',
                            )
                        ),

                        array(
                            'id'                        => 'section-post-colors',
                            'type'                      => 'info',
                            'icon'                      => 'el-icon-info-sign',
                            'title'                     => __('Post Colors', 'grateful'),
                            'desc'                      => __('Post color settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'article_bg',
                            'type'                  => 'background',
                            'title'                 => __('Article Background Color', 'grateful'),
                            'output'                => array('#rightcontent article.hentry', '#rightcontent .box'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#ffffff',
                                                    )
                        ),

                        array(
                            'id'                    => 'post_quote_bg',
                            'type'                  => 'background',
                            'title'                 => __('Post Format Quote Background Color', 'grateful'),
                            'output'                => array('#rightcontent article.format-quote'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#333333',
                                                    )
                        ),

                        array(
                            'id'                    => 'sticky_label_bg',
                            'type'                  => 'background',
                            'title'                 => __('Sticky Label Background Color', 'grateful'),
                            'output'                => array('#rightcontent article.sticky label.sticky'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#8Bc34a',
                                                    )
                        ),

                        array(
                            'id'                    => 'read-more-border',
                            'type'                  => 'border',
                            'title'                 => __('Read More Button Border Color', 'grateful'),
                            'output'                => array('#rightcontent article.hentry .read-more a'),
                            'all'                       => true,
                            'default'                   => array(
                                'border-color'          => '#795548',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                    => 'read-more-link',
                            'type'                  => 'link_color',
                            'title'                 => __('Read More Button Border Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('#rightcontent article.hentry .read-more a'),
                            'default'               => array(
                                                        'regular'  => '#795548',
                                                        'hover'    => '#8d6e63',
                            )
                        ),

                        array(
                            'id'                    => 'post_title_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Post Title Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.post-title h3 a'),
                            'default'               => array(
                                                        'regular'  => '#000000',
                                                        'hover'    => '#cd0216',
                            )
                        ),

                        array(
                            'id'                    => 'post_meta_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Post Meta Link Color', 'grateful'),
                            'desc'                  => __('Link Color for Category on post content', 'grateful'),
                            'active'                => false,
                            'output'                => array('.meta a'),
                            'default'               => array(
                                                        'regular'  => '#a1887f',
                                                        'hover'    => '#8d6e63',
                            )
                        ),

                        array(
                            'id'                    => 'carousel_meta_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Post Meta Carousel Slider Link Color', 'grateful'),
                            'desc'                  => __('Link Color for Category on post carousel slider content', 'grateful'),
                            'active'                => false,
                            'output'                => array('.overlay .meta a'),
                            'default'               => array(
                                                        'regular'  => '#a1887f',
                                                        'hover'    => '#8d6e63',
                            )
                        ),

                        array(
                            'id'                    => 'format_quote_bg',
                            'type'                  => 'background',
                            'title'                 => __('Post Format Quote Background Color', 'grateful'),
                            'output'                => array('article.post-quote'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#689f38',
                                                    )
                        ),

                        array(
                            'id'                    => 'read_more_button_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Continue Reading Button Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('a'),
                            'default'               => array(
                                                        'regular'  => '#000000',
                                                        'hover'    => '#cd0216',
                            )
                        ),

                        array(
                            'id'                        => 'post-nav-border',
                            'type'                      => 'border',
                            'title'                     => __('Post Nav Border', 'grateful'),
                            'desc'                      => __('Post nav border in the post detail page.', 'grateful'),
                            'output'                    => array('#post-nav'),
                            'all'                       => false,
                            'left'                      => false,
                            'right'                     => false,
                            'default'                   => array(
                                'border-color'          => '#eeeeee',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                    => 'section-social-media',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Social Media Link Colors', 'grateful'),
                            'desc'                  => __('Social media link color settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'social_network_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Social Network Icon Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.site-info .social ul li a'),
                            'default'               => array(
                                                        'regular'  => '#cccccc',
                                                        'hover'    => '#cd0216',
                            )
                        ),

                        array(
                            'id'                    => 'section-form-colors',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Form Colors', 'grateful'),
                            'desc'                  => __('Form color settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => 'search-widget-bg',
                            'type'                  => 'background',
                            'title'                 => __('Search Widget Background Color', 'grateful'),
                            'output'                    => array('.search-box'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#ffffff',
                                                    )
                        ),

                        array(
                            'id'                        => 'search-widget-border',
                            'type'                      => 'border',
                            'title'                     => __('Search Widget Border', 'grateful'),
                            'output'                    => array('.search-box'),
                            'all'                       => true,
                            'default'                   => array(
                                'border-color'          => '#cccccc',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                    => 'form_text_bg',
                            'type'                  => 'background',
                            'title'                 => __('Form Text Field & Textarea Color', 'grateful'),
                            'output'                    => array('form input[type="text"]', 'form input[type="password"]', 'form input[type="email"]', 'form textarea', 'form input[type="url"]'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#ffffff',
                                                    )
                        ),

                        array(
                            'id'                        => 'form_field_border',
                            'type'                      => 'border',
                            'title'                     => __('Form Text Field & Textarea Border', 'grateful'),
                            'desc'                      => __('Form Text Field & Textarea Border.', 'grateful'),
                            'output'                    => array('form input[type="text"]', 'form input[type="password"]', 'form input[type="email"]', 'form textarea', 'form input[type="url"]'),
                            'all'                       => true,
                            'default'                   => array(
                                'border-color'          => '#d7d7d7',
                                'border-style'          => 'solid',
                                'border-width'          => '1px', 
                            )
                        ),

                        array(
                            'id'                    => 'form_button_bg',
                            'type'                  => 'background',
                            'title'                 => __('Form Button Color', 'grateful'),
                            'output'                => array('.button.submit-button', 'form button[type="submit"]', 'form input[type="submit"]'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#333333',
                                                    )
                        ),

                        array(
                            'id'                    => 'form_button_hover_bg',
                            'type'                  => 'background',
                            'title'                 => __('Form Button Hover Color', 'grateful'),
                            'output'                => array('.button.submit-button:hover', 'form button[type="submit"]:hover', 'form input[type="submit"]:hover'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#555555',
                                                    )
                        ),

                        array(
                            'id'                        => 'form_validation_error_border',
                            'type'                      => 'border',
                            'title'                     => __('Form Validation Border', 'grateful'),
                            'output'                    => array('border' => 'div.wpcf7-validation-errors'),
                            'all'                       => true,
                            'default'                   => array(
                                                        'border-color'          => '#d7d7d7',
                                                        'border-style'          => 'solid',
                                                        'border-width'          => '2px',
                            )
                        ),

                        array(
                            'id'                    => 'section-other',
                            'type'                  => 'info',
                            'icon'                  => 'el-icon-info-sign',
                            'title'                 => __('Other Colors', 'grateful'),
                            'desc'                  => __('Other color settings.', 'grateful'),
                        ),

                        array(
                            'id'                    => '404_image',
                            'type'                  => 'media',
                            'title'                 => __('404 Page Image', 'grateful'),
                            'desc'                 => __('Preferred image size is 755x400 pixel.', 'grateful'),
                            'default'               => array(
                                                    'url' => get_template_directory_uri().'/images/404.jpg',
                            )
                        ),

                        array(
                            'id'                    => 'comments_author_link',
                            'type'                  => 'link_color',
                            'title'                 => __('Comment Author Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.comments-list ul li .author a'),
                            'default'               => array(
                                                        'regular'  => '#000000',
                                                        'hover'    => '#cd0216',
                            )
                        ),

                        array(
                            'id'                    => 'comments_meta_link',
                            'type'                  => 'link_color',
                            'title'                 => __('Comment Edit & Reply Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('a.comment-reply-link', 'a.comment-edit-link', 'a#cancel-comment-reply-link'),
                            'default'               => array(
                                                        'regular'  => '#e53935',
                                                        'hover'    => '#b71c1c',
                            )
                        ),

                        array(
                            'id'                    => 'back_to_top_bg',
                            'type'                  => 'background',
                            'title'                 => __('Back to Top Button Color', 'grateful'),
                            'output'                => array('#scroll-top'),
                            'preview'               => false,
                            'preview_media'         => false,
                            'background-repeat'     => false,
                            'background-attachment' => false,
                            'background-position'   => false,
                            'background-image'      => false,
                            'background-gradient'   => false,
                            'background-clip'       => false,
                            'background-origin'     => false,
                            'background-size'       => false,
                            'default'               => array(
                                                        'background-color'      => '#000000',
                                                    )
                        ),

                        array(
                            'id'                    => 'back_to_top_icon_color',
                            'type'                  => 'color',
                            'title'                 => __('Back to Top Button Icon Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('#scroll-top'),
                            'default'               => '#ffffff',
                            'validate'              => 'color'
                        ),

                         array(
                            'id'                    => 'nav_slider_color',
                            'type'                  => 'color',
                            'title'                 => __('Nav Slider Icon Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('ul.flex-direction-nav li a'),
                            'default'               => '#ffffff',
                            'validate'              => 'color'
                        ),
                        
                         array(
                            'id'                        => 'nav_slider_border',
                            'type'                      => 'border',
                            'title'                     => __('Nav Slider Border', 'grateful'),
                            'output'                    => array('ul.flex-direction-nav li a'),
                            'all'                       => true,
                            'default'                   => array(
                                                        'border-color'          => '#ffffff',
                                                        'border-style'          => 'solid',
                                                        'border-width'          => '1px',
                            )
                        ),

                        array(
                            'id'                    => 'pagination_link_color',
                            'type'                  => 'link_color',
                            'title'                 => __('Pagination Link Color', 'grateful'),
                            'active'                => false,
                            'output'                => array('.page-navigation a'),
                            'default'               => array(
                                                        'regular'  => '#cccccc',
                                                        'hover'    => '#ffab40',
                            )
                        ),
                    )
                );

                // Social Networks
                $this->sections[] = array(
                    'icon' => 'el-icon-user',
                    'title' => __('Author Info & Social Networks', 'grateful'),
                    'fields' => array(
                        array(
                            'id'                => 'blog_avatar',
                            'type'              => 'media', 
                            'url'               => true,
                            'title'             => __('Author Avatar', 'grateful'),
                            'output'            => false,
                            'desc'              => __('Upload your profile picture.', 'grateful'),
                            'default'           => array('url' => get_template_directory_uri() .'/images/avatar.jpg'),
                        ),

                        array(
                            'id'                          => 'blog_description',
                            'type'                        => 'textarea', 
                            'title'                       => __('About the Blog', 'grateful'),
                            'desc'                        => __('Write a short description about your blog.', 'grateful'),
                            'default'                     => __('This is my personal blog where I\'ll share a lot of stuffs about life and work everything I do in between.', 'grateful')
                        ),

                        array(
                            'id'                          => 'url_facebook',
                            'type'                        => 'text', 
                            'title'                       => __('Facebook Profile', 'grateful'),
                            'desc'                        => __('Your Facebook profile page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_twitter',
                            'type'                        => 'text', 
                            'title'                       => __('Twitter Profile', 'grateful'),
                            'desc'                        => __('Your Twitter profile page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_instagram',
                            'type'                        => 'text', 
                            'title'                       => __('Instagram Profile', 'grateful'),
                            'desc'                        => __('Your Instagram profile page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_gplus',
                            'type'                        => 'text', 
                            'title'                       => __('Google+ Profile', 'grateful'),
                            'desc'                        => __('Your Google+ profile page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_linkedin',
                            'type'                        => 'text', 
                            'title'                       => __('LinkedIn Profile', 'grateful'),
                            'desc'                        => __('Your LinkedIn profile page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_pinterest',
                            'type'                        => 'text', 
                            'title'                       => __('Pinterest Profile', 'grateful'),
                            'desc'                        => __('Your Pinterest page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_flickr',
                            'type'                        => 'text', 
                            'title'                       => __('Flickr Profile', 'grateful'),
                            'desc'                        => __('Your Flickr page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),

                        array(
                            'id'                          => 'url_youtube',
                            'type'                        => 'text', 
                            'title'                       => __('YouTube Profile', 'grateful'),
                            'desc'                        => __('Your YouTube video page.', 'grateful'),
                            'placeholder'                 => 'http://',
                            'default'                     => '#'
                        ),
                    )
                );
            }


            public function setHelpTabs() {

                // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-1',
                    'title'   => __( 'Theme Information 1', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                $this->args['help_tabs'][] = array(
                    'id'      => 'redux-help-tab-2',
                    'title'   => __( 'Theme Information 2', 'redux-framework-demo' ),
                    'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo' )
                );

                // Set the help sidebar
                $this->args['help_sidebar'] = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo' );
            }

            /**
             * All the possible arguments for Redux.
             * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
             * */
            public function setArguments() {

                $theme = wp_get_theme(); // For use with some settings. Not necessary.

                $this->args = array(
                    // TYPICAL -> Change these values as you need/desire
                    'opt_name'             => 'grateful_option',
                    // This is where your data is stored in the database and also becomes your global variable name.
                    'display_name'         => $theme->get( 'Name' ),
                    // Name that appears at the top of your panel
                    'display_version'      => $theme->get( 'Version' ),
                    // Version that appears at the top of your panel
                    'menu_type'            => 'menu',
                    //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                    'allow_sub_menu'       => true,
                    // Show the sections below the admin menu item or not
                    'menu_title'           => __( 'Theme Options', 'grateful' ),
                    'page_title'           => __( 'Theme Options', 'grateful' ),
                    // You will need to generate a Google API key to use this feature.
                    // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                    'google_api_key'       => '',
                    // Set it you want google fonts to update weekly. A google_api_key value is required.
                    'google_update_weekly' => false,
                    // Ajax save
                    'ajax_save'            => true,
                    // Must be defined to add google fonts to the typography module
                    'async_typography'     => true,
                    // Use a asynchronous font on the front end or font string
                    //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
                    'admin_bar'            => true,
                    // Show the panel pages on the admin bar
                    'admin_bar_icon'     => 'dashicons-portfolio',
                    // Choose an icon for the admin bar menu
                    'admin_bar_priority' => 50,
                    // Choose an priority for the admin bar menu
                    'global_variable'      => '',
                    // Set a different name for your global variable other than the opt_name
                    'dev_mode'             => false,
                    // Show the time the page took to load, etc
                    'update_notice'        => true,
                    // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
                    'customizer'           => true,
                    // Enable basic customizer support
                    //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                    //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                    // OPTIONAL -> Give you extra features
                    'page_priority'        => 61,
                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                    'page_parent'          => 'themes.php',
                    // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                    'page_permissions'     => 'manage_options',
                    // Permissions needed to access the options panel.
                    'menu_icon'            => get_template_directory_uri() .'/images/warrior-icon.png',
                    // Specify a custom URL to an icon
                    'last_tab'             => '',
                    // Force your panel to always open to a specific tab (by id)
                    'page_icon'            => 'icon-themes',
                    // Icon displayed in the admin panel next to your menu_title
                    'page_slug'            => 'warriorpanel',
                    // Page slug used to denote the panel
                    'save_defaults'        => true,
                    // On load save the defaults to DB before user clicks save or not
                    'default_show'         => false,
                    // If true, shows the default value next to each field that is not the default value.
                    'default_mark'         => '',
                    // What to print by the field's title if the value shown is default. Suggested: *
                    'show_import_export'   => true,
                    // Shows the Import/Export panel when not used as a field.

                    // CAREFUL -> These options are for advanced use only
                    'transient_time'       => 60 * MINUTE_IN_SECONDS,
                    'output'               => true,
                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                    'output_tag'           => true,
                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                    // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

                    // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                    'database'             => '',
                    // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                    'system_info'          => false,
                    // REMOVE

                    // HINTS
                    'hints' => array(
                        'icon'          => 'icon-question-sign',
                        'icon_position' => 'right',
                        'icon_color'    => 'lightgray',
                        'icon_size'     => 'normal',
                        'tip_style'     => array(
                            'color'         => 'light',
                            'shadow'        => true,
                            'rounded'       => false,
                            'style'         => '',
                        ),
                        'tip_position'  => array(
                            'my' => 'top left',
                            'at' => 'bottom right',
                        ),
                        'tip_effect'    => array(
                            'show'          => array(
                                'effect'        => 'slide',
                                'duration'      => '500',
                                'event'         => 'mouseover',
                            ),
                            'hide'      => array(
                                'effect'    => 'slide',
                                'duration'  => '500',
                                'event'     => 'click mouseleave',
                            ),
                        ),
                    )
                );

                // ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-docs',
                    'href'   => 'http://docs.reduxframework.com/',
                    'title' => __( 'Documentation', 'redux-framework-demo' ),
                );

                $this->args['admin_bar_links'][] = array(
                    //'id'    => 'redux-support',
                    'href'   => 'https://github.com/ReduxFramework/redux-framework/issues',
                    'title' => __( 'Support', 'redux-framework-demo' ),
                );

                $this->args['admin_bar_links'][] = array(
                    'id'    => 'redux-extensions',
                    'href'   => 'reduxframework.com/extensions',
                    'title' => __( 'Extensions', 'redux-framework-demo' ),
                );

                // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
                $this->args['share_icons'][] = array(
                    'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
                    'title' => 'Visit us on GitHub',
                    'icon'  => 'el el-icon-github'
                    //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
                    'title' => 'Like us on Facebook',
                    'icon'  => 'el el-icon-facebook'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://twitter.com/reduxframework',
                    'title' => 'Follow us on Twitter',
                    'icon'  => 'el el-icon-twitter'
                );
                $this->args['share_icons'][] = array(
                    'url'   => 'http://www.linkedin.com/company/redux-framework',
                    'title' => 'Find us on LinkedIn',
                    'icon'  => 'el el-icon-linkedin'
                );

                // Panel Intro text -> before the form
                $this->args['intro_text'] = __('<p>If you like this theme, please consider giving it a 5 star rating on ThemeForest. <a href="http://themeforest.net/downloads" target="_blank">Rate now</a>.</p>', 'grateful');

                // Panel Intro text -> before the form
                // if ( ! isset( $this->args['global_variable'] ) || $this->args['global_variable'] !== false ) {
                //     if ( ! empty( $this->args['global_variable'] ) ) {
                //         $v = $this->args['global_variable'];
                //     } else {
                //         $v = str_replace( '-', '_', $this->args['opt_name'] );
                //     }
                //     $this->args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'redux-framework-demo' ), $v );
                // } else {
                //     $this->args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo' );
                // }

                // Add content after the form.
                // $this->args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'redux-framework-demo' );
            }

            public function validate_callback_function( $field, $value, $existing_value ) {
                $error = true;
                $value = 'just testing';

                /*
              do your validation

              if(something) {
                $value = $value;
              } elseif(something else) {
                $error = true;
                $value = $existing_value;
                
              }
             */

                $return['value'] = $value;
                $field['msg']    = 'your custom error message';
                if ( $error == true ) {
                    $return['error'] = $field;
                }

                return $return;
            }

            public static function class_field_callback( $field, $value ) {
                print_r( $field );
                echo '<br/>CLASS CALLBACK';
                print_r( $value );
            }

        }

        global $reduxConfig;
        $reduxConfig = new Redux_Framework_sample_config();
    } else {
        echo "The class named Redux_Framework_sample_config has already been called. <strong>Developers, you need to prefix this class with your company name or you'll run into problems!</strong>";
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ):
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    endif;

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ):
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error = true;
            $value = 'just testing';

            /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            
          }
         */

            $return['value'] = $value;
            $field['msg']    = 'your custom error message';
            if ( $error == true ) {
                $return['error'] = $field;
            }

            $return['warning'] = $field;

            return $return;
        }
    endif;
