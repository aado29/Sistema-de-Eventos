<?php
     /* Conexion                      */
          $conexion = mysqli_connect("localhost","root","","eventos") or die("Error en la base de datos");

     /* Distincion de formulario       */
          if (!isset($_REQUEST['formName'])) {
               $form = "";
          }else{
               $form = $_REQUEST['formName'];
          }

     /* INICIO DE SESION               */
          if ($form == "session") {
               session_start();
               $u=$_REQUEST['user'];
               $p=$_REQUEST['pass'];

               $_SESSION['user'] = $u;
               $_SESSION['pass'] = $p;

               $query=mysqli_query($conexion,"SELECT * FROM usuarios WHERE correo_u = '$u' and contra_u = '$p'");

               if ( $reg=mysqli_fetch_array($query) ){
                    $_SESSION['type'] = $reg['tipo_u'];
                    echo "success: ".$_SESSION['type'];
                    mysqli_close($conexion);
               }else {
                    echo "error";
               }
          }else

// REGISTROS

     /* Registro de grupos de rescate  */
          if ($form == "reg-grupo") {
               session_start();

               // $id        = $_REQUEST['id'];
               $nombre    = $_REQUEST['name'];
               $tipo      = $_REQUEST['type'];
               $desc      = $_REQUEST['description'];
               $telefono  = $_REQUEST['phone'];
               $direccion = $_REQUEST['address'];
               $correo    = $_REQUEST['email'];
               $num_miemb = $_REQUEST['membersNumber'];
               $estado    = $_REQUEST['state'];

               $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO grupos (id_grupo , nombre_g , tipo_g , desc_g , telefono_g , direccion_g , correo_g , num_miemb , estado_g)
                    VALUES (NULL, '$nombre', '$tipo', '$desc', '$telefono', '$direccion', '$correo', '$num_miemb', '$estado')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "succes";
               }else {
                    echo "error";
               }

          }else

     /* Registro de Equipo             */
          if ($form == "reg-equipo") {
               session_start();

               // $id        = $_REQUEST['id'];
               $nombre    = $_REQUEST['name'];
               $desc      = $_REQUEST['description'];
               $estado    = $_REQUEST['state'];

               $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO equipos (id_equipo, nombre_e, desc_e, estado_e)
                    VALUES (null, '$nombre', '$desc', '$estado')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "succes";
               }else {
                    echo "error";
               }
          }else

     /* Registro de Usuarios           */
          if ($form == "reg-usuario") {
               session_start();

               $id        = $_REQUEST['id'];
               $cedula    = $_REQUEST['ced'];
               $nombre    = $_REQUEST['nombre'];
               $pass      = $_REQUEST['pass'];
               $telf      = $_REQUEST['telf'];
               $email     = $_REQUEST['email'];
               $tipo      = $_REQUEST['tipo'];

               $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO usuarios (id_usuario, cedula_u, nombre_u, contra_u, telefono_u, correo_u, tipo_u)
                    VALUES ('$id', '$cedula', '$nombre', '$pass', '$telf', '$email', '$tipo')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "<script>$(body).html(alert('Se registro'))</script>";
               }else {
                    mysqli_close($conexion);
                    echo "<script>$(body).html(alert('No se registro'))</script>";
               }
          }

     /* Registro de Vehiculo           */
          if ($form == "reg-vehiculo") {
               session_start();

               $placa      = $_REQUEST['plate'];
               $marca      = $_REQUEST['brand'];
               $modelo     = $_REQUEST['model'];
               $color      = $_REQUEST['color'];
               $ano        = $_REQUEST['year'];
               $carroceria = $_REQUEST['bodywork'];
               $motor      = $_REQUEST['motor'];
               $chassis    = $_REQUEST['chassis'];
               $estado     = $_REQUEST['state'];


               $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO vehiculos (id_vehiculo, placa, marca, modelo, color, ano, num_carroceria, num_motor, num_chasis, estado_vh)
                    VALUES (null, '$placa', '$marca', '$modelo', '$color', '$ano', '$carroceria', '$motor', '$chassis', '$estado')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "success";
               }else {
                    echo "error";
               }
          }

     /* Registro de Evento             */
          if ($form == "reg-evento") {
               session_start();

               $tipo       = $_REQUEST['eventType'];
               $fini       = $_REQUEST['startDate'];
               $ffin       = $_REQUEST['dueDate'];
               $lugar      = $_REQUEST['place'];
               $grupo      = $_REQUEST['group'];
               $voluntario = $_REQUEST['voluntary'];
               $equipo     = $_REQUEST['team'];

               $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO eventos (id_evento, tipo_ev, f_incio, f_fin, lugar_ev, id_grupo, id_voluntario, id_equipo)
                    VALUES (null, '$tipo', '$fini', '$ffin', '$lugar', '$grupo', '$voluntario', '$equipo')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "success";
               }else {
                    echo "error";
               }
          }

     /* Registro de Voluntario         */
          if ($form == "reg-voluntario") {
               session_start();

               $cedu     = $_REQUEST['ci'];
               $nomb     = $_REQUEST['firstName'];
               $apel     = $_REQUEST['lastName'];
               $dire     = $_REQUEST['address'];
               $telf     = $_REQUEST['phone'];
               $email    = $_REQUEST['email'];
               $tcam     = $_REQUEST['sizeShirt'];
               $tpan     = $_REQUEST['sizePants'];
               $tzap     = $_REQUEST['sizeShoes'];
               $cargo    = $_REQUEST['position'];
               $prof     = $_REQUEST['profession'];
               $espe     = $_REQUEST['speciality'];
               $ocup     = $_REQUEST['employment'];
               $grupo    = $_REQUEST['group'];
               $vehiculo = $_REQUEST['vehicle'];
               $tipo     = $_REQUEST['type'];
               $estado   = $_REQUEST['state'];

             $insertar = mysqli_query(
                    $conexion,
                    "INSERT INTO voluntarios (id_voluntario, cedula_v, nombre_v, apellido_v, direccion_v, telefono_v, correo_v, talla_camisa, talla_pantalon, talla_zapatos, cargo_v, profesion_v, especialidad_v, ocupacion_V, tipo_v, estado_v, id_equipo, id_vehiculo)
                    VALUES (null, '$cedu', '$nomb', '$apel', '$dire', '$telf', '$email', '$tcam', '$tpan', '$tzap', '$cargo', '$prof', '$espe', '$ocup', '$tipo', '$estado', '$grupo', '$vehiculo')"
               ) or die("error");

               if ($insertar) {
                    mysqli_close($conexion);
                    echo "success";
               }else {
                    echo "error";
               }
          }


?>
