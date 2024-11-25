<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";

    $txtRutAgregar = (isset($_POST['txtRutAgregar']))?$_POST['txtRutAgregar']:"";
    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtCorreoAgregar = (isset($_POST['txtCorreoAgregar']))?$_POST['txtCorreoAgregar']:"";
    $txtTelefonoAgregar = (isset($_POST['txtTelefonoAgregar']))?$_POST['txtTelefonoAgregar']:"";
    $txtDireccionAgregar = (isset($_POST['txtDireccionAgregar']))?$_POST['txtDireccionAgregar']:"";
    $txtComunaAgregar = (isset($_POST['txtComunaAgregar']))?$_POST['txtComunaAgregar']:"";
    $txtCiudadAgregar = (isset($_POST['txtCiudadAgregar']))?$_POST['txtCiudadAgregar']:"";
    $txtGiroAgregar = (isset($_POST['txtGiroAgregar']))?$_POST['txtGiroAgregar']:"";

    $txtRutEditar = (isset($_POST['txtRutEditar']))?$_POST['txtRutEditar']:"";
    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtCorreoEditar = (isset($_POST['txtCorreoEditar']))?$_POST['txtCorreoEditar']:"";
    $txtTelefonoEditar = (isset($_POST['txtTelefonoEditar']))?$_POST['txtTelefonoEditar']:"";
    $txtDireccionEditar = (isset($_POST['txtDireccionEditar']))?$_POST['txtDireccionEditar']:"";
    $txtComunaEditar = (isset($_POST['txtComunaEditar']))?$_POST['txtComunaEditar']:"";
    $txtCiudadEditar = (isset($_POST['txtCiudadEditar']))?$_POST['txtCiudadEditar']:"";
    $txtGiroEditar = (isset($_POST['txtGiroEditar']))?$_POST['txtGiroEditar']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM proveedor WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtRutEditar = $ListaSel['RUT'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtCorreoEditar = $ListaSel['Correo'];
            $txtTelefonoEditar = $ListaSel['Telefono'];
            $txtDireccionEditar = $ListaSel['Direccion'];
            $txtComunaEditar = $ListaSel['Comuna'];
            $txtCiudadEditar = $ListaSel['Ciudad'];
            $txtGiroEditar = $ListaSel['Giro'];
            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE proveedor SET RUT=:RUT, NOMBRE=:NOMBRE, CORREO=:CORREO, TELEFONO=:TELEFONO, DIRECCION=:DIRECCION, Comuna=:Comuna, Ciudad=:Ciudad, Giro=:Giro WHERE ID=:ID");
            $sentenciaSQL->bindParam(':RUT', $txtRutEditar);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreEditar);
            $sentenciaSQL->bindParam(':CORREO', $txtCorreoEditar);
            $sentenciaSQL->bindParam(':TELEFONO', $txtTelefonoEditar);
            $sentenciaSQL->bindParam(':DIRECCION', $txtDireccionEditar);
            $sentenciaSQL->bindParam(':Comuna', $txtComunaEditar);
            $sentenciaSQL->bindParam(':Ciudad', $txtCiudadEditar);
            $sentenciaSQL->bindParam(':Giro', $txtGiroEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $txtID="";
            $txtRutEditar = "";
            $txtNombreEditar = "";
            $txtCorreoEditar = "";
            $txtTelefonoEditar = "";
            $txtDireccionEditar = "";
            $txtComunaEditar = "";
            $txtCiudadEditar = "";
            $txtGiroEditar = "";
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM proveedor");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO proveedor (ID, RUT, NOMBRE, CORREO, TELEFONO, DIRECCION, Comuna, Ciudad, Giro) VALUES (:ID, :RUT, :NOMBRE, :CORREO, :TELEFONO, :DIRECCION, :Comuna, :Ciudad, :Giro)");
            $sentenciaSQL->bindParam(':RUT', $txtRutAgregar);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':CORREO', $txtCorreoAgregar);
            $sentenciaSQL->bindParam(':TELEFONO', $txtTelefonoAgregar);
            $sentenciaSQL->bindParam(':DIRECCION', $txtDireccionAgregar);
            $sentenciaSQL->bindParam(':Comuna', $txtComunaAgregar);
            $sentenciaSQL->bindParam(':Ciudad', $txtCiudadAgregar);
            $sentenciaSQL->bindParam(':Giro', $txtGiroAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindex);
            $sentenciaSQL->execute();
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM proveedor WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_proveedores.php");
            exit();
    
        case "Deseleccionar":
            $txtID="";
            $txtRutEditar = "";
            $txtNombreEditar = "";
            $txtCorreoEditar = "";
            $txtTelefonoEditar = "";
            $txtDireccionEditar = "";
            $txtComunaEditar = "";
            $txtCiudadEditar = "";
            $txtGiroEditar = "";
            break;

    }

    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Incluye los archivos de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Modal Agregar Proveedor -->
