<?php
require_once 'App/Domain/Users/UserEntity.php'; use App\Domain\Users\UserEntity;

$user = new UserEntity();
if (!$user->isAdmin) die('Доступ закрыт');
?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
              crossorigin="anonymous">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
                crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
        <title>Админ часть</title>
    </head>
    <body>
        <div class="container">
            <h1>Админка</h1>

            <h2>Создание продукта</h2>

            <h3 id="create-message"></h3>

            <div class="row row-form">
                <div class="col-12">
                    <form id="form-product">

                        <div class="mb-3">
                            <label for="name" class="form-label">Название</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Цена</label>
                            <input type="number" class="form-control" name="price" id="price" required min="0">
                        </div>

                        <h4>Тарифы</h4>

                        <div id="tarifs"></div>

                        <button type="button" id="add-tarif" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i>
                        </button>

                        <div class="my-3"></div>

                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="assets/js/admin.js"></script>
    </body>
</html>