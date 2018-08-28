<?php


class Configuration
{
	private static $registry;

	public function __construct()
	{
		if(Configuration::$registry === null)
		{
			Configuration::$registry = array();
		}
	}

	public function get($filename, $key, $defaultValue = null)
	{
		if(array_key_exists($filename, Configuration::$registry) === true)
		{
			if(array_key_exists($key, Configuration::$registry[$filename]) === true)
			{
				return Configuration::$registry[$filename][$key];
			}
		}

		return $defaultValue;
	}

	public function load($filename)
	{
		require_once CFG_PATH."/$filename.php";

		Configuration::$registry[$filename] = $config;
	}
}
