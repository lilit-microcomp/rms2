jQuery( document ).ready(function( $ ) {
    $(".show-comment-box").click(function(){
        if($(this).hasClass('active-for-submit')){
            $('.clone-comment form').submit()
            console.log('submit');
        }else{
            $('.clone-comment').remove();
            $('.show-comment-box').removeClass('active-for-submit');
            $(this).addClass('active-for-submit')

            let divCommentBox = $("#add-new-comment").find(".comment-box").clone().addClass('clone-comment').removeClass("d-none");
            let commentId = $(this).parent('div').data('comment-id');

            $(divCommentBox).find("[name='comment_parent_id']").val(commentId);

            console.log(commentId);

            $(divCommentBox).insertBefore(this);
            $(".clone-comment .comment-collapse-box").ckeditor();
        }
    });

    // $(".comment-body .comment-meta").ckeditor();


});
