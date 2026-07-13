<?php
if ( ! function_exists( 'westio_display_comments' ) ) {
    /**
     * Westio display comments
     *
     * @since  1.0.0
     */
    function westio_display_comments() {
        // If comments are open or we have at least one comment, load up the comment template.
        if ( comments_open() || 0 !== intval( get_comments_number() ) ) :
            comments_template();
        endif;
    }
}

if ( ! function_exists( 'westio_comment' ) ) {
    /**
     * Westio comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int $depth the comment depth.
     *
     * @since 1.0.0
     */
    function westio_comment( $comment, $args, $depth ) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr( $tag ) . ' '; ?><?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">

        <div class="comment-body">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 50 ); ?>
            </div>
            <?php if ( 'div' !== $args['style'] ) : ?>
            <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
                <?php endif; ?>
                <div class="comment-head">
                    <div class="comment-meta commentmetadata">
                        <?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() ); ?>

                        <?php
                        printf(
                            '<a href="%s" class="comment-date"><time datetime="%s">%s</time></a>',
                            esc_url( get_comment_link( $comment, $args ) ),
                            get_comment_time( 'c' ),
                            sprintf(
                            /* translators: 1: Comment date, 2: Comment time. */
                                __( '%1$s at %2$s', 'westio' ),
                                get_comment_date( 'F j, Y', $comment ),
                                get_comment_time( 'g:i a' )
                            )
                        );
                        ?>

                        <?php if ( '0' === $comment->comment_approved ) : ?>
                            <em class="comment-awaiting-moderation"><?php esc_html_e( 'Your comment is awaiting moderation.', 'westio' ); ?></em>
                            <br/>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="comment-text">
                    <?php comment_text(); ?>
                </div>

                <div class="reply">
                    <?php
                    comment_reply_link(
                        array_merge(
                            $args, array(
                                'add_below' => $add_below,
                                'depth'     => $depth,
                                'max_depth' => $args['max_depth'],
                            )
                        )
                    );
                    ?>
                    <?php edit_comment_link( esc_html__( 'Edit', 'westio' ), '  ', '' ); ?>
                </div>
                <?php if ( 'div' !== $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_credit' ) ) {
    /**
     * Display the theme credit
     *
     * @return void
     * @since  1.0.0
     */
    function westio_credit() {
        ?>
        <div class="site-info">
            <?php echo apply_filters( 'westio_copyright_text', $content = '&copy; ' . date( 'Y' ) . ' ' . '<a class="site-url" href="' . esc_url( site_url() ) . '">' . esc_html( get_bloginfo( 'name' ) ) . '</a>' . esc_html__( '. All Rights Reserved.', 'westio' ) ); ?>
        </div><!-- .site-info -->
        <?php
    }
}

