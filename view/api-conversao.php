<?php

// --- CONFIGURAÇÃO ---
// Substitua por sua chave de API real da ExchangeRate-API (ou outra API de sua escolha)
define('EXCHANGE_RATE_API_KEY', 'dd9e6ff28fc35b57dee0f862'); // <-- SUBSTITUA AQUI!
define('EXCHANGE_RATE_API_URL', 'https://v6.exchangerate-api.com/v6/' . EXCHANGE_RATE_API_KEY . '/latest/BRL');

// Definir o cabeçalho para retornar JSON
header('Content-Type: application/json');

// --- FUNÇÃO PARA OBTER AS TAXAS DE CÂMBIO ---
function getExchangeRates() {
    $ch = curl_init(); // Inicializa uma nova sessão cURL
    curl_setopt($ch, CURLOPT_URL, EXCHANGE_RATE_API_URL); // Define a URL para buscar
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a transferência como uma string

    $response = curl_exec($ch); // Executa a sessão cURL e obtém a resposta

    if (curl_errno($ch)) { // Verifica se houve algum erro na requisição cURL
        error_log("Erro ao conectar à API de taxas de câmbio: " . curl_error($ch));
        curl_close($ch);
        return null;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtém o código de status HTTP
    curl_close($ch); // Fecha a sessão cURL

    if ($http_code !== 200) { // Verifica se a requisição foi bem-sucedida (código 200)
        error_log("Erro na API de taxas de câmbio (HTTP {$http_code}): " . $response);
        return null;
    }

    $data = json_decode($response, true); // Decodifica a resposta JSON

    if (json_last_error() !== JSON_ERROR_NONE) { // Verifica erros na decodificação JSON
        error_log("Erro ao decodificar JSON da API de taxas de câmbio: " . json_last_error_msg());
        return null;
    }

    if (isset($data['result']) && $data['result'] === 'success') {
        return $data['conversion_rates'];
    } else {
        error_log("Erro na API de taxas de câmbio: " . ($data['error-type'] ?? 'Erro desconhecido'));
        return null;
    }
}

// --- LÓGICA DA API ---

// Verifica se o parâmetro 'amount' foi fornecido
if (!isset($_GET['amount'])) {
    echo json_encode(['error' => 'Parâmetro \'amount\' é obrigatório.']);
    http_response_code(400); // Bad Request
    exit;
}

$amount = $_GET['amount'];

// Valida se o 'amount' é um número
if (!is_numeric($amount)) {
    echo json_encode(['error' => 'Valor \'amount\' inválido. Deve ser um número.']);
    http_response_code(400); // Bad Request
    exit;
}

$amount = (float) $amount; // Converte para float

if ($amount < 0) {
    echo json_encode(['error' => 'O valor a ser convertido não pode ser negativo.']);
    http_response_code(400); // Bad Request
    exit;
}

// Obtém as taxas de câmbio
$rates = getExchangeRates();

if (is_null($rates)) {
    echo json_encode(['error' => 'Não foi possível obter as taxas de câmbio no momento. Tente novamente mais tarde.']);
    http_response_code(503); // Service Unavailable
    exit;
}

// Extrai as taxas para Dólar e Euro
$dollar_rate = $rates['USD'] ?? null;
$euro_rate = $rates['EUR'] ?? null;

if (is_null($dollar_rate) || is_null($euro_rate)) {
    echo json_encode(['error' => 'Não foi possível encontrar as taxas para USD ou EUR.']);
    http_response_code(500); // Internal Server Error
    exit;
}

// Realiza as conversões
$converted_dollar = $amount * $dollar_rate;
$converted_euro = $amount * $euro_rate;

// Prepara a resposta JSON
$response_data = [
    "original_amount" => $amount,
    "currency_from" => "BRL",
    "conversions" => [
        "USD" => round($converted_dollar, 2),
        "EUR" => round($converted_euro, 2)
    ],
    "rates_used" => [
        "USD" => $dollar_rate,
        "EUR" => $euro_rate
    ],
    "last_updated" => $rates['time_last_update_utc'] ?? 'N/A'
];

echo json_encode($response_data, JSON_PRETTY_PRINT); // JSON_PRETTY_PRINT para formatar a saída
?>