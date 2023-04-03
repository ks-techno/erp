/*
* credit
* debit
* */
function credit(tr){
    var credit = tr.find(".credit").val();
    if(credit > 0){
        tr.find('.debit').val(0);
        TotalAmount();
    }
}

function debit(tr){
    var debit = tr.find(".debit").val();
    if(debit > 0){
        tr.find('.credit').val(0);
        TotalAmount();
    }
}

function TotalAmount()
{
    var tot_amt = 0;
    var tot_debit = 0;
    var tot_credit = 0;
    $( ".egt_form_body>tr" ).each(function( index ) {
        var amount = $(this).find(".amount").val();
        amount = (amount == '' || amount == undefined)? 0 : amount.replace( /,/g, '');
        tot_amt = (parseFloat(tot_amt)+parseFloat(amount));

        var debit = $(this).find(".debit").val();
        debit = (debit == '' || debit == undefined)? 0 : debit.replace( /,/g, '');
        tot_debit = (parseFloat(tot_debit)+parseFloat(debit));

        var credit = $(this).find(".credit").val();
        credit = (credit == '' || credit == undefined)? 0 : credit.replace( /,/g, '');
        tot_credit = (parseFloat(tot_credit)+parseFloat(credit));
    });

    tot_amt = tot_amt.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2});

    tot_debit = tot_debit.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2});

    tot_credit = tot_credit.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2});

    $("#tot_amount").html(tot_amt);
    $("#tot_debit").html(tot_debit);
    $("#tot_credit").html(tot_credit);

    $("#tot_voucher_amount").val(tot_amt);

    var tot_diff = parseFloat(tot_debit) - parseFloat(tot_credit);

    tot_diff = tot_diff.toLocaleString('en-US', {minimumFractionDigits: 0, maximumFractionDigits: 2});

    $("#tot_jv_difference").val(tot_diff);
    $("#tot_difference").html(tot_diff);

}


function calcDC(){
    $(".credit").keyup(function(){
        var tr = $(this).parents('tr');
        credit(tr);
        var tot = TotalAmount();
        $("#tot_debit").html(tot.tot_debit);
        $("#tot_credit").html(tot.tot_credit);
    });
    $(".debit").keyup(function(){
        var tr = $(this).parents('tr');
        debit(tr);
        var tot = TotalAmount();
        $("#tot_debit").html(tot.tot_debit);
        $("#tot_credit").html(tot.tot_credit);
    });
    $(".amount").keyup(function(){
        var tot = TotalAmount();
        $("#tot_debit").html(tot.tot_debit);
        $("#tot_credit").html(tot.tot_credit);
    });
    var tot = TotalAmount();
    $("#tot_debit").html(tot.tot_debit);
    $("#tot_credit").html(tot.tot_credit);
}
$(document).ready(function(){
    calcDC();
});
