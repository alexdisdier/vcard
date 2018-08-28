<?php

class MetaModel
{
  public function create($siteTitle, $siteDescription, $siteIcon, $googleAnalytics)
  {
    $sql = 'INSERT INTO meta
    (
      site_title,
      site_description,
      site_icon,
      google_analytics
    ) VALUES (?, ?, ?, ?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $siteTitle,
      $siteDescription,
      $siteIcon,
      $googleAnalytics
    ]);
  }

  public function find($metaId)
  {
    $database = new Database();

    $sql = 'SELECT
    site_title,
    site_description,
    site_icon,
    google_analytics
    FROM meta
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $metaId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    site_title,
    site_description,
    site_icon,
    google_analytics
    FROM meta';

    // Get all data
    return $database->query($sql);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE meta';

    $database = new Database();

    return $database->executeSql($delete);
  }

}
