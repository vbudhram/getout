<?php
	class DBSettings
	{
		private static $username = "akushnir";
		private static $password = "password";
		private static $connectionString = '//oracle.cise.ufl.edu/orcl';
		
		public static function GetUsername()
		{
			return self::$username;
		}
		
		public static function GetPassword()
		{
			return self::$password;
		}
		
		public static function GetConnectionString()
		{
			return self::$connectionString;
		}
	}
?>
