<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Delivery_Time_For_Woo
 * @subpackage Delivery_Time_For_Woo/public/partials
 */
?>


<?php
    $day_txt = ( $num_of_days > 1 ) ? 'days' : 'day';
    $cursor = ( !empty( $dt_desc ) ) ? ';cursor:pointer' : ';cursor:normal';
?>

<div class="dft-display-time">
    <p style="color:<?php echo $dtf_color.$cursor; ?>" data-pid="<?php echo get_the_ID(); ?>" class="dft-display-days">
        Delivery time: <?php echo $num_of_days.' '.$day_txt; ?>
    </p>

    <p class="dft-display-time-desc"></p>
</div>