$(document).ready(function() {
    $("#buscar").on("keyup", function() {
        const query = $(this).val().trim();

        if (query) {
            $.ajax({
                url: "buscar_sugerencias.php",
                type: "GET",
                data: { query: query },
                success: function(data) {
                    const suggestions = JSON.parse(data);
                    let suggestionsHtml = "<ul>";

                    suggestions.forEach((product) => {
                        suggestionsHtml += `<li><a href="product_details.php?id=${product.id_producto}">${product.nombre}</a></li>`;
                    });

                    suggestionsHtml += "</ul>";
                    $("#sugerencias").html(suggestionsHtml).show();
                },
                error: function() {
                    console.error("Error al obtener sugerencias");
                }
            });
        } else {
            $("#sugerencias").hide();
        }
    });

    // Ocultar sugerencias al hacer clic fuera
    $(document).click(function(event) {
        if (!$(event.target).closest("#buscar, #sugerencias").length) {
            $("#sugerencias").hide();
        }
    });
});
