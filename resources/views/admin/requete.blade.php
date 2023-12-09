

<script>
    function toast(phrase) { 
        

        Command: toastr["success"](phrase, "success")
        
        toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
        }
}

function requete(type,route,donnees,callback) { 
    // let reponse = {};
    $.ajax({
        type: type,
        url: route,
        data: donnees,
        dataType: "json",
        success: function (response) {
            // return response;
            if(typeof callback == 'function') {
                callback(response);
                
            }
        },error:function(err){
                let error = err.responseJSON;

                if(typeof callback == 'function') {
                    callback(error);
                    
                }
                // $('#errorListUpdate').html("");
                // $('#errorListUpdate').addClass('alert alert-danger');

                // $.each(error.errors, function(key, err_values) {
                //         $('#errorListUpdate').append('<li>'+err_values+'</li>');
                // });
                // return error;
        }
    });

    
}
</script>