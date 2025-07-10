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
    }
}
