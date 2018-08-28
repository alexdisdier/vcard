<?php

class SocialController
{
  public function httpGetMethod(Http $http)
  {
    $userSession = new UserSession();

    // We only have access if we're logged in
    if($userSession->isAuthenticated() == false)
    {

      // Otherwise, we redirect to the login page
      $http->redirectTo('/user/login');
    }
  }

  // Manipulate the data sent through the form
  // - ./www/admin/social/SocialView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {
    $socialModel = new SocialModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $socialModel->truncate();

    // Create a counter in order to control the amount of social network they can display on homepage.
    $count = 0;

    // Loop through the $formFields array
    for ($n = 0; $n < count($formFields)+6; $n++) {

      // Check if the user input a value and set $count maximum of 5
      if ( !empty($formFields['social_url'][$n]) && ($count < 5)) {

        // // We create a new row in our 'social' table
        $socialModel->create
        (
          $formFields['social_name'][$n],
          $formFields['social_url'][$n]
        );

        // We increment our counter
        $count ++;
      }
    }

    // Uncomment below if you want to log out the user after editing,
    // $userSession = new UserSession();
    // $userSession->destroy();

    // Once the data have been input, redirect the user to home page
    $http->redirectTo('/');
  }
}
