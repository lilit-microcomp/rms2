<?php
namespace App\Helpers\Contracts;

interface CommentInterface
{
   public function setAllComments();

   public function setAllCommentsByTypeAndId($id, $type);

   public function saveComment($request);

   public function setComment($id);

   public function UpdateComment($request, $id);

   public function DeleteComment($id);

}
