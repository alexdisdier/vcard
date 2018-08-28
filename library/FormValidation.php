<?php
/**
* FormValidation => Backend
*
* If the user tries to delete via devTool the required attribute, this will
* validate the form
* 
* Source: //www.w3schools.com/php/php_forms.asp
*/

// define variables and set to empty values
$firstNameErr = $lastNameErr  = $emailErr = $websiteErr = $passwordErr = "";
$firstName    = $lastName     = $email    = $website    = $password    = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  if (empty($_POST["firstName"])) {
    $firstNameErr = "First name is required";
  } else {
    $firstName = test_input($_POST["firstName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$firstName)) {
      $firstNameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["lastName"])) {
    $lastNameErr = "Last name is required";
  } else {
    $lastName = test_input($_POST["lastName"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$lastName)) {
      $lastNameErr = "Only letters and white space allowed";
    }
  }

  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

  if (empty($_POST["website"])) {
    $websiteErr = "";
  } else {
    $website = test_input($_POST["website"]);
    // check if URL address syntax is valid (this regular expression also allows dashes in the URL)
    if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteErr = "Invalid URL";
    }
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
