/*
 * Dynamic To Top Plugin Settings
 * http://www.mattvarone.com
 *
 * By Matt Varone
 * @sksmatt
 *
*/
jQuery(document).ready(function () {

    var preview = jQuery('#dynamic-to-top-button');
    var preview_button_version = jQuery('#dynamic-to-top-button #dtt-image');
    var preview_text_version = jQuery('#dynamic-to-top-button #dtt-text');
    var hide_on_button = jQuery('#text-text, #slider-font-size, #checkbox-bold, #checkbox-text-shadow, #farbtastic-text-color, #farbtastic-shadow-color').parent().parent();

    jQuery('#checkbox-text-version').click(function () {
        toggle_text_version();
    });

    toggle_text_version();
    update_preview();
    update_position();

    var update_fields = '#checkbox-bold, #checkbox-inset, #checkbox-shadow, #checkbox-text-shadow, .colorvalue';

    jQuery(update_fields).change(function () {
        update_preview()
    });
    jQuery('#select-position').change(function () {
        update_position();
    });

    jQuery('#text-text').keyup(function () {
        update_preview()
    });

    jQuery('.ddt-bg-colors a').click(function (e) {
        e.preventDefault();
        var color = jQuery(this).attr('title');
        jQuery('#dynamic-to-top-preview').css('background-color', color);
    });

    // Slider Radius
    var slider = jQuery("#slider-radius").hide();
    var slider_val = jQuery('span#radius-val').html(slider.val());

    jQuery('#slider-picker-radius').slider({
        range: "min",
        value: slider.val(),
        min: 0,
        max: 30,
        slide: function (event, ui) {
            slider.val(ui.value);
            slider_val.html(ui.value);
            preview.css('border-radius', ui.value + 'px');
        }
    });

    // Slider Border Width
    var slider_2 = jQuery("#slider-border-width").hide();
    var slider_val_2 = jQuery('span#border-val').html(slider_2.val());

    jQuery('#slider-picker-border-width').slider({
        range: "min",
        value: slider_2.val(),
        min: 0,
        max: 10,
        slide: function (event, ui) {
            slider_2.val(ui.value);
            slider_val_2.html(ui.value);
            preview.css('border-width', ui.value + 'px');
        }
    });

    // Slider Speed
    var slider_3 = jQuery('#slider-speed').hide();
    var slider_val_3 = jQuery('span#speed-val').html(slider_3.val());

    jQuery('#slider-picker-speed').slider({
        range: "max",
        value: slider_3.val(),
        min: 600,
        step: 100,
        max: 3000,
        slide: function (event, ui) {
            slider_3.val(ui.value);
            slider_val_3.html(ui.value);
        }
    });

    // Slider Padding Top/Bottom
    var slider_4 = jQuery("#slider-padding-top-bottom").hide();
    var slider_val_4 = jQuery('span#padding-top-bottom-val').html(slider_4.val());

    jQuery('#slider-picker-padding-top-bottom').slider({
        range: "min",
        value: slider_4.val(),
        min: 2,
        max: 21,
        slide: function (event, ui) {
            slider_4.val(ui.value);
            slider_val_4.html(ui.value);
            preview.css({
                paddingTop: ui.value + 'px',
                paddingBottom: ui.value + 'px'
            });
        }
    });

    // Slider Padding Left/Right
    var slider_5 = jQuery("#slider-padding-left-right").hide();
    var slider_val_5 = jQuery('span#padding-left-right-val').html(slider_5.val());

    jQuery('#slider-picker-padding-left-right').slider({
        range: "min",
        value: slider_5.val(),
        min: 2,
        max: 40,
        slide: function (event, ui) {
            slider_5.val(ui.value);
            slider_val_5.html(ui.value);
            preview.css({
                paddingLeft: ui.value + 'px',
                paddingRight: ui.value + 'px'
            });
        }
    });

    // Slider Font Size
    var slider_6 = jQuery("#slider-font-size").hide();
    var slider_val_6 = jQuery('span#font-size-val').html(slider_6.val());

    jQuery('#slider-picker-font-size').slider({
        range: "min",
        value: slider_6.val(),
        min: 0.8,
        max: 2,
        step: 0.05,
        slide: function (event, ui) {
            slider_6.val(ui.value);
            slider_val_6.html(ui.value);
            preview.css({
                fontSize: ui.value + 'em'
            });
        }
    });

    jQuery('.dtt-slider').css('width', '25em');

    // Color Pickers
    jQuery('#farbtastic-picker-text-color').farbtastic('#farbtastic-text-color');
    jQuery('#farbtastic-picker-background-color').farbtastic('#farbtastic-background-color');
    jQuery('#farbtastic-picker-border-color').farbtastic('#farbtastic-border-color');
    jQuery('#farbtastic-picker-shadow-color').farbtastic('#farbtastic-shadow-color');

    jQuery('.dtt-farbtastic').hide().css('margin-bottom', '15px').mouseup(function () {
        update_preview()
    });

    jQuery('.picker').click(function (e) {
        e.preventDefault();
        toogle_picker(jQuery(this));

    });

    jQuery('.colorvalue').click(function () {
        var picker = jQuery(this).parent().find('.picker');
        if (picker.html() === picker.attr('data-closed')) {
            toogle_picker(picker);
        }
    });

    function toogle_picker(picker) {
        picker.parent().find('.dtt-farbtastic').toggle();

        var open = picker.attr('data-open');
        if (picker.html() === open) {
            picker.html(picker.attr('data-closed'));
            picker.parent().find('.picker').addClass('picker-opened');
        } else {
            picker.parent().find('.picker').removeClass('picker-opened');
            picker.html(open);
        }
    }

/* FUNCTIONS
	/////////////////////////////*/

    function toggle_text_version() {
        if (jQuery('#checkbox-text-version').attr('checked')) {
            preview_button_version.hide();
            preview_text_version.show();
            preview.removeClass('button-version');
            hide_on_button.show();
        } else {
            preview_button_version.show().css('display', 'block');
            preview_text_version.hide();
            preview.addClass('button-version');
            hide_on_button.hide();
        }
    }

    function update_position() {
        var preview_position = jQuery('#select-position').val();

        switch (preview_position) {
        case 'Top Left':
            preview.css({
                top: '10px',
                left: '10px',
                bottom: '',
                right: ''
            });
            break;

        case 'Top Right':
            preview.css({
                top: '10px',
                right: '10px',
                bottom: '',
                left: ''
            });
            break;

        case 'Bottom Left':
            preview.css({
                bottom: '10px',
                left: '10px',
                top: '',
                right: ''
            });
            break;

        case 'Bottom Right':
            preview.css({
                bottom: '10px',
                right: '10px',
                top: '',
                left: ''
            });
            break;
        }
    }

    function update_preview() {
        prevew = new Object;
        preview.text = jQuery('#text-text').val();
        preview.border_width = jQuery('#slider-border-width').val();
        preview.border_radius = jQuery('#slider-radius').val();
        preview.text_color = jQuery('#farbtastic-text-color').val();
        preview.bg_color = jQuery('#farbtastic-background-color').val();
        preview.border_color = jQuery('#farbtastic-border-color').val();
        preview.padding_top_bottom = jQuery('#slider-padding-top-bottom').val();
        preview.padding_left_right = jQuery('#slider-padding-left-right').val();
        preview.find('#dtt-text').font_size = jQuery('#slider-font-size').val();
        preview.shadow = jQuery('#checkbox-shadow').attr("checked");
        preview.inset = jQuery('#checkbox-inset').attr("checked");
        preview.bold = jQuery('#checkbox-bold').attr("checked");
        preview.position = jQuery('#select-position').val();
        preview.text_shadow = jQuery('#checkbox-text-shadow').attr("checked");
        preview.text_shadow_color = jQuery('#farbtastic-shadow-color').val();

        preview.css({
            borderStyle: 'solid',
            borderWidth: preview.border_width + 'px',
            borderRadius: preview.border_radius + 'px',
            borderColor: preview.border_color,
            backgroundColor: preview.bg_color,
            color: preview.text_color,
            paddingTop: preview.padding_top_bottom + 'px',
            paddingBottom: preview.padding_top_bottom + 'px',
            paddingLeft: preview.padding_left_right + 'px',
            paddingRight: preview.padding_left_right + 'px',
            fontSize: preview.font_size + 'em',
        }).find('#dtt-text').html(preview.text);

        if (preview.bold) {
            preview.css('font-weight', 'bold');
        } else {
            preview.css('font-weight', 'normal');
        }

        if (preview.shadow) {
            preview.addClass('dynamic-to-top-shadow');
        } else {
            preview.removeClass('dynamic-to-top-shadow');
        }

        if (preview.inset) {
            preview.addClass('dynamic-to-top-inset');
        } else {
            preview.removeClass('dynamic-to-top-inset');
        }

        if (preview.text_shadow) {
            preview.css('text-shadow', '0 1px 0 ' + preview.text_shadow_color);
        } else {
            preview.css('text-shadow', '');
        }

    }

});