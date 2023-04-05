$(function () {
    'use strict';

    var pageLoginForm = $('#bank_payment_create');
    alert('wewew');
    // jQuery Validation
    // --------------------------------------------------------------------
    if (pageLoginForm.length) {
        pageLoginForm.validate({
            /*
            * ? To enable validation onkeyup
            onkeyup: function (element) {
              $(elem  ent).valid();
            },*/
            /*
            * ? To enable validation on focusout
            onfocusout: function (element) {
              $(element).valid();
            }, */
            rules: {  
            },
            submitHandler: function (form) {
                pageLoginForm.find(":submit").prop('disabled', true);
                //form[0].submit(); // submit the form
                var formData = new FormData(form);
                alert('asdasd'); 
                $.ajax({
                    
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url         : form.action,
                    type        : form.method,
                    dataType	: 'json',
                    data        : formData,
                    cache       : false,
                    contentType : false,
                    processData : false,
                    success: function(response,status) {
                        console.log(response);
                        if(response.status == 'success'){
                            alert('asdasd');
                            ntoastr.success(response.message);
                            setTimeout(function () {
                                $("form").find(":submit").prop('disabled', false);
                            }, 2000);
                            window.location.href = response['data']['redirect'];
                        }else{
                            alert('asdasd');
                            ntoastr.error(response.message);
                            setTimeout(function () {
                                pageLoginForm.find(":submit").prop('disabled', false);
                            }, 2000);
                        }
                    },
                    error: function(response,status) {
                        // console.log(response.responseJSON);
                        if(response.responseJSON.message !== undefined){
                            alert('asdasd');
                            ntoastr.error(response.responseJSON.message);
                        }
                        setTimeout(function () {
                            $("form").find(":submit").prop('disabled', false);
                        }, 2000);
                    },
                });
            }
        });
    }
});
