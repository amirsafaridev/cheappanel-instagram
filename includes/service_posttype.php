<?php
function cptui_register_my_cpts_my_markets() {

    /**
     * Post Type: سرویس ها.
     */

    $labels = [
        "name" => esc_html__( "سرویس ها", "twentytwentytwo" ),
        "singular_name" => esc_html__( "سرویس", "twentytwentytwo" ),
        "menu_name" => esc_html__( "سرویس ها", "twentytwentytwo" ),
        "all_items" => esc_html__( "همه سرویس ها", "twentytwentytwo" ),
        "add_new" => esc_html__( "افزودن", "twentytwentytwo" ),
        "add_new_item" => esc_html__( "افزودن سرویس جدید", "twentytwentytwo" ),
        "edit_item" => esc_html__( "ویرایش سرویس", "twentytwentytwo" ),
        "new_item" => esc_html__( "سرویس جدید", "twentytwentytwo" ),
        "view_item" => esc_html__( "مشاهده سرویس", "twentytwentytwo" ),
        "view_items" => esc_html__( "مشاهده سرویس ها", "twentytwentytwo" ),
        "search_items" => esc_html__( "جستجوی سرویس ها", "twentytwentytwo" ),
        "not_found" => esc_html__( "هیچ سرویس ها پیدا نشد", "twentytwentytwo" ),
        "not_found_in_trash" => esc_html__( "No سرویس ها found in trash.", "twentytwentytwo" ),
        "parent" => esc_html__( "والد سرویس:", "twentytwentytwo" ),
        "featured_image" => esc_html__( "تصویر شاخص برای سرویس", "twentytwentytwo" ),
        "set_featured_image" => esc_html__( "تنظیم تصویر شاخص برای سرویس", "twentytwentytwo" ),
        "remove_featured_image" => esc_html__( "حذف تصویر شاخص برای سرویس", "twentytwentytwo" ),
        "use_featured_image" => esc_html__( "استفاده به عنوان تصویر شاخص برای سرویس", "twentytwentytwo" ),
        "archives" => esc_html__( "آرشیو سرویس", "twentytwentytwo" ),
        "insert_into_item" => esc_html__( "درج در سرویس", "twentytwentytwo" ),
        "uploaded_to_this_item" => esc_html__( "آپلود در سرویس", "twentytwentytwo" ),
        "filter_items_list" => esc_html__( "لیست فیلتر سرویس ها", "twentytwentytwo" ),
        "items_list_navigation" => esc_html__( "ناوبری لیست سرویس ها", "twentytwentytwo" ),
        "items_list" => esc_html__( "لیست سرویس ها", "twentytwentytwo" ),
        "attributes" => esc_html__( "ویژگی های سرویس ها", "twentytwentytwo" ),
        "name_admin_bar" => esc_html__( "سرویس", "twentytwentytwo" ),
        "item_published" => esc_html__( "سرویس منتشر شد", "twentytwentytwo" ),
        "item_published_privately" => esc_html__( "سرویس به صورت خصوصی منتشر شد.", "twentytwentytwo" ),
        "item_reverted_to_draft" => esc_html__( "سرویس به پیش نویس بازگشت.", "twentytwentytwo" ),
        "item_scheduled" => esc_html__( "سرویس زمانبندی شد", "twentytwentytwo" ),
        "item_updated" => esc_html__( "سرویس به‌روزرسانی شد.", "twentytwentytwo" ),
        "parent_item_colon" => esc_html__( "والد سرویس:", "twentytwentytwo" ),
    ];

    $args = [
        "label" => esc_html__( "سرویس ها", "twentytwentytwo" ),
        "labels" => $labels,
        "description" => "",
        "public" => true,
        "publicly_queryable" => true,
        "show_ui" => true,
        "show_in_rest" => false,
        "rest_base" => "",
        "rest_controller_class" => "WP_REST_Posts_Controller",
        "rest_namespace" => "wp/v2",
        "has_archive" => false,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "delete_with_user" => false,
        "exclude_from_search" => false,
        "capability_type" => "post",
        "map_meta_cap" => true,
        "hierarchical" => false,
        "can_export" => false,
        "rewrite" => [ "slug" => "my_markets", "with_front" => true ],
        "query_var" => true,
        "supports" => ["title"],
        "show_in_graphql" => false,
    ];

    register_post_type( "my_markets", $args );
}

add_action( 'init', 'cptui_register_my_cpts_my_markets' );
