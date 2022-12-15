<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../webroot/css/style.css">
        <title>Ejercicio 01-1</title>
    </head>

    <body>
        <header>
            <h1>Tema 4</h1>
            <h2>Ejercicio 01-1</h2>
        </header>
        <main>
            <section>
                <?php
//@author Josue Martinez Fernandez
//@version 1.0
//ultima actualizacion 13/12/2022
//Importacion del fichero de conexion
//El fichero se selecciona en base al host en el que se ejecute el programa
                if ($_SERVER['HTTP_HOST'] == 'daw205.ieslossauces.es') {
                    require_once '../conf/confConexionEE.php';
                } else if ($_SERVER['SERVER_ADDR'] == '192.168.3.212') {
                    require_once '../conf/confConexionEDH.php';
                } else if ($_SERVER['SERVER_ADDR'] == '192.168.20.19') {
                    require_once '../conf/confConexionED.php';
                }
//Crea e inicializa el array que contiene las claves de configuracion de la conexion
                $aAtributos = [
                    'AUTOCOMMIT',
                    'CASE',
                    'CLIENT_VERSION',
                    "CONNECTION_STATUS",
                    "DRIVER_NAME",
                    "ERRMODE",
                    "ORACLE_NULLS",
                    "PERSISTENT",
                    //"PREFETCH", DA ERROR
                    "SERVER_INFO",
                    "SERVER_VERSION",
                        //"TIMEOUT" DA ERROR
                ];
//Configuracion de las conexiones, una con password correcto y otra con password incorrecto
//La conexion correcta muestra una tabla con los atributos de la misma
//Tras cada conexion la misma se cierra
//todo el codigo bajo captura de excepciones     
                try {
                    echo '<h2>Conexion con password correcto:</h2>';
                    $miDB = new PDO(HOSTPDO, USER, PASSWD);
                    echo 'Conexion realizada con exito';
                    echo '<table>';
                    foreach ($aAtributos as $atributo) {
                        echo '<tr><td>' . $atributo . '</td>';
                        echo '<td>' . $miDB->getAttribute(constant("PDO::ATTR_$atributo")) . '</td></tr>';
                    }
                    echo '</table>';
                } catch (Exception $e) {
                    echo 'Error ' . $e->getCode() . ' : ' . $e->getMessage() . '<br>';
                } finally {
                    unset($miDB);
                }
                try {
                    echo '<h2>Conexion con password incorrecto:</h2>';
                    $miDB = new PDO(HOSTPDO, USER, 'p');
                } catch (Exception $e) {
                    echo 'Error ' . $e->getCode() . ' : ' . $e->getMessage() . '<br>';
                } finally {
                    unset($miDB);
                }
                ?>
            </section>
            <div class="return">
                <a href="../indexProyectoTema4.php"><img src="../webroot/images/back.png" alt="Imagen back"></a>
            </div>
        </main>
        <footer>
            <div class="footerIcons">
                <a href="../doc/curriculum.pdf" target="_blank"><img src="../webroot/images/curriculum.png"
                                                                     alt="Imagen curriculum"></a>
                <a href="https://github.com/JosueMarFer/205DWESProyectoTema4" target="_blank"><img
                        src="../webroot/images/github.png" alt="Imagen github"></a>
            </div>
            <div class="home">
                <a href="../../index.html"><img src="../webroot/images/home.png" alt="Imagen home"></a>
                <p>Josué martínez Fernández</p>
            </div>
        </footer>
    </body>
</html>