<div class="modal fade" id="agregarProveedorModal" tabindex="-1" aria-labelledby="agregarProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarProveedorModalLabel">Agregar proveedor</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="row">
            <div class="col">
              <!-- RUT -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtRutAgregar" class="form-label">Rut</label>
                  <input class="form-control" name="txtRutAgregar" id="txtRutAgregar" placeholder="Ingrese el RUT"></input>
                </div>
              </div>
              <!-- Nombre -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtNombreAgregar" class="form-label">Nombre</label>
                  <input class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre"></input>
                </div>
              </div>
              <!-- Correo -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtCorreoAgregar" class="form-label">Correo</label>
                  <input class="form-control" name="txtCorreoAgregar" id="txtCorreoAgregar" placeholder="Ingrese el correo"></input>
                </div>
              </div>
              <!-- Teléfono -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtTelefonoAgregar" class="form-label">Teléfono</label>
                  <input class="form-control" name="txtTelefonoAgregar" id="txtTelefonoAgregar" placeholder="Ingrese el número telefónico"></input>
                </div>
              </div>
            </div>
            <div class="col">
              <!-- Dirección -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtDireccionAgregar" class="form-label">Dirección</label>
                  <input class="form-control" name="txtDireccionAgregar" id="txtDireccionAgregar" placeholder="Ingrese la dirección"></input>
                </div>
              </div>
              <!-- Comuna -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtComunaAgregar" class="form-label">Comuna</label>
                  <input class="form-control" name="txtComunaAgregar" id="txtComunaAgregar" placeholder="Ingrese la comuna"></input>
                </div>
              </div>
              <!-- Ciudad -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtCiudadAgregar" class="form-label">Ciudad</label>
                  <input class="form-control" name="txtCiudadAgregar" id="txtCiudadAgregar" placeholder="Ingrese la ciudad"></input>
                </div>
              </div>
              <!-- Giro -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtGiroAgregar" class="form-label">Giro</label>
                  <input class="form-control" name="txtGiroAgregar" id="txtGiroAgregar" placeholder="Ingrese el giro"></input>
                </div>
              </div>
            </div>
          </div>
          <!-- Botón agregar -->
          <div class="row">
            <div class="text-center">
              <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Incluye los archivos de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Incluye los archivos de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Incluye los archivos de Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<!-- Modal Editar Proveedor -->
