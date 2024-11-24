<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtIDCredencial = (isset($_POST['txtIDCredencial']))?$_POST['txtIDCredencial']:"";
    $txtIDArea = (isset($_POST['txtIDArea']))?$_POST['txtIDArea']:"";

    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtUsuarioAgregar = (isset($_POST['txtUsuarioAgregar']))?$_POST['txtUsuarioAgregar']:"";
    $txtContraseniaAgregar = (isset($_POST['txtContraseniaAgregar']))?$_POST['txtContraseniaAgregar']:"";
    $txtAreaAgregar = (isset($_POST['txtAreaAgregar']))?$_POST['txtAreaAgregar']:"";

    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtUsuarioEditar = (isset($_POST['txtUsuarioEditar']))?$_POST['txtUsuarioEditar']:"";
    $txtContraseniaEditar = (isset($_POST['txtContraseniaEditar']))?$_POST['txtContraseniaEditar']:"";
    $txtAreaEditar = (isset($_POST['txtAreaEditar']))?$_POST['txtAreaEditar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM empleado WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtAreaEditar = $ListaSel['ID_Area'];
            $txtIDCredencial = $ListaSel['ID_Credenciales'];

            $sentenciaSQL=$conn->prepare("SELECT * FROM credenciales WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtIDCredencial);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
            
            $txtUsuarioEditar = $ListaSel['Usuario'];
            $txtContraseniaEditar = $ListaSel['Contrasenha'];
            
            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE empleado SET Nombre=:Nombre, ID_Area=:ID_Area WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Nombre', $txtNombreEditar);
            $sentenciaSQL->bindParam(':ID_Area', $txtAreaEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("UPDATE credenciales SET Usuario=:Usuario, Contrasenha=:Contrasenha WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Usuario', $txtUsuarioEditar);
            $sentenciaSQL->bindParam(':Contrasenha', $txtContraseniaEditar);
            $sentenciaSQL->bindParam(':ID', $txtIDCredencial);
            $sentenciaSQL->execute();

            $txtID="";
            $txtNombreEditar = "";
            $txtIDCredencial = "";
            $txtUsuarioEditar = "";
            $txtAreaEditar = "";
            $txtContraseniaEditar = "";

            header("Location: gestionar_usuarios.php");
            exit();
    
        // TERMINAR EL AGREGAR!!!!!!!!
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $txtTipoUsuario = "Usuario";
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM credenciales");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindexCred = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO credenciales (ID, Usuario, Contrasenha, Tipo_Usuario) VALUES (:ID, :Usuario, :Contrasenha, :Tipo_Usuario)");
            $sentenciaSQL->bindParam(':Usuario', $txtUsuarioAgregar);
            $sentenciaSQL->bindParam(':Contrasenha', $txtContraseniaAgregar);
            $sentenciaSQL->bindParam(':Tipo_Usuario', $txtTipoUsuario);
            $sentenciaSQL->bindParam(':ID', $lastindexCred);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM empleado");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindexEmp = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO empleado (ID, Nombre, ID_Credenciales, ID_Area) VALUES (:ID, :Nombre, :ID_Credenciales, :ID_Area)");
            $sentenciaSQL->bindParam(':Nombre', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':ID_Credenciales', $lastindexCred);
            $sentenciaSQL->bindParam(':ID_Area', $txtAreaAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindexEmp);
            $sentenciaSQL->execute();
            
            header("Location: gestionar_usuarios.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM empleado WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();

            $sentenciaSQL = $conn->prepare("DELETE FROM credenciales WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtIDCredencial);
            $sentenciaSQL->execute();

            header("Location: gestionar_usuarios.php");
            exit();
    
    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM empleado");
    $sentenciaSQL->execute();
    $listaUsuarios=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM credenciales");
    $sentenciaSQL->execute();
    $listaCredenciales=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">


<!-- Modal -->
<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- Nombre -->
          <div class="mb-3">
            <label for="txtNombreAgregar" class="form-label">Nombre</label>
            <input class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre"></input>
          </div>
          <!-- Area -->
          <div class="mb-3">
            <label for="txtAreaAgregar" class="form-label">Área</label>
            <input class="form-control" name="txtAreaAgregar" id="txtAreaAgregar" placeholder="Ingrese el área"></input>
          </div>
          <!-- Usuario -->
          <div class="mb-3">
            <label for="txtUsuarioAgregar" class="form-label">Nombre de usuario</label>
            <input class="form-control" name="txtUsuarioAgregar" id="txtUsuarioAgregar" placeholder="Ingrese el nombre de usuario"></input>
          </div>
          <!-- Contraseña -->
          <div class="mb-3">
            <label for="txtContraseniaAgregar" class="form-label">Contraseña</label>
            <input class="form-control" name="txtContraseniaAgregar" id="txtContraseniaAgregar" placeholder="Ingrese la contraseña"></input>
          </div>
          <!-- Botón agregar -->
          <div class="text-center">
            <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Listado -->
<div class="card row m-5 shadow overflow-scroll">
    <!-- Botón para abrir el modal -->
    <h4 class="p-2">Listado de usuarios</h4>
    <hr>
    <div class="m-2">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal">
        Agregar usuario
        </button>
    </div>
    <table class="table table-bordered">
        <thead>    
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Área</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaUsuarios as $lista){?>
            <tr>
                <td><?php echo $lista['ID'] ?></td>
                <td><?php echo $lista['Nombre']?></td>
                <?php foreach($listaCredenciales as $credencial){if($lista['ID_Credenciales']==$credencial['ID']){?>
                <td><?php echo $credencial['Usuario'] ?></td>
                <td><?php echo $credencial['Contrasenha'] ?></td>
                <?php } } ?>
                <?php foreach($listaAreas as $area){if($lista['ID_Area']==$area['ID']){?>
                <td><?php echo $area['ID'] ?></td>
                <td><?php echo $area['Area'] ?></td>
                <?php } } ?>
                
                <td>
                    <form method="POST">
                        <div class="row border">
                            <div class="col">
                                <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['ID'] ?>"></input></div>
                                <div class="row m-1"><input type="hidden" name="txtIDCredencial" id="txtIDCredencial" value="<?php echo $credencial['ID'] ?>"></input></div>
                                <div class="row m-1"><input type="hidden" name="txtIDArea" id="txtIDArea" value="<?php echo $area['ID'] ?>"></input></div>
                                <!-- Botón para abrir el modal -->
                                <div class="row m-2">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarUsuarioModal"
                                            data-id="<?php echo $lista['ID'] ?>"
                                            data-nombre="<?php echo $lista['Nombre'] ?>"
                                            data-id-credencial="<?php echo $credencial['ID'] ?>"
                                            data-usuario="<?php echo $credencial['Usuario'] ?>"
                                            data-contrasenia="<?php echo $credencial['Contrasenha'] ?>"
                                            data-area="<?php echo $area['ID'] ?>">
                                    Editar usuario seleccionado
                                    </button>    
                                </div>
                                <div class="row m-1"><input type="submit" name="accion" value="Eliminar" class="btn btn-danger"></input></div>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<!-- Modal -->
<div class="modal fade" id="editarUsuarioModal" tabindex="-1" aria-labelledby="editarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarUsuarioModalLabel">Editar usuario seleccionado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- ID -->
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <label for="txtID" class="form-label">ID</label>
                <input type="text" class="form-control" name="txtID" id="modalTxtID" placeholder="ID" readonly>
              </div>
            </div>
            <div class="col"></div>
          </div>
          <!-- Nombre -->
          <div class="row">
            <div class="mb-3">
              <label for="txtNombreEditar" class="form-label">Nombre</label>
              <input class="form-control" name="txtNombreEditar" id="modalTxtNombreEditar" placeholder="Ingrese el nombre"></input>
            </div>
          </div>
          <!-- Area -->
          <div class="row">
            <div class="mb-3">
              <label for="txtAreaEditar" class="form-label">Área</label>
              <input class="form-control" name="txtAreaEditar" id="modalTxtAreaEditar" placeholder="Ingrese el área"></input>
            </div>
          </div>
          <!-- ID Credencial -->
          <div class="row">
            <div class="mb-3">
              <label for="txtIDCredencial" class="form-label">ID Credencial</label>
              <input class="form-control" name="txtIDCredencial" id="modalTxtIDCredencial" placeholder="ID Credencial" readonly></input>
            </div>
          </div>
          <!-- Usuario -->
          <div class="row">
            <div class="mb-3">
              <label for="txtUsuarioEditar" class="form-label">Nombre de usuario</label>
              <input class="form-control" name="txtUsuarioEditar" id="modalTxtUsuarioEditar" placeholder="Ingrese el nombre de usuario"></input>
            </div>
          </div>
          <!-- Contraseña -->
          <div class="row">
            <div class="mb-3">
              <label for="txtContraseniaEditar" class="form-label">Contraseña</label>
              <input class="form-control" name="txtContraseniaEditar" id="modalTxtContraseniaEditar" placeholder="Ingrese la contraseña"></input>
            </div>
          </div>
          <!-- Editar y Deseleccionar -->
          <div class="row">
            <div class="col text-center">
              <input class="btn btn-warning" type="submit" value="Editar" name="accion">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var editarUsuarioModal = document.getElementById('editarUsuarioModal');
    editarUsuarioModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var userId = button.getAttribute('data-id');
        var userName = button.getAttribute('data-nombre');
        var userIdCredencial =button.getAttribute('data-id-credencial');
        var userUsuario = button.getAttribute('data-usuario');
        var userContrasenia = button.getAttribute('data-contrasenia');
        var userArea = button.getAttribute('data-area');

        var modalTxtID = editarUsuarioModal.querySelector('#modalTxtID');
        var modalTxtNombreEditar = editarUsuarioModal.querySelector('#modalTxtNombreEditar');
        var modalTxtIDCredencial = editarUsuarioModal.querySelector('#modalTxtIDCredencial');
        var modalTxtUsuarioEditar = editarUsuarioModal.querySelector('#modalTxtUsuarioEditar');
        var modalTxtContraseniaEditar = editarUsuarioModal.querySelector('#modalTxtContraseniaEditar');
        var modalTxtAreaEditar = editarUsuarioModal.querySelector('#modalTxtAreaEditar');

        modalTxtID.value = userId;
        modalTxtNombreEditar.value = userName;
        modalTxtIDCredencial.value = userIdCredencial;
        modalTxtUsuarioEditar.value = userUsuario;
        modalTxtContraseniaEditar.value = userContrasenia;
        modalTxtAreaEditar.value = userArea;
    });
});
</script>

<?php
    include_once("../../src/footer.php");
?>