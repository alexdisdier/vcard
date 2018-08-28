<?php


class LogoutController
{
	public function httpGetMethod(Http $http)
	{
		// We destroy the user session
		$userSession = new UserSession();
		$userSession->destroy();

 		// Then we redirect the user to homepage
		$http->redirectTo('/');
	}
}
