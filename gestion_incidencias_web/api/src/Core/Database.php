<?php
    #Llamamos al namespace y usamos las clases externas
    namespace App\Core;
    use PDO;
    use PDOException;

    #Definimos la clase y la propiedad estática
    class Database{
        private static ?PDO $instance = null;

        #Definimos el constructor privado
        private function __construct() {}

        #En el método estático, vamos a verificar si la instancia es nula,
        #de ser así, entonces se obtendrán los parámetros de las variables 
        #del archivo ".env"
        public static function getInstance(): PDO
        {
            if (self::$instance === null) {
                try {
                    #Gracias a los parámetros se configura la conexión
                    #de forma flexible
                    $host = $_ENV['DB_HOST'];
                    $port = $_ENV['DB_PORT'];
                    $dbname = $_ENV['DB_NAME'];
                    $user = $_ENV['DB_USER'];
                    $pass = $_ENV['DB_PASS'];
    
                    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    
                    self::$instance = new PDO($dsn, $user, $pass);
                    self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    self::$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                } catch (PDOException $e) {
                    die("❌ Error de conexión a la base de datos: " . $e->getMessage());
                }
            }
            return self::$instance;   
        }
    }
?>