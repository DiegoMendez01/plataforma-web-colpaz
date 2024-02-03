<?php
require_once("../../config/connection.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    require_once ("../mainHead/head.php");
    ?>
    <title>Aula Virtual: Reenviar Correo Electrónico</title>
</head>
<body>
    <div class="page-content" style="margin-top: 0; padding-top: 20px;">
        <div class="container-fluid">
            <header class="section-header">
                <div class="tbl">
                    <div class="tbl-row">
                        <div class="tbl-cell">
                            <ol class="breadcrumb breadcrumb-simple">
                                <li><a href="../site/">Inicio</a></li>
                                <li class="active">Reenvio de Correo</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </header>
            <div class="box-typical box-typical-padding">
                <p>
                    Módulo que permite al usuario el reenvio de un correo electronico para confirmar su cuenta.
                </p>
                <div class="col-md-12 text-center">
                    <img class="hidden-md-down" src="../../public/img/LogoCOLPAZ.png" alt="Logo" style="height: 20vh;">
                </div>
                <h2>Formulario de Reenvío de Correo Electrónico</h2>
                <form method="post" id="submitted_email">
                    <div class="form-group">
                        <label for="email">Correo Electronico <b>*</b></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Ingrese la dirección de correo electronico">
                    </div>
                    <div class="text-center">
                    	<button type="submit" class="btn btn-primary">Enviar Correo</button>
                    </div>
                </form>
            </div>
		</div>
	</div>
    <?php
    require_once ("../mainJs/js.php");
    ?>
    
    <script src="site.js"></script>
</body>
</html>