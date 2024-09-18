<?php
require_once 'App/Infrastructure/sdbh.php'; use sdbh\sdbh;
$dbh = new sdbh();
?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container">
    <div class="row row-header">
        <div class="col-12" id="count">
            <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
            <h1>Прокат Y</h1>
        </div>
    </div>

    <div class="row row-form">
        <div class="col-12">
            <form action="App/calculate.php" method="POST" id="form">

                <?php $products = $dbh->make_query('SELECT * FROM a25_products');
                if (is_array($products)) { ?>
                    <label class="form-label" for="product">Выберите продукт:</label>
                    <select class="form-select" name="product" id="product">
                        <?php foreach ($products as $product) {
                            $name = $product['NAME'];
                            $price = $product['PRICE'];
                            $tarif = $product['TARIFF'];
                            ?>
                            <option value="<?= $product['ID']; ?>"><?= $name; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <label for="customRange1" class="form-label" id="count">Количество дней:</label>
                <input type="number" name="days" class="form-control" id="customRange1" min="1" max="30">

                <?php $services = unserialize($dbh->mselect_rows('a25_settings', ['set_key' => 'services'], 0, 1, 'id')[0]['set_value']);
                if (is_array($services)) {
                    ?>
                    <label for="customRange1" class="form-label">Дополнительно:</label>
                    <?php
                    $index = 0;
                    foreach ($services as $k => $s) {
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="<?= $s; ?>" id="flexCheck<?= $index; ?>">
                            <label class="form-check-label" for="flexCheck<?= $index; ?>">
                                <?= $k ?>: <?= $s ?>
                            </label>
                        </div>
                    <?php $index++; } ?>
                <?php } ?>

                <button type="submit" class="btn btn-primary">Рассчитать</button>
            </form>

            <div class="d-flex text-center">
                <h5>Итоговая стоимость: <span id="total-price"></span></h5>
                <button
                    id="info-price"
                    type="button"
                    class="btn btn-link"
                    data-toggle="tooltip"
                    data-placement="top"
                    title=""
                    hidden
                >
                    <i class="bi bi-question-circle"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'App/calculate.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    $("#total-price").text(data.total_sum);

                    const infoTooltip = $("#info-price")
                    infoTooltip.attr('title', data.calculation_info).tooltip('dispose').tooltip();
                    infoTooltip.removeAttr('hidden');
                },
                error: function() {
                    $("#total-price").text('Ошибка при расчете');
                }
            });
        });
    });

</script>
</body>
</html>