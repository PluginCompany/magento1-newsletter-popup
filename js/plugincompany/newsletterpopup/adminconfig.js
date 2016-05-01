/**
 * Created by milan on 1/11/15.
 */
jQuery(document).ready(function(){
    jQuery('input.fawesome').each(function(){
        var icon = jQuery(this).val();
        jQuery(this).parent().append('<div data-title="Pick an icon below" data-placement="inline" class="icp icp-auto" data-selected="' + icon + '"></div>');
    });

    jQuery('.icp-auto').iconpicker();

    jQuery('.icp').on('iconpickerSelected', function(e) {
        jQuery(this).prev().val(e.iconpickerInstance.getValue(e.iconpickerValue));
    });
})