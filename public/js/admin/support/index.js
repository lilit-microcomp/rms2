jQuery( document ).ready(function( $ ) {

    $('select[name="user_id"]').on('change', function(){
        var userId = $(this).val();
        window.location.href = '/admin/support/'+userId+'/user';
    });
});
