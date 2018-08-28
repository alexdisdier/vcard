<?php

class SiteModel
{
  public function create($firstName, $lastName)
  {
    $sql = 'INSERT INTO site_description
    (
      first_name,
      last_name
    ) VALUES (?, ?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $firstName,
      $lastName
    ]);
  }

  public function find($siteId)
  {
    $database = new Database();

    $sql = 'SELECT
    first_name,
    last_name
    FROM site_description
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $siteId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT * FROM site_description';

    // Get all data
    return $database->query($sql);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE site_description';

    $database = new Database();

    return $database->executeSql($delete);
  }

}
