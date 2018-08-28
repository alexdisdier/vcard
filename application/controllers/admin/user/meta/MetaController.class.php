<?php

class MetaController
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
  // - ./www/admin/user/meta/MetaView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {
    // Check if user has uploaded an image
    // If true, then we upload the file in /assets/images
    // Else, we set the default image
    if($http->hasUploadedFile('site_icon') == true)
    {
      $siteIcon = $http->moveUploadedFile('site_icon', '/assets/images');
    }
    else {
      $siteIcon = 'default-favicon.png';
    }

    $metaModel = new MetaModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $metaModel->truncate();

    // We create a new row in our 'meta' table
    $metaModel->create
      (
        $formFields['site_title'],
        $formFields['site_description'],
        $siteIcon,
        $formFields['google_analytics']
      );

      // Uncomment below if you want to log out the user after editing,
      // $userSession = new UserSession();
      // $userSession->destroy();

      // Once the data have been input, redirect the user to home page
      $http->redirectTo('/');
    }
}