if ( ! function_exists( 'westio_social' ) ) {
    function westio_social() {
        $social_list = westio_get_theme_option( 'social_text', [] );
        if ( empty( $social_list ) ) {
            return;
        }
        ?>
        <div class="westio-social">
            <ul>
                <?php

                foreach ( $social_list as $social_item ) {
                    ?>
                    <li><a href="<?php echo esc_url( $social_item ); ?>"></a></li>
                    <?php
                }
                ?>

            </ul>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_site_branding' ) ) {
    /**
     * Site branding wrapper and display
     *
     * @return void
     * @since  1.0.0
     */
    function westio_site_branding() {
        ?>
        <div class="site-branding">
            <?php echo westio_site_title_or_logo(); ?>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_site_title_or_logo' ) ) {
    /**
     * Display the site title or logo
     *
     * @param bool $echo Echo the string or return it.
     *
     * @return string
     * @since 2.1.0
     */
    function westio_site_title_or_logo() {
        ob_start();
        the_custom_logo(); ?>
        <div class="site-branding-text">
            <?php if ( is_front_page() ) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                          rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"
                                         rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php endif; ?>

            <?php
            $description = get_bloginfo( 'description', 'display' );

            if ( $description || is_customize_preview() ) :
                ?>
                <p class="site-description"><?php echo esc_html( $description ); ?></p>
            <?php endif; ?>
        </div><!-- .site-branding-text -->
        <?php
        $html = ob_get_clean();

        return $html;
    }
}

if ( ! function_exists( 'westio_primary_navigation' ) ) {
    /**
     * Display Primary Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function westio_primary_navigation() {
        ?>
        <nav class="main-navigation" role="navigation"
             aria-label="<?php esc_attr_e( 'Primary Navigation', 'westio' ); ?>">
            <?php
            wp_nav_menu( apply_filters( 'westio_nav_menu_args', [
                'fallback_cb'     => '__return_empty_string',
                'theme_location'  => 'primary',
                'container_class' => 'primary-navigation',
                'link_before'     => '<span class="menu-title">',
                'link_after'      => '</span>'
            ] ) );
            ?>
        </nav>
        <?php
    }
}

if ( ! function_exists( 'westio_mobile_navigation' ) ) {
    /**
     * Display Handheld Navigation
     *
     * @return void
     * @since  1.0.0
     */
    function westio_mobile_navigation() {
        if ( isset( get_nav_menu_locations()['handheld'] ) || isset( get_nav_menu_locations()['vertical'] ) ): ?>
            <div class="mobile-nav-tabs">
                <ul>
                    <?php if ( isset( get_nav_menu_locations()['handheld'] ) ): ?>
                        <li class="mobile-tab-title mobile-pages-title active" data-menu="pages">
                            <span><?php echo esc_html( get_term( get_nav_menu_locations()['handheld'], 'nav_menu' )->name ); ?></span>
                        </li>
                    <?php endif; ?>
                    <?php if ( isset( get_nav_menu_locations()['vertical'] ) ) : ?>
                        <li class="mobile-tab-title mobile-categories-title" data-menu="categories">
                            <span><?php echo esc_html( get_term( get_nav_menu_locations()['vertical'], 'nav_menu' )->name ); ?></span>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
            <?php if ( isset( get_nav_menu_locations()['handheld'] ) ): ?>
                <nav class="mobile-menu-tab mobile-navigation mobile-pages-menu active"
                     aria-label="<?php esc_attr_e( 'Mobile Navigation', 'westio' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'handheld',
                            'container_class' => 'handheld-navigation',
                        )
                    );
                    ?>
                </nav>
            <?php endif; ?>
            <?php if ( isset( get_nav_menu_locations()['vertical'] ) ): ?>
                <nav class="mobile-menu-tab mobile-navigation-categories mobile-categories-menu"
                     aria-label="<?php esc_attr_e( 'Mobile Navigation', 'westio' ); ?>">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'vertical',
                            'container_class' => 'handheld-navigation',
                        )
                    );
                    ?>
                </nav>
            <?php endif; ?>
        <?php endif; ?>
        <?php
    }
}

