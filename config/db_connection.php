<?

try {
    $dsn = "pgsql:host=localhost;port=5432;dbname=annuity_management;user=postgres;password=admin";
    $pdo = new PDO($dsn);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}