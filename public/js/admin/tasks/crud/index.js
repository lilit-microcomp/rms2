
jQuery( document ).ready(function( $ ) {
    $( "#datepicker-start" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepicker-end" ).datepicker({ dateFormat: 'yy-mm-dd' });

    CKEDITOR.replace( 'description' );

    if($('select[name="client_id"]').val()){
        var clientId = $('select[name="client_id"]').val();
        if(clientId) {
            $.ajax({
                url: '/projects/get/'+clientId,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
                success:function(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function(key, value){
                        $('select[name="project_id"]').append('<option value="'+ key +'">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }

    }

    $('select[name="client_id"]').on('change', function(){
        var clientId = $(this).val();
        if(clientId) {
            $.ajax({
                url: '/projects/get/'+clientId,
                type:"GET",
                dataType:"json",
                beforeSend: function(){
                    $('#loader').css("visibility", "visible");
                },
                success:function(data) {
                    $('select[name="project_id"]').empty();
                    $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
                    $.each(data, function(key, value){
                        $('select[name="project_id"]').append('<option value="'+ key +'">' + value + '</option>').removeAttr("disabled");;
                    });
                },
                complete: function(){
                    $('#loader').css("visibility", "hidden");
                }
            });
        } else {
            $('select[name="project_id"]').empty();
        }

    });
});
