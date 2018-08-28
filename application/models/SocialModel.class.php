<?php

class SocialModel
{
  public function create($socialName, $socialUrl)
  {

    $sql = 'INSERT INTO social_media
    (
      social_name,
      social_url
    )   VALUES (?,?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $socialName,
      $socialUrl
    ]);
  }

  public function find($socialId)
  {
    $database = new Database();

    $sql = 'SELECT
    social_name,
    social_url
    FROM social_media
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $socialId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    social_name,
    social_url
    FROM social_media';

    // Get all data
    return $database->query($sql);
  }

  public function update($socialName,$socialUrl)
  {
    $sql = "UPDATE `social_media`
    SET
    social_name     = '$socialName',
    social_url      = '$socialUrl'
    WHERE id = id";

    // Update the "social_media" table
    $database = new Database();

    $database->executeSql($sql,
    [
      $socialName,
      $socialUrl
    ]);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE social_media';

    $database = new Database();

    return $database->executeSql($delete);
  }
}
