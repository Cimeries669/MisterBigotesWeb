<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pasarela de Pago</title>
    <link rel="stylesheet" href="finalizar_compra.css">
    <style>
        @media screen and (max-width: 400px) {
            #paypal-button-container {
                width: 100%;
            }
        }
        @media screen and (min-width: 400px) {
            #paypal-button-container {
                width: 250px;
            }
        }
    </style>
</head>
<body> 
    <?php 
    // Monto total en CLP
    $total_clp = 60000; // Monto en pesos chilenos
    ?>

    <h3>Total a pagar: $<?php echo number_format($total_clp, 0); ?> CLP</h3>
    <div id="success-message" style="display: none; background-color: #28a745; color: white; padding: 15px; margin-top: 20px; border-radius: 5px; text-align: center;">
    Pago completado por <span id="payer-name"></span>. ¡Gracias por tu compra!
</div>
    <div id="paypal-button-container"></div>

    <!-- Incluir el SDK de PayPal en USD -->
    <script src="https://www.paypal.com/sdk/js?client-id=AW7y9shmBaa6uaBn1mfIN3rRbKvW74hINrXkjttgO0kjbnEbyEkksjEfYVSGhderGvRxqmd3pT7wwirn&currency=USD"></script>
    <script>
        // Configurar la tasa de conversión (por ejemplo, 1 CLP = 0.0012 USD)
        const clpToUsdRate = 0.0012; // Asegúrate de actualizar esta tasa de cambio regularmente
        const totalClp = <?php echo $total_clp; ?>;
        const totalUsd = (totalClp * clpToUsdRate).toFixed(2); // Convertir a USD con dos decimales

        paypal.Buttons({ 
            style: {
                color: 'blue',
                shape: 'pill',
                label: 'pay'
            },
            createOrder: function(data, actions) {
                // Crear la orden en USD con el monto convertido
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            currency_code: 'USD',
                            value: totalUsd // Monto convertido a USD
                        }
                    }]
                });
            },

            onApprove: function(data, actions) {
                // Capturar el pago y redirigir al usuario a la página de agradecimiento
                return actions.order.capture().then(function(details) {
                    setTimeout(function() {
                        window.location.href = "gracias.php";
                   
        }, 1); 
                }).catch(function(err) {
                    console.error('Error al capturar la orden:', err);
                    alert('Hubo un problema al procesar el pago.');
                });
            },

            onCancel: function(data) {
                alert("Transacción cancelada");
                console.log('Transacción cancelada:', data);
            },

            onError: function(err) {
                console.error('Error en la transacción:', err);
                alert('Hubo un problema con la transacción. Inténtalo de nuevo.');
            }
        }).render('#paypal-button-container');
    </script>
</body>
</html>
