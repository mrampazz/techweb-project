<?php
$articleId = $_GET["articleId"];
manageMessage($output);

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
$output = str_replace("{article-price}", number_format((float)$articlePrice, 2, '.', ''),$output);
$output = str_replace("{article-description}", $articleDescription,$output);
$output = str_replace("{article-release-date}", $formattedDate, $output);
$output = str_replace("article-purchase-url", (substr($purchaseLink, 0, 4) != "http") ? "//".$purchaseLink : $purchaseLink, $output);


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
//check if a previously written comment needs to be restored
if (isset($_SESSION['comment']) && !isset($_SESSION['is-comment-published'])){
  $output = str_replace("{comment-input}", $_SESSION['comment'], $output);
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

Utils::unsetAll(array('comment','error-message','is-comment-published','is-comment-deleted'));


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

    // if the comment belongs to the logged-in user or if admin-->shows the delete button
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

//checks whether a message (error or confirmation) should be displayed
function manageMessage(&$output){
  if(isset($_SESSION['error-message']) || (isset($_SESSION['is-comment-published']) && empty($_SESSION['is-comment-published']))){
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","error-message-box",$output);
    $output = str_replace("{message-box-title}","Errore caricamento commento",$output);
    if (isset($_SESSION['error-message']))
      $output = str_replace("{message-box-text}","Si è verificato un problema durante l'invio del tuo commento. ".$_SESSION['error-message'],$output);
    else
      $output = str_replace("{message-box-text}","Si è verificato un problema durante l'invio del tuo commento.",$output);
  }
  else if(isset($_SESSION['is-comment-deleted'])){
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    if ($_SESSION['is-comment-deleted'] === true){
      $output = str_replace("{message-box-class}","success-message-box",$output);
      $output = str_replace("{message-box-title}","Commento cancellato!",$output);
      $output = str_replace("{message-box-text}","Il commento da te selezionato è stato correttamente rimosso.",$output);
    }
    else{
      $output = str_replace("{message-box-class}","error-message-box",$output);
      $output = str_replace("{message-box-title}","Errore eliminazione commento",$output);
      $output = str_replace("{message-box-text}","Ci dispiace, si è verificato un errore durante l'eliminazione del commento.",$output);
    }
  }
  else if(isset($_SESSION['is-comment-published']) &&  $_SESSION['is-comment-published']===true){
    $page = file_get_contents("../html/message-box.html");
    $output = str_replace("{message-box}",$page,$output);
    $output = str_replace("{message-box-class}","success-message-box",$output);
    $output = str_replace("{message-box-title}","Commento pubblicato!",$output);
    $output = str_replace("{message-box-text}","Il tuo commento è stato correttamente pubblicato. Grazie per aver condiviso la tua opinione!",$output);
  }
  else{
    $output = str_replace("{message-box}","",$output);
  }
}
?>
