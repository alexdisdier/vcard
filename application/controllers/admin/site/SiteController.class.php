<?php

class SiteController
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
  // - ./www/admin/quotes/QuotesView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {

    $siteModel = new SiteModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $siteModel->truncate();

    // We create a new row in our 'site_description' table
    $siteModel->create
      (
        $formFields['first_name'],
        $formFields['last_name']
      );

      // Uncomment below if you want to log out the user after editing,
      // $userSession = new UserSession();
      // $userSession->destroy();

      // Once the data have been input, redirect the user to home page
      $http->redirectTo('/');
    }
}
