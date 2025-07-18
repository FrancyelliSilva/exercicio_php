<?php include 'header.php'; ?>
<center>
    <div class="col-md-6 mt-4">
        <div class="card p-4" style="border-radius: 10px; height: 15rem; border:none; background-image: linear-gradient(to bottom, #5ec296, #39aa97, #239191);" >   
            <h6>Conversor de Real para Dolar e Euro</h6>         
            <form method="post" action="" class="mt-2">
            <div style="display: flex; align-items: center;"> 
                <span style="margin-right: 5px; font-weight: bold;">R$</span>
                    <input type="number" step="0.01" name="real" placeholder="Digite o valor em real" class="form-control" value="<?php echo isset($_POST['real']) ? htmlspecialchars($_POST['real']) : ''; ?>">
            </div>
            <div class="text-end">
                <button type="submit" name="converter_moeda" class="btn btn-sm btn-success mt-2">Converter</button>
            </div>
                <?php if (!empty($conversao_error)): ?>
                    <div class="mt-2 text-danger text-start"><?php echo $conversao_error; ?></div>
                <?php else: ?>
                    <div class="mt-2 text-start">Dolar &#x00024: <?php echo $dolarConvertido; ?></div>
                    <div class="mt-2 text-start">Euro 	&#8364: <?php echo $euroConvertido; ?></div>
                <?php endif; ?>
            </form>
        </div>
    </div>
<center>
<?php include 'footer.php'; ?>