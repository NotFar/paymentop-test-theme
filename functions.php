<?php

use inc\FaqClass;

/**
 * Functions and definitions
 */

/*
 * Add theme script and style
 */
function theme_scripts_style(): void
{

    wp_register_style('app', get_template_directory_uri() . '/dist/app.css', [], 1, 'all');
    wp_enqueue_style('app');

    wp_enqueue_script('jquery');

    wp_register_script('app', get_template_directory_uri() . '/dist/app.js', ['jquery'], 1, true);
    wp_enqueue_script('app');

}
add_action( 'wp_enqueue_scripts', 'theme_scripts_style' );

/*
 *  Add theme support languages, tag, thumbnail, menu, logo, widgets
 */
function paymentop_test_theme_setup(): void
{

    load_theme_textdomain( 'paymentop-test-theme', get_template_directory() . '/languages' );

    add_theme_support( 'title-tag' );

    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'header_nav' => 'Header',
            'footer_nav_1' => 'Footer 1',
            'footer_nav_2' => 'Footer 2',
            'footer_nav_3' => 'Footer 3',
            'footer_nav_4' => 'Footer 4',
        )
    );

    add_theme_support( 'widgets' );

    add_theme_support( 'custom-logo', [
        'height'      => 190,
        'width'       => 190,
        'flex-width'  => false,
        'flex-height' => false,
        'header-text' => '',
    ] );

}

add_action( 'after_setup_theme', 'paymentop_test_theme_setup' );

/*
 * Register post type theme_faq and theme_form
 */
add_action( 'init', 'register_post_types' );

