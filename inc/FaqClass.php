<?php

namespace inc;

class FaqClass
{

    public string $post_type = 'theme_faq';

    public string $theme_question = 'theme_faq_question';
    public string $theme_answer = 'theme_faq_answer';

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'faq_block_fields' ) );
        add_action( 'save_post_' . $this->post_type, array( $this, 'faq_block_fields_save' ) );
        add_action( 'admin_print_footer_scripts', array( $this, 'faq_block_fields_assets' ), 10, 99 );
    }

    public function faq_block_fields(): void
    {
        add_meta_box( 'faq_fields', __('FAQ Block', 'paymentop-test-theme'), array( $this, 'faq_fields_function' ), $this->post_type, 'normal', 'high');
    }

    public function faq_fields_function( $post ): void
    {

        $faq_group = get_post_meta($post->ID, 'theme_faq_answer_question', true);
        wp_nonce_field( 'theme_faq_repeatable_meta_box_nonce', 'theme_faq_repeatable_meta_box_nonce' );
        ?>
        <table id="repeatable-fieldset-faq">
            <tbody>
            <?php
            if ( $faq_group ) :
                foreach ( $faq_group as $field ) {
                    ?>
                    <tr>
                        <td>
                            <p><?php echo __('Question', 'paymentop-test-theme') ?></p>
                            <input type="text" name="<?php echo $this->theme_question . '[]'; ?>" value="<?php if($field[$this->theme_question] != '') echo esc_attr( $field[$this->theme_question] ); ?>" />
                        </td>
                        <td>
                            <p><?php echo __('Answer', 'paymentop-test-theme') ?></p>
                            <textarea rows="5" name="<?php echo $this->theme_answer . '[]'; ?>"><?php if ($field[$this->theme_answer] != '') echo esc_attr( $field[$this->theme_answer] ); ?></textarea>
                        </td>
                        <td>
                            <a class="button remove-row" href="#1"><?php echo __('Remove', 'paymentop-test-theme') ?></a>
                        </td>
                    </tr>
                    <?php
                }
            else :
                ?>
                <tr>
                    <td>
                        <p><?php echo __('Question', 'paymentop-test-theme') ?></p>
                        <input type="text" name="<?php echo $this->theme_question. '[]'; ?>" />
                    </td>
                    <td>
                        <p><?php echo __('Answer', 'paymentop-test-theme') ?></p>
                        <textarea name="<?php echo $this->theme_answer . '[]'; ?>" rows="5"></textarea>
                    </td>
                    <td>
                        <a class="button  cmb-remove-row-button button-disabled" href="#"><?php echo __('Remove', 'paymentop-test-theme') ?></a>
                    </td>
                </tr>
            <?php endif; ?>

            <!-- empty hidden -->
            <tr class="empty-row screen-reader-text">
                <td>
                    <p><?php echo __('Question', 'paymentop-test-theme') ?></p>
                    <input type="text" name="<?php echo $this->theme_question. '[]'; ?>"/>
                </td>
                <td>
                    <p><?php echo __('Answer', 'paymentop-test-theme') ?></p>
                    <textarea rows="5" name="<?php echo $this->theme_answer . '[]'; ?>"></textarea>
                </td>
                <td>
                    <a class="button remove-row" href="#"><?php echo __('Remove', 'paymentop-test-theme') ?></a>
                </td>
            </tr>
            </tbody>
        </table>
        <p><a id="add-row" class="button" href="#"><?php echo __('Add another', 'paymentop-test-theme') ?></a></p>
        <?php
    }

    public function faq_block_fields_save( $post_id ): void
    {

        if ( ! isset( $_POST['theme_faq_repeatable_meta_box_nonce'] ) ||
            ! wp_verify_nonce( $_POST['theme_faq_repeatable_meta_box_nonce'], 'theme_faq_repeatable_meta_box_nonce' ) )
            return;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!current_user_can('edit_post', $post_id))
            return;

        $empty = get_post_meta($post_id, 'theme_faq_answer_question', true);
        $completed = array();
        $field_question = $_POST[$this->theme_question];
        $field_answer = $_POST[$this->theme_answer];
        $count = count( $field_question );
        for ( $i = 0; $i < $count; $i++ ) {
            if ( $field_question[$i] != '' ) :
                $completed[$i][$this->theme_question] = stripslashes( strip_tags( $field_question[$i] ) );
                $completed[$i][$this->theme_answer] = stripslashes( $field_answer[$i] );
            endif;
        }
        if ( !empty( $completed ) && $completed != $empty )
            update_post_meta( $post_id, 'theme_faq_answer_question', $completed );
        elseif ( empty($completed) && $empty )
            delete_post_meta( $post_id, 'theme_faq_answer_question', $empty );
    }

    public function faq_block_fields_assets(): void
    {
        if ( is_admin() && get_current_screen()->id == $this->post_type ) {
            $this->faq_block_fields_styles();
            $this->faq_block_fields_scripts();
        }
    }

    public function faq_block_fields_styles() {
        ?>
        <style>
            #repeatable-fieldset-faq {
                width: 100%;
            }
            #repeatable-fieldset-faq tbody tr:nth-child(odd) {
                background: rgb(204 204 204 / 40%);
            }
            #repeatable-fieldset-faq tr {
                display: flex;
                flex-direction: column;
                padding: 0px 20px 20px 20px;
            }
            #repeatable-fieldset-faq p {
                margin-bottom: 5px;
                font-size: 14px;
                font-weight: 500;
            }
            #repeatable-fieldset-faq input, table#repeatable-fieldset-faq textarea {
                width: 100%;
            }
            #repeatable-fieldset-faq .remove-row {
                float: right;
            }
        </style>
        <?php
    }

    public function faq_block_fields_scripts() {
        ?>
        <script>
            jQuery(document).ready(function($){
                $('#add-row').on('click', function() {
                    var row = $('.empty-row.screen-reader-text').clone(true);
                    row.removeClass('empty-row screen-reader-text');
                    row.insertBefore('#repeatable-fieldset-faq tbody>tr:last');
                    return false;
                });

                $('.remove-row').on('click', function() {
                    $(this).parents('tr').remove();
                    return false;
                });
            });
        </script>
        <?php
    }

}