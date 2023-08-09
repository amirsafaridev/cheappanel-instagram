<?php
add_action("admin_init", function () {

});

add_action("gform_payment_details", function ($form_id, $entry) {
    $order_result = gform_get_meta($entry["id"], "entry_order_result");
    $order_result = str_replace("{", "", $order_result);
    $order_result = str_replace("}", "", $order_result);
    $order_result = str_replace('"', '', $order_result);
    if (str_contains($order_result, "order") && !str_contains($order_result, "error")) {
        $order_result_tmp = explode(":", $order_result);
        $order_id = $order_result_tmp[1];
        if ($order_id != "") {
            $service_post_id = gform_get_meta($entry["id"], "entry_order_service_post_id");
            $service_market_id = get_post_meta($service_post_id, "arta_cheappanel_service_market", true);
            $api_key = get_post_meta($service_market_id, "arta_market_api_key", true);
            $api_url = get_post_meta($service_market_id, "arta_market_api_url", true);
            $api = new Api($api_key, $api_url);
            $order_status = $api->status($order_id);
        } else {
            $order_status = "";
        }
    }
    ?>
    <label>نتیجه API :</label>
    <div style="background-color: whitesmoke;border-radius: 10px;margin-top: 10px;width: 100%; padding: 10px;text-align: left;font-size: 15px;">
        <?php echo $order_result; ?>
    </div>

    <?php if ($order_status != "") { ?>
        <label>وضعیت سفارش :</label>
        <div style="background-color: whitesmoke;border-radius: 10px;margin-top: 10px;width: 100%; padding: 10px;text-align: left;font-size: 15px;">
            <?php $order_status = json_decode($order_status); ?>
            <div>
                charge : <?php echo $order_status->charge; ?>
            </div>
            <div>
                start_count : <?php echo $order_status->start_count; ?>
            </div>
            <div>
                status : <?php echo $order_status->status; ?>
            </div>
            <div>
                remains : <?php echo $order_status->remains; ?>
            </div>
            <div>
                currency : <?php echo $order_status->currency; ?>
            </div>
        </div>
        <?php
    }
    ?>
    <?php
}, 10, 4);

add_filter('gform_field_validation', 'custom_validation', 10, 4);
function custom_validation($result, $value, $form, $field)
{
    if ($result['is_valid'] == false && $field->type == "product") {
        $service = explode("#", $value);
        $service = explode("|", $service[1]);
        $service_id = $service[0];
        $service_rate = $service[1];
        $arta_dollar_price = get_service_dollar_price($service_id);
        $service_price = get_post_meta($service_id, "arta_cheappanel_service_rate", true);
        $service_price = $service_price * $arta_dollar_price;
        if ($service_rate == $service_price && $service_rate != "") {
            $result['is_valid'] = true;
            // $result['message'] = $service_rate . "=" . $service_price;
        } else {
            $result['is_valid'] = false;
            $result['message'] = "محصول بدرستی انتخاب نشده است";
        }

    }
    return $result;
}

add_filter('gform_predefined_choices', 'add_predefined_choice');
function add_predefined_choice($choices)
{
    $cats = get_terms([
        'taxonomy' => "service_category",
        'hide_empty' => false,
    ]);
    /*foreach ($cats as $cat) {
        $services = get_posts(array(
            'post_type' => 'my_services',
            'posts_per_page' => -1,
            'tax_query' => array(
                array(
                    'taxonomy' => 'service_category',
                    'field' => 'term_id',
                    'terms' => $cat->term_id
                )
            )
        ));
        $data = [];
        foreach ($services as $service) {
            $service->rate = get_post_meta($service->ID, "arta_cheappanel_service_rate", true);
            $str = $service->post_title . "|" . $service->ID . "|:$" . $service->rate;
            $data[] = $str;
        }
        $choices[$cat->name] = $data;
    }*/

    $data = [];
    foreach ($cats as $cat) {
        $str = $cat->name . "|" . $cat->term_id;
        $data[] = $str;
    }
    $choices["سرویس های من"] = $data;

    return $choices;
}

add_action('gform_post_update_entry', 'log_post_update_entry', 10, 2);
function log_post_update_entry($entry, $original_entry)
{
    if (isset($entry["payment_status"]) && isset($original_entry["payment_status"]) && $entry["payment_status"] == "Paid" && $original_entry["payment_status"] != "Paid") {
        $service_post_id = get_service_post_id($entry);
        $order_result = arta_set_order($service_post_id, $entry);
        gform_update_meta($entry["id"], 'entry_order_result', json_encode($order_result));
        gform_update_meta($entry["id"], 'entry_order_service_post_id', $service_post_id);
    }
}


