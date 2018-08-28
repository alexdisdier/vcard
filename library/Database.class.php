<?php

class Database
{
	private $pdo;

	public function __construct()
	{
		$configuration = new Configuration();

		$this->pdo = new PDO
		(
			$configuration->get('database', 'dsn'),
			$configuration->get('database', 'user'),
			$configuration->get('database', 'password')
		);

		$this->pdo->exec('SET NAMES UTF8');
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function executeSql($sql, array $values = array())
	{
		$query = $this->pdo->prepare($sql);

		$query->execute($values);

		return $this->pdo->lastInsertId();
	}

  public function query($sql, array $criteria = array())
  {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  public function queryOne($sql, array $criteria = array())
  {
        $query = $this->pdo->prepare($sql);

        $query->execute($criteria);

        return $query->fetch(PDO::FETCH_ASSOC);
    }
}
