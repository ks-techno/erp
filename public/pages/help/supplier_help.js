var help_supplier_url = '/help/supplier';
var help_supplier_id = 'supplier_name';
var help_supplier_surname = 'supplierHelp';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);
    var valid = thix.parents('.inLineHelp').find('#'+help_supplier_surname).length;
    console.log(valid);
    if(valid) {
        var create_new_supplier = thix.find('td').attr('data-field');

        if(create_new_supplier == 'create_new_supplier'){
           // $('#createNewsupplier').modal('show')
            var name = $(document).find('#supplier_name').val();
            $(document).find('#supplier_create #name').val(name);
        }else{
            var supplier_name = thix.find('td[data-field="supplier_name"]').text();
            var supplier_phone = thix.find('td[data-field="supplier_phone"]').text();
            var supplier_id = thix.find('td[data-field="supplier_id"]').text();

            $('form').find('#supplier_name').val(supplier_name);
            $('form').find('#supplier_id').val(supplier_id);
        }
        $('#inLineHelp').remove();
    }
});

$('#'+help_supplier_id).on('focusin keyup',function(e){
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
        var url2 = help_supplier_url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    }

});
$(document).on('click',function(e){
    if($(e.target).attr('id') != help_supplier_id) {
        $("#inLineHelp[data-id='supplier']").remove();
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
