<?php

class CoverController
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
  // - ./www/admin/site/SiteView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {

    // Check if user has uploaded an image
    // If true, then we upload the file in /assets/images
    // Else, we set the default image
    if($http->hasUploadedFile('cover_img') == true)
    {
      $coverImg = $http->moveUploadedFile('cover_img', '/assets/images');
    }
    else {
      $coverImg = 'default-cover.jpg';
    }

    $coverModel = new CoverModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $coverModel->truncate();

    // We create our row in our 'cover' table
    $coverModel->create
    (
      $coverImg
    );

    // Uncomment below if you want to log out the user after editing,
    // $userSession = new UserSession();
    // $userSession->destroy();

    // Once the data have been input, redirect the user to homepage
    $http->redirectTo('/');
  }
}
