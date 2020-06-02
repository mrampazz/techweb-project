<?php
$articleId = $_GET["articleId"];

//--ARTICLE INFO--
$articleInfo = loadInfo($articleId);
$articleFullName = $articleInfo["brand"]." ".$articleInfo["model"];
$articleImageUrl = $articleInfo["urlImage"];
$articlePrice = $articleInfo["initialPrice"];
$releaseDate = $articleInfo["launchDate"];
$articleDescription = $articleInfo["description"];
$purchaseLink = $articleInfo["purchaseLink"];
$formattedDate = date("d-m-Y", strtotime($releaseDate));

$output = str_replace("{article-id}",$articleId,$output);
$output = str_replace("article-id-link",$articleId,$output);
$output = str_replace("{article-name}", $articleFullName,$output);
$output = str_replace("article-image-url", "../assets/img/articles/".$articleImageUrl,$output);
$output = str_replace("{article-price}", $articlePrice,$output);
$output = str_replace("{article-description}", $articleDescription,$output);
$output = str_replace("{article-release-date}", $formattedDate, $output);
$output = str_replace("article-purchase-url", $purchaseLink, $output);


//--LIKES--
//obtains and sets users' votes for the article
$totalVotes = getTotalAndPositiveVotes($articleId)[0];
$positiveVotes = getTotalAndPositiveVotes($articleId)[1];
$negativeVotes = $totalVotes-$positiveVotes;
$output = str_replace("{article-likes}", ($positiveVotes==null) ? "0" : $positiveVotes, $output);
$output = str_replace("{article-dislikes}", ($negativeVotes==null) ? "0" : $negativeVotes, $output); 

//check if the user is logged and shows elements accordingly 
if (!SessionManager::isUserLogged()){
  $output = str_replace("{comment-form-visible}", "hidden", $output);
  $output = str_replace("{login-link-visible}", "", $output);
  $output = str_replace("login-url", SessionManager::BASE_URL."login"."&articleId=".$articleId, $output);
}
else{
  $output = str_replace("{comment-form-visible}", "", $output);
  $output = str_replace("{login-link-visible}", "hidden", $output);
  $output = str_replace("login-url", "", $output);
}
//check whether or not the user likes the article and set the thumb accordingly
$check = likeCheck($articleId);
switch($check) {
  case 1: //like
    $output = str_replace("{like-selected}", "thumb-selected", $output);
  break;
  case 0: //dislike
    $output = str_replace("{dislike-selected}", "thumb-selected", $output);
  break;
  default: { //no opinion or not logged
    $output = str_replace("{like-selected}", "", $output);
    $output = str_replace("{dislike-selected}", "", $output);
  } break;
}


//--COMMENTS--
//check if an error has occurred
if(isset($_SESSION['error-message']) && isset($_SESSION['login']) && !$_SESSION['login']) {
  $output = str_replace("<div class=\"margin-top-2 hidden\">","<div class=\"margin-top-2\" tabindex=\"0\">",$output);
  $output = str_replace("{error-message}",$_SESSION['error-message'],$output);
  unset($_SESSION['error-message']);
}
//check if a previously written comment needs to be restored
if (isset($_SESSION['comment'])){
  $output = str_replace("{comment-input}", $_SESSION['comment'], $output);
  unset($_SESSION['comment']);
}
else{
  $output = str_replace("{comment-input}", "", $output);
}

$comments = Comment::getCommentsFor($articleId);
if (!empty($comments)){
  $output = str_replace("{comment-list}", getCommentList($comments), $output);
}
else{
  $output = str_replace("{comment-list}", "<p class=\"font-size-0-75 text-align-center\"> Nessun commento presente per questo prodotto. </p>", $output);
}



//--HELPER FUNCTIONS--
function loadInfo($id){
  $list = Article::fetch($id);
  return array("brand"=>$list->brand, "model"=>$list->model, "urlImage"=>$list->image, "initialPrice"=>$list->initialPrice,
   "launchDate"=>$list->launchDate, "description"=>$list->content, "purchaseLink"=>$list->link);
}

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
    for ($i = 0; $i < count($votedArticles); $i++) {
      if ($votedArticles[$i]->article_id == $id) {
        return $votedArticles[$i]->positive ? 1 : 0;  
      }
    }
  } 
  return -1;
}

function getCommentList($comments) {
  $commentList = [];

  for ($i = 0; $i < count($comments); $i++) {
    $commentContent = $comments[$i]->content;
    $userFullName = $comments[$i]->userFullName;
    $commentUserId = $comments[$i]->userId;
    $userAvatar = Comment::getAvatar($commentUserId);
    $userAvatarUrl = $userAvatar[0]->avatar_url;

    if ($commentUserId == SessionManager::getUserId() || SessionManager::userCanPublish()){
      SessionManager::userCanPublish() ? $isPersonalComment = false : $isPersonalComment = true;
      $comment = file_get_contents("../html/comment-deletable.html");
      $comment = str_replace("delete-comment-url", "../php/delete_comment.php?articleId=".$_GET["articleId"], $comment);
      $comment = str_replace("{comment-id}", $comments[$i]->id, $comment);
    }
    else{
      $isPersonalComment = false;
      $comment = file_get_contents("../html/comment.html"); 
    }
    $comment = str_replace("{user-full-name-comment}", $userFullName, $comment);
    $comment = str_replace("{content-comment}", $commentContent, $comment);
    $comment = str_replace("avatar-url-comment", "../assets/img/avatars/".$userAvatarUrl, $comment);

    //shows personal comments first if it is not admin
    $isPersonalComment ? array_unshift($commentList, $comment) : array_push($commentList, $comment);
  }
  return implode($commentList);
}
?>
