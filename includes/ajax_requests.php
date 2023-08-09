<?php


add_action('wp_ajax_nopriv_update_market_services', 'update_market_services');
add_action('wp_ajax_update_market_services', 'update_market_services');
function update_market_services()
{
    $counter = 0;
    $market_id = $_POST['market_id'];

    $api_key = get_post_meta($market_id, "arta_market_api_key", true);
    $api_url = get_post_meta($market_id, "arta_market_api_url", true);
    $api = new Api($api_key, $api_url);
    $services = $api->services();

    $args = array(
        'post_type' => 'my_services',
        'posts_per_page' => -1,
        'post_status' => ['publish', 'draft'],
        'meta_query' => array(
            array(
                'key' => 'arta_cheappanel_service_market',
                'value' => $market_id
            )
        ),
    );
    $posts = get_posts($args);

    foreach ($posts as $post) {
        $service_id = get_post_meta($post->ID, "arta_cheappanel_service_id", true);
        $service_ids[$service_id] = $post->ID;
    }

    //echo json_encode($service_ids);exit();
    foreach ($services as $service) {
        if (!empty($service_ids[$service->service])) {
            update_service($service, $service_ids[$service->service], $market_id);
            $counter++;
        } else {
            insert_service($service, $market_id);
        }
    }

    update_post_meta($market_id, "arta_market_last_update", time());
    echo json_encode([
        "result" => true,
        "time" => $counter
    ]);
    exit();
}


add_action('wp_ajax_nopriv_get_all_services', 'get_all_services');
add_action('wp_ajax_get_all_services', 'get_all_services');
function get_all_services()
{
    $term_id = $_POST["term_id"];
    $data = [];
    $services = get_posts(array(
        'post_type' => 'my_services',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'service_category',
                'field' => 'term_id',
                'terms' => $term_id
            )
        )
    ));
    foreach ($services as $service) {
        $rate = (float)get_post_meta($service->ID, "arta_cheappanel_service_rate", true);
        $custom_rate = (float)get_post_meta($service->ID, "arta_cheappanel_service_rate_custom", true);
        if ($custom_rate != $rate && $custom_rate > 0 && $custom_rate != "") {
            $service->rate = $custom_rate;
        } else {
            $service->rate = $rate;
        }
        $service->min = (int)get_post_meta($service->ID, "arta_cheappanel_service_min", true);
        $service->max = (int)get_post_meta($service->ID, "arta_cheappanel_service_max", true);
        $service->dollar = (int)get_service_dollar_price($service->ID);
        $data[] = $service;
    }
    echo json_encode($data);
    exit();
}


add_action('wp_ajax_nopriv_get_all_categories', 'get_all_categories');
add_action('wp_ajax_get_all_categories', 'get_all_categories');
function get_all_categories()
{
    $cats = get_terms([
        'taxonomy' => "service_category",
        'hide_empty' => false,
    ]);
    echo json_encode($cats);
    exit();
}









