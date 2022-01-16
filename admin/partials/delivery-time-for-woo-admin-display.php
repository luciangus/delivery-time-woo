<?php

/**
 * Provide a admin area view for the plugin
 *
 * @since      1.0.0
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/admin/partials
 */
?>


<div>
    <div class = "delivery-time-woo-heading-container">
        <h1 class = "delivery-time-woo-heading" >General settings</h1>
    </div>

    <?php if( !empty( $saved ) ) { ?>
        <div class="delivery-time-woo-saved-heading">
            <span class="delivery-time-woo-saved-text">Settings Saved Successfully.</span>
        </div>    
    <?php } ?>


    <form action="<?php echo esc_attr( admin_url('admin-post.php') ); ?>" method="POST">
        <input type="hidden" name="action" value="save_delivery_time_for_woo_settings" />
        
        <div class="delivery-time-woo-white-box">
            <p class="delivery-time-woo-form-field">
                <label class="delivery-time-woo-admin-label" for="delivery_time_woo_delivery_time">
                    Delivery time
                </label>
                <input type="number" name="dtf_delivery_time" id="dtf_delivery_time"  value="<?php echo $dtf_delivery_time; ?>" min="0">                      
            </p>

            <p class="delivery-time-woo-form-field">
                <label class="delivery-time-woo-admin-label" for="delivery_time_woo_display_on">
                    Display on
                </label>

                <select name="dtf_display_on[]" multiple>
                    <option <?php echo ( in_array( 'dtf_is_single', $dtf_display_on ) || count( $dtf_display_on ) < 1 ) ?  'selected' : ''; ?> value="dtf_is_single">Single product page</option>
                    <option <?php echo in_array( 'dtf_is_archive', $dtf_display_on ) ?  'selected' : ''; ?> value="dtf_is_archive">Product archive page</option>
                </select>
            </p>

            <p class="delivery-time-woo-form-field">
                <label class="delivery-time-woo-admin-label" for="delivery_time_woo_color">
                    Color
                </label>
                <input type="text" name="dtf_color" id="dtf_color"  value="<?php echo $dtf_color; ?>">                      
            </p>

        </div>

        <div>
            <input type="submit" class="button button-primary delivery-time-woo-custom-button" value="Save Settings">
        </div>
    </form>
</div>