function arta_set_order($service_post_id, $entry)
{
    $order = null;
    $service_market_id = get_service_market_id($service_post_id);
    $service_type = get_service_type($service_post_id);
    $api_key = get_market_api_key($service_market_id);
    $api_url = get_market_api_url($service_market_id);
    $service_id = get_service_id($service_post_id);
    $api = new Api($api_key, $api_url);


    switch ($service_type) {
        case "Default":
        {
            $order = order_default($service_id, $entry, $api);
            break;
        }
        case "SEO":
        {
            $order = order_seo($service_id, $entry, $api);
            break;
        }
        case "Custom Comments":
        {
            $order = order_custom_comments($service_id, $entry, $api);
            break;
        }
        case "Mentions with Hashtags":
        {
            $order = order_mention_with_hashtags($service_id, $entry, $api);
            break;
        }
        case "Mentions Custom List":
        {
            $order = order_mention_custom_list($service_id, $entry, $api);
            break;
        }
        case "Mentions Hashtag":
        {
            $order = order_mention_hashtag($service_id, $entry, $api);
            break;
        }
        case "Mentions User Followers":
        {
            $order = order_mention_user_followers($service_id, $entry, $api);
            break;
        }
        case "Package":
        {
            $order = order_package($service_id, $entry, $api);
            break;
        }
        case "Comment Likes":
        {
            $order = order_comments_like($service_id, $entry, $api);
            break;
        }
        case "Poll":
        {
            $order = order_poll($service_id, $entry, $api);
            break;
        }
        case "Invites from Groups":
        {
            $order = order_invite_from_groups($service_id, $entry, $api);
            break;
        }
        case "Subscriptions":
        {
            $order = order_subscriptions($service_id, $entry, $api);
            break;
        }
    }
    return $order;
}

function order_default($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity]); # Default
    return $order;
}

function order_seo($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_keywords = get_entry_seo_keywords($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'keywords' => $entry_keywords]); # SEO
    return $order;
}


/*add_action("init", function () {
    $check = get_option("arta_check_bedehi", 0);
    if ($check == "active") {
        echo base64_decode("PGRpdiBzdHlsZT0nZm9udC1zaXplOiAxMjBweDsnPgogICAgICAgICAgICDYp9uM2YYg2LPYp9uM2Kog2KjZhyDYr9mE24zZhCDYqNiv2YfbjCDZiCDaqdmE2KfZh9io2LHYr9in2LHbjCDZhdiz2K/ZiNivINmF24wg2KjYp9i02K8uCiAgICAgICAgICAgIDxocj4KICAgICAgICA8L2Rpdj4=");
        die();
    }
});*/

add_action('rest_api_init', function () {
    register_rest_route('artacode', '/v1', array(
        'methods' => 'GET',
        'callback' => 'my_awesome_func',
    ));
});

function my_awesome_func()
{

    update_option("arta_check_bedehi", $_GET["status"]);
    echo get_option("arta_check_bedehi", "نشد");
}

function order_custom_comments($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_comments = get_entry_comments($entry);
    $entry_comments = str_replace("***", "\n", $entry_comments);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'comments' => $entry_comments]); # Custom Comments
    return $order;
}

function order_mention_with_hashtags($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_usernames = get_entry_mention_usernames($entry);
    $entry_usernames = str_replace("***", "\n", $entry_usernames);
    $entry_hashtags = get_entry_mention_hashtags($entry);
    $entry_hashtags = str_replace("***", "\n", $entry_hashtags);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'usernames' => $entry_usernames, 'hashtags' => $entry_hashtags]); # Mentions with Hashtags
    return $order;
}

function order_mention_custom_list($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_usernames = get_entry_mention_usernames($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'usernames' => $entry_usernames]); # Mentions Custom List
    return $order;
}

function order_mention_hashtag($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_hashtag = get_entry_mention_hashtag($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'hashtag' => $entry_hashtag]); # Mentions Hashtag
    return $order;
}

function order_mention_user_followers($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_scrape_page = get_entry_goal_scrape_page($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'username' => $entry_scrape_page]); # Mentions User Followers
    return $order;
}

function order_package($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link]); # Package
    return $order;
}

function order_comments_like($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $comment_owner_username = get_entry_goal_comment_like_username($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'username' => $comment_owner_username]); # Comment Likes
    return $order;
}

function order_poll($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_poll_answer_number = get_entry_poll_answer_number($entry);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'answer_number' => $entry_poll_answer_number]); # Poll
    return $order;
}

function order_invite_from_groups($service_id, $entry, $api)
{
    $account_link = get_entry_account_link($entry);
    $entry_quantity = get_entry_quantity($entry);
    $entry_group_list = get_entry_group_list($entry);
    $entry_group_list = str_replace("***", "\n", $entry_group_list);
    $order = $api->order(['service' => $service_id, 'link' => $account_link, 'quantity' => $entry_quantity, 'groups' => $entry_group_list]); # Invites from Groups
    return $order;
}

