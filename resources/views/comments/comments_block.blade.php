

<ul class="comment odd alt">
    <div class="comment-body" >
    <div style="margin-top: 5px;">

        <div> <!-- left border style="border-left: 1px solid #CFCFCF;" -->
            <p style="font-size: 14px">{{$comment->user_name}} &nbsp;{{$comment->created_at}} &nbsp;&nbsp;</p>
            <p style="font-size: 14px">{!! $comment->text !!}</p>
        </div>

    </div>

    <!--<div class="comment-author vcard">
			<cite class="fn">{{$comment->user_name}}</cite>
        </div>
        <div class="comment-meta commentmetadata">
			<p>{{$comment->text}}</p>
        </div>-->
        <div class="reply text-right" data-comment-id = {!! $comment->id !!} >
            <a rel="nofollow" href="#add_comment" class="btn btn-primary comment-reply-link show-comment-box" data-toggle="collapse" style="width: 100px;">Reply</a>
        </div>
        @if ($comment_id)
            <li>
                @foreach($comments as $comment)
                    @if($comment->parent_id == $comment_id)
                        @include('comments.comments_block', [
                        'comment' => $comment,
                        'comment_id' => $comment->id])
                    @endif
                @endforeach
            </li>
        @endif
    </div>
</ul>

