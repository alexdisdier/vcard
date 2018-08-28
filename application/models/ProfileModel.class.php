<?php

class ProfileModel
{
  public function create($profileImage)
  {

    $sql = 'INSERT INTO profile
    (
      profile_img
    )   VALUES (?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $profileImage
    ]);
  }

  public function find($profileId)
  {
    $database = new Database();

    $sql = 'SELECT
    profile_img
    FROM profile
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $profileId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    profile_img
    FROM profile';

    // Get all data
    return $database->query($sql);
  }

  public function update($profileImage)
  {
    $sql = "UPDATE `profile`
    SET
    profile_img = '$profileImage'
    WHERE id = id";

    // Update the "profile" table
    $database = new Database();

    $database->executeSql($sql,
    [
      $profileImage
    ]);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE profile';

    $database = new Database();

    return $database->executeSql($delete);
  }

  // Check if data already exist in the table
  public function countRow(){

    $countRow = 'SELECT count(*) FROM profile';

    $database = new Database();

    return $database->executeSql($countRow);


  }
}