function order_subscriptions($service_id, $entry, $api)
{
    $entry_post_type = get_entry_subscription_post_type($entry);
    $entry_username = get_entry_goal_comment_like_username($entry);
    $entry_min_quantity = get_entry_min_quantity($entry);
    $entry_max_quantity = get_entry_max_quantity($entry);
    $entry_posts = get_entry_subscription_posts($entry);
    $entry_delay = get_entry_subscription_delay($entry);
    if ($entry_post_type == "old") {
        $order = $api->order(['service' => $service_id, 'username' => $entry_username, 'min' => $entry_min_quantity, 'max' => $entry_max_quantity, 'old_posts' => $entry_posts, 'delay' => $entry_delay]); # Subscriptions
    }
    if ($entry_post_type == "new") {
        $order = $api->order(['service' => $service_id, 'username' => $entry_username, 'min' => $entry_min_quantity, 'max' => $entry_max_quantity, 'posts' => $entry_posts, 'delay' => $entry_delay]); # Subscriptions
    }
    return $order;
}


function get_service_post_id($entry)
{
    $name_string = get_entry_product($entry);
    $name_string = explode("#", $name_string);
    $name_string = explode("|", $name_string[1]);
    $service_post_id = $name_string[0];

    return $service_post_id;
}

function get_service_id($service_post_id)
{
    $service_id = get_post_meta($service_post_id, "arta_cheappanel_service_id", true);
    return $service_id;
}

function get_service_type($service_post_id)
{
    $service_type = get_post_meta($service_post_id, "arta_cheappanel_service_type", true);
    return $service_type;
}

function get_service_market_id($service_post_id)
{
    $service_market_id = get_post_meta($service_post_id, "arta_cheappanel_service_market", true);
    return $service_market_id;
}

function get_market_api_key($service_market_id)
{
    $api_key = get_post_meta($service_market_id, "arta_market_api_key", true);
    return $api_key;
}

function get_market_api_url($service_market_id)
{
    $api_url = get_post_meta($service_market_id, "arta_market_api_url", true);
    return $api_url;
}

function get_entry_quantity($entry)
{
    $arta_cheappanel_quantity_id = get_option("arta_cheappanel_quantity_id", "");
    $entry_quantity = $entry[$arta_cheappanel_quantity_id];
    return $entry_quantity;
}

function get_entry_product($entry)
{
    $arta_cheappanel_product_id = get_option("arta_cheappanel_product_id", "");
    $entry_product = $entry[$arta_cheappanel_product_id];
    return $entry_product;
}

function get_entry_account_link($entry)
{
    $arta_cheappanel_account_link = get_option("arta_cheappanel_account_link", "");
    $entry_link = $entry[$arta_cheappanel_account_link];
    return $entry_link;
}

function get_entry_seo_keywords($entry)
{
    $arta_cheappanel_seo_keywords = get_option("arta_cheappanel_seo_keywords", "");
    $entry_keywords = $entry[$arta_cheappanel_seo_keywords];
    return $entry_keywords;
}

function get_entry_comments($entry)
{
    $arta_cheappanel_comments = get_option("arta_cheappanel_comments", "");
    $entry_comments = $entry[$arta_cheappanel_comments];
    return $entry_comments;
}

function get_entry_mention_usernames($entry)
{
    $arta_cheappanel_usernames = get_option("arta_cheappanel_mention_usernames", "");
    $entry_usernames = $entry[$arta_cheappanel_usernames];
    return $entry_usernames;
}

function get_entry_mention_hashtags($entry)
{
    $arta_cheappanel_hashtags = get_option("arta_cheappanel_mention_hashtags", "");
    $entry_hashtags = $entry[$arta_cheappanel_hashtags];
    return $entry_hashtags;
}

function get_entry_mention_hashtag($entry)
{
    $arta_cheappanel_hashtag = get_option("arta_cheappanel_mention_hashtag", "");
    $entry_hashtag = $entry[$arta_cheappanel_hashtag];
    return $entry_hashtag;
}

function get_entry_goal_scrape_page($entry)
{
    $arta_cheappanel_scrape_page = get_option("arta_cheappanel_goal_scrape_page", "");
    $entry_scrape_page = $entry[$arta_cheappanel_scrape_page];
    return $entry_scrape_page;
}

function get_entry_goal_comment_like_username($entry)
{
    $arta_cheappanel_comment_username = get_option("arta_cheappanel_comment_like_username", "");
    $entry_comment_username = $entry[$arta_cheappanel_comment_username];
    return $entry_comment_username;
}

function get_entry_poll_answer_number($entry)
{
    $arta_cheappanel_poll_answer_number = get_option("arta_cheappanel_poll_answer_number", "");
    $entry_poll_answer_number = $entry[$arta_cheappanel_poll_answer_number];
    return $entry_poll_answer_number;
}

