<?php include 'header.php'; ?>
<center>
    <div class="col-md-6 mt-4">
        <div class="card p-4" style="border-radius: 10px; height: 15rem; border:none; background-image: linear-gradient(to bottom, #ffdff5, #ffeefa, #ffdff5);" >   
            <h6>Digite um número para ver o antecessor e sucessor</h6>         
            <form method="post" action="" class="mt-2">
                <input type="number" name="numero" placeholder="Digite um número" class="form-control">
                <div class="text-end">
                    <button type="submit" name="confirmar" class="btn btn-sm btn-outline-success mt-2">Confirmar</button>
                </div>
                    <div class="mt-2 text-start">Antecessor: <?php echo $antecessor; ?></div>
                    <div class="mt-2 text-start">Sucessor: <?php echo $sucessor; ?></div>                
            </form>
        </div>
    </div>
<center>
<?php include 'footer.php'; ?>