<?php


class UserModel
{

  function userExist()
  {
    $database = new Database();

    $sql = 'SELECT
    Email
    FROM User';

    // Récupération de l'utilisateur ayant l'email spécifié en argument.
    $user = $database->queryOne($sql);

    // Have we found the user in our "User" table ?
    if(empty($user) == false)
    {
      throw new DomainException
      (
        "Only one user can be registered on this website."
      );
    }

    return $user;
  }

  public function find($userId)
  {
    $database = new Database();

    // Find the specific user
    return $database->queryOne
    (
      "SELECT
      Id,
      LastName,
      FirstName,
      Email,
      Password
      FROM User
      WHERE Id = ?",
      [ $userId ]
    );
  }

  public function findWithEmail($email)
  {
    $database = new Database();

    // Get the password in relation with the $email passed as the argument
    $user = $database->queryOne
    (
      "SELECT
      Password
      FROM User
      WHERE Email = ?",
      [ $email ]
    );
    return $user;
  }

  public function findWithEmailPassword($email, $password)
  {
    $database = new Database();

    // Get the user detais according to the arguments $email and $password
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

    // Have we found the user in our "User" table ?
    if(empty($user) == true)
    {
      throw new DomainException
      (
        "There is no account associated with this email."
      );
    }

    // Does the password match the one within the "User" table ?
    if($this->verifyPassword($password, $user['Password']) == false)
    {
      throw new DomainException
      (
        'Wrong password. Try again or click Forgot password to reset it.'
      );
    }

    return $user;
  }

  private function hashPassword($password)
  {
    /*
    * Salt key generator. It need the php extension OpenSSL.
    *
    * openssl_random_pseudo_bytes() will Generate a pseudo-random string of bytes.
    * However, the blowfish encryption needs a salt solely with the following characters: a-z, A-Z ou 0-9.
    *
    * We therefore have to use bin2hex() to convert the result into a hexadecimal string of characters.
    * We then hash it at 22 characters to make sure we get the right length
    * necessary to build the blowfish encryption
    */
    $salt = '$2y$11$'.substr(bin2hex(openssl_random_pseudo_bytes(32)), 0, 22);

    // Read TFM crypt() : http://devdocs.io/php/function.crypt
    return crypt($password, $salt);
  }

  public function signUp($lastName,$firstName,$email,$password)
  {
    $database = new Database();

    // We check if a user exists with this $email
    $user = $database->queryOne
    (
      "SELECT Id FROM User WHERE Email = ?", [ $email ]
    );

    // Did we find a user ?
    if(empty($user) == false)
    {
      throw new DomainException
      (
        "That username is taken. Only one username can create an account"
      );
    }

    $sql = "INSERT INTO User
    (
      LastName,
      FirstName,
      Email,
      Password
    ) VALUES (?, ?, ?, ?)";

    /*
    * Hashing the password which means the password as it stands cannot be * found.
    */
    $passwordHash = $this->hashPassword($password);

    // Insert the user into the table "User"
    $database->executeSql($sql,
    [
      $lastName,
      $firstName,
      $email,
      $passwordHash,
    ]);

    // Display a notification that will appear on the homepage
    $flashBag = new FlashBag();
    $flashBag->add('Your account has been successfully created.');
  }

  public function updateLoginTimestamp($userId)
  {
    // Update the last time this user was logged in
    $database = new Database();
    $database->executeSql
    (
      "UPDATE User SET LastLoginTimestamp = NOW()	WHERE Id = ?",
      [ $userId ]
    );
  }

  private function verifyPassword($password, $hashedPassword)
  {
    // If the clear password is the same as the hashed pasword, return true.
    return crypt($password, $hashedPassword) == $hashedPassword;
  }

  // This function updates the old user password.
  public function resetPassword($newPassword)
  {
    // We reuse the hashPassword function
    $passwordHash = $this->hashPassword($newPassword);

    $sql = "UPDATE `User`
    SET
    Password = '$passwordHash'
    WHERE id = id";

    // Mise à jour de la table "quotes".
    $database = new Database();

    $database->executeSql($sql,
    [
      $passwordHash
    ]);

    // Display a notification that will appear on the homepage
    $flashBag = new FlashBag();
    $flashBag->add('Your password has been changed successfully');
  }

}
