<?php

class QuotesModel
{
  public function create($quoteContent)
  {

    $sql = 'INSERT INTO quotes
    (
      quote_content
    )   VALUES (?)';

    // Insert the data submitted through the form
    $database = new Database();
    $database->executeSql($sql,
    [
      $quoteContent
    ]);
  }

  public function find($quotesId)
  {
    $database = new Database();

    $sql = 'SELECT
    quote_content
    FROM quotes
    WHERE id = ?';

    // Get the individual data
    return $database->queryOne($sql, [ $quotesId ]);
  }

  public function listAll()
  {
    $database = new Database();

    $sql = 'SELECT
    quote_content
    FROM quotes';

    // Get all data
    return $database->query($sql);
  }

  public function update($quoteContent)
  {
    $sql = "UPDATE `quotes`
    SET
    quote_content = '$quoteContent'
    WHERE id = id";

    // Update the "quotes" table
    $database = new Database();

    $database->executeSql($sql,
    [
      $quoteContent
    ]);
  }

  public function truncate()
  {
    $delete = 'TRUNCATE TABLE quotes';

    $database = new Database();

    return $database->executeSql($delete);
  }
}
