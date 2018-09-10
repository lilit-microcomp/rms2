<?php
namespace App\Helpers\Services;
use App\Helpers\Contracts\CommentInterface;
use App\Models\Comments;
use Illuminate\Support\Facades\Hash;

class CommentService implements CommentInterface
{
   protected $comment;
   public $all_comments;
   public $current_comment;

   public function __construct() {
       $this->comment = new Comments();
   }

   public function setAllComments() {
       $this->all_comments = $this->comment::all();
   }


   public function setAllCommentsByTypeAndId($id, $type) {
       $this->all_comments = $this->comment::where('type_page_row_id', $id)
                                            ->where('type_page', $type)
                                            ->get();
   }

   public function saveCommentFromRequest($request) {
       dd(1);
       $this->saveComment($request->all());
   }

   public function saveComment($array) {
       if($this->comment->create($array)) {
           return true;
       } else {
           return false;
       }
   }

   public function setComment($id) {
       $this->current_comment = $this->comment->find($id);
   }

   public function UpdateComment($request, $id) {
       $comment = $this->comment->find($id);
       if($comment->update(array_filter($request->all()))) {
           return true;
       } else {
           return false;
       }
   }

   public function DeleteComment($id) {
       $comment = Comment::findOrFail($id);
       if($comment->delete()) {
           return true;
       } else {
           return false;
       }
   }
}
