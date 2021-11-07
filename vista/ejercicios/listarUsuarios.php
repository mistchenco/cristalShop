<?php
include_once '../../configuracion.php';
$sesion = new session();

$datos = data_submitted();
$rolSesion = $sesion->getRol();
$objUsuario=$sesion->getUsuario();

if (!$sesion->activa()) {
  header('Location: index.php');
} else {
  include_once '../estructura/cabecera.php';
}

echo "<h4>Usted esta Logueado como: {$objUsuario->getUsNombre()}</h4>";

include_once "../estructura/cabecera.php";
$abmUsuario = new abmUsuario();
$abmRol = new abmUsuarioRol();
$listaUsuario = $abmUsuario->buscar(null);

?>

<div class="container mt-3">
  <h4>Implementar en la capa de la vista:
    un script Vista/listarUsuario.php que liste los usuario registrados y permita actualizar sus datos o
    realizar un borrado lógico. Las acciones que se van a poder invocar son:
    accion/actualizarLogin.php y accion/eliminarLogin.php</h4>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col" class="text-center">Id Usuario</th>
        <th scope="col" class="text-center">Nombre de Usuario</th>
        <th scope="col" class="text-center"> Password</th>
        <th scope="col" class="text-center">Email</th>
        <th scope="col" class="text-center">Rol</th>
        <th scope="col" class="text-center">Estado</th>
        <th scope="col" class="text-center">Editar Datos</th>
        <th scope="col" class="text-center">Deshabilitar Usuario</th>
      </tr>
    </thead>
    <?php
    if (count($listaUsuario) > 0) {

      foreach ($listaUsuario as $objUsuario) {
        $idUsuario = $objUsuario->getIdUsuario();

        $datos['idUsuario'] = $idUsuario;
        $listaRol = $abmRol->buscar($datos);

        echo '<tr><td class="text-center" style="width:200px;">' . $objUsuario->getIdUsuario() . '</td>';
        echo '<td class="text-center" style="width:200px;">' . $objUsuario->getUsNombre() . '</td>';
        echo '<td class="text-center" style="width:200px;">' . $objUsuario->getUsPass() . '</td>';
        echo '<td class="text-center" style="width:200px;">' . $objUsuario->getUsMail() . '</td>';
        $descripcion="";
        foreach ($listaRol as $rol) {
          $objRol = $rol->getObjRol();
          $descripcion=$descripcion.$objRol->getRolDescripcion().'</br>';
         
        }
        echo '<td class="text-center" style="width:200px;">' . $descripcion . '</td>';
        '</tr>';

        if ($objUsuario->getUsDesabilitado()== null || $objUsuario->getUsDesabilitado()=="0000-00-00 00:00:00") {

          echo "<td class='text-center'><i class='far fa-check-circle'></i></td>";
        } else {
          echo "<td class='text-center'><i class='far fa-times-circle'></i></td>";
        }
        echo "<form action='editarUsuario.php' method='post'>
        <td class='text-center'>
        <input name='idUsuario' id='idUsuario' type='hidden' value='$idUsuario'>
        <button class='btn btn-dark' type='submit'><i class='fas fa-edit'></i>
        </button></td></form>
        <form action='../accion/eliminarUsuario.php' method='post'>
        <td class='text-center'>
        <input name='idUsuario' id='idUsuario' type='hidden' value='$idUsuario'>
        <button class=' btn btn-dark' type='submit'>
        <i class='fas fa-user-times'></i></i></button></td></form></tr>";
      }
      if (isset($_GET['Message'])) {
        print '<script type="text/javascript">alert("' . $_GET['Message'] . '");</script>';
      }
    } else {

      echo '<h3> No se encontraron registros </h3>';
    }

    ?>
</div>
</table>

<?php
include_once '../estructura/footer.php';
?>