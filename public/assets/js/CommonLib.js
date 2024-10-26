const CommonLib = {
    ajaxForm:function(formData='',method,url) {
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        return $.ajax({
            type: method,
            url: url,
            data:formData,
            dataType: 'json',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('.spinner-border').show();
            },
            success: function(d){;},
            complete:function(){
                $('.spinner-border').hide();
            }
        });
    },
    notification:{
        success:function(message){
            return cuteToast({
                url:'',
                type: "success",
                title: "Success",
                message: message,
                buttonText: "Okay"
            });
        },
        error:function(message){
            return cuteToast({
                url:'',
                type: "error",
                title: "Failure",
                message: message,
                buttonText: "Okay"
            });
        },
        warning:function(message){
            return cuteToast({
                url:'',
                type: "warning",
                title: "Warning",
                message: message,
                buttonText: "Okay"
            });
        },
    }
}
