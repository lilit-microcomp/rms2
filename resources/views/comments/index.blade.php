@if (count($comments) > 0)
    <ul>
        @foreach ($comments as $comment)
            @if(!$comment->parent_id)
                @include('comments.comments_block', [
                        'comment' => $comment,
                        'comment_id' =>$comment->id])

            @endif
        @endforeach
    </ul>
@endif
