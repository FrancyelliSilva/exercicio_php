<?php
include 'header.php';
?>

<?php
//Antecessor e sucessor
$numero_a = '';
$antecessor = '';
$sucessor = '';

if (isset($_POST['confirmar']) && isset($_POST['numero'])) {   
        $numero_a = filter_var($_POST['numero'], FILTER_VALIDATE_INT);
        if ($numero_a !== false && $numero_a !== null) {
            $antecessor = $numero_a - 1;
            $sucessor = $numero_a + 1;
        } else {
            $antecessor = '';
            $sucessor = '';
        }
} else {
    $numero_a = '';
    $antecessor = '';
    $sucessor = '';
}

//Sorteio de um número aleatório
$numero_sorteado = '';
$numero_digitado = '';
$mensagem_sorteio = '';

if (isset($_POST['sortear'])) {
    $numero_sorteado = rand(1, 100);
    if (isset($_POST['digitado']) || filter_var($_POST['digitado'], FILTER_VALIDATE_INT) !== false) {
        $numero_digitado = filter_var($_POST['digitado'], FILTER_VALIDATE_INT);
        if ($numero_digitado === $numero_sorteado) {
            $mensagem_sorteio = '<div class="mt-2 text-success">Você acertou!</div>';
        } else {
            $mensagem_sorteio = '<div class="mt-2 text-danger">Você errou!</div>';
        }
    }else{
        $mensagem_sorteio = '<div class="mt-2">Digite um número</div>';
    }

}else{
    $numero_sorteado = '';   
}
?>
<!-- Antecessor e sucessor -->
<h1 class="text-center text-white mt-4 text-uppercase">Exercício PHP</h1>
<div class="row mt-4 m-2">
    <div class="col-md-4">
        <div class="card p-4" style="border-radius: 10px; height: 15rem; border:none; background-image: linear-gradient(to bottom, #ffdff5, #ffeefa, #ffdff5);" >   
            <h6>Digite um número para ver o antecessor e sucessor</h6>         
            <form method="post" action="pagina.php" class="mt-2">
                <input type="number" name="numero" placeholder="Digite um número" class="form-control">
                <div class="text-end">
                    <button type="submit" name="confirmar" class="btn btn-sm btn-outline-success mt-2">Confirmar</button>
                </div>
                    <div class="mt-2">ANTECESSOR: <?php echo $antecessor; ?></div>
                    <div class="mt-2">SUCESSOR: <?php echo $sucessor; ?></div>                
            </form>
        </div>
    </div>
    <!-- Adivinhe o número sorteado -->
    <div class="col-md-4">
        <div class="card p-4" style="border-radius: 10px; height: 15rem;border:none; background-image: linear-gradient(to bottom, #ffdff5, #ffeefa, #ffdff5);" >   
            <h6>Adivinhe o número sorteado (1 a 100)</h6>         
            <form method="post" action="pagina.php" class="mt-2">
                <input type="number" name="digitado" placeholder="Digite um número" class="form-control">
                <div class="text-end">
                    <button type="submit" name="sortear" class="btn btn-sm btn-outline-success mt-2">Sortear</button>
                </div>                   
                    <?php if (isset($_POST['sortear']) && isset($_POST['digitado'])) { ?>
                        <div class="mt-2">Número sorteado: <?php echo isset($numero_sorteado) ? $numero_sorteado : ''; ?></div>
                        <div class="mt-2">Número digitado: <?php echo isset($numero_digitado) ? $numero_digitado : ''; ?></div>
                        <?php echo $mensagem_sorteio; ?>
                    <?php } ?>
            </form>
        </div>
    </div>
</div>


<?php
include 'footer.php';
?>