<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../webroot/css/style.css">
        <title>Ejercicio 05-1</title>
    </head>

    <body>
        <header>
            <h1>Tema 4</h1>
            <h2>Ejercicio 05-1</h2>
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
//Definicion de los scripts de inserccion
                $codigoInsertaDepartamento1 = 'INSERT INTO T02_Departamento VALUES (UPPER("pp1"), "Prueba 1", NOW(), null, 1000)';
                $codigoInsertaDepartamento2 = 'INSERT INTO T02_Departamento VALUES (UPPER("pp2"), "Prueba 2", NOW(), null, 2000)';
                $codigoInsertaDepartamento3 = 'INSERT INTO T02_Departamento VALUES (UPPER("pp3"), "Prueba 3", NOW(), null, 3000)';
//Creamos la conexion      
                try {
                    $miDB = new PDO(HOSTPDO, USER, PASSWD);
//Desactivacion del autocommit
                    $miDB->beginTransaction();
//Ejecutamos los query

                    $insertaDepartamento = $miDB->prepare($codigoInsertaDepartamento1);
                    $insertaDepartamento->execute();
                    $insertaDepartamento = $miDB->prepare($codigoInsertaDepartamento2);
                    $insertaDepartamento->execute();
                    $insertaDepartamento = $miDB->prepare($codigoInsertaDepartamento3);
                    $insertaDepartamento->execute();
//Evaluamos si se ha de hacer el commit o el rollback
                    $miDB->commit();
                    echo 'Transaccion completada';
                } catch (Exception $e) {
                    $miDB->rollBack();
                    echo 'ERROR. No se ha podido realizar la transaccion';
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