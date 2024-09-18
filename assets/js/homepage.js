$(document).ready(function() {
    $("#form").submit(function(event) {
        event.preventDefault();

        if (validateDateInputs() === null){
            return;
        }

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
            error: function(err) {
                const errorResponse = JSON.parse(err.responseText);
                $("#total-price").text(errorResponse?.error || 'Ошибка сервера!');
            }
        });
    });

    const options = {
        dateFormat: "dd.mm.yy",
    };

    $("#startDate").datepicker(options);
    $("#endDate").datepicker(options);
});

const validateDateInputs = function () {

    const startDate = $("#startDate").datepicker("getDate");
    const endDate = $("#endDate").datepicker("getDate");

    if (!startDate || !endDate) {
        $("#total-price").text("Не выбраны даты проката");
        return  null;
    }

    const timeDiff = endDate - startDate;
    const dayDiff = timeDiff / (1000 * 3600 * 24);

    if (dayDiff > 30) {
        $("#total-price").text("Длительность проката не может превышать 30 дней!");
        return null;
    }

    if (startDate > endDate) {
        $("#total-price").text("Начальная дата проката больше конечной даты!");
        return null;
    }
}