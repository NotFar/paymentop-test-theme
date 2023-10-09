<?php

namespace inc;

class FormClass
{

    public string $post_type = 'theme_form';

    public string $form_field_name = 'theme_form_field_name';
    public string $form_field_type = 'theme_form_field_type';
    public string $form_field_required = 'theme_form_field_required';
    public string $form_field_sort = 'theme_form_field_sort';

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'form_block_fields' ) );
        add_action( 'save_post_' . $this->post_type, array( $this, 'form_block_fields_save' ) );
        add_action( 'admin_print_footer_scripts', array( $this, 'form_block_fields_assets' ), 10, 99 );
    }

    public function form_block_fields(): void
    {
        add_meta_box( 'form_fields', __('Theme form editor', 'paymentop-test-theme'), array( $this, 'form_fields_function' ), $this->post_type, 'normal', 'high');
    }

    public function form_fields_function( $post ): void
    {

        $form_group = get_post_meta($post->ID, 'theme_form_field_type_name', true);
        wp_nonce_field( 'theme_form_repeatable_meta_box_nonce', 'theme_form_repeatable_meta_box_nonce' );

        $select_fields = array(
            'field_text' => 'Text',
            'field_number' => 'Phone number',
            'field_email' => 'E-mail',
            'field_textarea' => 'Textarea',
            'field_checkbox' => 'Checkbox',
        );
        ?>
        <table id="repeatable-fieldset-form">
            <tbody>
            <?php
            if ( $form_group ) :
                foreach ( $form_group as $field ) {
                    ?>
                    <tr>
                        <td>
                            <p><?php echo __('Field type', 'paymentop-test-theme') ?></p>
                            <select name="<?php echo $this->form_field_type . '[]'; ?>">
                                <option value="">____</option>
                                <?php
                                foreach($select_fields as $key => $value) {
                                    echo '<option value="'. $key .'" ' . (($key == $field[$this->form_field_type]) ? 'selected="selected"' : "") . '>' . $value . '</option>';
                                }
                                ?>
                            </select>
                        </td>
                        <td>
                            <p><?php echo __('Field name', 'paymentop-test-theme') ?></p>
                            <input required type="text" name="<?php echo $this->form_field_name . '[]'; ?>" value="<?php if($field[$this->form_field_name] != '') echo esc_attr( $field[$this->form_field_name] ); ?>" />
                        </td>
                        <td>
                            <p><?php echo __('Field required?', 'paymentop-test-theme') ?></p>
                            <input type="checkbox" class="checkbox_required" <?php if($field[$this->form_field_required] == 'Yes') { echo 'checked'; } ?> />
                            <input type="hidden" class="checkbox_required_value" name="<?php echo $this->form_field_required . '[]'; ?>" value="<?php if($field[$this->form_field_required] == 'Yes') { echo 'Yes'; } else { echo 'No'; } ?>">
                        </td>
                        <td>
                            <p><?php echo __('Field sort(1,2,3 ....)', 'paymentop-test-theme') ?></p>
                            <input type="number" name="<?php echo $this->form_field_sort . '[]'; ?>" value="<?php if($field[$this->form_field_sort] != '') echo $field[$this->form_field_sort]; ?>" min="1" max="20"/>
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
                        <p><?php echo __('Field type', 'paymentop-test-theme') ?></p>
                        <select name="<?php echo $this->form_field_type . '[]'; ?>">
                            <option value="">____</option>
                            <?php
                            foreach($select_fields as $key => $value) {
                                echo '<option value="'. $key .'">' . $value . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <p><?php echo __('Field name', 'paymentop-test-theme') ?></p>
                        <input type="text" name="<?php echo $this->form_field_name. '[]'; ?>" />
                    </td>
                    <td>
                        <p><?php echo __('Field required?', 'paymentop-test-theme') ?></p>
                        <input type="checkbox" class="checkbox_required"/>
                        <input type="hidden" class="checkbox_required_value" name="<?php echo $this->form_field_required . '[]'; ?>" value="No">
                    </td>
                    <td>
                        <p><?php echo __('Field sort(1,2,3 ....)', 'paymentop-test-theme') ?></p>
                        <input type="number" name="<?php echo $this->form_field_sort . '[]'; ?>" min="1" max="20"/>
                    </td>
                    <td>
                        <a class="button  cmb-remove-row-button button-disabled" href="#"><?php echo __('Remove', 'paymentop-test-theme') ?></a>
                    </td>
                </tr>
            <?php endif; ?>

            <!-- empty hidden -->
            <tr class="empty-row screen-reader-text">
                <td>
                    <p><?php echo __('Field type', 'paymentop-test-theme') ?></p>
                    <select name="<?php echo $this->form_field_type . '[]'; ?>">
                        <option value="">____</option>
                        <?php
                        foreach($select_fields as $key => $value) {
                            echo '<option value="'. $key .'">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <p><?php echo __('Field name', 'paymentop-test-theme') ?></p>
                    <input type="text" name="<?php echo $this->form_field_name. '[]'; ?>"/>
                </td>
                <td>
                    <p><?php echo __('Field required?', 'paymentop-test-theme') ?></p>
                    <input type="checkbox" class="checkbox_required"/>
                    <input type="hidden" class="checkbox_required_value" name="<?php echo $this->form_field_required . '[]'; ?>" value="No">
                </td>
                <td>
                    <p><?php echo __('Field sort(1,2,3 ....)', 'paymentop-test-theme') ?></p>
                    <input type="number" name="<?php echo $this->form_field_sort . '[]'; ?>" min="1" max="20"/>
                </td>
                <td>
                    <a class="button remove-row" href="#"><?php echo __('Remove', 'paymentop-test-theme') ?></a>
                </td>
            </tr>
            </tbody>
        </table>
        <p><a id="add-row" class="button" href="#"><?php echo __('Add field', 'paymentop-test-theme') ?></a></p>
        <?php
    }

    public function form_block_fields_save( $post_id ): void
    {

        if ( ! isset( $_POST['theme_form_repeatable_meta_box_nonce'] ) ||
            ! wp_verify_nonce( $_POST['theme_form_repeatable_meta_box_nonce'], 'theme_form_repeatable_meta_box_nonce' ) )
            return;

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;

        if (!current_user_can('edit_post', $post_id))
            return;

        $empty = get_post_meta($post_id, 'theme_form_field_type_name', true);
        $completed = array();
        $field_type = $_POST[$this->form_field_type];
        $field_name = $_POST[$this->form_field_name];
        $field_required = $_POST[$this->form_field_required];
        $field_sort = $_POST[$this->form_field_sort];
        $count = count( $field_type );
        for ( $i = 0; $i < $count; $i++ ) {
            if ( $field_type[$i] != '' ) :
                $completed[$i][$this->form_field_type] = $field_type[$i];
                $completed[$i][$this->form_field_name] = stripslashes( $field_name[$i] );
                $completed[$i][$this->form_field_required] = $field_required[$i];
                $completed[$i][$this->form_field_sort] = $field_sort[$i];
            endif;
        }
        if ( !empty( $completed ) && $completed != $empty )
            update_post_meta( $post_id, 'theme_form_field_type_name', $completed );
        elseif ( empty($completed) && $empty )
            delete_post_meta( $post_id, 'theme_form_field_type_name', $empty );
    }

    public function form_block_fields_assets(): void
    {
        if ( is_admin() && get_current_screen()->id == $this->post_type ) {
            $this->form_block_fields_styles();
            $this->form_block_fields_scripts();
        }
    }

    public function form_block_fields_styles() {
        ?>
        <style>
            #repeatable-fieldset-form {
                width: 100%;
            }
            #repeatable-fieldset-form tr {
                display: flex;
                flex-direction: row;
                justify-content: space-between;
                gap: 20px;
                padding: 0px 20px 20px 20px;
            }
            #repeatable-fieldset-form tbody tr:nth-child(odd) {
                background: rgb(204 204 204 / 40%);
            }
            #repeatable-fieldset-form td {
                display: flex;
                flex-direction: column;
                justify-content: end;
            }
            #repeatable-fieldset-form tr td:nth-child(1) {
                width: 14%;
            }
            #repeatable-fieldset-form tr td:nth-child(2) {
                width: 46%;
            }
            #repeatable-fieldset-form tr td:nth-child(3) {
                align-items: center;
            }
            #repeatable-fieldset-form tr td:nth-child(3) p {
                position: relative;
                top: -14px;
            }
            #repeatable-fieldset-form p {
                margin-bottom: 5px;
                font-size: 14px;
                font-weight: 500;
            }
            #repeatable-fieldset-form input, table#repeatable-fieldset-form textarea {
                width: 100%;
            }
            #repeatable-fieldset-form .checkbox_required {
                width: 17px;
                position: relative;
                top: -7px;
            }
            #repeatable-fieldset-form .remove-row {
                float: right;
            }
        </style>
        <?php
    }

    public function form_block_fields_scripts() {
        ?>
        <script>
            jQuery(document).ready(function($){
                $('#add-row').on('click', function() {
                    var row = $('.empty-row.screen-reader-text').clone(true);
                    row.removeClass('empty-row screen-reader-text');
                    row.insertBefore('#repeatable-fieldset-form tbody>tr:last');
                    return false;
                });

                $('.remove-row').on('click', function() {
                    $(this).parents('tr').remove();
                    return false;
                });

                /*
                checkbox required
                 */
                $(document).on('change', '#repeatable-fieldset-form tr .checkbox_required', function() {
                    if($(this).is(':checked')) {
                        $(this).closest('tr').find('.checkbox_required_value').val('Yes')
                    } else {
                        $(this).closest('tr').find('.checkbox_required_value').val('No')
                    }
                });
            });
        </script>
        <?php
    }

}