jQuery(document).ready(function () {

    if (jQuery(".arta_select_category").length > 0) {
        // jQuery(".arta_select_service select").children().remove();
        jQuery(".arta_select_category select").on("change", function () {
            jQuery(".arta_select_service select").children().remove();
            jQuery(".arta_select_service select").prepend(`<option id="wait_option">منتظر بمانید ...</option>`);
            if(jQuery(".arta_select_category select").val() != ""){
                jQuery(".arta_select_service label").text('محصولات '+jQuery(".arta_select_category select  option:selected").text());
            }else{
                jQuery(".arta_select_service label").text('محصولات');
            }
            let term_id = jQuery(this).val();
            jQuery(".arta_select_service select").attr("disabled",true);
            get_services(term_id).then(r => {
                console.log(r)
                jQuery(".arta_select_service select").children().remove();
                jQuery(".arta_select_service select").prepend(`<option>لطفا محصول را انتخاب کنید</option>`);
                $.each(r, function (index, value) {
                    jQuery(".arta_select_service select").append(`
                         <option value="${value.post_title}_#${value.ID}|${value.rate * value.dollar}" data-p="${value.rate}" data-mx="${value.max}" data-mn="${value.min}">${value.post_title}</option>
                    `);
                });
                jQuery(".arta_select_service select").on("change", function () {
                    let rate = jQuery(this).find(":selected").attr("data-p");
                    let max = jQuery(this).find(":selected").attr("data-mx");
                    let min = jQuery(this).find(":selected").attr("data-mn");
                    jQuery("#quantity_label").remove();
                    jQuery(".arta_service_quantity input[type=number]").val(min);
                    jQuery(".arta_service_quantity input[type=number]").attr("min", min);
                    jQuery(".arta_service_quantity input[type=number]").attr("max", max);
                    jQuery(".arta_service_quantity label").append(`<span id="quantity_label"> حداقل ${min} ، حداکثر ${max}  </span>`);
                });
                jQuery(".arta_select_service select").attr("disabled",false);
                jQuery("#arta_select_service select #wait_option").remove();
            });
        });
    }

    if (jQuery("#update_market_services").length > 0) {
        jQuery("#update_market_services").on('click', function () {
            let market_id = jQuery(this).attr("data-market");
            jQuery(this).attr("disabled", true);
            jQuery(this).text("در حال بروزرسانی ...");
            jQuery("#update_services_waiting_message").show();
            update_services(market_id).then(r => {
                jQuery(this).attr("disabled", false);
                jQuery(this).text("بروزرسانی");
                jQuery("#market_last_update").text(r.time);
                jQuery("#update_services_waiting_message").hide();
                alert("بروزرسانی انجام شد");
            });
        });
    }

    if (jQuery(".arta_select_service").length > 0) {
        $('.arta_select_service select').select2();
    }

    if (jQuery(".arta_service_quantity").length > 0) {
        jQuery(".arta_service_quantity input[type=number]").on("input change", function () {
            let qtt = jQuery(this).val();
            let rate = jQuery(".arta_select_service select").find(":selected").attr("data-p");
        });
    }


});

async function update_services(market_id) {
    let res = "";
    await jQuery.ajax({
        type: 'post',
        url: arta_cheappanel_object.ajaxurl,
        data: {
            'action': 'update_market_services',
            'market_id': market_id,
        },
        beforeSend: function () {

        },
        success: function (data) {
            res = JSON.parse(data);
        },
        complete: function (data) {

        }
    });
    return res;
}

async function get_services(term_id) {
    let res = "";
    await jQuery.ajax({
        type: 'post',
        url: arta_cheappanel_object.ajaxurl,
        data: {
            'action': 'get_all_services',
            'term_id': term_id
        },
        beforeSend: function () {

        },
        success: function (data) {
            res = JSON.parse(data);
        },
        complete: function (data) {

        }
    });
    return res;
}

async function get_categories() {
    let res = "";
    await jQuery.ajax({
        type: 'post',
        url: arta_cheappanel_object.ajaxurl,
        data: {
            'action': 'get_all_categories',
        },
        beforeSend: function () {

        },
        success: function (data) {
            res = JSON.parse(data);
        },
        complete: function (data) {

        }
    });
    return res;
}