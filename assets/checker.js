var audio = new Audio('assets/blop.mp3');
$(document).ready(() => {
    $("#click_apd").click(function () {
        $("#Aprovada").toggle();
    });

    $("#click_rpd").click(function () {
        $("#Reprovada").toggle();
    });
    $('#start').click(() => {
        audio.play();
        if (!$('#lista').val()) {
            $("#start").html("Lista Vazio!");
        } else {
            testando()
            var line = $('#lista').val().replace(',', '').split('\n')
            line.forEach((value) => {
                teste(value);
            })
        }

    })
})

function testando() {
    setTimeout(() => {
        $("#start").html("Iniciando.");
        setTimeout(() => {
            $("#start").html("Iniciando..");
            setTimeout(() => {
                $("#start").html("Iniciando...");
            }, 600)
        }, 600)
    }, 600)
}

function teste(value) {
    $.ajax({
        url: 'api.php',
        type: 'GET',
        data: 'lista=' + value,
        success: function (data) {
            var json = JSON.parse(data);
            var msg = json.msg;
            switch (json.status) {
                case 0:
                    $("#aprovadas").append(msg);
                    audio.play();
                    $('#apd_count').html(parseInt($('#apd_count').html()) + 1);
                    removelinha();
                    break;
                case 1:
                    $("#reprovadas").append(msg);
                    $('#rpd_count').html(parseInt($('#rpd_count').html()) + 1);
                    removelinha();
                    break;
                case 2:
                    $("#tentativas").append(msg);
                    teste(value)
                    break;
            }
        }
    })
}

function removelinha() {
    var lines = $("#lista").val().split('\n');
    lines.splice(0, 1);
    $("#lista").val(lines.join("\n"));
}