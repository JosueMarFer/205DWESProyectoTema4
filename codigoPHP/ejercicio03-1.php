<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../webroot/css/style.css">
        <title>Ejercicio 03-1</title>
    </head>

    <body>
        <header>
            <h1>Tema 4</h1>
            <h2>Ejercicio 03-1</h2>
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
//Importa la libreria de validación   
                require_once '../core/221120ValidacionFormularios.php';
//Define las instrucciones sql en variables     
                $codigoBuscaCodigo = 'SELECT * FROM T02_Departamento WHERE T02_CodDepartamento = :codigoBusqueda';
                $codigoInsertaDepartamento = 'INSERT INTO T02_Departamento VALUES (:codigoInsercion, :descripcionInsercion, now(), null, :volumenNegocioInsercion)';
//Define e inicializa el array de errores
                $aErrores = [
                    'CodDepartamento' => '',
                    'DescDepartamento' => '',
                    'VolumenNegocio' => ''
                ];
//Define e inicializa el array de respuestas
                $aRespuestas = [
                    'CodDepartamento' => '',
                    'DescDepartamento' => '',
                    'VolumenNegocio' => ''
                ];
//Define e inicializa la variable encargada de comprobar si los datos estan validados
                $entradaOK = true;
//Si se ha pulsado el boton de enviar valida los campos
//en caso de devolver algun error almacena el mismo en el array de errores (en su campo correspondiente)
                if (isset($_REQUEST['enviar'])) {

                    $aErrores['CodDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['CodDepartamento'], 3, 3, 1);
                    if (is_null($aErrores['CodDepartamento'])) {
                        if ($_REQUEST['CodDepartamento'] == strtoupper($_REQUEST['CodDepartamento'])) {
                            try {
                                $miDB = new PDO(HOSTPDO, USER, PASSWD);
                                $buscaCodigo = $miDB->prepare($codigoBuscaCodigo);
                                $buscaCodigo->bindParam(':codigoBusqueda', $_REQUEST['CodDepartamento']);
                                $buscaCodigo->execute();
                                if ($buscaCodigo->rowCount() > 0) {
                                    $aErrores['CodDepartamento'] = "El codigo ya existe";
                                }
                            } catch (Exception $e) {
                                echo 'Error ' . $e->getCode() . ' : ' . $e->getMessage() . '<br>';
                            } finally {
                                unset($miDB);
                            }
                        } else {
                            $aErrores['CodDepartamento'] = "El codigo debe estar en Mayusculas";
                        }
                    }
                    $aErrores['DescDepartamento'] = validacionFormularios::comprobarAlfabetico($_REQUEST['DescDepartamento'], 255, 1, 1);
                    $aErrores['VolumenNegocio'] = validacionFormularios::comprobarFloat($_REQUEST['VolumenNegocio'], PHP_FLOAT_MAX, 0, 1);
//Recorre el array de errores y en caso de tener alguno la variable que comprueba la entrada pasa a ser false
//Limpia de $_REQUEST los campos que no han sido validados
                    foreach ($aErrores as $errorIndex => $errorValue) {
                        if (!is_null($errorValue)) {
                            $_REQUEST[$errorIndex] = '';
                            $entradaOK = false;
                        }
                    }
                } else {
                    $entradaOK = false;
                }
//Comprueba si la entrada es valida
//Si es valida recoje los datos en el array de respuestas
//Si no es valida vuelve a mostrar el formulario
//El array de respuestas se ejecuta en el query de insercion
                if ($entradaOK) {
                    $aRespuestas['CodDepartamento'] = $_REQUEST['CodDepartamento'];
                    $aRespuestas['DescDepartamento'] = $_REQUEST['DescDepartamento'];
                    $aRespuestas['VolumenNegocio'] = $_REQUEST['VolumenNegocio'];
                    try {
                        $miDB = new PDO(HOSTPDO, USER, PASSWD);
                        $insertaDepartamento = $miDB->prepare($codigoInsertaDepartamento);
                        $insertaDepartamento->bindParam(':codigoInsercion', $_REQUEST['CodDepartamento']);
                        $insertaDepartamento->bindParam(':descripcionInsercion', $_REQUEST['DescDepartamento']);
                        $insertaDepartamento->bindParam(':volumenNegocioInsercion', $_REQUEST['VolumenNegocio']);
                        $insertaDepartamento->execute();
                        echo 'El campo se ha añadido correctamente';
                    } catch (Exception $e) {
                        echo 'Error ' . $e->getCode() . ' : ' . $e->getMessage() . '<br>';
                    } finally {
                        unset($miDB);
                    }
                } else {
                    ?>
                    <form name="ejercicio03-1" action="./<?php echo basename($_SERVER['PHP_SELF']); ?>" method="post">
                        <fieldset>
                            <legend>Datos Departamento</legend>
                            <div class="formElement">
                                <label for="CodDepartamento">Codigo de departamento:</label>
                                <input type="text" id="CodDepartamento" name="CodDepartamento"
                                       value="<?php echo $_REQUEST['CodDepartamento'] ?? '' ?>" />
                                       <?php (!is_null($aErrores['CodDepartamento'])) ? print '<p style="color: red; display: inline;">' . $aErrores['CodDepartamento'] . '</p>' : ''; ?>
                            </div>
                            <div class="formElement">
                                <label for="DescDepartamento">Descripcion de departamento:</label>
                                <input type="text" id="DescDepartamento" name="DescDepartamento"
                                       value="<?php echo $_REQUEST['DescDepartamento'] ?? '' ?>" />
                                       <?php (!is_null($aErrores['DescDepartamento'])) ? print '<p style="color: red; display: inline;">' . $aErrores['DescDepartamento'] . '</p>' : ''; ?>
                            </div>
                            <div class="formElement">
                                <label for="VolumenNegocio">Volumen de negocio:</label>
                                <input type="number" id="VolumenNegocio" step="0.01" name="VolumenNegocio"
                                       value="<?php echo $_REQUEST['VolumenNegocio'] ?? '' ?>" />
                                       <?php (!is_null($aErrores['VolumenNegocio'])) ? print '<p style="color: red; display: inline;">' . $aErrores['VolumenNegocio'] . '</p>' : ''; ?>
                            </div>
                            <div class="formElement">
                                <input type="submit" value="Enviar" name="enviar" />
                            </div>
                        </fieldset>
                    </form>
                    <?php
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