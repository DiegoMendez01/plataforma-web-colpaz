<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Correo Electrónico</title>
    <!-- Incluye Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'helvetica', 'helvetica neue', arial, verdana, sans-serif;
            background-color: #F5F5F5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #E1F3E1;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
        }
        .success-message {
            color: #007B3E;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .checkmark-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background-color: transparent;
            margin: 0 auto;
            position: relative;
            border: 2px solid #007B3E; /* Ancho del borde ajustado y color verde */
        }
        .checkmark {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #FFF;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .checkmark::before {
            content: '\2713'; /* Símbolo de verificación Unicode similar al logo de Nike */
            font-size: 30px;
            color: #007B3E;
        }
        .message {
            margin: 20px 0;
        }
        .button-container {
            margin-top: 20px;
        }
        .accept-button {
            background-color: #007B3E;
            color: #FFF;
            padding: 10px 20px;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .accept-button:hover {
            background-color: #005929;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-message">¡Verificación de cuenta exitosa!</div>
        <div class="checkmark-circle">
            <div class="checkmark"></div>
        </div>
        <p class="message">Tu correo electrónico ha sido verificado correctamente.</p>
        <div class="button-container">
            <button class="btn btn-success accept-button" onclick="window.location.href='https://tudireccion.com'">Aceptar</button>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
