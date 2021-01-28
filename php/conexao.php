 <?php

/**
 * 
 */
class Conexao
{
	private static $con;

	public static function getConexao()
	{
		if (self::$con == null) {
			self::$con = new PDO("mysql:host=127.0.0.1;dbname=docs", 'root', '');
		}
		return self::$con;
	}
}