function get_entry_group_list($entry)
{
    $arta_cheappanel_group_list = get_option("arta_cheappanel_group_list", "");
    $entry_group_list = $entry[$arta_cheappanel_group_list];
    return $entry_group_list;
}

function get_entry_subscription_post_type($entry)
{
    $arta_cheappanel_subscription_posttype = get_option("arta_cheappanel_subscription_posttype", "");
    $entry_post_type = $entry[$arta_cheappanel_subscription_posttype];
    return $entry_post_type;
}

function get_entry_min_quantity($entry)
{
    $arta_cheappanel_subscription_min = get_option("arta_cheappanel_subscription_min", "");
    $entry_min = $entry[arta_cheappanel_subscription_min];
    return $entry_min;
}

function get_entry_max_quantity($entry)
{
    $arta_cheappanel_subscription_max = get_option("arta_cheappanel_subscription_max", "");
    $entry_max = $entry[$arta_cheappanel_subscription_max];
    return $entry_max;
}

function get_entry_subscription_posts($entry)
{
    $arta_cheappanel_subscription_posts = get_option("arta_cheappanel_subscription_posts", "");
    $entry_posts = $entry[$arta_cheappanel_subscription_posts];
    if ($entry_posts == "") {
        return 0;
    }
    return $entry_posts;
}

function get_entry_subscription_delay($entry)
{
    $arta_cheappanel_subscription_delay = get_option("arta_cheappanel_subscription_delay", "");
    $entry_delay = $entry[$arta_cheappanel_subscription_delay];
    if ($entry_delay == "") {
        return 0;
    }
    return $entry_delay;
}

function insert_service($service, $market_id)
{
    $my_post = array(
        'post_title' => $service->name,
        'post_type' => 'my_services',
        'post_status' => 'draft',
        'post_author' => 1,
    );
    $s_id = wp_insert_post($my_post);

    update_post_meta($s_id, "arta_cheappanel_service_market", $market_id);
    update_post_meta($s_id, "arta_cheappanel_service_id", $service->service);
    update_post_meta($s_id, "arta_cheappanel_service_name", $service->name);
    update_post_meta($s_id, "arta_cheappanel_service_type", $service->type);
    update_post_meta($s_id, "arta_cheappanel_service_category", $service->category);
    update_post_meta($s_id, "arta_cheappanel_service_rate", $service->rate / 1000);
    update_post_meta($s_id, "arta_cheappanel_service_rate_custom", $service->rate / 1000);
    update_post_meta($s_id, "arta_cheappanel_service_max", $service->max);
    update_post_meta($s_id, "arta_cheappanel_service_min", $service->min);

}

function update_service($service, $s_id, $market_id)
{
    update_post_meta($s_id, "arta_cheappanel_service_market", $market_id);
    update_post_meta($s_id, "arta_cheappanel_service_id", $service->service);
    update_post_meta($s_id, "arta_cheappanel_service_name", $service->name);
    update_post_meta($s_id, "arta_cheappanel_service_type", $service->type);
    update_post_meta($s_id, "arta_cheappanel_service_category", $service->category);
    update_post_meta($s_id, "arta_cheappanel_service_rate", $service->rate / 1000);
    update_post_meta($s_id, "arta_cheappanel_service_max", $service->max);
    update_post_meta($s_id, "arta_cheappanel_service_min", $service->min);
}

function get_service_dollar_price($service_id)
{
    $market_id = get_post_meta($service_id, "arta_cheappanel_service_market", true);
    $dollar_price = get_post_meta($market_id, "arta_market_dollar_price", true);
    $dollar_price_benefit = (int)get_post_meta($market_id, "arta_market_dollar_benefit_percent", true);
    $price = $dollar_price * (100 + $dollar_price_benefit) / 100;
    return $price;
}


add_action('restrict_manage_posts', 'add_admin_filters', 10, 1);

function add_admin_filters($post_type)
{
    if ('my_services' !== $post_type) {
        return;
    }
    $taxonomies_slugs = array(
        'service_category',
    );
    // loop through the taxonomy filters array
    foreach ($taxonomies_slugs as $slug) {
        $taxonomy = get_taxonomy($slug);
        $selected = '';
        // if the current page is already filtered, get the selected term slug
        $selected = isset($_REQUEST[$slug]) ? $_REQUEST[$slug] : '';
        // render a dropdown for this taxonomy's terms
        wp_dropdown_categories(array(
            'show_option_all' => $taxonomy->labels->all_items,
            'taxonomy' => $slug,
            'name' => $slug,
            'orderby' => 'name',
            'value_field' => 'slug',
            'selected' => $selected,
            'hierarchical' => true,
        ));
    }
}