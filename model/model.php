<?php
class Model {
    public function calcularAntecessorSucessor($numero) {
        if(filter_var($numero, FILTER_VALIDATE_INT) !== false) {
            return [
                'antecessor' => $numero - 1,
                'sucessor' => $numero + 1
            ];
        }
        return [
            'antecessor' => '',
            'sucessor' => ''
        ];
    }

    public function sortearNumero($digitado) {
       $numero_sorteado = rand(1, 100);
       $digitado = filter_var($digitado, FILTER_VALIDATE_INT);
       if ($digitado === false) {
        return [
            'numero_sorteado' => $numero_sorteado,
            'numero_digitado' => $digitado,
            'mensagem' => 'Digite um número'
        ];
       }
        $mensagem = ($digitado === $numero_sorteado)
            ? '<div class="mt-2 text-success">Você acertou!</div>'
            : '<div class="mt-2 text-danger">Você errou!</div>';
        return [
            'numero_sorteado' => $numero_sorteado,
            'numero_digitado' => $digitado,
            'mensagem' => $mensagem
        ];
    }

    public function converterReal($real){
        // --- CONFIGURAÇÃO DA API DE CÂMBIO ---
        $apiKey = 'dd9e6ff28fc35b57dee0f862'; //
        $apiUrl = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/BRL"; //
        $ch = curl_init(); // Inicializa uma nova sessão cURL
        curl_setopt($ch, CURLOPT_URL, $apiUrl); // Define a URL para buscar
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Retorna a transferência como uma string

        $response = curl_exec($ch); // Executa a sessão cURL

        if (curl_errno($ch)) { // Verifica erros cURL
            error_log("Erro ao conectar à API de taxas de câmbio: " . curl_error($ch)); //
            curl_close($ch); //
            return ['error' => 'Não foi possível obter as taxas de câmbio no momento.'];
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Obtém o código de status HTTP
        curl_close($ch); // Fecha a sessão cURL

        if ($http_code !== 200) { // Verifica se a requisição foi bem-sucedida
            error_log("Erro na API de taxas de câmbio (HTTP {$http_code}): " . $response); //
            return ['error' => 'Erro ao obter as taxas de câmbio da fonte externa.'];
        }

        $data = json_decode($response, true); // Decodifica a resposta JSON

        if (json_last_error() !== JSON_ERROR_NONE) { // Verifica erros na decodificação JSON
            error_log("Erro ao decodificar JSON da API de taxas de câmbio: " . json_last_error_msg()); //
            return ['error' => 'Erro ao processar os dados das taxas de câmbio.'];
        }

        if (isset($data['result']) && $data['result'] === 'success') { // Verifica se a API retornou sucesso
            $rates = $data['conversion_rates']; //

            $dollar_rate = $rates['USD'] ?? null; // Obtém a taxa do Dólar
            $euro_rate = $rates['EUR'] ?? null; // Obtém a taxa do Euro

            if (is_null($dollar_rate) || is_null($euro_rate)) {
                return ['error' => 'Não foi possível encontrar as taxas para USD ou EUR.'];
            }

            return [
                'dolar' => $real * $dollar_rate,
                'euro' => $real * $euro_rate,
                'rates_used' => [
                    'USD' => $dollar_rate,
                    'EUR' => $euro_rate
                ]
            ];
        } else {
            error_log("Erro na API de taxas de câmbio: " . ($data['error-type'] ?? 'Erro desconhecido')); //
            return ['error' => 'A API de câmbio retornou um erro.'];
        }
    }
    
}//end-class
