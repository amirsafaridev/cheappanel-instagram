<?php
add_action('admin_menu', 'arta_cheappanel_admin_menu');
function arta_cheappanel_admin_menu()
{
    add_menu_page(
        __('وب سرویس ', 'textdomain'),
        'وب سرویس  ',
        'manage_options',
        'cheappanel_setting',
        'arta_cheappanel_setting',
        '',
        6
    );
}

//////////////////// Setting menu callback /////////////////////////////////////////////////////////
function arta_cheappanel_setting()
{
    if (isset($_POST["submit"])) {
        $arta_cheappanel_quantity_id = $_POST['arta_cheappanel_quantity_id'];
        $arta_cheappanel_product_id = $_POST['arta_cheappanel_product_id'];
        $arta_cheappanel_account_link = $_POST['arta_cheappanel_account_link'];
        $arta_cheappanel_seo_keywords = $_POST['arta_cheappanel_seo_keywords'];
        $arta_cheappanel_comments = $_POST['arta_cheappanel_comments'];
        $arta_cheappanel_mention_usernames = $_POST['arta_cheappanel_mention_usernames'];
        $arta_cheappanel_mention_hashtags = $_POST['arta_cheappanel_mention_hashtags'];
        $arta_cheappanel_goal_scrape_page = $_POST['arta_cheappanel_goal_scrape_page'];
        $arta_cheappanel_mention_hashtag = $_POST['arta_cheappanel_mention_hashtag'];
        $arta_cheappanel_comment_like_username = $_POST['arta_cheappanel_comment_like_username'];
        $arta_cheappanel_poll_answer_number = $_POST['arta_cheappanel_poll_answer_number'];
        $arta_cheappanel_group_list = $_POST['arta_cheappanel_group_list'];
        $arta_cheappanel_subscription_posttype = $_POST['arta_cheappanel_subscription_posttype'];
        $arta_cheappanel_subscription_min = $_POST['arta_cheappanel_subscription_min'];
        $arta_cheappanel_subscription_max = $_POST['arta_cheappanel_subscription_max'];
        $arta_cheappanel_subscription_posts = $_POST['arta_cheappanel_subscription_posts'];
        $arta_cheappanel_subscription_delay = $_POST['arta_cheappanel_subscription_delay'];


        update_option("arta_cheappanel_quantity_id", $arta_cheappanel_quantity_id);
        update_option("arta_cheappanel_product_id", $arta_cheappanel_product_id);
        update_option("arta_cheappanel_account_link", $arta_cheappanel_account_link);
        update_option("arta_cheappanel_seo_keywords", $arta_cheappanel_seo_keywords);
        update_option("arta_cheappanel_comments", $arta_cheappanel_comments);
        update_option("arta_cheappanel_mention_usernames", $arta_cheappanel_mention_usernames);
        update_option("arta_cheappanel_mention_hashtags", $arta_cheappanel_mention_hashtags);
        update_option("arta_cheappanel_goal_scrape_page", $arta_cheappanel_goal_scrape_page);
        update_option("arta_cheappanel_mention_hashtag", $arta_cheappanel_mention_hashtag);
        update_option("arta_cheappanel_comment_like_username", $arta_cheappanel_comment_like_username);
        update_option("arta_cheappanel_poll_answer_number", $arta_cheappanel_poll_answer_number);
        update_option("arta_cheappanel_group_list", $arta_cheappanel_group_list);
        update_option("arta_cheappanel_subscription_posttype", $arta_cheappanel_subscription_posttype);
        update_option("arta_cheappanel_subscription_min", $arta_cheappanel_subscription_min);
        update_option("arta_cheappanel_subscription_max", $arta_cheappanel_subscription_max);
        update_option("arta_cheappanel_subscription_posts", $arta_cheappanel_subscription_posts);
        update_option("arta_cheappanel_subscription_delay", $arta_cheappanel_subscription_delay);
    }


    $arta_cheappanel_quantity_id = get_option("arta_cheappanel_quantity_id", "");
    $arta_cheappanel_product_id = get_option("arta_cheappanel_product_id", "");
    $arta_cheappanel_account_link = get_option("arta_cheappanel_account_link", "");
    $arta_cheappanel_seo_keywords = get_option("arta_cheappanel_seo_keywords", "");
    $arta_cheappanel_comments = get_option("arta_cheappanel_comments", "");
    $arta_cheappanel_mention_usernames = get_option("arta_cheappanel_mention_usernames", "");
    $arta_cheappanel_mention_hashtags = get_option("arta_cheappanel_mention_hashtags", "");
    $arta_cheappanel_goal_scrape_page = get_option("arta_cheappanel_goal_scrape_page", "");
    $arta_cheappanel_mention_hashtag = get_option("arta_cheappanel_mention_hashtag", "");
    $arta_cheappanel_comment_like_username = get_option("arta_cheappanel_comment_like_username", "");
    $arta_cheappanel_poll_answer_number = get_option("arta_cheappanel_poll_answer_number", "");
    $arta_cheappanel_group_list = get_option("arta_cheappanel_group_list", "");
    $arta_cheappanel_subscription_posttype = get_option("arta_cheappanel_subscription_posttype", "");
    $arta_cheappanel_subscription_min = get_option("arta_cheappanel_subscription_min", "");
    $arta_cheappanel_subscription_max = get_option("arta_cheappanel_subscription_max", "");
    $arta_cheappanel_subscription_posts = get_option("arta_cheappanel_subscription_posts", "");
    $arta_cheappanel_subscription_delay = get_option("arta_cheappanel_subscription_delay", "");

    ?>
    <div class="wrap">
        <h1>تنظیمات افزونه سفارش Cheappanel</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <table class="form-table" role="presentation">
                <tbody>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_product_id">ID فیلد محصول</label></th>
                    <td>
                        <input name="arta_cheappanel_product_id" type="text"
                               id="arta_cheappanel_product_id"
                               value="<?php echo $arta_cheappanel_product_id; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_quantity_id">ID فیلد تعداد</label></th>
                    <td>
                        <input name="arta_cheappanel_quantity_id" type="text"
                               id="arta_cheappanel_quantity_id"
                               value="<?php echo $arta_cheappanel_quantity_id; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_account_link">ID  فیلد لینک حساب کاربری یا یک پست</label></th>
                    <td>
                        <input name="arta_cheappanel_account_link" type="text"
                               id="arta_cheappanel_account_link"
                               value="<?php echo $arta_cheappanel_account_link; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_seo_keywords">ID فیلد کلمات کلیدی</label></th>
                    <td>
                        <input name="arta_cheappanel_seo_keywords" type="text"
                               id="arta_cheappanel_seo_keywords"
                               value="<?php echo $arta_cheappanel_seo_keywords; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_comments">ID فیلد کامنت ها</label></th>
                    <td>
                        <input name="arta_cheappanel_comments" type="text"
                               id="arta_cheappanel_comments"
                               value="<?php echo $arta_cheappanel_comments; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_mention_usernames">ID فیلد نام های کاربری برای منشن</label></th>
                    <td>
                        <input name="arta_cheappanel_mention_usernames" type="text"
                               id="arta_cheappanel_mention_usernames"
                               value="<?php echo $arta_cheappanel_mention_usernames; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_mention_hashtags">ID فیلد هشتگ ها برای منشن</label></th>
                    <td>
                        <input name="arta_cheappanel_mention_hashtags" type="text"
                               id="arta_cheappanel_mention_hashtags"
                               value="<?php echo $arta_cheappanel_mention_hashtags; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_goal_scrape_page">ID فیلد آدرس صفحه کاربری هدف</label></th>
                    <td>
                        <input name="arta_cheappanel_goal_scrape_page" type="text"
                               id="arta_cheappanel_goal_scrape_page"
                               value="<?php echo $arta_cheappanel_goal_scrape_page; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_mention_hashtag">ID فیلد هشتگ تکی</label></th>
                    <td>
                        <input name="arta_cheappanel_mention_hashtag" type="text"
                               id="arta_cheappanel_mention_hashtag"
                               value="<?php echo $arta_cheappanel_mention_hashtag; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_comment_like_username">ID فیلد نام کاربری تکی</label></th>
                    <td>
                        <input name="arta_cheappanel_comment_like_username" type="text"
                               id="arta_cheappanel_comment_like_username"
                               value="<?php echo $arta_cheappanel_comment_like_username; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_poll_answer_number">ID فیلد تعداد پاسخ به نظرسنجی</label></th>
                    <td>
                        <input name="arta_cheappanel_poll_answer_number" type="text"
                               id="arta_cheappanel_poll_answer_number"
                               value="<?php echo $arta_cheappanel_poll_answer_number; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_group_list">ID فیلد گروه ها</label></th>
                    <td>
                        <input name="arta_cheappanel_group_list" type="text"
                               id="arta_cheappanel_group_list"
                               value="<?php echo $arta_cheappanel_group_list; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_subscription_posttype">ID فیلد نوع پست برای subscriptions</label></th>
                    <td>
                        <input name="arta_cheappanel_subscription_posttype" type="text"
                               id="arta_cheappanel_subscription_posttype"
                               value="<?php echo $arta_cheappanel_subscription_posttype; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_subscription_min">ID فیلد حداقل تعداد برای subscriptions</label></th>
                    <td>
                        <input name="arta_cheappanel_subscription_min" type="text"
                               id="arta_cheappanel_subscription_min"
                               value="<?php echo $arta_cheappanel_subscription_min; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_subscription_max">ID فیلد حداکثر تعداد برای subscriptions</label></th>
                    <td>
                        <input name="arta_cheappanel_subscription_max" type="text"
                               id="arta_cheappanel_subscription_max"
                               value="<?php echo $arta_cheappanel_subscription_max; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_subscription_posts">ID فیلد تعداد پست برای subscriptions</label></th>
                    <td>
                        <input name="arta_cheappanel_subscription_posts" type="text"
                               id="arta_cheappanel_subscription_posts"
                               value="<?php echo $arta_cheappanel_subscription_posts; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="arta_cheappanel_subscription_delay">ID فیلد مدت تاخیر subscriptions</label></th>
                    <td>
                        <input name="arta_cheappanel_subscription_delay" type="text"
                               id="arta_cheappanel_subscription_delay"
                               value="<?php echo $arta_cheappanel_subscription_delay; ?>"
                               class="regular-text" style="">
                    </td>
                </tr>
                </tbody>
            </table>
            <p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary"
                                     value="ذخیرهٔ تغییرات"></p>
        </form>
    </div>
    <?php
}
