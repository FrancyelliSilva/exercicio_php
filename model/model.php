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
}//end-class
