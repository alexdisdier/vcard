<?php

class ResetModel
{
  public function create($email, $selector, $token, $expires)
  {
    $sql = 'INSERT INTO password_reset
    (
      email,
      selector,
      token,
      expires
    ) VALUES (?, ?, ?, ?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $email,
      $selector,
      $token,
      $expires
    ]);

  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE password_reset';

    $database = new Database();

    return $database->executeSql($delete);
  }

  public function findWithEmail($email)
  {
    $database = new Database();

    // Get the use details that matches the $email argument
    $user = $database->queryOne
    (
      "SELECT
      Id,
      LastName,
      FirstName,
      Email,
      Password
      FROM User
      WHERE Email = ?",
      [ $email ]
    );

    // Did we find the user ?
    if(empty($user) == true)
    {
      throw new DomainException
      (
        "No user was found with this email address."
      );
    }else{

      // Possibility of displaying a message to the user.
      $flashBag = new FlashBag();
      $flashBag->add("An email has been sent to reset your password.");
    }

    return $user;
  }

  // Function that retrieves the token created by the user when he submitted lost password (TokenController.php)
  public function getToken()
  {
    $database = new Database();

    $sql = "SELECT
    *
    FROM password_reset";

    // Get all data
    $results = $database->query($sql);

    return $results;
  }

}
