<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/emdn.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Medios</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark  bg-dark " style="z-index: 1005">
        
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="/medios-comunicacion/">

                <img src="<?= asset('./images/emdn.png') ?>" width="35px'" alt="cit" >

                Medios
            </a>
            <div class="collapse navbar-collapse" id="navbarToggler">
                
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/medios-comunicacion/"><i class="bi bi-house-fill me-2"></i>Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/medios-comunicacion/eventos"><i class="bi bi-plus-circle me-2"></i>Nuevo evento</a>
                    </li>
                    <?php if(isset($_SESSION['AMC_ADMIN'])) : ?>
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-tools me-2"></i>Mantenimientos
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/armas"><i class="ms-lg-0 ms-2 bi bi-hammer me-2"></i>Armas</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/calibres"><i class="ms-lg-0 ms-2 bi bi-hash me-2"></i>Calibres</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/colores"><i class="ms-lg-0 ms-2 bi bi-palette me-2"></i>Colores</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/delitos"><i class="ms-lg-0 ms-2 bi bi-clipboard-x me-2"></i>Delitos</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/desastre_natural"><i class="ms-lg-0 ms-2 bi bi-cloud-lightning-rain me-2"></i>Desastres Naturales</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/fenomeno_natural"><i class="ms-lg-0 ms-2 bi bi-cloudy me-2"></i>Fenomenos Naturales</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/moneda"><i class="ms-lg-0 ms-2 bi bi-coin me-2"></i>Moneda</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/nacionalidad"><i class="ms-lg-0 ms-2 bi bi-person-rolodex me-2"></i>Nacionalidades</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/organizacion"><i class="ms-lg-0 ms-2 bi bi-building me-2"></i>Organizaciones</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/tipo"><i class="ms-lg-0 ms-2 bi bi-arrows-move me-2"></i>Tipos de Movimientos Sociales</a>
                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/usuarios"><i class="fa-sharp fa-solid fa-users"></i>Usuarios</a>
                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/Fuentes"><i class="ms-lg-0 ms-2 bi bi-arrows-move me-2"></i>Fuentes</a>
                            </li>
                            

                        
                        </ul>
                    </div> 
                    <div class="nav-item dropdown " >
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-bar-chart me-2"></i>Estadisticas
                        </a>
                        <ul class="dropdown-menu  dropdown-menu-dark "id="dropwdownRevision" style="margin: 0;">
                            <!-- <h6 class="dropdown-header">Información</h6> -->
                           
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/capturas"><i class="ms-lg-0 ms-2  fa-solid fa-handcuffs me-2"></i>Capturas</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/droga"><i class="ms-lg-0 ms-2 fa-solid fa-cannabis me-2"> </i>Drogas</a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/muertes"><i class="ms-lg-0 ms-2 fa-solid fa-skull me-2"></i>Muertes</a>
                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/dinero_y_armas"><i class="ms-lg-0 ms-2 bi bi-plus-circle me-2"></i>Dinero</a>
                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/maras"><i class="ms-lg-0 ms-2 fa-solid fa-user-ninja me-2"></i>Maras</a>

                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/migrantes"><i class="ms-lg-0 ms-2 fa-solid fa-users-between-lines me-2"></i>Migrantes</a>
                            </li>
                            <li>

                                <a class="dropdown-item nav-link text-white " href="/medios-comunicacion/mapas/desastres"><i class="ms-lg-0 ms-2 fa-solid fa-house-chimney-crack me-2"></i>Desastres</a>
                            </li>

                        
                        </ul>
                    </div> 
                    <?php endif ?>
                </ul> 
                <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                    <!-- Ruta relativa desde el archivo donde se incluye menu.php -->
                    <a href="/menu/" class="btn btn-danger"><i class="bi bi-arrow-bar-left"></i>MENÚ</a>
                </div>

            
            </div>
        </div>
        
    </nav>
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-danger" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div class="container-fluid pt-3" style="min-height: 85vh">
        
        <?php echo $contenido; ?>
    </div>
    <div class="container-fluid " >
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                        Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/ae0feae7c7.js" crossorigin="anonymous"></script>
</body>
</html>
