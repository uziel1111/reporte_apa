  <script>
    var base_url = "<?= base_url() ?>";
  </script>
<main role="main">
    <div class="container">
        <div class="card">
            <div class="card-shadow">
                <div class="card-header">
                    <div class="row">
                        <div class="col-12 input-group">
                            <?php foreach ($array as $key => $value) { ?>
                            <br>
                            <div class="row">
                            <button  onclick="genera_curp_Auxiliar('<?= $key ?>','<?= $value["nombre"] ?>','<?= $value["apellido_paterno"] ?>','<?= $value["apellido_materno"] ?>','<?= $value["dia"] ?>','<?= $value["mes"] ?>','<?= $value["anio"] ?>','<?= $value["estado"] ?>','<?= $value["sexo"] ?>')">Generar_curp <?= $key?></button>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="<?= base_url('assets/asset/curp_github.js'); ?>"></script>
<script src="<?= base_url('assets/asset/js/auxiliar.js'); ?>"></script>
