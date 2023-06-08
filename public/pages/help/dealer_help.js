var help_seller_url = '/help/seller';
var help_seller_id = 'seller_name';
var help_seller_surname = 'sellerHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_seller_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_seller = thix.find('td').attr('data-field');

        if(create_new_seller == 'create_new_seller'){
            $('#createNewseller').modal('show')
            var name = $(document).find('#seller_name').val();
            $(document).find('#seller_create #name').val(name);
        }else{
            var seller_name = thix.find('td[data-field="seller_name"]').text();
            var seller_phone = thix.find('td[data-field="seller_phone"]').text();
            var seller_id = thix.find('td[data-field="seller_id"]').text();

            $('form').find('#seller_name').val(seller_name);
            $('form').find('#seller_id').val(seller_id);

            if($('#form_type').val() !== undefined){
                if($('#form_type').val() == 'booking_transfer'){
                    funcGetNewMemberDetail(seller_id)
                }
            }
        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_seller_id).on('focusin keyup',function(e){
    $('#inLineHelp').remove();
    e.preventDefault();
    var thix = $(this);
    var val = thix.val();
    var eg_help_block = thix.parents('.eg_help_block');
    var inLIneHelpLength = eg_help_block.find('#inLineHelp').length;

    if ((val || !val) && inLIneHelpLength == 0){
        eg_help_block.append('<div id="inLineHelp"></div>');
        var inLineHelp = eg_help_block.find('#inLineHelp');
        val = val.replace(/\s/g,'%20');
        var url2 = help_seller_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_seller_id) {
        $("#inLineHelp[data-id='seller']").remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});

$(document).on('keydown', function(e) {
    if ($('.inline_help_table').length) {
        var inLineHelp = $('.inline_help_table');
        var scrollHeight = inLineHelp.prop('scrollHeight');
        var scrollTop = inLineHelp.scrollTop();
        var lineHeight = parseInt(inLineHelp.css('line-height'));
        var offsetTop = parseInt(inLineHelp.css('top'));
        var keyCode = e.keyCode;
        if (keyCode == 38) { // up arrow key
            e.preventDefault();
            $('#seller_type').focus();
            inLineHelp.scrollTop(scrollTop - lineHeight);
            if (inLineHelp.scrollTop() == 0) {
                inLineHelp.css('top', offsetTop + lineHeight + 'px');
            }
            var selectedRow = inLineHelp.find('.selected');
            if (selectedRow.prev().length) {
                selectedRow.removeClass('selected');
                selectedRow.prev().addClass('selected');
            }
        } else if (keyCode == 40) { // down arrow key
            e.preventDefault();
            $('#seller_type').focus();
            inLineHelp.scrollTop(scrollTop + lineHeight);
            if (inLineHelp.scrollTop() + inLineHelp.innerHeight() == scrollHeight) {
                inLineHelp.css('top', offsetTop - lineHeight + 'px');
            }
            var selectedRow = inLineHelp.find('.selected');
            if (selectedRow.next().length) {
                selectedRow.removeClass('selected');
                selectedRow.next().addClass('selected');
            }
        }
        
        
    }
});