<div class="modal fade" id="editarProveedorModal" tabindex="-1" aria-labelledby="editarProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarProveedorModalLabel">Editar proveedor seleccionado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="row">
            <div class="col-6">
              <!-- ID -->
              <input type="hidden" class="form-control" name="txtID" id="txtID" placeholder="ID">
              <!-- RUT -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtRutEditar" class="form-label">Rut</label>
                  <input class="form-control" name="txtRutEditar" id="txtRutEditar" placeholder="Ingrese el RUT"></input>
                </div>
              </div>
              <!-- Nombre -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtNombreEditar" class="form-label">Nombre</label>
                  <input class="form-control" name="txtNombreEditar" id="txtNombreEditar" placeholder="Ingrese el nombre"></input>
                </div>
              </div>
              <!-- Correo -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtCorreoEditar" class="form-label">Correo</label>
                  <input class="form-control" name="txtCorreoEditar" id="txtCorreoEditar" placeholder="Ingrese el correo"></input>
                </div>
              </div>
              <!-- Teléfono -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtTelefonoEditar" class="form-label">Teléfono</label>
                  <input class="form-control" name="txtTelefonoEditar" id="txtTelefonoEditar" placeholder="Ingrese el número telefónico"></input>
                </div>
              </div>
            </div>
            <div class="col-6">
              <!-- Dirección -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtDireccionEditar" class="form-label">Dirección</label>
                  <input class="form-control" name="txtDireccionEditar" id="txtDireccionEditar" placeholder="Ingrese la dirección"></input>
                </div>
              </div>
              <!-- Comuna -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtComunaEditar" class="form-label">Comuna</label>
                  <input class="form-control" name="txtComunaEditar" id="txtComunaEditar" placeholder="Ingrese la comuna"></input>
                </div>
              </div>
              <!-- Ciudad -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtCiudadEditar" class="form-label">Ciudad</label>
                  <input class="form-control" name="txtCiudadEditar" id="txtCiudadEditar" placeholder="Ingrese la ciudad"></input>
                </div>
              </div>
              <!-- Giro -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtGiroEditar" class="form-label">Giro</label>
                  <input class="form-control" name="txtGiroEditar" id="txtGiroEditar" placeholder="Ingrese el giro"></input>
                </div>
              </div>
            </div>
          </div>
          <!-- Editar y Deseleccionar -->
          <div class="row">
            <div class="col text-center">
              <input class="btn btn-warning" type="submit" value="Editar" name="accion">
            </div>
            <div class="col text-center">
              <input class="btn btn-info" type="submit" value="Deseleccionar" name="accion">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" aria-labelledby="confirmarEliminarModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="confirmarEliminarModalLabel">Confirmar Eliminación</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ¿Estás seguro de querer eliminar este proveedor?
      </div>
      <div class="modal-footer">
        <form method="POST" id="formEliminarProveedor">
          <input type="hidden" name="txtID" id="txtIDEliminarModal">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <!-- <button type="submit" class="btn btn-danger" name="accion">Eliminar</button> -->
           <input class="btn btn-danger" type="submit" value="Eliminar" name="accion">
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Listado -->
<div class="card row m-5 shadow">
    <h4 class="p-2">Listado de proveedores</h4>
    <hr>
    <div class="p-2">
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#agregarProveedorModal">
            Agregar proveedor
        </button>
    </div>
    <table id="tablaProveedores" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>RUT</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Telefono</th>
                <th>Dirección</th>
                <th>Comuna</th>
                <th>Ciudad</th>
                <th>Giro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaProveedores as $lista){?>
            <tr>
                <td><?php echo $lista['ID'] ?></td>
                <td><?php echo $lista['RUT'] ?></td>
                <td><?php echo $lista['Nombre'] ?></td>
                <td><?php echo $lista['Correo'] ?></td>
                <td><?php echo $lista['Telefono'] ?></td>
                <td><?php echo $lista['Direccion'] ?></td>
                <td><?php echo $lista['Comuna'] ?></td>
                <td><?php echo $lista['Ciudad'] ?></td>
                <td><?php echo $lista['Giro'] ?></td>
                <td>
                    <form method="POST" class="row m-0">
                            <div class="btn-group m-0" role="group">
                                <input type="hidden" name="txtID" id="txtIDEliminar" class="m-0">
                                    <!-- Botón para abrir el modal de edición -->
                                    <button type="button" class="btn btn-warning btn-sm m-0" data-bs-toggle="modal" data-bs-target="#editarProveedorModal"
                                            data-id="<?php echo $lista['ID'] ?>"
                                            data-rut="<?php echo $lista['RUT'] ?>"
                                            data-nombre="<?php echo $lista['Nombre'] ?>"
                                            data-correo="<?php echo $lista['Correo'] ?>"
                                            data-telefono="<?php echo $lista['Telefono'] ?>"
                                            data-direccion="<?php echo $lista['Direccion'] ?>"
                                            data-comuna="<?php echo $lista['Comuna'] ?>"
                                            data-ciudad="<?php echo $lista['Ciudad'] ?>"
                                            data-giro="<?php echo $lista['Giro'] ?>">
                                        <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                                    </button>
                                    <!-- Botón para abrir el modal de confirmación de eliminación -->
                                    <button type="button" class="btn btn-danger btn-sm m-0" data-bs-toggle="modal" data-bs-target="#confirmarEliminarModal"
                                        data-id="<?php echo $lista['ID'] ?>">
                                        <i class="fas fa-trash"></i> <!-- Ícono de basurero -->
                                    </button>
                            </div>
                    </form>
                </td>
            </tr>
            <?php }?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#tablaProveedores').DataTable({
            "order": [[0, "asc"]]
        });

        var editarProveedorModal = document.getElementById('editarProveedorModal');
        editarProveedorModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var rut = button.getAttribute('data-rut');
            var nombre = button.getAttribute('data-nombre');
            var correo = button.getAttribute('data-correo');
            var telefono = button.getAttribute('data-telefono');
            var direccion = button.getAttribute('data-direccion');
            var comuna = button.getAttribute('data-comuna');
            var ciudad = button.getAttribute('data-ciudad');
            var giro = button.getAttribute('data-giro');

            var modalID = editarProveedorModal.querySelector('#txtID');
            var modalRut = editarProveedorModal.querySelector('#txtRutEditar');
            var modalNombre = editarProveedorModal.querySelector('#txtNombreEditar');
            var modalCorreo = editarProveedorModal.querySelector('#txtCorreoEditar');
            var modalTelefono = editarProveedorModal.querySelector('#txtTelefonoEditar');
            var modalDireccion = editarProveedorModal.querySelector('#txtDireccionEditar');
            var modalComuna = editarProveedorModal.querySelector('#txtComunaEditar');
            var modalCiudad = editarProveedorModal.querySelector('#txtCiudadEditar');
            var modalGiro = editarProveedorModal.querySelector('#txtGiroEditar');

            modalID.value = id;
            modalRut.value = rut;
            modalNombre.value = nombre;
            modalCorreo.value = correo;
            modalTelefono.value = telefono;
            modalDireccion.value = direccion;
            modalComuna.value = comuna;
            modalCiudad.value = ciudad;
            modalGiro.value = giro;
        });

        var confirmarEliminarModal = document.getElementById('confirmarEliminarModal');
        confirmarEliminarModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var inputID = document.getElementById('txtIDEliminarModal');
            inputID.value = id;
        });
    });
</script>

<?php
    include_once("../../src/footer.php");
?>
