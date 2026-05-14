<?php
class Database {
    private static $instance = null;
    private $pdo;
    
    private function __construct() {
        try {
            $this->ensureMysqlIsReady('127.0.0.1', 3306, 3);

            $this->pdo = new PDO(
                'mysql:host=127.0.0.1;port=3306;dbname=workwave6_0;charset=utf8',
                'root',
                '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_TIMEOUT => 5
                ]
            );
        } catch(PDOException $e) {
            throw new RuntimeException("Connection failed: " . $e->getMessage(), 0, $e);
        } catch(Throwable $e) {
            throw new RuntimeException("Connection failed: " . $e->getMessage(), 0, $e);
        }
    }

    private function ensureMysqlIsReady($host, $port, $timeout) {
        $socket = @stream_socket_client(
            "tcp://{$host}:{$port}",
            $errno,
            $errstr,
            $timeout,
            STREAM_CLIENT_CONNECT
        );

        if (!$socket) {
            throw new RuntimeException("MySQL is not reachable on {$host}:{$port}.");
        }

        stream_set_timeout($socket, $timeout);
        $handshake = fread($socket, 4);
        $meta = stream_get_meta_data($socket);
        fclose($socket);

        if ($meta['timed_out'] || $handshake === '') {
            throw new RuntimeException('MySQL started but is not ready to accept connections yet.');
        }
    }
    
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function getConnection() {
        return $this->pdo;
    }
}
?>
