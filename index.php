<?php

require_once("config/database.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Web Educativa</title>
    <link rel="stylesheet" href="assets/css/lib/lobipanel/lobipanel.min.css">
    <link rel="stylesheet" href="assets/css/separate/vendor/lobipanel.min.css">
    <link rel="stylesheet" href="assets/css/lib/jqueryui/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/css/separate/pages/widgets.min.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <link rel="stylesheet" href="assets/css/separate/pages/login.min.css">
    <link rel="stylesheet" href="assets/css/lib/font-awesome/font-awesome.min.pcss">
    <link rel="stylesheet" href="assets/css/lib/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
</head>

<body>
    <header class="site-header bg-primary" id="home">
        <div class="container-fluid">
            <a href="#" class="site-logo">
                <img class="hidden-md-down" src="assets/img/LogoCOLPAZ.png" alt="">
                <img class="hidden-lg-up" src="assets/img/LogoCOLPAZ.png" alt="">
            </a>
            <div class="site-header-content">
                <div class="site-header-content-in">
                    <div class="site-header-shown">
                        <button type="button" class="burger-right">
                            <i class="font-icon-menu-addl"></i>
                        </button>
                    </div>
                    <div class="mobile-menu-right-overlay"></div>
                    <div class="site-header-collapsed">
                        <div class="site-header-collapsed-in">
                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-application" data-target="#" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                                    <span class="fa fa-plus-circle"></span>
                                    <span class="lbl">Aplicaciones</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dd-header-about">
                                    <a class="dropdown-item" href="https://compucol.co/ingreso/" target="_blank"><span class="font-icon font-icon-compucol"></span>Compucol</a>
                                    <a class="dropdown-item" href="https://www.udemy.com/" target="_blank"><span class="font-icon font-icon-udemy"></span>Udemy</a>
                                    <a class="dropdown-item" href="http://sedboyaca.gov.co/" target="_blank"><span class="font-icon font-icon-sedboyaca"></span>SedBoyaca</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-activities" data-target="#" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                                    <span class="fa fa-info-circle"></span>
                                    <span class="lbl">Actividades</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dd-header-about">
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-vision"></span>Eventos culturales</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-mision"></span>Eventos cientificos</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-history"></span>Eventos ambientales</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-teachers"></span>Eventos tecnologicos</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                                <a class="dropdown-toggle" id="dd-header-about" data-target="#" href="http://example.com" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                                    <span class="fa fa-plus-circle"></span>
                                    <span class="lbl">Sobre nosotros</span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dd-header-about">
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-vision"></span>Vision</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-mision"></span>Mision</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-history"></span>Historia</a>
                                    <a class="dropdown-item" href="#"><span class="font-icon font-icon-teachers"></span>Planta de Docentes</a>
                                </div>
                            </div>
                            <div class="dropdown dropdown-typical">
                            	<?php
                            	if(!empty($_SESSION['id'])){
                            	?>
                                <a href="views/home/" class="dropdown-toggle no-arr" style="color: white;">
                                    <span class="fa fa-graduation-cap"></span>
                                    <span class="lbl">Aula virtual</span>
                                </a>
                                <?php
                            	}else{
                                ?>
                                <a href="views/site/" class="dropdown-toggle no-arr" style="color: white;">
                                    <span class="fa fa-graduation-cap"></span>
                                    <span class="lbl">Aula virtual</span>
                                </a>
                                <?php
                            	}
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </header>

    <div class="page-content" style="max-width: 95% !important; margin: 0 auto;">
        <div class="container">
            <div class="row">
                <div class="box-typical box-typical-full-height" style="min-height: 576px; padding: 50px">
                    <!-- Columna izquierda para la descripción -->
                    <div class="col-md-6 text-center">
                        <h2>Nuestra Institución</h2>
                        <p class="lead color-blue-grey-lighter">La Institución Educativa Técnica Nuestra Señora de la Paz apoya los proyectos tecnológicos de la región</p>
                        <img class="hidden-md-down" src="assets/img/LogoCOLPAZ.png" alt="Logo">
                    </div>
                    <!-- Columna derecha para el video de YouTube -->
                    <div class="col-md-6">
                        <!-- Video de YouTube incrustado -->
                        <div class="embed-responsive embed-responsive-16by9">
                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/Q64EKesPOfU" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="box-typical box-typical-padding" style="height: 720px;">
                    <div class="col-md-3">
                        <div class="col-md-12">
                            <section class="widget widget-weather">
                                <div class="widget-weather-big">
                                    <div class="icon">
                                        <i class="font-icon font-icon-weather-clouds"></i>
                                    </div>
                                    <div class="info">
                                        <div class="degrees">29°</div>
                                        <div class="weather">Cloudy</div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="col-md-12">
                            <div class="contacts-page-col-right">
                                <h3>Próximos Eventos</h3>
                                <ul>
                                    <li>Evento 1 - Fecha y descripción del evento.</li>
                                    <li>Evento 2 - Fecha y descripción del evento.</li>
                                    <li>Evento 3 - Fecha y descripción del evento.</li>
                                    <li>Evento 4 - Fecha y descripción del evento.</li>
                                    <!-- Agrega más eventos según sea necesario -->
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="add-customers-screen tbl text-center" style="height: 700px;">
                            <div class="contacts-page-col-right">
                                <div class="contacts-page-section">
                                    <div class="institution-events text-justify">
                                        <h3>Eventos de la Institución</h3>
                                        <p>Join us for exciting events organized by our institution! We are committed to providing enriching experiences for our community. Our upcoming events include:</p>

                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed consectetur mi in tortor rhoncus, vel efficitur lectus vestibulum. Fusce auctor purus eget tristique vestibulum.</p>

                                        <p>Nunc ut est nec justo varius bibendum. Pellentesque eget tincidunt odio. Integer euismod, justo ac cursus luctus, massa dolor fringilla augue.</p>

                                        <p>Don't miss out on these fantastic opportunities to connect with fellow members of our institution and engage in meaningful activities!</p>
                                    </div>

                                    <!-- Imagen relacionada con los eventos -->
                                    <div class="event-image">
                                        <img src="assets/img/fondoLogin.png" alt="Imagen de eventos" width="400">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="box-typical box-typical-full-height" style="min-height: 576px; padding: 50px">
                    <h2>Noticias</h2>
                    <div class="col-md-4">
                        <div class="card" style="height: 320px;">
                            <img src="assets/img/icon_facebook.svg" class="card-img-top" alt="Imagen 1">
                            <div class="card-body" style="overflow-y: auto; max-height: 240px;">
                                <!-- Publicación simulada de Facebook 1 -->
                                <p>📚 ¡Nuevas oportunidades educativas en Boyacá! 🌟 Descubre lo que tenemos para ti en nuestra última carta. #EducaciónEnBoyacá</p>
                                <p><small>Hace 1 hora - 100 Me gusta - 20 Comentarios</small></p>

                                <!-- Publicación simulada de Facebook 2 -->
                                <p>📚 ¡Más noticias educativas en Boyacá! 🎓 Explora nuestras iniciativas para mejorar la educación en la región. #EducaciónEnBoyacá</p>
                                <p>📢 ¡Gracias por tu apoyo continuo en nuestra misión! Juntos hacemos la diferencia en la educación. #EducaciónBoyacá</p>
                                <p><small>Hace 2 horas - 150 Me gusta - 30 Comentarios</small></p>
                                <!-- Agrega más contenido según sea necesario -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card" style="height: 320px;">
                            <img src="assets/img/icon_twitter.svg" class="card-img-top" alt="Imagen 2">
                            <div class="card-body" style="overflow-y: auto; max-height: 240px;">
                                <!-- Tweet simulado para Twitter de Sedboyacá 1 -->
                                <p>📣 ¡Atención, Boyacenses! 📢 No te pierdas las novedades en educación que compartimos en nuestra última carta. #EducaciónBoyacá #NuevasOportunidades</p>
                                <p><small>Hace 30 minutos - 50 Retweets - 80 Me gusta</small></p>

                                <!-- Tweet simulado para Twitter de Sedboyacá 2 -->
                                <p>📣 ¡Nuevas oportunidades educativas en Boyacá! 🎓 Descubre cómo estamos transformando la educación en la región. #EducaciónSedboyacá</p>
                                <p><small>Hace 1 hora - 60 Retweets - 90 Me gusta</small></p>
                                <!-- Agrega más contenido según sea necesario -->
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card" style="height: 320px;">
                            <img src="assets/img/icon_twitter.svg" class="card-img-top" alt="Imagen 3">
                            <div class="card-body" style="overflow-y: auto; max-height: 240px;">
                                <!-- Tweet simulado para el Ministerio de Educación de Colombia 1 -->
                                <p>🇨🇴 El Ministerio de Educación de Colombia se complace en apoyar las iniciativas educativas en Boyacá. ¡Mira lo que tienen para ofrecer en su carta más reciente! #EducaciónColombia #JuntosPorLaEducación</p>
                                <p><small>Hace 2 horas - 40 Retweets - 70 Me gusta</small></p>

                                <!-- Tweet simulado para el Ministerio de Educación de Colombia 2 -->
                                <p>🇨🇴 ¡Educación de calidad para todos! 📚 Descubre cómo estamos trabajando para mejorar la educación en Colombia. #EducaciónColombia #CalidadEducativa</p>
                                <p><small>Hace 3 horas - 30 Retweets - 50 Me gusta</small></p>
                                <!-- Agrega más contenido según sea necesario -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-light" id="contact">
        <div class="container py-4">
            <div class="row">
                <!-- Columna de Contacto -->
                <div class="col-md-6">
                    <h4>Contacto</h4>
                    <hr style="border-top: 2px solid black; margin-top: 10px;">
                    <p><b>Dirección:</b> Quípama, Boyacá</p>
                    <p><b>Teléfono:</b> (123) 456-7890</p>
                    <p><b>Correo electrónico:</b> ticolpaz@gmail.com</p>
                </div>
                <!-- Columna de Enlaces Rápidos -->
                <div class="col-md-6">
                    <h4>Enlaces Rápidos</h4>
                    <hr style="border-top: 2px solid black; margin-top: 10px;">
                    <ul class="list-unstyled">
                        <li><a href="#home">Inicio</a></li>
                        <li><a href="#contact">Contacto</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

    <script src="assets/js/lib/jquery/jquery.min.js"></script>
    <script src="assets/js/lib/tether/tether.min.js"></script>
    <script src="assets/js/lib/bootstrap/bootstrap.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>