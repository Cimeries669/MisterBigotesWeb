$(document).ready(function () {
    // Manejar la selección de tipo de entrega
    $('input[name="tipo_entrega"]').on('change', function () {
        const seleccion = $(this).val();
        if (seleccion === "domicilio") {
            $('#datos-envio').slideDown();
        } else {
            $('#datos-envio').slideUp();
        }
    });

    // Validar y guardar datos del envío
    $('#finalizar-compra').on('click', function (e) {
        const tipoEntrega = $('input[name="tipo_entrega"]:checked').val();

        if (tipoEntrega === "domicilio") {
            const direccion = $('#direccion').val().trim();
            const telefono = $('#telefono').val().trim();
            const email = $('#email').val().trim();
            const observaciones = $('#observaciones').val().trim();

            if (!direccion || !telefono || !email) {
                e.preventDefault();
                alert('Por favor, completa todos los campos de envío a domicilio.');
                return;
            }

            // Enviar los datos al servidor
            $.ajax({
                url: 'guardar_envio.php',
                type: 'POST',
                data: {
                    direccion: direccion,
                    telefono: telefono,
                    email: email,
                    observaciones: observaciones,
                },
                success: function (response) {
                    console.log(response); // Puedes ajustar según el manejo que necesites
                },
                error: function () {
                    alert('Hubo un error al guardar los datos de envío.');
                },
            });
        }
    });
});
