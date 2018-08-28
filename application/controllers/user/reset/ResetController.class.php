<?php


class ResetController
{
	public function httpGetMethod()
	{
		return [ '_form' => new ResetForm() ];
	}

	public function httpPostMethod(Http $http, array $formFields)
	{

		try
		{

			$resetModel 	= new ResetModel();

			// Get the token details from the database -> models/ResetModel.class.php
			$results 			= $resetModel->getToken();

			// If we were to put an expiration date
			// $results = $this->db->get_results("SELECT * FROM password_reset WHERE selector = :selector AND expires >= :time", ['selector'=>$selector,'time'=>time()]);

			// Get the token details from the form submitted by the user
			$selector			= $formFields['selector'];
			$validator		= $formFields['validator'];
			$newPassword 	= $formFields['password'];

			if ( empty( $results ) ) {
				// Possibility of displaying a message to the user.
				$flashBag = new FlashBag();
				$flashBag->add("This link has expired. Try to resend the password");
				// redirect the user to homepage
				$http->redirectTo('/');
				// return array('status'=>0,'message'=>'There was an error processing your request. Error Code: 002');
			}

			// Get the details from our "password_reset" table at index 0.
			$auth_token			= $results[0]['token'];
			$auth_selector 	= $results[0]['selector'];
			$auth_email			= $results[0]['email'];

			// hex2bin function reformat the token validator into binary. Originally in TokenController.php, it was set with bin2hex.
			$calc = hash('sha256', hex2bin($validator));

			// Validate tokens
			// if ( hash_equals( $calc, $auth_token ) )  {
			if ( $selector == $auth_selector )  {

				// Check if the email attached to the token is the same as the user already registered in database
				$userModel = new UserModel();
				$userEmail = $userModel->findWithEmail
				(
					$auth_email
				);

				// Catch possible error
				if ( false === $userEmail ) {
					// Possibility of displaying a message to the user.
		      $flashBag = new FlashBag();
		      $flashBag->add("The email on file is different.");
					// redirect the user to homepage
					$http->redirectTo('/');
				}

				// We're ready to update the user's old password with the new one
				$update = $userModel->resetPassword
				(
					$newPassword
				);

				// Delete any existing password reset token
				$resetModel->truncate();

				if ( $update == true ) {
					// New password. New session.
					session_destroy();

					return array('status'=>1,'message'=>'Password updated successfully. <a href="index.php">Login here</a>');
				}
			}

			// redirect the user to homepage
			$http->redirectTo('/');
		}

		catch(DomainException $exception)
		{
			// Show the message on the front
			$form = new resetForm();
			$form->bind($formFields);
			$form->setErrorMessage($exception->getMessage());

			return [ '_form' => $form ];
		}
	}
}
