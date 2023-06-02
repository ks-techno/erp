// var url = '/help/chart';
// var id = 'egt_chart_code';

// $(document).on('change','#egt_chart_code',function(e){
//     var selectedOption = $(this).find(':selected');
//     var chart_name = selectedOption.data('chart-name');
//     var chart_code = selectedOption.data('chart-code');
//     var chart_id = selectedOption.data('chart-id');
//     $('#egt_chart_name').val(chart_name);
//     $('#egt_chart_name1').val(chart_name);
//     $('#egt_chart_code1').val(chart_code);
//     $('#egt_chart_code').val(chart_code);
//     $('#chart_id1').val(chart_id);
//     $('#chart_id').val(chart_id);
// });


var url = '/help/chart';
var id = 'egt_chart_code';

$(document).on('change','.egt_form_header_input',function(e){
    var thix = $(this);
    var selectedOption = $(this).find(':selected');
    var chart_code = selectedOption.data('chart-code');
    var chart_name = selectedOption.data('chart-name');
    var chart_id = selectedOption.data('chart-id');
    var create_new_customer = thix.find('td').attr('data-field');
    if(create_new_customer == 'create_new_customer'){
        $('#createNewCustomer').modal('show')
    }
       
            $('.egt_form_header_input').find('.chart_code').val(chart_code);
            $('.egt_form_header_input').find('.chart_name').val(chart_name);
            $('.egt_form_header_input').find('.chart_id').val(chart_id);
        
    
});
$(document).on('change','.egt_form_body',function(e){
    var thix = $(this);
    
    var selectedOption = $(this).find(':selected');
    var chart_code = selectedOption.data('chart-code');
    var chart_name = selectedOption.data('chart-name');
    var chart_id = selectedOption.data('chart-id');
    var create_new_customer = thix.find('td').attr('data-field');
    if(create_new_customer == 'create_new_customer'){
        $('#createNewCustomer').modal('show')
    }
       
            $('.egt_form_header_input').find('.chart_code').val(chart_code);
            $('.egt_form_header_input').find('.chart_name').val(chart_name);
            $('.egt_form_header_input').find('.chart_id').val(chart_id);
        
    
});

$(document).on('change','.egt_form_header_input_2nd',function(e){
    var thix = $(this);
   
    var selectedOption = $(this).find(':selected');
    var chart_code1 = selectedOption.data('chart-code1');

    var chart_name1 = selectedOption.data('chart-name1');
    var chart_id1 = selectedOption.data('chart-id1');
    var create_new_customer = thix.find('td').attr('data-field');
    if(create_new_customer == 'create_new_customer'){
        $('#createNewCustomer').modal('show')
    }
            $('.egt_form_header_input_2nd').find('.chart_code1').val(chart_code1);
            $('.egt_form_header_input_2nd').find('.chart_name1').val(chart_name1);
            $('.egt_form_header_input_2nd').find('.chart_id1').val(chart_id1);
        
    
});

$('#'+id).keyup(function(e){
    console.log(e)
    var thix = $(this);
    var val = thix.val();
    console.log(thix);
    console.log(val);
    var inLIneHelpLength = $('#erp_grid_table>.erp_form___block').find('#inLineHelp').length;
    if (e.which === 113 && inLIneHelpLength == 0 && val.length < 3 ) {
        e.preventDefault();
        $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
        var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
        inLineHelp.load(url);
        var offsetTop = 64;
        var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    } else if (e.which === 113 && inLIneHelpLength == 0 && val.length > 3) {
        e.preventDefault();
        $('#erp_grid_table>.erp_form___block').append('<div id="inLineHelp"></div>');
        var inLineHelp = $('#erp_grid_table>.erp_form___block').find('#inLineHelp');
        url2 = url +'/'+val
        inLineHelp.load(url2);
        var offsetTop = 64;
        var offsetLeft = thix.offset().left - $('.erp_form___block').offset().left;
        $('#inLineHelp').css({top:offsetTop+'px'});
        $('#inLineHelp').css({left:offsetLeft+'px'});
    } else {
        var value = val.toLowerCase();
        $(".val_table").filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });

        if(e.which === 8 && val.length < 9){
            thix.parents('tr').find('.chart_name').val('');
        }
    }
});
$(document).on('click',function(e){
    if($(e.target).attr('id') != id) {
        $('#inLineHelp').remove();
    }
});
$(document).on('keydown', function(e) {
    if ($('.inline_help_table').length) {
        
        var inLineHelp = $('.inline_help_table');
        var scrollHeight = inLineHelp.prop('scrollHeight');
        var scrollTop = inLineHelp.scrollTop();
        var lineHeight = parseInt(inLineHelp.css('line-height'));
        var offsetTop = parseInt(inLineHelp.css('top'));
        var keyCode = e.keyCode;
        if (keyCode == 38) { 
            e.preventDefault();
            $('#egt_cheque_no').focus();
            inLineHelp.scrollTop(scrollTop - lineHeight);
            if (inLineHelp.scrollTop() == 0) {
                inLineHelp.css('top', offsetTop + lineHeight + 'px');
            }
            var selectedRow = inLineHelp.find('.selected');
            if (selectedRow.prev().length) {
                selectedRow.removeClass('selected');
                selectedRow.prev().addClass('selected');
            }
        } else if (keyCode == 40) { 
            e.preventDefault();
            $('#egt_cheque_no').focus();
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

