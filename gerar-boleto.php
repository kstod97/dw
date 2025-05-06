<?php



// 1) Conexão ao banco
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['login']) == 0) {
    header('location:index.php');
} else {

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

// 2) Validação da reserva
$bookingId = intval($_GET['booking_id'] ?? 0);
if (!$bookingId) {
    die("Reserva inválida.");
}

// 3) Busca dados da reserva e do cliente
$stmt = $pdo->prepare("
    SELECT b.*, u.FullName, u.EmailId, u.Address, u.City, u.Country
    FROM tblbooking AS b
    INNER JOIN tblusers AS u ON u.EmailId = b.userEmail
    WHERE b.id = :id
");
$stmt->execute([':id' => $bookingId]);
$booking = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$booking) {
    die("Reserva não encontrada.");
}

// 4) Define dados do boleto
$valorBoleto = number_format($booking['TotalPrice'], 2, ',', '');
$nossoNumero = str_pad($bookingId, 8, '0', STR_PAD_LEFT);
$dataVenc = date('d/m/Y', strtotime('+3 days'));

$dadosboleto = [
    // Dados fixos do cedente
    "agencia"         => "1234",
    "conta"           => "567890",
    "conta_dv"        => "1",
    "convenio"        => "1234567",
    "carteira"        => "06",
    "codigo_cedente"  => "7654321",

    // Dados do boleto
    "nosso_numero"     => $nossoNumero,
    "numero_documento" => date('Ymd') . $bookingId,
    "data_vencimento"  => $dataVenc,
    "data_documento"   => date('d/m/Y'),
    "data_processamento" => date('d/m/Y'),
    "valor_boleto"     => $valorBoleto,

    // Sacado
    "sacado"     => $booking['FullName'],
    "endereco1"  => $booking['Address'],
    "endereco2"  => "{$booking['City']} / {$booking['Country']}",

    // Instruções
    "instrucoes" => [
        "- Não receber após o vencimento",
        "- Após o vencimento cobrar multa de 2%"
    ],
];

// 5) Gera o boleto
require_once __DIR__ . '/boleto/funcoes_bradesco.php';
require_once __DIR__ . '/boleto/layout_bradesco.php';

$linha_digitavel = function_exists('monta_linha_digitavel') ? monta_linha_digitavel($dadosboleto) : '';

ob_start();
require_once __DIR__ . '/boleto/boleto_bradesco.php';
$html = ob_get_clean();

// 6) Salva dados no banco
$stmt = $pdo->prepare("
    INSERT INTO tblboleto (booking_id, nosso_numero, linha_digitavel, vencimento, valor, url_boleto, status)
    VALUES (:bid, :nn, :ld, :vcto, :val, :url, 1)
");
$stmt->execute([
    ':bid'  => $bookingId,
    ':nn'   => $nossoNumero,
    ':ld'   => $linha_digitavel,
    ':vcto' => date('Y-m-d', strtotime('+3 days')),
    ':val'  => $booking['TotalPrice'],
    ':url'  => null
]);
$boletoId = $pdo->lastInsertId();

// 7) Salva HTML em arquivo e atualiza URL no banco
$boletoFile = __DIR__ . "/boleto/boleto_$boletoId.html";
$url        = "/dw3/boleto/boleto_$boletoId.html";
file_put_contents($boletoFile, $html);

$pdo->prepare("UPDATE tblboleto SET url_boleto = :url WHERE id = :id")
    ->execute([':url' => $url, ':id' => $boletoId]);

// 8) Redireciona para o boleto
header("Location: $url");
exit;
}