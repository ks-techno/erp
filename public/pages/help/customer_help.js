var url = '/help/customer';
var id = 'customer_name';

$(document).on('click','.data_tbody_row',function(e){
    var thix = $(this);

    var create_new_customer = thix.find('td').attr('data-field');

    console.log(create_new_customer)
    if(create_new_customer == 'create_new_customer'){
        $('#createNewCustomer').modal('show')
    }else{
        var customer_name = thix.find('td[data-field="customer_name"]').text();
        var customer_phone = thix.find('td[data-field="customer_phone"]').text();
        var customer_id = thix.find('td[data-field="customer_id"]').text();

        $('form').find('#customer_name').val(customer_name +" - "+ customer_phone);
        $('form').find('#customer_id').val(customer_id);
    }
});

$('#'+id).on('focusin keyup',function(e){
    var thix = $(this);
    var val = thix.val();
    var eg_help_block = thix.parents('.eg_help_block');
    var inLIneHelpLength = eg_help_block.find('#inLineHelp').length;
    if(inLIneHelpLength != 0){
        $('#inLineHelp').remove();
    }
    if (val || !val){
        e.preventDefault();
        eg_help_block.append('<div id="inLineHelp"></div>');
        var inLineHelp = eg_help_block.find('#inLineHelp');
        val = val.replace(' ','%20');
        var url2 = url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 30;
        var offsetLeft = thix.offset().left - eg_help_block.offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    } else {
        var value = val.toLowerCase();
        $(".val_table").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

      //  thix.val('');
    }
});
$(document).on('click',function(e){
    if($(e.target).attr('id') != id) {
        $('#inLineHelp').remove();
    }
});

$(document).on('click','#addon_remove',function(e){
    $(this).parents('.eg_help_block').find('input').val('');
});
