function TotalAmount() {
  var tot_credit = 0;

  // Use .egt_form_body tr instead of .egt_form_body > tr to select all descendant tr elements
  $( ".egt_form_body>tr" ).each(function( index ){
      var credit = $(this).find(".chart_amount").val();

      credit = credit == '' || credit == undefined ? 0 : credit.replace(/,/g, '');
      tot_credit += parseFloat(credit);
  });

  tot_credit = tot_credit.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 2 });

  $("#tot_credit").html(tot_credit);
}

$(document).ready(function() {
  TotalAmount();

  $(".chart_amount").on("keyup", function() {
      TotalAmount();
  });
});
