<!-- Davi de Assis Fabricio e Vinicius Queiroz -->
<?php
// Configuração do Banco de Dados
class Database {
    private $host = 'localhost';
    private $db_name = 'financai_db';
    private $username = 'root'; // Altere conforme sua configuração
    private $password = '';     // Altere conforme sua configuração
    private $conn;

    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        
        return $this->conn;
    }
}

// Função helper para conectar ao banco
function getDBConnection() {
    $database = new Database();
    return $database->getConnection();
}
?>