if ( ! function_exists( 'westio_homepage_header' ) ) {
    /**
     * Display the page header without the featured image
     *
     * @since 1.0.0
     */
    function westio_homepage_header() {
        edit_post_link( esc_html__( 'Edit this section', 'westio' ), '', '', '', 'button westio-hero__button-edit' );
        ?>
        <header class="entry-header">
            <?php
            the_title( '<h1 class="entry-title">', '</h1>' );
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if ( ! function_exists( 'westio_page_header' ) ) {
    /**
     * Display the page header
     *
     * @since 1.0.0
     */
    function westio_page_header() {

        if ( is_front_page() || ! is_page_template( 'default' ) ) {
            return;
        }

        $post_id      = get_the_ID();
        $is_elementor = get_post_meta( $post_id, '_elementor_edit_mode', true );

        if ( $is_elementor === 'builder' ) {
            return;
        }

        ?>
        <header class="entry-header">
            <?php
            if ( has_post_thumbnail() ) {
                westio_post_thumbnail( 'full' );
            }
            the_title( '<h1 class="entry-title">', '</h1>' );
            ?>
        </header><!-- .entry-header -->
        <?php
    }
}

if ( ! function_exists( 'westio_page_content' ) ) {
    /**
     * Display the post content
     *
     * @since 1.0.0
     */
    function westio_page_content() {
        ?>
        <div class="entry-content">
            <?php the_content(); ?>
            <?php
            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'westio' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if ( ! function_exists( 'westio_post_wrapper_start' ) ) {
    function westio_post_wrapper_start() {
        echo '<div class="post-content-wrapper">';
    }
}

if ( ! function_exists( 'westio_post_wrapper_end' ) ) {
    function westio_post_wrapper_end() {
        echo '</div>';
    }
}

if ( ! function_exists( 'westio_post_header' ) ) {
    /**
     * Display the post header with a link to the single post
     *
     * @since 1.0.0
     */
    function westio_post_header() {
        ?>
        <header class="entry-header">
            <div class="entry-meta">
                <?php westio_post_meta( [
                    'show_cat'     => true,
                    'show_author'  => true,
                    'show_date'    => true,
                    'show_comment' => false
                ] ); ?>
            </div>
            <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
            <div class="entry-excerpt"><?php echo wp_trim_words( get_the_excerpt(), 999999 ); ?></div>
        </header><!-- .entry-header -->
        <?php
    }
}

if ( ! function_exists( 'westio_post_loop' ) ) {
    function westio_post_loop() {
        ?>
        <div class="entry-content">
            <div class="entry-meta">
                <?php westio_post_meta( [
                    'show_cat'     => true,
                    'show_author'  => true,
                    'show_date'    => true,
                    'show_comment' => false
                ] ); ?>
            </div>

            <?php the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' ); ?>

            <div class="excerpt-content"><?php echo wp_trim_words( get_the_excerpt() ); ?></div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_post_content' ) ) {
    /**
     * Display the post content with a link to the single post
     *
     * @since 1.0.0
     */
    function westio_post_content() {
        ?>
        <div class="entry-content">
            <?php

            /**
             * Functions hooked in to westio_post_content_before action.
             *
             */
            do_action( 'westio_post_content_before' );


            if ( is_single() ) {
                the_content(
                    sprintf(
                    /* translators: %s: post title */
                        esc_html__( 'Read More', 'westio' ) . ' %s',
                        '<span class="screen-reader-text">' . get_the_title() . '</span>'
                    )
                );
            }

            /**
             * Functions hooked in to westio_post_content_after action.
             *
             */
            do_action( 'westio_post_content_after' );

            wp_link_pages(
                array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'westio' ),
                    'after'  => '</div>',
                )
            );
            ?>
        </div><!-- .entry-content -->
        <?php
    }
}

if ( ! function_exists( 'westio_post_meta' ) ) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function westio_post_meta( $atts = array() ) {
        global $post;

        if ( get_post_type() !== 'post' ) {
            return;
        }

        $atts = shortcode_atts(
            array(
                'show_date'    => true,
                'show_cat'     => true,
                'show_author'  => true,
                'show_comment' => true,
            ),
            $atts
        );

        // Categories
        $categories = '';
        if ( $atts['show_cat'] ) {
            $categories_list = get_the_category_list( '' );
            if ( $categories_list ) {
                $categories = '<div class="categories-link"><div class="category">' . $categories_list . '</div></div>';
            }
        }

        // Meta items array
        $meta_items = array();

        // Date
        if ( $atts['show_date'] ) {
            $meta_items[] = '<div class="posted-on"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . get_the_date( 'j M, Y' ) . '</a></div>';
        }

        // Author
        if ( $atts['show_author'] ) {
            $author_id = $post->post_author;
            $meta_items[] = sprintf(
                '<div class="post-author"><span>'.esc_html('By ').' <a href="%1$s" class="url fn" rel="author">%2$s</a></span></div>',
                esc_url( get_author_posts_url( $author_id ) ),
                esc_html( get_the_author_meta( 'display_name', $author_id ) )
            );
        }

        // Comments
        if ( $atts['show_comment'] ) {
            ob_start();
            comments_popup_link(
                esc_html__( '0 comments', 'westio' ),
                esc_html__( '1 comment', 'westio' ),
                esc_html__( '% comments', 'westio' )
            );
            $meta_items[] = '<div class="meta-reply">' . ob_get_clean() . '</div>';
        }

        // Build meta group with separators
        $posted_comment = '';
        if ( ! empty( $meta_items ) ) {
            $posted_comment = '<div class="post-meta-group">' . implode( '<span class="meta-separator"></span>', $meta_items ) . '</div>';
        }

        echo wp_kses(
            $categories . $posted_comment,
            array(
                'div'  => array( 'class' => array() ),
                'span' => array( 'class' => array() ),
                'a'    => array( 'href' => array(), 'rel' => array(), 'class' => array(), 'style' => array() ),
                'time' => array( 'datetime' => array(), 'class' => array() ),
            )
        );
    }
}

if ( ! function_exists( 'westio_get_allowed_html' ) ) {
    function westio_get_allowed_html() {
        return apply_filters(
            'westio_allowed_html',
            array(
                'br'     => array(),
                'i'      => array(),
                'b'      => array(),
                'u'      => array(),
                'em'     => array(),
                'del'    => array(),
                'a'      => array(
                    'href'  => true,
                    'class' => true,
                    'title' => true,
                    'rel'   => true,
                ),
                'strong' => array(),
                'span'   => array(
                    'style' => true,
                    'class' => true,
                ),
            )
        );
    }
}

if ( ! function_exists( 'westio_edit_post_link' ) ) {
    /**
     * Display the edit link
     *
     * @since 2.5.0
     */
    function westio_edit_post_link() {
        edit_post_link(
            sprintf(
                wp_kses( __( 'Edit <span class="screen-reader-text">%s</span>', 'westio' ),
                    array(
                        'span' => array(
                            'class' => array(),
                        ),
                    )
                ),
                get_the_title()
            ),
            '<div class="edit-link">',
            '</div>'
        );
    }
}

if ( ! function_exists( 'westio_categories_link' ) ) {
    /**
     * Prints HTML with meta information for the current cateogries
     */
    function westio_categories_link() {

        // Get Categories for posts.
        $categories_list = get_the_category_list( '' );

        if ( 'post' === get_post_type() && $categories_list ) {
            // Make sure there's more than one category before displaying.
            echo '<div class="categories-link"><span class="screen-reader-text">' . esc_html__( 'Categories', 'westio' ) . '</span>' . $categories_list . '</div>';
        }
    }
}
if ( ! function_exists( 'westio_paging_nav' ) ) {
    /**
     * Display navigation to next/previous set of posts when applicable.
     */
    function westio_paging_nav() {
        global $wp_query;

        $args = array(
            'type'      => 'list',
            'next_text' => '<i class="westio-icon-angle-right"></i>',
            'prev_text' => '<i class="westio-icon-angle-left"></i>',
        );

        the_posts_pagination( $args );
    }
}

if ( ! function_exists( 'westio_post_nav' ) ) {
    /**
     * Display navigation to next/previous post when applicable.
     */
    function westio_post_nav() {

        $prev_post      = get_previous_post();
        $next_post      = get_next_post();
        $args           = [];
        $thumbnail_prev = '';
        $thumbnail_next = '';

        if ( $prev_post ) {
            $thumbnail_prev = get_the_post_thumbnail( $prev_post->ID, array( 90, 70 ) );
        };

        if ( $next_post ) {
            $thumbnail_next = get_the_post_thumbnail( $next_post->ID, array( 90, 70 ) );
        };
        if ( $next_post ) {
            $args['next_text'] = '<span class="nav-content"><span class="reader-text">' . esc_html__( 'Next post', 'westio' ) . ' </span><span class="title">%title</span></span>'.$thumbnail_next;
        }
        if ( $prev_post ) {
            $args['prev_text'] = $thumbnail_prev.'<span class="nav-content"><span class="reader-text">' . esc_html__( 'Previous post', 'westio' ) . ' </span><span class="title">%title</span></span> ';
        }

        the_post_navigation( $args );

    }
}

if ( ! function_exists( 'westio_get_sidebar' ) ) {
    /**
     * Display westio sidebar
     *
     * @uses get_sidebar()
     * @since 1.0.0
     */
    function westio_get_sidebar() {
        get_sidebar();
    }
}

if ( ! function_exists( 'westio_post_thumbnail' ) ) {
    /**
     * Display post thumbnail
     *
     * @param string $size the post thumbnail size.
     *
     * @uses has_post_thumbnail()
     * @uses the_post_thumbnail
     * @var $size . thumbnail|medium|large|full|$custom
     * @since 1.5.0
     */
    function westio_post_thumbnail( $size = 'post-thumbnail' ) {
        if ( has_post_thumbnail() ) : ?>
            <div class="post-thumbnail">
                <?php the_post_thumbnail( $size ? $size : 'post-thumbnail' ); ?>
            </div>
        <?php endif;
    }
}

if ( ! function_exists( 'westio_header_account' ) ) {
    function westio_header_account() {

        if ( ! westio_get_theme_option( 'show_header_account', true ) ) {
            return;
        }
        $account_link = wp_login_url();
        ?>
        <div class="site-header-account">
            <a href="<?php echo esc_url( $account_link ); ?>">
                <i class="westio-icon-user"></i>
            </a>
            <div class="account-dropdown"></div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_form_login' ) ) {
    function westio_form_login() {
        $register_link = wp_registration_url();
        ?>
        <div class="login-form-head">
            <span class="login-form-title"><?php esc_html_e( 'Sign in', 'westio' ) ?></span>
            <span class="pull-right">
                <a class="register-link" href="<?php echo esc_url( $register_link ); ?>"
                   title="<?php esc_attr_e( 'Register', 'westio' ); ?>"><?php esc_html_e( 'Create an Account', 'westio' ); ?></a>
            </span>
        </div>
        <form class="westio-login-form-ajax" data-toggle="validator">
            <p>
                <label><?php esc_html_e( 'Username or email', 'westio' ); ?> <span class="required">*</span></label>
                <input name="username" type="text" required placeholder="<?php esc_attr_e( 'Username', 'westio' ) ?>">
            </p>
            <p>
                <label><?php esc_html_e( 'Password', 'westio' ); ?> <span class="required">*</span></label>
                <input name="password" type="password" required
                       placeholder="<?php esc_attr_e( 'Password', 'westio' ) ?>">
            </p>
            <button type="submit" data-button-action
                    class="btn btn-primary btn-block w-100 mt-1"><?php esc_html_e( 'Login', 'westio' ) ?></button>
            <input type="hidden" name="action" value="westio_login">
            <?php wp_nonce_field( 'ajax-westio-login-nonce', 'security-login' ); ?>
        </form>
        <div class="login-form-bottom">
            <a href="<?php echo wp_lostpassword_url( get_permalink() ); ?>" class="lostpass-link"
               title="<?php esc_attr_e( 'Lost your password?', 'westio' ); ?>"><?php esc_html_e( 'Lost your password?', 'westio' ); ?></a>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_template_account_dropdown' ) ) {
    function westio_template_account_dropdown() {
        if ( ! westio_get_theme_option( 'show_header_account', true ) ) {
            return;
        }
        ?>
        <div class="account-wrap d-none">
            <div class="account-inner <?php if ( is_user_logged_in() ): echo "dashboard"; endif; ?>">
                <?php if ( ! is_user_logged_in() ) {
                    westio_form_login();
                } else {
                    westio_account_dropdown();
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_account_dropdown' ) ) {

    function westio_account_dropdown() { ?>
        <?php if ( has_nav_menu( 'my-account' ) ) : ?>
            <nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Dashboard', 'westio' ); ?>">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'my-account',
                    'menu_class'     => 'account-links-menu',
                    'depth'          => 1,
                ) );
                ?>
            </nav><!-- .social-navigation -->
        <?php else: ?>
            <ul class="account-dashboard">
                <li>
                    <a href="<?php echo esc_url( get_dashboard_url( get_current_user_id() ) ); ?>"
                       title="<?php esc_attr_e( 'Dashboard', 'westio' ); ?>"><?php esc_html_e( 'Dashboard', 'westio' ); ?></a>
                </li>
                <li>
                    <a title="<?php esc_attr_e( 'Log out', 'westio' ); ?>" class="tips"
                       href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>"><?php esc_html_e( 'Log Out', 'westio' ); ?></a>
                </li>
            </ul>
        <?php endif;
    }
}

if ( ! function_exists( 'westio_header_search_popup' ) ) {
    function westio_header_search_popup() {
        ?>
        <div class="site-search-popup">
            <div class="site-search-popup-wrap">
                <a href="#" class="site-search-popup-close">
                    <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="23.691" height="22.723" viewBox="0 0 23.691 22.723">
                        <g transform="translate(-126.154 -143.139)">
                            <line x2="23" y2="22" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="1"></line>
                            <path d="M0,22,23,0" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor" stroke-width="1"></path>
                        </g>
                    </svg>
                </a>
                <div class="site-search">
                    <?php get_search_form(); ?>
                </div>

            </div>
        </div>
        <div class="site-search-popup-overlay"></div>
        <?php
    }
}

if ( ! function_exists( 'westio_header_search_button' ) ) {
    function westio_header_search_button() {

        add_action( 'wp_footer', 'westio_header_search_popup', 1 );
        ?>
        <div class="site-header-search">
            <a href="#" class="button-search-popup">
                <i class="westio-icon-search-lg"></i>
            </a>
        </div>
        <?php
    }
}

if ( ! function_exists( 'westio_mobile_nav' ) ) {
    function westio_mobile_nav() {
        if ( isset( get_nav_menu_locations()['handheld'] ) ) {
            ?>
            <div class="westio-mobile-nav">
                <div class="menu-scroll-mobile">
                    <a href="#" class="mobile-nav-close"><i class="westio-icon-times"></i></a>
                    <?php
                    westio_mobile_navigation();
                    westio_social();
                    ?>
                </div>
                <?php if ( westio_is_elementor_activated() ) {
                    westio_language_switcher_mobile();
                } ?>
            </div>
            <div class="westio-overlay"></div>
            <?php
        }
    }
}

if ( ! function_exists( 'westio_mobile_nav_button' ) ) {
    function westio_mobile_nav_button() {
        if ( isset( get_nav_menu_locations()['handheld'] ) ) {
            ?>
            <a href="#" class="menu-mobile-nav-button">
                <span class="toggle-text screen-reader-text"><?php echo apply_filters( 'westio_menu_toggle_text', esc_html__( 'Menu', 'westio' ) ); ?></span>
                <div class="westio-icon">
                    <span class="icon-1"></span>
                    <span class="icon-2"></span>
                    <span class="icon-3"></span>
                </div>
            </a>
            <?php
        }
    }
}

if ( ! function_exists( 'westio_language_switcher' ) ) {
    function westio_language_switcher() {
        $languages = apply_filters( 'wpml_active_languages', [] );
        if ( westio_is_wpml_activated() && count( $languages ) > 0 ) {
            ?>
            <div class="westio-language-switcher">
                <ul class="menu">
                    <li class="item">
                        <div class="language-switcher-head">
                            <img src="<?php echo esc_url( $languages[ ICL_LANGUAGE_CODE ]['country_flag_url'] ) ?>"
                                 alt="<?php esc_attr( $languages[ ICL_LANGUAGE_CODE ]['default_locale'] ) ?>">
                            <span class="title"><?php echo esc_html( $languages[ ICL_LANGUAGE_CODE ]['translated_name'] ); ?></span>
                            <i aria-hidden="true" class="westio-icon-angle-down"></i>
                        </div>
                        <ul class="sub-item">
                            <?php
                            foreach ( $languages as $key => $language ) {
                                if ( ICL_LANGUAGE_CODE === $key ) {
                                    continue;
                                }
                                ?>
                                <li>
                                    <a href="<?php echo esc_url( $language['url'] ) ?>">
                                        <img width="18" height="12"
                                             src="<?php echo esc_url( $language['country_flag_url'] ) ?>"
                                             alt="<?php esc_attr( $language['default_locale'] ) ?>">
                                        <span><?php echo esc_html( $language['translated_name'] ); ?></span>
                                    </a>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php
        }
    }
}

if ( ! function_exists( 'westio_language_switcher_mobile' ) ) {
    function westio_language_switcher_mobile() {
        $languages = apply_filters( 'wpml_active_languages', [] );
        if ( westio_is_wpml_activated() && count( $languages ) > 0 ) { ?>
            <div class="westio-language-switcher-mobile">
                <ul class="menu">
                    <li class="item">
                        <div class="language-switcher-head">
                            <img src="<?php echo esc_url( $languages[ ICL_LANGUAGE_CODE ]['country_flag_url'] ) ?>"
                                 alt="<?php esc_attr( $languages[ ICL_LANGUAGE_CODE ]['default_locale'] ) ?>">
                        </div>
                    </li>
                    <?php foreach ( $languages as $key => $language ) {
                        if ( ICL_LANGUAGE_CODE === $key ) {
                            continue;
                        } ?>
                        <li class="item">
                            <div class="language-switcher-img">
                                <a href="<?php echo esc_url( $language['url'] ) ?>">
                                    <img src="<?php echo esc_url( $language['country_flag_url'] ) ?>"
                                         alt="<?php esc_attr( $language['default_locale'] ) ?>">
                                </a>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <?php
        }
    }
}

function westio_replace_categories_list( $output, $args ) {
    if ( $args['show_count'] == 1 ) {
        $pattern = '#<li([^>]*)><a([^>]*)>(.*?)<\/a>\s*\(([0-9]*)\)\s*#i';

        return preg_replace_callback(
            $pattern,
            function ( $matches ) {
                $count = (int) $matches[4] < 10 ? '0' . $matches[4] : $matches[4];

                return "<li{$matches[1]}><a{$matches[2]}><span class=\"cat-name\">{$matches[3]}</span> <span class=\"count cat-count\">({$count})</span></a>";
            },
            $output
        );
    }

    return $output;
}

add_filter( 'wp_list_categories', 'westio_replace_categories_list', 10, 2 );

function westio_replace_archive_list( $link_html, $url, $text, $format, $before, $after, $selected ) {
    if ( $format == 'html' ) {
        $pattern     = '#<li><a([^>]*)>(.*?)<\/a>&nbsp;\s*\(([0-9]*)\)\s*#i';  // removed ( and )
        $replacement = '<li><a$1><span class="archive-name">$2</span> <span class="count archive-count">($3)</span></a>';

        return preg_replace( $pattern, $replacement, $link_html );
    }

    return $link_html;
}

add_filter( 'get_archives_link', 'westio_replace_archive_list', 10, 7 );

if ( ! function_exists( 'westio_post_taxonomy' ) ) {
    /**
     * Display the post taxonomies
     *
     * @since 2.4.0
     */
    function westio_post_taxonomy() {
        /* translators: used between list items, there is a space after the comma */

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', '', '' );
        ?>
        <aside class="entry-tags">
            <?php if ( $tags_list ) : ?>
                <span class="tags-text"><?php echo esc_html(_n('Tags', 'Tags:', count(get_the_tags()), 'westio')); ?></span>
                <div class="tags-links">
                    <?php printf( '%s', $tags_list ); ?>
                </div>
            <?php endif; ?>
        </aside>
        <?php
    }
}

if ( ! function_exists( 'westio_update_comment_fields' ) ) {
    function westio_update_comment_fields( $fields ) {

        $commenter = wp_get_current_commenter();
        $req       = get_option( 'require_name_email' );
        $aria_req  = $req ? "aria-required='true'" : '';

        $fields['author']
            = '<p class="comment-form-author">
			<input id="author" name="author" type="text" placeholder="' . esc_attr__( 'Name *', 'westio' ) . '" value="' . esc_attr( $commenter['comment_author'] ) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['email']
            = '<p class="comment-form-email">
			<input id="email" name="email" type="email" placeholder="' . esc_attr__( 'Email *', 'westio' ) . '" value="' . esc_attr( $commenter['comment_author_email'] ) .
              '" size="30" ' . $aria_req . ' />
		</p>';

        $fields['url']
            = '<p class="comment-form-url">
			<input id="url" name="url" type="url"  placeholder="' . esc_attr__( 'Your Website', 'westio' ) . '" value="' . esc_attr( $commenter['comment_author_url'] ) .
              '" size="30" ' . $aria_req . ' />
			</p>';

        if (isset($fields['url']))
            unset($fields['url']);

        return $fields;
    }
}

add_filter( 'comment_form_default_fields', 'westio_update_comment_fields' );

if ( ! function_exists( 'westio_render_html_back_to_top' ) ) {
    function westio_render_html_back_to_top() {
        echo sprintf( '<a href="#" class="scrollup"><span class="scrollup-icon westio-icon-arrow-up"></span></a>' );
    }

    add_action( 'wp_footer', 'westio_render_html_back_to_top' );
}