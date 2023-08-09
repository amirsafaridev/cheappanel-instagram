<?php

add_action('add_meta_boxes', 'order_checks');
if (!function_exists('order_checks')) {
    function order_checks()
    {
        add_meta_box('order_checks_box', __('مشخصات محصول', 'woocommerce'), 'order_checks_box_callback', 'my_services', 'normal', 'core');
    }
}
function order_checks_box_callback()
{
    global $post;
    $arta_cheappanel_service_market = get_post_meta($post->ID, "arta_cheappanel_service_market", true);
    $arta_cheappanel_service_id = get_post_meta($post->ID, "arta_cheappanel_service_id", true);
    $arta_cheappanel_service_name = get_post_meta($post->ID, "arta_cheappanel_service_name", true);
    $arta_cheappanel_service_type = get_post_meta($post->ID, "arta_cheappanel_service_type", true);
    $arta_cheappanel_service_category = get_post_meta($post->ID, "arta_cheappanel_service_category", true);
    $arta_cheappanel_service_rate = get_post_meta($post->ID, "arta_cheappanel_service_rate", true);
    $arta_cheappanel_service_rate_custom = get_post_meta($post->ID, "arta_cheappanel_service_rate_custom", true);
    $arta_cheappanel_service_max = get_post_meta($post->ID, "arta_cheappanel_service_max", true);
    $arta_cheappanel_service_min = get_post_meta($post->ID, "arta_cheappanel_service_min", true);

    $markets = get_posts(array(
        'post_type' => "my_markets",
        'numberposts' => -1,
    ));
    ?>
    <div class="wrap">
        <table class="form-table">
            <tbody>
            <tr>
                <th scope="row"><label for="service_market">سرویس محصول</label></th>
                <td>
                    <select name="service_market" id="service_market" required>
                        <option></option>
                        <?php
                        foreach ($markets as $makrket) {
                            ?>
                            <option
                                    <?php
                                    if($arta_cheappanel_service_market == $makrket->ID){
                                        echo "selected";
                                    }
                                    ?>
                                    value="<?php echo $makrket->ID; ?>"><?php echo $makrket->post_title; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_id">آی دی سرویس</label></th>
                <td>
                    <input type="text" name="service_id" id="service_id"
                           value="<?php echo $arta_cheappanel_service_id; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_name">نام سرویس</label></th>
                <td>
                    <input type="text" name="service_name" id="service_name"
                           value="<?php echo $arta_cheappanel_service_name; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_type">نوع </label></th>
                <td>
                    <input type="text" name="service_type" id="service_type"
                           value="<?php echo $arta_cheappanel_service_type; ?>">
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_category">دسته بندی سرویس</label></th>
                <td>
                    <input type="text" name="service_category" id="service_category"
                           value="<?php echo $arta_cheappanel_service_category; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_rate">قیمت سرویس</label></th>
                <td>
                    <input type="text" name="service_rate" id="service_rate"
                           value="<?php echo $arta_cheappanel_service_rate; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_rate_custom">قیمت سرویس دستی</label></th>
                <td>
                    <input type="text" name="service_rate_custom" id="service_rate_custom"
                           value="<?php echo $arta_cheappanel_service_rate_custom; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_max">حداکثر</label></th>
                <td>
                    <input type="text" name="service_max" id="service_max"
                           value="<?php echo $arta_cheappanel_service_max; ?>" required>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="service_min">حداقل</label></th>
                <td>
                    <input type="text" name="service_min" id="service_min"
                           value="<?php echo $arta_cheappanel_service_min; ?>" required>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <?php
}


add_action('save_post', 'my_service_setting_save_post', 10, 3);
function my_service_setting_save_post($post_id)
{
    global $post;
    if ('my_services' == $post->post_type) {

        $service_market = $_POST["service_market"];
        $service_id = $_POST["service_id"];
        $service_name = $_POST["service_name"];
        $service_type = $_POST["service_type"];
        $service_category = $_POST["service_category"];
        $service_rate = $_POST["service_rate"];
        $service_rate_custom = $_POST["service_rate_custom"];
        $service_max = $_POST["service_max"];
        $service_min = $_POST["service_min"];

        update_post_meta($post->ID, "arta_cheappanel_service_market", $service_market);
        update_post_meta($post->ID, "arta_cheappanel_service_id", $service_id);
        update_post_meta($post->ID, "arta_cheappanel_service_name", $service_name);
        update_post_meta($post->ID, "arta_cheappanel_service_type", $service_type);
        update_post_meta($post->ID, "arta_cheappanel_service_category", $service_category);
        update_post_meta($post->ID, "arta_cheappanel_service_rate", $service_rate);
        update_post_meta($post->ID, "arta_cheappanel_service_rate_custom", $service_rate_custom);
        update_post_meta($post->ID, "arta_cheappanel_service_max", $service_max);
        update_post_meta($post->ID, "arta_cheappanel_service_min", $service_min);

    }
}


