jQuery( document ).ready(function( $ ) {
    $( "#datepicker-start" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $( "#datepicker-end" ).datepicker({ dateFormat: 'yy-mm-dd' });

    CKEDITOR.replace( 'description' );
    CKEDITOR.replace( 'access_data' );
});
