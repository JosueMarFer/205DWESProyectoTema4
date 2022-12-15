<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../webroot/css/style.css">
        <title>Ejercicio 06-1</title>
    </head>

    <body>
        <header>
            <h1>Tema 4</h1>
            <h2>Ejercicio 06-1</h2>
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
                $codigoInsertaDepartamento = 'INSERT INTO T02_Departamento VALUES (? , ? , now(), null, ? )';
//Creacion e inicialización de array con los datos a importar      
                $aimportacion = [
                    ['CodDepartamento' => 'DPA',
                        'DescDepartamento' => 'Departamento prueba 1',
                        'VolumenNegocio' => '1100'],
                    ['CodDepartamento' => 'DPB',
                        'DescDepartamento' => 'Departamento prueba 2',
                        'VolumenNegocio' => '1200'],
                    ['CodDepartamento' => 'DPC',
                        'DescDepartamento' => 'Departamento prueba 3',
                        'VolumenNegocio' => '1300']
                ];
//Realizamos la conexxion      
                try {
                    $miDB = new PDO(HOSTPDO, USER, PASSWD);
//Desactivacion del autocommit
                    $miDB->beginTransaction();
//Bucle que recorre el array y lo almacena en la consulta preparada como parametro
                    foreach ($aimportacion as $indexDepartamento => $aDeparamento) {
                        $CodDepartamento = $aDeparamento['CodDepartamento'];
                        $DescDepartamento = $aDeparamento['DescDepartamento'];
                        $VolumenNegocio = $aDeparamento['VolumenNegocio'];

                        $insertaDepartamento = $miDB->prepare($codigoInsertaDepartamento);
                        $insertaDepartamento->execute(array($CodDepartamento, $DescDepartamento, $VolumenNegocio));
                    }
//Evaluamos si se ha de hacer el commit o el rollback
                    $miDB->commit();
                    echo 'Transaccion completada';
                } catch (Exception $e) {
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