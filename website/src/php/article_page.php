<?php
include_once("../../server/db_manager.php");
include_once("../../server/models/models.php");
include_once("../../server/session_manager.php");

$title="";
$cover_url="";
$description="";

$userId = null;

$dbMan = DBManager::getInstance();

$articleId = $_GET["articleId"];
$articleInfo = loadInfo($articleId);


$likes=$articleInfo[9];
$data_rilascio=$articleInfo[10];
$newDate = date("m-Y", strtotime($data_rilascio));

$output=str_replace("{starNumber}", count($starNumber),$output);
$output=str_replace("{articleid}",$articleId,$output);
$output=str_replace("article-id-link",$articleId,$output);

$output=str_replace("{title}", $articleInfo[0],$output);
$output=str_replace("cover_url", "../public/".$articleInfo[2],$output);
$output=str_replace("{description}", $articleInfo[3],$output);
$output = str_replace("{air_date}", $newDate, $output);


$both_likes=setLikes($articleId);
$positive_votes=$both_likes[1];
$total_votes=$both_likes[0];

$output=str_replace("{likes}", ($positive_votes==null) ? 0 : $positive_votes,$output);
$output=str_replace("{dislikes}", (($total_votes-$positive_votes)==null) ? 0 : ($total_votes-$positive_votes) ,$output); 

$check = like_check($articleId);
switch($check) {
  case 1:
    $output = str_replace("{like-selected}", "thumb-selected", $output);
  break;
  case 0:
    $output = str_replace("{dislike-selected}", "thumb-selected", $output);
  break;
  case -1: {
    $output = str_replace("{like-selected}", " ", $output);
    $output = str_replace("{dislike-selected}", " ", $output);
  } break;
}


$comments=Comment::getCommentsFor($articleId);
$output = str_replace("{commentList}", getCommentList($comments), $output);
$output = str_replace("{movieList}", getSimilarMovies($realGenre, $genre_variable), $output);



function loadInfo($id){
  $list=Article::fetch($id);

  $arr=array($list->title, $list->coverUrl, $list->description);
  return $arr;
}

function setLikes($iddd){
  $likes_list = Article::list();
  for($p=0; $p<count($likes_list); $p++){
    $lola=$likes_list[$p]->id;
    if($iddd==$lola){
      return $arr2=array($likes_list[$p]->votesTotal, $likes_list[$p]->votesPositive);
    }
  }
}

function like_check($id) {
  $votedMovies = null;
  if (SessionManager::isUserLogged()) {
    $userId = SessionManager::getUserId();
    $votedMovies = Article::getUserVotes($userId);
  }   
  if ($votedMovies != null) {
    for ($x = 0; $x < count($votedMovies); $x++) {
      if ($votedMovies[$x]->article_id == $id) {
        switch ($votedMovies[$x]->positive) {
          case 1:
            return 1;
          break;
          case 0:
            return 0;
          break;
        }
      }
    }
    return -1;
  } else {
    return -1;
  }
}

function getCommentList($comments) {
  $commentList = [];
  $y=0;

  for ($x = 0; $x < count($comments); $x++) {
    
    $contenuto = $comments[$x]->content;
    $nome_commento=$comments[$x]->userFullName;
    $id_to_url=$comments[$x]->userId;

    $id_to_url_aux=Comment::getAvatar($id_to_url);
    $finally_url=$id_to_url_aux[$y]->avatar_url;
    
    $commento = file_get_contents("../html/comment.html");
    $commento = str_replace("{nome_commento}", $nome_commento, $commento);
    $commento = str_replace("{contenuto_commento}", $contenuto, $commento);
    $commento = str_replace("avatar_url_commento", "../public/".$finally_url, $commento);

    array_push($commentList, $commento);
  }
  return implode($commentList);
}

?>
