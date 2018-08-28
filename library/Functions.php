<?php
/**
 * functions.php
*/

// function addApostropheSql(){
//   return $formFields['content_short'] = str_replace("'", "&#039;", $_POST['content_short']);
//
// }

// Verify if the user already has an account
function userExist()
{
  $database = new Database();

  $sql = 'SELECT
  Email
  FROM User';

  // Get the user whose email has been specified
  $user = $database->queryOne($sql);

  return $user;
}

// Verify if the user already has an administrator account
function adminEmail()
{
  $database = new Database();

  $sql = 'SELECT
  Email
  FROM User';

    // Get the user whose email has been specified
  $user = $database->queryOne($sql);

  return $user;
}

function adminName()
{
  $database = new Database();

  $sql = 'SELECT
  FirstName,
  LastName
  FROM User';

  $user = $database->queryOne($sql);

  return $user;
}

// Create icon depending the argument
function icon($svg_icons) {

  require 'svg.php';

  switch ($svg_icons) {
    case 'pen':
    echo $pen;
    break;
    case 'smile':
    echo $smile;
    break;
    case 'forbidden':
      echo $forbidden;
      break;
    }
  }

  function social_media($name){

    // svg.php manages all my svgs
    require 'svg.php';

    // Pour assurer toutes les façons que l'utilisateur peut rentrer le nom
    $name = strtolower($name);

    switch ($name) {
      case 'facebook':
      echo $facebook;
      break;

      case 'flickr':
      echo $flickr;
      break;

      case 'github':
      echo $github;
      break;

      case 'googleplus':
      echo $googleplus;
      break;

      case 'instagram':
      echo $instagram;
      break;

      case 'linkedin':
      echo $linkedin;
      break;

      case 'medium':
      echo $medium;
      break;

      case 'twitter':
      echo $twitter;
      break;

      case 'youtube':
      echo $youtube;
      break;

      default:
      echo "no svg found";
      break;
    }
  }
