<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Captura o CPF da query string
$cpf = isset($_GET['cpf']) ? preg_replace('/\D/', '', $_GET['cpf']) : null;

if (!$cpf) {
    echo json_encode(["error" => "CPF não fornecido"]);
    exit;
}

// URL da API externa (ajuste para o endpoint real)
$apiUrl = "https://api.seuservidor.com/consulta?cpf=" . urlencode($cpf);

try {
    // Inicia o cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // caso a API use SSL self-signed
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if (curl_errno($ch)) {
        echo json_encode(["error" => "Erro cURL: " . curl_error($ch)]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    // Verifica resposta
    if ($httpCode >= 200 && $httpCode < 300 && $response) {
        echo $response;
    } else {
        echo json_encode(["error" => "Erro ao consultar o servidor externo", "status" => $httpCode]);
    }

} catch (Exception $e) {
    echo json_encode(["error" => "Exceção: " . $e->getMessage()]);
}
?>
