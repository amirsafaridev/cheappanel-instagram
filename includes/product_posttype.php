<?php
function cptui_register_my_cpts_my_services() {

    /**
     * Post Type: محصولات.
     */

    $labels = [
        "name" => esc_html__( "محصولات", "twentytwentytwo" ),
        "singular_name" => esc_html__( "محصول", "twentytwentytwo" ),
        "menu_name" => esc_html__( "محصولات", "twentytwentytwo" ),
        "all_items" => esc_html__( "همه محصولات", "twentytwentytwo" ),
        "add_new" => esc_html__( "افزودن", "twentytwentytwo" ),
        "add_new_item" => esc_html__( "افزودن محصول جدید", "twentytwentytwo" ),
        "edit_item" => esc_html__( "ویرایش محصول", "twentytwentytwo" ),
        "new_item" => esc_html__( "محصول جدید", "twentytwentytwo" ),
        "view_item" => esc_html__( "مشاهده محصول", "twentytwentytwo" ),
        "view_items" => esc_html__( "مشاهده محصولات", "twentytwentytwo" ),
        "search_items" => esc_html__( "جستجوی محصولات", "twentytwentytwo" ),
        "not_found" => esc_html__( "هیچ محصولات پیدا نشد", "twentytwentytwo" ),
        "not_found_in_trash" => esc_html__( "No محصولات found in trash.", "twentytwentytwo" ),
        "parent" => esc_html__( "والد محصول:", "twentytwentytwo" ),
        "featured_image" => esc_html__( "تصویر شاخص برای محصول", "twentytwentytwo" ),
        "set_featured_image" => esc_html__( "تنظیم تصویر شاخص برای محصول", "twentytwentytwo" ),
        "remove_featured_image" => esc_html__( "حذف تصویر شاخص برای محصول", "twentytwentytwo" ),
        "use_featured_image" => esc_html__( "استفاده به عنوان تصویر شاخص برای محصول", "twentytwentytwo" ),
        "archives" => esc_html__( "آرشیو محصول", "twentytwentytwo" ),
        "insert_into_item" => esc_html__( "درج در محصول", "twentytwentytwo" ),
        "uploaded_to_this_item" => esc_html__( "آپلود در محصول", "twentytwentytwo" ),
        "filter_items_list" => esc_html__( "لیست فیلتر محصولات", "twentytwentytwo" ),
        "items_list_navigation" => esc_html__( "ناوبری لیست محصولات", "twentytwentytwo" ),
        "items_list" => esc_html__( "لیست محصولات", "twentytwentytwo" ),
        "attributes" => esc_html__( "ویژگی های محصولات", "twentytwentytwo" ),
        "name_admin_bar" => esc_html__( "محصول", "twentytwentytwo" ),
        "item_published" => esc_html__( "محصول منتشر شد", "twentytwentytwo" ),
        "item_published_privately" => esc_html__( "محصول به صورت خصوصی منتشر شد.", "twentytwentytwo" ),
        "item_reverted_to_draft" => esc_html__( "محصول به پیش نویس بازگشت.", "twentytwentytwo" ),
        "item_scheduled" => esc_html__( "محصول زمانبندی شد", "twentytwentytwo" ),
        "item_updated" => esc_html__( "محصول به‌روزرسانی شد.", "twentytwentytwo" ),
        "parent_item_colon" => esc_html__( "والد محصول:", "twentytwentytwo" ),
    ];

    $args = [
        "label" => esc_html__( "محصولات", "twentytwentytwo" ),
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
        "rewrite" => [ "slug" => "my_services", "with_front" => true ],
        "query_var" => true,
        "supports" => [ "title" ],
        "show_in_graphql" => false,
    ];

    register_post_type( "my_services", $args );
}

add_action( 'init', 'cptui_register_my_cpts_my_services' );




function cptui_register_my_taxes_service_category() {

    /**
     * Taxonomy: دسته بندی ها.
     */

    $labels = [
        "name" => esc_html__( "دسته بندی ها", "twentytwentytwo" ),
        "singular_name" => esc_html__( "دسته بندی", "twentytwentytwo" ),
        "menu_name" => esc_html__( "دسته بندی ها", "twentytwentytwo" ),
        "all_items" => esc_html__( "همه دسته بندی ها", "twentytwentytwo" ),
        "edit_item" => esc_html__( "ویرایش دسته بندی", "twentytwentytwo" ),
        "view_item" => esc_html__( "مشاهده دسته بندی", "twentytwentytwo" ),
        "update_item" => esc_html__( "به‌روزرسانی نام دسته بندی", "twentytwentytwo" ),
        "add_new_item" => esc_html__( "افزودن دسته بندی جدید", "twentytwentytwo" ),
        "new_item_name" => esc_html__( "اسم دسته بندی جدید", "twentytwentytwo" ),
        "parent_item" => esc_html__( "والد دسته بندی", "twentytwentytwo" ),
        "parent_item_colon" => esc_html__( "والد دسته بندی:", "twentytwentytwo" ),
        "search_items" => esc_html__( "جستجوی دسته بندی ها", "twentytwentytwo" ),
        "popular_items" => esc_html__( "دسته بندی ها محبوب", "twentytwentytwo" ),
        "separate_items_with_commas" => esc_html__( "دسته بندی ها را با کاما جدا کنید", "twentytwentytwo" ),
        "add_or_remove_items" => esc_html__( "اضافه یا حذف دسته بندی ها", "twentytwentytwo" ),
        "choose_from_most_used" => esc_html__( "انتخاب از پراستفاده ترین دسته بندی ها", "twentytwentytwo" ),
        "not_found" => esc_html__( "هیچ دسته بندی ها پیدا نشد", "twentytwentytwo" ),
        "no_terms" => esc_html__( "بدون هیچ دسته بندی ها", "twentytwentytwo" ),
        "items_list_navigation" => esc_html__( "ناوبری لیست دسته بندی ها", "twentytwentytwo" ),
        "items_list" => esc_html__( "لیست دسته بندی ها", "twentytwentytwo" ),
        "back_to_items" => esc_html__( "بازگشت به دسته بندی ها", "twentytwentytwo" ),
        "name_field_description" => esc_html__( "The name is how it appears on your site.", "twentytwentytwo" ),
        "parent_field_description" => esc_html__( "Assign a parent term to create a hierarchy. The term Jazz, for example, would be the parent of Bebop and Big Band.", "twentytwentytwo" ),
        "slug_field_description" => esc_html__( "The slug is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.", "twentytwentytwo" ),
        "desc_field_description" => esc_html__( "The description is not prominent by default; however, some themes may show it.", "twentytwentytwo" ),
    ];


    $args = [
        "label" => esc_html__( "دسته بندی ها", "twentytwentytwo" ),
        "labels" => $labels,
        "public" => true,
        "publicly_queryable" => true,
        "hierarchical" => false,
        "show_ui" => true,
        "show_in_menu" => true,
        "show_in_nav_menus" => true,
        "query_var" => true,
        "rewrite" => [ 'slug' => 'service_category', 'with_front' => true, ],
        "show_admin_column" => false,
        "show_in_rest" => true,
        "show_tagcloud" => false,
        "rest_base" => "service_category",
        "rest_controller_class" => "WP_REST_Terms_Controller",
        "rest_namespace" => "wp/v2",
        "show_in_quick_edit" => false,
        "sort" => false,
        "show_in_graphql" => false,
    ];
    register_taxonomy( "service_category", [ "my_services" ], $args );
}
add_action( 'init', 'cptui_register_my_taxes_service_category' );