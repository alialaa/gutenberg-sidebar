<?php

function myprefix_register_meta() {
    register_meta('post', '_myprefix_text_metafield', array(
        'show_in_rest' => true,
        'type' => 'string',
        'single' => true,
        'sanitize_callback' => 'sanitize_text_field',
        'auth_callback' => function() { 
            return current_user_can('edit_posts');
        }
    ));
}
add_action('init', 'myprefix_register_meta');

function myprefix_add_meta_box() {
    add_meta_box( 
        'myprefix_post_options_metabox', 
        'Post Options', 
        'myprefix_post_options_metabox_html', 
        'post', 
        'normal', 
        'default',
        array('__back_compat_meta_box' => true)
    );
}

add_action( 'add_meta_boxes', 'myprefix_add_meta_box' );

function myprefix_post_options_metabox_html($post) {
    $field_value = get_post_meta($post->ID, '_myprefix_text_metafield', true);
    wp_nonce_field( 'myprefix_update_post_metabox', 'myprefix_update_post_nonce' );
    ?>
    <p>
        <label for="myprefix_text_metafield"><?php esc_html_e( 'Text Custom Field', 'textdomain' ); ?></label>
        <br />
        <input class="widefat" type="text" name="myprefix_text_metafield" id="myprefix_text_metafield" value="<?php echo esc_attr( $field_value ); ?>" />
    </p>
    <?php
}

function myprefix_save_post_metabox($post_id, $post) {

    $edit_cap = get_post_type_object( $post->post_type )->cap->edit_post;
    if( !current_user_can( $edit_cap, $post_id )) {
        return;
    }
    if( !isset( $_POST['myprefix_update_post_nonce']) || !wp_verify_nonce( $_POST['myprefix_update_post_nonce'], 'myprefix_update_post_metabox' )) {
        return;
    }

    if(array_key_exists('myprefix_text_metafield', $_POST)) {
        update_post_meta( 
            $post_id, 
            '_myprefix_text_metafield', 
            sanitize_text_field($_POST['myprefix_text_metafield'])
        );
    }

}

add_action( 'save_post', 'myprefix_save_post_metabox', 10, 2 );