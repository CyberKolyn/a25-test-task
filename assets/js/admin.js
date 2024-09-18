$(document).ready(function() {
    const form = $("#form-product")
    form.submit(function(event) {
        event.preventDefault();
        $.ajax({
            url: 'App/product.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                form.trigger("reset");
                $('#tarifs').empty();
                $('#create-message').text('Успешно создан!');
            },
            error: function(err) {
                $('#create-message').text('Ошибка создания');
            }
        });
    });

    $('#add-tarif').on('click', function() {
        const tarifCounter = $('#tarifs').children('div').length;

        const newTarif = `
        <div class="d-flex align-items-center" id="tarif-${tarifCounter}">
            <div class="mb-3">
                <label class="form-label">
                    Сколько дней
                    <input type="number" class="form-control" name="tarifsDay[]" min="0">
                </label>
            </div>
            <span class="mx-2"></span>
            <div class="mb-3">
                <label class="form-label">
                    Цена
                    <input type="number" class="form-control" name="tarifsPrice[]" min="0">
                </label>
            </div>
            <span class="mx-2"></span>
            <button type="button" class="btn btn-danger" data-delete-id="${tarifCounter}">Удалить</button>
        </div>
    `;
        $('#tarifs').append(newTarif);
    });

    $(document).on('click', 'button[data-delete-id]', function() {
        const tarifId = $(this).data('delete-id');
        $(`#tarif-${tarifId}`).remove();
    });
});