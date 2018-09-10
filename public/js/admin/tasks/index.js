jQuery( document ).ready(function( $ ) {

    $('select[name="user_id"]').on('change', function(){
        var userId = $(this).val();
        window.location.href = '/admin/tasks/'+userId+'/user';
        // alert(userId);
        // if(userId) {
        //     $.ajax({
        //         url: '/tasks/get/'+userId,
        //         type:"GET",
        //         dataType:"json",
        //         beforeSend: function(){
        //             $('#loader').css("visibility", "visible");
        //         },
        //         success:function(data) {
        //             $('select[name="project_id"]').empty();
        //             $('select[name="project_id"]').append('<option value="" disabled=disabled selected>' + 'Please select ...' + '</option>');
        //             $.each(data, function(key, value){
        //                 $('select[name="project_id"]').append('<option value="'+ key +'">' + value + '</option>').removeAttr("disabled");;
        //             });
        //         },
        //         complete: function(){
        //             $('#loader').css("visibility", "hidden");
        //         }
        //     });
        // } else {
        //     $('select[name="project_id"]').empty();
        // }

    });
});
