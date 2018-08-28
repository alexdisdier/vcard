<?php
//Based on source: https://www.johnmorrisonline.com/create-email-based-password-reset-feature-login-script/

class TokenController
{
	public function httpGetMethod()
	{
		return [ '_form' => new TokenForm()	];
	}

	public function httpPostMethod(Http $http, array $formFields)
	{

		// Create random selector and convert it into hexadecimal
		$selector = bin2hex(random_bytes(8));

		// Create random token and hash it
		$token = random_bytes(128);
		$token = hash('sha256', $token);

		// Creat the link the user we'll have to click on to reset his password
		$url = sprintf('%s/index.php/user/reset?%s', $_SERVER['HTTP_HOST'] , http_build_query([
			'selector' => $selector,
			'validator' => bin2hex($token)
		]));

		// Token expiration in 1 hour (not working at the moment) Not working at the moment
		$expires = new DateTime('NOW');
		$expires = $expires->add(new DateInterval('PT01H')); // + 1 hour
		$expires = $expires->format('U'); // returns the date in secondes from Unix time (january 1st 1970, 0H00 00s GMT

		$resetModel = new ResetModel();

		// We delete and reset auto increment
		$resetModel->truncate();

		// Then we recreate the row
		$resetModel->create
		(
			$formFields['email'],
			$selector,
			$token,
			$expires
		);

		// Try sending the email to the user
		try
		{
			$user = $resetModel->findWithEmail($formFields['email']);
			$adminEmail = implode(adminEmail());
			$adminName = implode(" " , adminName());

			// Recipient
			$to = $formFields['email'];

			// Subject
			$subject = 'Your password reset link';

			// Message
			$message = '<p>We received a password reset request. The link to reset your password is below. ';
			$message .= 'If you did not make this request, you can ignore this 	email</p>';
			$message .= '<p>Here is your password reset link:</br>';
			$message .= sprintf('<a href="%s">%s</a></p>', $url, $url);
			$message .= '<p>Thanks!</p>';

			// Headers
			$headers = "From: " . $adminName . " <" . $adminEmail . ">\r\n";
			$headers .= "Reply-To: " . $adminEmail . "\r\n";
			$headers .= "Content-type: text/html\r\n";

			// Send email
			mail($to, $subject, $message, $headers);

			// redirect the user to homepage
			$http->redirectTo('/');
		}

		catch(DomainException $exception)
		{
			// Show the message on the front
			$form = new tokenForm();
			$form->bind($formFields);
			$form->setErrorMessage($exception->getMessage());

			return [ '_form' => $form ];
		}
	}
}
