<?php include 'header.php'; ?>
    <div class="col-md-4 mt-4">
        <div class="card p-4" style="border-radius: 10px; height: 15rem;border:none; background-image: linear-gradient(to bottom, #2193b0, #6dd5ed, #bde7fa);" >   
            <h6>Adivinhe o número sorteado (1 a 100)</h6>         
            <form method="post" action="" class="mt-2">
                <input type="number" name="digitado" placeholder="Digite um número" class="form-control">
                <div class="text-end">
                    <button type="submit" name="sortear" class="btn btn-sm btn-outline-success mt-2">Sortear</button>
                </div>                   
                    <?php if (isset($numero_sorteado)) { ?>
                        <div class="mt-2">Número sorteado: <?php echo $numero_sorteado; ?></div>
                        <div class="mt-2">Número digitado: <?php echo $numero_digitado; ?></div>
                        <?php echo $mensagem_sorteio; ?>
                    <?php } ?>
            </form>
        </div>
    </div>
<?php include 'footer.php'; ?>