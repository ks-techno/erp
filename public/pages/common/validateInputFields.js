
// number validator
function NumberValidate(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 47 && charCode <58)
    {
        return true;
    }
    return false;
}
//end number  validator

//phone number pattern validator
function allowNumberDash(evt){
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if ((charCode > 47 && charCode <58) || (charCode == 45 || charCode == 43))
    {
        return true;
    }
    return false;
}
//end number pattern validator



$(document).ready(function() {
    $(document).find('.NumberValidate').keypress(NumberValidate);
    $(document).find('.AllowNumberDash').keypress(allowNumberDash);
});

