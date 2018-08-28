<?php

class AboutModel
{
  public function create($contentShort, $contentLong, $residence, $email, $jobType, $jobAvailability, $portfolioUrl)
  {
    $sql = 'INSERT INTO about
    (
      content_short,
      content_long,
      residence,
      email,
      job_type,
      job_availability,
      portfolio_url
    ) VALUES (?, ?, ?, ?, ?, ?, ?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $contentShort,
      $contentLong,
      $residence,
      $email,
      $jobType,
      $jobAvailability,
      $portfolioUrl
    ]);

    /** Since the user sees right away his data changed,
    *   I didn't feel the need to display an extra message
    *   Possibility of displaying a message to the user. Uncomment below
    */

    // $flashBag = new FlashBag();
    // $flashBag->add('Votre section about a bien été enregistré, vous pouvez logout.');

  }

  public function find($aboutId)
  {
    $database = new Database();

    $sql = 'SELECT
    content_short,
    content_long,
    residence,
    email,
    job_type,
    job_availability,
    portfolio_url
    FROM about
    WHERE id = ?';

    // Get only one row
    return $database->queryOne($sql, [ $aboutId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    content_short,
    content_long,
    residence,
    email,
    job_type,
    job_availability,
    portfolio_url
    FROM about';

    // Get all the data from the "about" table
    return $database->query($sql);
  }

  // Before inserting the new data from our form,
  // we delete the table and reset the id to 1
  public function truncate()
  {
    $delete = 'TRUNCATE TABLE about';

    $database = new Database();

    return $database->executeSql($delete);
  }

  // public function insertApostrophe($content){
  //   return $content = str_replace("'", "&#039;", $content);
  // }

}
