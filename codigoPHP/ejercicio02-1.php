<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../webroot/css/style.css">
        <title>Ejercicio 02-1</title>
    </head>

    <body>
        <header>
            <h1>Tema 4</h1>
            <h2>Ejercicio 02-1</h2>
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
//Define las instrucciones sql en variables
                $CodigoConsultaDatos = 'select * from T02_Departamento;';
//Crea una conexion
                try {
                    $miDB = new PDO(HOSTPDO, USER, PASSWD);
//Ejecuta el query        
                    $contenidoDepartamentos = $miDB->prepare($CodigoConsultaDatos);
                    $contenidoDepartamentos->execute();
//Mostrar el numero de registros
                    echo 'El numero de Registros es: ' . $contenidoDepartamentos->rowCount();
//Almacenar en un objeto el resultado de cada consulta
//cada vez que se le asigna un nuevo fetchobject() se almacena una nueva fila de la consulta
//Imprime el resultado en formato de tabla
                    $oContenidoDepartamentos = $contenidoDepartamentos->fetchObject();
                    echo '<table><thead><tr><th>T02_CodDepartamento</th><th>T02_DescDepartamento</th><th>T02_FechaCreacionDepartamento</th><th>T02_FechaBaja</th><th>T02_VolumenNegocio</th></tr></thead><tbody>';
                    while ($oContenidoDepartamentos != null) {
                        echo '<tr><td>' . $oContenidoDepartamentos->T02_CodDepartamento, '</td>';
                        echo '<td>' . $oContenidoDepartamentos->T02_DescDepartamento, '</td>';
                        echo '<td>' . $oContenidoDepartamentos->T02_FechaCreacionDepartamento, '</td>';
                        echo '<td>' . $oContenidoDepartamentos->T02_FechaBaja, '</td>';
                        echo '<td>' . $oContenidoDepartamentos->T02_VolumenNegocio, '</td></tr>';
                        $oContenidoDepartamentos = $contenidoDepartamentos->fetchObject();
                    }
                    echo '</table>';
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