<?php

class CoverModel
{
  public function create($coverImage)
  {

    $sql = 'INSERT INTO cover
    (
      cover_img
    )   VALUES (?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $coverImage
    ]);

    /** Since the user sees right away his data changed,
    *   I didn't feel the need to display an extra message
    *   Possibility of displaying a message to the user. Uncomment below
    */

    // $flashBag = new FlashBag();
    // $flashBag->add('Votre Image Cover a bien été enregistrée');
  }

  public function find($coverId)
  {
    $database = new Database();

    $sql = 'SELECT
    cover_img
    FROM cover
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $coverId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    cover_img
    FROM cover';

    // Get all data
    return $database->query($sql);
  }

  public function update($coverImage)
  {
    $sql = "UPDATE `cover`
    SET
    cover_img = '$coverImage'
    WHERE id = id";

    // Update the "cover" table
    $database = new Database();

    $database->executeSql($sql,
    [
      $coverImage
    ]);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE cover';

    $database = new Database();

    return $database->executeSql($delete);
  }

  // Check if data already exist in the table
  public function countRow(){

    $countRow = 'SELECT count(*) FROM cover';

    $database = new Database();

    return $database->executeSql($countRow);

  }
}