function register_post_types(): void
{

    register_post_type( 'theme_faq', [
        'label'  => null,
        'labels' => [
            'name'               => __('FAQs', 'paymentop-test-theme'),
            'singular_name'      => __('FAQ', 'paymentop-test-theme'),
            'add_new'            => __('Add FAQ', 'paymentop-test-theme'),
            'add_new_item'       => __('Addition FAQ', 'paymentop-test-theme'),
            'edit_item'          => __('Editing FAQ', 'paymentop-test-theme'),
            'new_item'           => __('New FAQ', 'paymentop-test-theme'),
            'view_item'          => __('View FAQ', 'paymentop-test-theme'),
            'search_items'       => __('Searching FAQ', 'paymentop-test-theme'),
            'not_found'          => __('Not found', 'paymentop-test-theme'),
            'not_found_in_trash' => __('Not found in the cart', 'paymentop-test-theme'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Theme FAQs', 'paymentop-test-theme'),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'menu_position'       => 26,
        'menu_icon'           => 'dashicons-book',
        'hierarchical'        => false,
        'supports'            => [ 'title', 'revisions'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

    register_post_type( 'theme_form', [
        'label'  => null,
        'labels' => [
            'name'               => __('Forms', 'paymentop-test-theme'),
            'singular_name'      => __('Form', 'paymentop-test-theme'),
            'add_new'            => __('Add Form', 'paymentop-test-theme'),
            'add_new_item'       => __('Addition Form', 'paymentop-test-theme'),
            'edit_item'          => __('Editing Form', 'paymentop-test-theme'),
            'new_item'           => __('New Form', 'paymentop-test-theme'),
            'view_item'          => __('View Form', 'paymentop-test-theme'),
            'search_items'       => __('Searching Form', 'paymentop-test-theme'),
            'not_found'          => __('Not found', 'paymentop-test-theme'),
            'not_found_in_trash' => __('Not found in the cart', 'paymentop-test-theme'),
            'parent_item_colon'  => '',
            'menu_name'          => __('Theme Forms', 'paymentop-test-theme'),
        ],
        'description'         => '',
        'public'              => true,
        'publicly_queryable'  => false,
        'exclude_from_search' => true,
        'show_ui'             => true,
        'show_in_nav_menus'   => false,
        'show_in_menu'        => true,
        'show_in_admin_bar'   => true,
        'show_in_rest'        => true,
        'rest_base'           => null,
        'menu_position'       => 27,
        'menu_icon'           => 'dashicons-forms',
        'hierarchical'        => false,
        'supports'            => [ 'title', 'revisions'],
        'taxonomies'          => [],
        'has_archive'         => false,
        'rewrite'             => true,
        'query_var'           => true,
    ] );

}

/*
 * Messages for FAQs
 */
add_filter( 'post_updated_messages', 'faqs_messages' );

function faqs_messages( $messages ) {

    global $post;

    $messages[ 'theme_faq' ] = array(
        0 => '',
        1 => __('FAQ updated.', 'paymentop-test-theme'),
        2 => __('Field modified.', 'paymentop-test-theme'),
        3 => __('Field deleted.', 'paymentop-test-theme'),
        4 => __('FAQ updated.', 'paymentop-test-theme'),
        5 => isset( $_GET[ 'revision' ] ) ? sprintf( 'FAQ restored from revision: %s', wp_post_revision_title( (int) $_GET[ 'revision' ], false ) ) : false,
        6 => __('FAQ added.', 'paymentop-test-theme'),
        7 => __('FAQ saved.', 'paymentop-test-theme'),
        8 => __('FAQ sent for verification', 'paymentop-test-theme'),
        9 => sprintf( 'FAQ is scheduled for publication on <strong>%1$s</strong>.', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
        10 => __('The draft FAQ has been saved', 'paymentop-test-theme'),
    );

    return $messages;

}

/*
 * Messages for Forms
 */
add_filter( 'post_updated_messages', 'forms_messages' );

function forms_messages( $messages ) {

    global $post;

    $messages[ 'theme_form' ] = array(
        0 => '',
        1 => __('Form updated.', 'paymentop-test-theme'),
        2 => __('Field modified.', 'paymentop-test-theme'),
        3 => __('Field deleted.', 'paymentop-test-theme'),
        4 => __('Form updated.', 'paymentop-test-theme'),
        5 => isset( $_GET[ 'revision' ] ) ? sprintf( 'Form restored from revision: %s', wp_post_revision_title( (int) $_GET[ 'revision' ], false ) ) : false,
        6 => __('Form added.', 'paymentop-test-theme'),
        7 => __('Form saved.', 'paymentop-test-theme'),
        8 => __('Form sent for verification', 'paymentop-test-theme'),
        9 => sprintf( 'Form is scheduled for publication on <strong>%1$s</strong>.', date_i18n( __( 'M j, Y @ G:i' ), strtotime( $post->post_date ) ) ),
        10 => __('The draft Form has been saved', 'paymentop-test-theme'),
    );

    return $messages;

}

/*
 * Add shortcode to table FAQs
 */
add_filter( 'manage_edit-theme_faq_columns', 'shortcode_faqs_columns', 25 );

function shortcode_faqs_columns( $columns ) {

    $faq_shortcode = array( 'faq_shortcode' => __('Shortcode', 'paymentop-test-theme') );
    $columns = array_slice( $columns, 0, 2, true ) + $faq_shortcode + array_slice( $columns, 2, NULL, true );

    return $columns;

}

/*
 * Show faq shortcode name
 */
add_action( 'manage_posts_custom_column', 'show_shortcode_faq_columns', 25 );

function show_shortcode_faq_columns( $column ): void
{

    switch ( $column ) {
        case 'faq_shortcode': {
            global $post;
                echo '<input onfocus="this.select()" style="border:none;outline:none;background:none" readonly="readonly" type="text" value="' . esc_html( '[theme_faq id="' . $post->ID . '"]') . '">';
                break;
        }
    }

}

/*
 * Add author to table FAQs
 */
add_filter( 'manage_edit-theme_faq_columns', 'shortcode_faqs_column_author', 25 );

function shortcode_faqs_column_author( $columns ) {

    $faq_author = array( 'faq_author' => __('Author', 'paymentop-test-theme') );
    $columns = array_slice( $columns, 0, 2, true ) + $faq_author + array_slice( $columns, 2, NULL, true );

    return $columns;

}

/*
 * Show faq author name
 */
add_action( 'manage_posts_custom_column', 'show_author_faq_columns', 25 );

function show_author_faq_columns( $column ): void
{

    switch ( $column ) {
        case 'faq_author': {
            global $post;
            $author_id = $post->post_author;
                echo get_the_author_meta( 'display_name', $author_id );
                break;
        }
    }

}

/*
 * FORMS
 */

/*
 * Add shortcode to table Forms
 */
add_filter( 'manage_edit-theme_form_columns', 'shortcode_forms_columns', 25 );

function shortcode_forms_columns( $columns ) {

    $form_shortcode = array( 'form_shortcode' => __('Shortcode', 'paymentop-test-theme') );
    $columns = array_slice( $columns, 0, 2, true ) + $form_shortcode + array_slice( $columns, 2, NULL, true );

    return $columns;

}

/*
 * Show form shortcode name
 */
add_action( 'manage_posts_custom_column', 'show_shortcode_form_columns', 25 );

function show_shortcode_form_columns( $column ): void
{

    switch ( $column ) {
        case 'form_shortcode': {
            global $post;
                echo '<input onfocus="this.select()" style="border:none;outline:none;background:none" readonly="readonly" type="text" value="' . esc_html( '[theme_form id="' . $post->ID . '"]') . '">';
                break;
        }
    }

}

/*
 * Add author to table Forms
 */
add_filter( 'manage_edit-theme_form_columns', 'shortcode_forms_column_author', 25 );

function shortcode_forms_column_author( $columns ) {

    $form_author = array( 'form_author' => __('Author', 'paymentop-test-theme') );
    $columns = array_slice( $columns, 0, 2, true ) + $form_author + array_slice( $columns, 2, NULL, true );

    return $columns;

}

/*
 * Show form author name
 */
add_action( 'manage_posts_custom_column', 'show_author_form_columns', 25 );

function show_author_form_columns( $column ): void
{

    switch ( $column ) {
        case 'form_author': {
            global $post;
            $author_id = $post->post_author;
                echo get_the_author_meta( 'display_name', $author_id );
                break;
        }
    }

}

/*
 * Create FAQ shortcode
 */
function theme_faq_shortcode( $atts ): string
{

    $post_id = $atts['id'];

    $post = get_posts( [
        'post_type' => 'theme_faq',
        'include' => $post_id,
    ]);

    if(!$post) {
        return false;
    }

    $faq_group = get_post_meta( $post_id, 'theme_faq_answer_question', true );

    if ( $faq_group ) :
        $shortcode = '<div class="theme-faq-accordion-blocks">';
            $shortcode .= '<div class="theme-faq-column">';
                foreach ( $faq_group as $field ) {
                    $question = $field['theme_faq_question'];
                    $answer = $field['theme_faq_answer'];
                    $shortcode .= '<div class="theme-faq-accordion-block">';
                        $shortcode .= '<div class="theme-faq-accordion-title">';
                            $shortcode .= '<p>' . $question . '</p>';
                            $shortcode .= '<div>';
                                $shortcode .= '<span class="active"></span>';
                                $shortcode .= '<span></span>';
                            $shortcode .= '</div>';
                        $shortcode .= '</div>';
                        $shortcode .= ' <div class="theme-faq-accordion-deck">';
                            $shortcode .= '<p>' . $answer . '</p>';
                        $shortcode .= '</div>';
                    $shortcode .= '</div>';
                }
            $shortcode .= '</div>';
        $shortcode .= '</div>';
    endif;
    return $shortcode;

}

add_shortcode( 'theme_faq', 'theme_faq_shortcode' );

/*
 * Create Form shortcode
 */
function theme_form_shortcode( $atts ): string
{
    $post_id = $atts['id'];

    $post = get_posts( [
        'post_type' => 'theme_form',
        'include' => $post_id,
    ]);

    if(!$post) {
        return false;
    }

    $form_group = get_post_meta( $post_id, 'theme_form_field_type_name', true );

    if ( $form_group ) :
        usort($form_group, fn($a, $b) => $a['theme_form_field_sort'] <=> $b['theme_form_field_sort']);
        $shortcode = '<div class="theme-form-section">';
            $shortcode .= '<form class="theme-form" method="post">';
                $shortcode .= '<input type="hidden" name="form_id" value="' . $post_id . '">';
                foreach ( $form_group as $field ) {
                    $form_type = $field['theme_form_field_type'];
                    $form_name = $field['theme_form_field_name'];
                    $form_required = $field['theme_form_field_required'];

                    $shortcode .= '<div class="theme-form-group">';
                        $shortcode .= '<label ' . (($form_type == 'field_checkbox') ? 'class="form_field_checkbox"' : "") . ' ' . (($form_type == 'field_email') ? 'class="form_field_email"' : "") . '>';
                        $shortcode .= '<p>' . $form_name . '</p>';
                        switch ( $form_type ) {
                            case 'field_text':
                                $shortcode .= '<input type="text" name="' . $form_name . '" class="form_field_text theme_form_field_text ' . (($form_required == 'Yes') ? 'field_required' : "") . '" ' . (($form_required == 'Yes') ? 'required' : "") . '>';
                                break;
                            case 'field_email':
                                $shortcode .= '<input type="text" name="' . $form_name . '" class="form_field_text theme_form_field_email ' . (($form_required == 'Yes') ? 'field_required' : "") . '" ' . (($form_required == 'Yes') ? 'required' : "") . '><span class="email_validation"></span>';
                                break;
                            case 'field_number':
                                $shortcode .= '<input type="text" name="' . $form_name . '" class="form_field_text theme_form_field_phone ' . (($form_required == 'Yes') ? 'field_required' : "") . '" ' . (($form_required == 'Yes') ? 'required' : "") . '>';
                                break;
                            case 'field_textarea':
                                $shortcode .= '<textarea name="' . $form_name . '" class="form_field_text theme_form_field_textarea ' . (($form_required == 'Yes') ? 'field_required' : "") . '" ' . (($form_required == 'Yes') ? 'required' : "") . '></textarea>';
                                break;
                            case 'field_checkbox':
                                $shortcode .= '<input type="checkbox" name="' . $form_name . '" class="theme_form_field_checkbox ' . (($form_required == 'Yes') ? 'field_required' : "") . '" ' . (($form_required == 'Yes') ? 'required' : "") . '>';
                                break;
                        }
                        $shortcode .= '</label>';
                    $shortcode .= '</div>';
                }
                $shortcode .= '<input type="submit" class="theme-form-submit" value="' . __('Send', 'paymentop-test-theme') . '">';
            $shortcode .= '</form>';
            $shortcode .= '<div class="theme-form-response"></div>';
        $shortcode .= '</div>';
    endif;
    return $shortcode;

}

add_shortcode( 'theme_form', 'theme_form_shortcode' );

/*
 * Theme form ajax url and nonce
 */
add_action('wp_enqueue_scripts', 'send_theme_form_localize_ajax');

function send_theme_form_localize_ajax(): void
{

    wp_localize_script('jquery', 'ajax', array(
        'url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('send_theme_form_ajax_nonce'),
    ));

}

/*
 * Send theme form function
 */
add_action('wp_ajax_send_theme_form', 'send_theme_form');
add_action('wp_ajax_nopriv_send_theme_form', 'send_theme_form');

function send_theme_form(): void
{

    if ( !wp_verify_nonce($_POST['nonce'], 'send_theme_form_ajax_nonce') ) {
        die('Permission Denied.');
    }

    $data_form = $_POST['data'];
    $data_form = explode("&", $data_form);

    $post_id = '';
    foreach ( $data_form as $key => $value ) {
        $field_key = stristr($value, '=', true);

        $field_value = stristr($value, '=');
        $field_value = str_replace('=', '', $field_value);
        if($field_key == 'form_id') {
            $post_id = $field_value;
        }
    }

    $form_title = get_the_title($post_id);

    $admin_email = get_option('admin_email');

    $subject = $form_title;
    $headers = array(
        'From: ' . $form_title . ' <' . $admin_email . '>',
        'content-type: text/html; charset=UTF-8',
    );

    $message = '';
    foreach ( $data_form as $key => $value ) {
        $field_key = stristr($value, '=', true);
        $field_value = stristr($value, '=');
        $field_value = str_replace('=', '', $field_value);
        if($field_key != 'form_id')
        $message .= esc_html($field_key) . ' = ' . esc_html($field_value) .  "<br>";
    }

    $mailResult = wp_mail( $admin_email, $subject, $message, $headers );
    if($mailResult) {
        echo __('The email has been sent!', 'paymentop-test-theme');
    } else {
        echo __('Something went wrong!', 'paymentop-test-theme');
    }

    wp_die();

}

/*
 * Enable FAQ section in post type theme_faq
 */
$faqFile = get_template_directory() . '/inc/FaqClass.php';
if (file_exists($faqFile)) {
    require_once $faqFile;
    if (!class_exists('FaqClass')) {
        $FaqClass = new FaqClass();
    }
}

/*
 * Enable Forms section in post type theme_form
 */
$formFile = get_template_directory() . '/inc/FormClass.php';
if (file_exists($formFile)) {
    require_once $formFile;
    if (!class_exists('FormClass')) {
        $FaqClass = new \inc\FormClass();
    }
}