<?php
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");
include_once("../../server/session_manager.php");

$title="";
$coverUrl="";
$description="";

$dbMan = DBManager::getInstance();

$articleId = $_GET["articleId"];
$articleInfo = loadInfo($articleId);


$likes = $articleInfo[9];
$airDate = $articleInfo[10];
$newDate = date("d-m-Y", strtotime($airDate));

$output = str_replace("{article-id}",$articleId,$output);
$output = str_replace("article-id-link",$articleId,$output);
$output = str_replace("{title}", $articleInfo[0],$output);
$output = str_replace("cover_url", "../public/".$articleInfo[2],$output);
$output = str_replace("{description}", $articleInfo[3],$output);
$output = str_replace("{air-date}", $newDate, $output);


$totalVotes = getTotalAndPositiveVotes($articleId)[0];
$positiveVotes = getTotalAndPositiveVotes($articleId)[1];
$negativeVotes = $totalVotes-$positiveVotes;

$output = str_replace("{likes}", ($positiveVotes==null) ? 0 : $positiveVotes, $output);
$output = str_replace("{dislikes}", ($negativeVotes==null) ? 0 : ($negativeVotes), $output); 

//check user opinion for the article
$check = likeCheck($articleId);
switch($check) {
  case 1:
    $output = str_replace("{like-selected}", "thumb-selected", $output);
  break;
  case 0:
    $output = str_replace("{dislike-selected}", "thumb-selected", $output);
  break;
  case -1: {
    $output = str_replace("{like-selected}", "", $output);
    $output = str_replace("{dislike-selected}", "", $output);
  } break;
}


$comments = Comment::getCommentsFor($articleId);
$output = str_replace("{comment-list}", getCommentList($comments), $output);


function loadInfo($id){
  $list = Article::fetch($id);
  return array($list->title, $list->coverUrl, $list->description);
}

//CAMBIA è una funzione get per voti totali e voti positivi
function getTotalAndPositiveVotes($articleId){
  $likesList = Article::list();
  for($i=0; $i<count($likesList); $i++){
    if($articleId == $likesList[$i]->id){
      return array($likesList[$i]->votesTotal, $likesList[$i]->votesPositive);
    }
  }
}


function likeCheck($id) {
  $votedArticles = null;
  if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
    $votedArticles = Article::getUserVotes($userId);
  }   
  if ($votedArticles != null) {
    for ($x = 0; $x < count($votedArticles); $x++) {
      if ($votedArticles[$x]->article_id == $id) {
        return $votedArticles[$x]->positive ? 1 : 0;  
      }
    }
  } 
  return -1;
}

function getCommentList($comments) {
  $commentList = [];

  for ($x = 0; $x < count($comments); $x++) {
    $commentContent = $comments[$x]->content;
    $userFullName = $comments[$x]->userFullName;
    $userId = $comments[$x]->userId;

    $userAvatar = Comment::getAvatar($userId);
    $userAvatarUrl = $userAvatar[0]->avatar_url;
    
    $comment = file_get_contents("../html/comment.html");
    $comment = str_replace("{user-comment}", $userFullName, $comment);
    $comment = str_replace("{content-comment}", $commentContent, $comment);
    $comment = str_replace("avatar_url_comment", "../public/".$userAvatarUrl, $comment);

    array_push($commentList, $comment);
  }
  return implode($commentList);
}

?>
