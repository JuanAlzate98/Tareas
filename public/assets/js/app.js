console.log(" app.js funcionando");

$('.form_wrap').hide();

function ShowHideElement() {
    let text = "";

    if (text === "") {
        text = "Click de nuevo";
    }

    if ($('#show').text() !== "Enviar mensaje") {
        $('.form_wrap').show();
        text = "Ocultar";
    }

    if ($('#show').text() === "Ocultar") {
        $('.form_wrap').hide();
        text = "Enviar mensaje";
    }
    $('#show').html(text);
}