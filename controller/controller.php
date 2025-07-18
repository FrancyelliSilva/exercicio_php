<?php
require_once 'model/model.php';

class Controller {
    private $model;
//Função para criar o objeto da classe Model
    public function __construct() {
        $this->model = new Model();
    }

    public function index() {

        $antecessor = $sucessor = $numero = '';
        if(isset($_POST['confirmar']) && isset($_POST['numero'])) {
            $numero = $_POST['numero'];
            $resultado = $this->model->calcularAntecessorSucessor($numero);
            $antecessor = $resultado['antecessor'];
            $sucessor = $resultado['sucessor'];
        }

        require_once 'view/calcular-antessor-sucessor.php';

        if (isset($_POST['sortear'])) {
            $digitado = $_POST['digitado'] ?? '';
            $result = $this->model->sortearNumero($digitado);
            $numero_sorteado = $result['numero_sorteado'];
            $numero_digitado = $result['numero_digitado'];
            $mensagem_sorteio = $result['mensagem'];
        }
        require_once 'view/adivinhe-numero.php';

        // ---Conversor do Real ---
        $dolarConvertido = '';
        $euroConvertido = '';
        $conversao_error = ''; // Para exibir mensagens de erro da conversão

        if (isset($_POST['converter_moeda'])) { // Usei 'converter_moeda' como o nome do botão de submit
            $real = $_POST['real'] ?? '';

            if (!is_numeric($real) || $real < 0) {
                $conversao_error = "Por favor, digite um valor numérico positivo para o Real.";
            } else {
                $real = (float) $real;
                $resultadoConversao = $this->model->converterReal($real);

                if (isset($resultadoConversao['error'])) {
                    $conversao_error = $resultadoConversao['error'];
                } else {
                    $dolarConvertido = round($resultadoConversao['dolar'], 2);
                    $euroConvertido = round($resultadoConversao['euro'], 2);
                }
            }
        }

        require_once 'view/conversor-dolar.php';
    }
}
