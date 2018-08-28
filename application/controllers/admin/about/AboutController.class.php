<?php

class AboutController
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
  // - ./www/admin/about/AboutView.phtml
  public function httpPostMethod(Http $http, array $formFields)
  {

    $aboutModel = new AboutModel();

    // Before inserting the new data from our form,
    // we delete the table and reset the id to 1
    $aboutModel->truncate();

    // The following enables the user to add apostrophes into the table
    // in case it doesn't automatically works.

    // $aboutModel->insertApostrophe($formFields['content_long']);
    // $aboutModel->insertApostrophe($formFields['content_short']);
    // $aboutModel->insertApostrophe($formFields['residence']);
    // $aboutModel->insertApostrophe($formFields['job_type']);
    // $aboutModel->insertApostrophe($formFields['job_availability']);

    // We create our row in our 'about' table
    $aboutModel->create
    (
      $formFields['content_short'],
      $formFields['content_long'],
      $formFields['residence'],
      $formFields['email'],
      $formFields['job_type'],
      $formFields['job_availability'],
      $formFields['portfolio_url']
    );

    // Uncomment below if you want to log out the user after editing,
    // $userSession = new UserSession();
    // $userSession->destroy();

    // Once the data have been input, redirect the user to homepage
    $http->redirectTo('/');
  }
}
