<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtNombreAgregar = (isset($_POST['txtNombreAgregar']))?$_POST['txtNombreAgregar']:"";
    $txtStockMinimoAgregar = (isset($_POST['txtStockMinimoAgregar']))?$_POST['txtStockMinimoAgregar']:"";
    $txtNombreEditar = (isset($_POST['txtNombreEditar']))?$_POST['txtNombreEditar']:"";
    $txtStockMinimoEditar = (isset($_POST['txtStockMinimoEditar']))?$_POST['txtStockMinimoEditar']:"";

    $txtIDProveedor = (isset($_POST['txtIDProveedor']))?$_POST['txtIDProveedor']:"";

    $txtIDArea = (isset($_POST['txtIDArea']))?$_POST['txtIDArea']:"";

    $txtAreaAgregar = (isset($_POST['txtAreaAgregar']))?$_POST['txtAreaAgregar']:"";

    $txtIDProvee = (isset($_POST['txtIDProvee']))?$_POST['txtIDProvee']:"";
    $txtIDInsumoProveedor = (isset($_POST['txtIDInsumoProveedor']))?$_POST['txtIDInsumoProveedor']:"";
    $txtCodigoAgregar = (isset($_POST['txtCodigoAgregar']))?$_POST['txtCodigoAgregar']:"";
    $txtDescripcionAgregar = (isset($_POST['txtDescripcionAgregar']))?$_POST['txtDescripcionAgregar']:"";
    $txtPresentacionAgregar = (isset($_POST['txtPresentacionAgregar']))?$_POST['txtPresentacionAgregar']:"";
    $txtPrecioAgregar = (isset($_POST['txtPrecioAgregar']))?$_POST['txtPrecioAgregar']:"";

    $txtCodigo = (isset($_POST['txtCodigo']))?$_POST['txtCodigo']:"";
    $txtDescripcion = (isset($_POST['txtDescripcion']))?$_POST['txtDescripcion']:"";
    $txtPresentacion = (isset($_POST['txtPresentacion']))?$_POST['txtPresentacion']:"";
    $txtPrecio = (isset($_POST['txtPrecio']))?$_POST['txtPrecio']:"";

    $txtIDInsumo = (isset($_POST['txtIDInsumo']))?$_POST['txtIDInsumo']:"";

    $accion = (isset($_POST['accion']))?$_POST['accion']:"";
    $accion_insumo_proveedor = (isset($_POST['accion_insumo_proveedor']))?$_POST['accion_insumo_proveedor']:"";

    switch ($accion){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM insumo WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtNombreEditar = $ListaSel['Nombre'];
            $txtStockMinimoEditar = $ListaSel['Stock_minimo'];

            break;
    
        case "Editar":
            $mensaje = "Insumo editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE insumo SET Nombre=:Nombre, Stock_minimo=:Stock_minimo WHERE ID=:ID");
            $sentenciaSQL->bindParam(':Stock_minimo', $txtStockMinimoEditar);
            $sentenciaSQL->bindParam(':Nombre', $txtNombreEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            $txtID="";
            $txtNombreEditar="";
            $txtStockMinimoEditar="";
            header("Location: mantener_insumos.php");
            exit();
    
        case "Agregar":
            $mensaje = "Insumo agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM insumo");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO insumo (ID, NOMBRE, STOCK_MINIMO, ID_AREA) VALUES (:ID, :NOMBRE, :STOCK_MINIMO, :ID_AREA)");
            $sentenciaSQL->bindParam(":ID", $lastindex);
            $sentenciaSQL->bindParam(':NOMBRE', $txtNombreAgregar);
            $sentenciaSQL->bindParam(':STOCK_MINIMO', $txtStockMinimoAgregar);
            $sentenciaSQL->bindParam(':ID_AREA', $txtAreaAgregar);
            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();
    
        case "Eliminar":
            $mensaje = "Insumo eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM insumo WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();

        case "Agregar Insumo":
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Provee) AS lastIndex FROM provee");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            echo $lastindex;
            echo " - ";
            echo $txtCodigoAgregar;
            echo " - ";
            echo $txtPrecioAgregar;
            echo " - ";
            echo $txtDescripcionAgregar;
            echo " - ";
            echo $txtPresentacionAgregar;
            echo " - ";
            echo $txtIDArea;
            echo " - ";
            echo $txtIDProveedor;
            echo " - ";
            echo $txtID;

            $sentenciaSQL = $conn->prepare("INSERT INTO provee (ID_Provee, Codigo_Insumo, Precio, Descripcion, Presentacion, ID_Area, ID_Proveedor, ID_Insumo) VALUES (:ID_Provee, :Codigo_Insumo, :Precio, :Descripcion, :Presentacion, :ID_Area, :ID_Proveedor, :ID_Insumo)");
            $sentenciaSQL->bindParam(":ID_Provee", $lastindex);
            $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigoAgregar);
            $sentenciaSQL->bindParam(':Precio', $txtPrecioAgregar);
            $sentenciaSQL->bindParam(':Descripcion', $txtDescripcionAgregar);
            $sentenciaSQL->bindParam(':Presentacion', $txtPresentacionAgregar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDArea);
            $sentenciaSQL->bindParam(':ID_Proveedor', $txtIDProveedor);
            $sentenciaSQL->bindParam(':ID_Insumo', $txtID);

            $sentenciaSQL->execute();
            header("Location: mantener_insumos.php");
            exit();

    }

    switch($accion_insumo_proveedor){
        case "Eliminar":
          $mensaje = "Insumo proveedor eliminado satisfactoriamente";
          $sentenciaSQL = $conn->prepare("DELETE FROM provee WHERE ID_Provee=:ID_Provee");
          $sentenciaSQL->bindParam(':ID_Provee', $txtIDProvee);
          $sentenciaSQL->execute();
          header("Location: mantener_insumos.php");
          exit();

      case "Editar":
          // ver los parámetros que se están enviando
          // echo $txtIDProvee;
          // echo " - ";
          // // echo $txtIDProveedor;
          // // echo " - ";
          // echo $txtCodigo;
          // echo " - ";
          // echo $txtPrecio;
          // echo " - ";
          // echo $txtDescripcion;
          // echo " - ";
          // echo $txtPresentacion;
          // echo " - ";
          // echo $txtIDArea; 
          // echo " - ";
          // echo $txtIDInsumo;

          $mensaje = "Insumo proveedor editado satisfactoriamente";
          $sentenciaSQL = $conn->prepare("UPDATE provee SET Codigo_Insumo=:Codigo_Insumo, Precio=:Precio, Descripcion=:Descripcion, Presentacion=:Presentacion, ID_Area=:ID_Area WHERE ID_Provee=:ID_Provee");
          $sentenciaSQL->bindParam(':ID_Provee', $txtIDProvee);
          $sentenciaSQL->bindParam(':Codigo_Insumo', $txtCodigo);
          $sentenciaSQL->bindParam(':Precio', $txtPrecio);
          $sentenciaSQL->bindParam(':Descripcion', $txtDescripcion);
          $sentenciaSQL->bindParam(':Presentacion', $txtPresentacion);
          $sentenciaSQL->bindParam(':ID_Area', $txtIDArea);
          $sentenciaSQL->execute();
          // $txtID="";
          $txtCodigo="";
          $txtPrecio="";
          $txtDescripcion="";
          $txtPresentacion="";
          $txtIDArea="";
          // $txtIDProveedor="";
          header("Location: mantener_insumos.php");
          exit();
    }


    $sentenciaSQL= $conn->prepare("SELECT * FROM insumo");
    $sentenciaSQL->execute();
    $listaInsumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
    
    $sentenciaSQL= $conn->prepare("SELECT * FROM proveedor");
    $sentenciaSQL->execute();
    $listaProveedores=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM provee");
    $sentenciaSQL->execute();
    $listaProvee=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL= $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- Modal Agregar Insumo -->
<div class="modal fade" id="agregarInsumoModal" tabindex="-1" aria-labelledby="agregarInsumoModalLabel" aria-hidden= "true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarInsumoModalLabel">Agregar insumo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="mb-3">
            <label for="txtNombreAgregar" class="form-label">Nombre insumo</label>
            <input type="text" class="form-control" name="txtNombreAgregar" id="txtNombreAgregar" placeholder="Ingrese el nombre del insumo">
          </div>
          <div class="mb-3">
            <label for="txtStockMinimoAgregar" class="form-label">Stock mínimo</label>
            <input class="form-control" name="txtStockMinimoAgregar" id="txtStockMinimoAgregar" placeholder="Ingrese el stock mínimo">
          </div>
          <div class="mb-3">
            <label for="txtAreaAgregar" class="form-label">Área</label>
            <select class="form-control" name="txtAreaAgregar" id="txtAreaAgregar">
              <option value="">Seleccione un área</option>
              <?php foreach ($listaAreas as $area): ?>
                <option value="<?php echo $area['ID']; ?>"><?php echo $area['Area']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="text-center">
            <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Editar Insumo -->
<div class="modal fade" id="editarInsumoModal" tabindex="-1" aria-labelledby="editarInsumoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarInsumoModalLabel">Editar insumo seleccionado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <input type="hidden" class="form-control" name="txtID" id="txtID" placeholder="ID">
          <div class="mb-3">
            <label for="txtNombreEditar" class="form-label">Nombre insumo</label>
            <input type="text" class="form-control" name="txtNombreEditar" id="txtNombreEditar" placeholder="Ingrese el nombre del insumo">
          </div>
          <div class="mb-3">
            <label for="txtStockMinimoEditar" class="form-label">Stock mínimo</label>
            <input class="form-control" name="txtStockMinimoEditar" id="txtStockMinimoEditar" placeholder="Ingrese la descripción">
          </div>
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
    var editarInsumoModal = document.getElementById('editarInsumoModal');
    editarInsumoModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');
      var nombre = button.getAttribute('data-nombre');
      var stockMinimo = button.getAttribute('data-stock-minimo');

      var modalID = editarInsumoModal.querySelector('#txtID');
      var modalNombre = editarInsumoModal.querySelector('#txtNombreEditar');
      var modalStockMinimo = editarInsumoModal.querySelector('#txtStockMinimoEditar');

      modalID.value = id;
      modalNombre.value = nombre;
      modalStockMinimo.value = stockMinimo;
    });
  });
</script>

<!-- Incluye los archivos de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Incluye los archivos de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Modal Agregar Proveedor -->
<div class="modal fade" id="agregarProveedorModal" tabindex="-1" aria-labelledby="agregarProveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarProveedorModalLabel">Agregar proveedor para el insumo seleccionado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- <input type="hidden" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID"> -->
          <input type="hidden" class="form-control" name="txtID" id="txtID" placeholder="ID">
          <!-- Inserción de datos -->
          <div class="row">
            <!-- Columna izquierda -->
            <div class="col">
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="txtIDProveedor" class="form-label">Seleccionar proveedor</label>
                    <select id="txtIDProveedor" name="txtIDProveedor" class="form-control">
                      <option value="">Seleccione un proveedor</option>
                      <?php foreach ($listaProveedores as $proveedor): ?>
                        <option value="<?php echo $proveedor['ID']; ?>" <?php echo ($proveedor['ID'] == $txtIDProveedor) ? 'selected' : ''; ?>>
                          <?php echo $proveedor['Nombre']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="txtIDArea" class="form-label">Seleccionar área</label>
                    <select id="txtIDArea" name="txtIDArea" class="form-control">
                      <option value="">Seleccione un área</option>
                      <?php foreach ($listaAreas as $area): ?>
                        <option value="<?php echo $area['ID']; ?>" <?php echo ($area['ID'] == $txtIDArea) ? 'selected' : ''; ?>>
                          <?php echo $area['Area']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
              </div>
              <!-- Código -->
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="txtCodigoAgregar" class="form-label">Codigo</label>
                    <input type="text" class="form-control" name="txtCodigoAgregar" id="txtCodigoAgregar" value="<?php echo $txtCodigoAgregar?>" placeholder="Ingrese el código">
                  </div>
                </div>
              </div>
            </div>
            <!-- Columna derecha -->
            <div class="col">
              <!-- Descripción -->
              <div class="row">
                <div class="col">
                  <div class="mb-3">
                    <label for="txtDescripcionAgregar" class="form-label">Descripción</label>
                    <input type="text" class="form-control" name="txtDescripcionAgregar" id="txtDescripcionAgregar" value="<?php echo $txtDescripcionAgregar?>" placeholder="Ingrese la descripción">
                  </div>
                </div>
              </div>
              <!-- Presentación -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtPresentacionAgregar" class="form-label">Presentación</label>
                  <input class="form-control" name="txtPresentacionAgregar" id="txtPresentacionAgregar" value="<?php echo $txtPresentacionAgregar?>" placeholder="Ingrese la presentación"></input>
                </div>
              </div>
              <!-- Precio -->
              <div class="row">
                <div class="mb-3">
                  <label for="txtPrecioAgregar" class="form-label">Precio</label>
                  <input class="form-control" name="txtPrecioAgregar" id="txtPrecioAgregar" value="<?php echo $txtPrecioAgregar?>" placeholder="Ingrese el precio"></input>
                </div>
              </div>
            </div>
          </div>
          <!-- Agregar -->
          <div class="row">
            <div class="col text-center">
              <input class="btn btn-warning" type="submit" value="Agregar Insumo" name="accion">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var agregarProveedorModal = document.getElementById('agregarProveedorModal');
    agregarProveedorModal.addEventListener('show.bs.modal', function(event) {
      var button = event.relatedTarget;
      var id = button.getAttribute('data-id');

      var modalID = agregarProveedorModal.querySelector('#txtID');

      modalID.value = id;
    });
  });
</script>

<!-- Incluye los archivos de Bootstrap -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

<!-- Incluye los archivos de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<!-- Listado -->
<div class="card row m-5 shadow p-3">
    <h4 class="p-2">Gestionar insumos</h4>
    <hr>
    <div class="p-2">
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn btn-primary w-auto" data-bs-toggle="modal" data-bs-target="#agregarInsumoModal">
            Agregar insumo
        </button>
    </div>
    
    <table id="tablaInsumos" class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre insumo</th>
                <th>Área</th>
                <th>Cantidad</th>
                <th>Stock mínimo</th>
                <th>Semáforo</th>
                <th></th>
                <th>Editar elemento</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaInsumos as $insumo){?>
            <tr>
                <td><?php echo $insumo['ID'] ?></td>
                <td><?php echo $insumo['Nombre'] ?></td>
                <td>
                  <?php 
                  foreach($listaAreas as $area) {
                    if($area['ID'] == $insumo['ID_Area']) {
                    echo $area['Area'];
                    break;
                    }
                  }
                  ?>
                </td>
                <td><?php echo $insumo['Cantidad'] ?></td>
                <td><?php echo $insumo['Stock_minimo'] ?></td>
                <td>
                  <span class="semaforo <?php echo ($insumo['Cantidad'] < $insumo['Stock_minimo']) ? 'rojo' : 'verde'; ?>"></span>
                </td>
                <td>
                    <table class="table table-responsive">
                        <thead>
                            <tr>
                                <!-- <th>Área</th> -->
                                <th>Proveedor</th>
                                <th>Código Insumo</th>
                                <th>Descripción</th>
                                <th>Presentación</th>
                                <th>Precio</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listaProveedores as $proveedor){ ?>
                            <?php foreach($listaProvee as $provee){ ?>
                            <?php if($insumo['ID']==$provee['ID_Insumo'] && $proveedor['ID']==$provee['ID_Proveedor']){ ?>
                            <tr>
                                <!-- <td>
                                  <?php 
                                    foreach($listaAreas as $area) {
                                      if($area['ID'] == $provee['ID_Area']) {
                                        echo $area['Area'];
                                        break;
                                      }
                                    }
                                  ?>
                                </td> -->
                                <td><?php echo $proveedor['Nombre'] ?></td>
                                <td><?php echo $provee['Codigo_Insumo'] ?></td>
                                <td><?php echo $provee['Descripcion'] ?></td>
                                <td><?php echo $provee['Presentacion'] ?></td>
                                <td><?php echo "$".number_format($provee['Precio'], 0, '', '.')  ?></td>
                                <td>
                                    <form method="POST" class="m-0">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarInsumoProveedorModal<?php echo $provee['ID_Provee']?>">
                                                <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                                            </button>
                                            <button type="submit" name="accion_insumo_proveedor" value="Eliminar" class="btn btn-danger btn-sm">
                                              <i class="fas fa-trash"></i> <!-- Ícono de basurero -->
                                            </button>
                                        </div>
                                        <input type="hidden" name="txtIDProvee" value="<?php echo $provee['ID_Provee']; ?>">
                                    </form>
                                    <!-- Modal para editar insumo proveedor -->
                                    <div class="modal fade" id="editarInsumoProveedorModal<?php echo $provee['ID_Provee']?>" tabindex="-1" aria-labelledby="editarInsumoProveedorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarInsumoProveedorModalLabel">Editar Insumo Proveedor</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form id="formEditarInsumoProveedor" method="POST">
                                                        <div class="mb-3">
                                                            <label for="txtIDProvee" class="form-label">ID Provee</label>
                                                            <input type="text" class="form-control" value="<?php echo $provee['ID_Provee']?>" id="txtIDProvee" name="txtIDProvee" readonly>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="txtCodigo" class="form-label">Código Insumo</label>
                                                            <input type="text" class="form-control" value="<?php echo $provee['Codigo_Insumo']?>" id="txtCodigo" name="txtCodigo">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="txtDescripcion" class="form-label">Descripción</label>
                                                            <input type="text" class="form-control" value="<?php echo $provee['Descripcion']?>" id="txtDescripcion" name="txtDescripcion">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="txtPresentacion" class="form-label">Presentación</label>
                                                            <input type="text" class="form-control" value="<?php echo $provee['Presentacion']?>" id="txtPresentacion" name="txtPresentacion">
                                                        </div>
                                                        <div class="mb-3">
                                                          <label for="txtIDArea" class="form-label">Área</label>
                                                          <select class="form-control" id="txtIDArea" name="txtIDArea">
                                                            <?php foreach ($listaAreas as $area): ?>
                                                              <option value="<?php echo $area['ID']; ?>" <?php echo ($area['ID'] == $provee['ID_Area']) ? 'selected' : ''; ?>>
                                                                <?php echo $area['Area']; ?>
                                                              </option>
                                                            <?php endforeach; ?>
                                                          </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="txtPrecio" class="form-label">Precio</label>
                                                            <input type="text" class="form-control" value="<?php echo $provee['Precio']?>" id="txtPrecio" name="txtPrecio">
                                                        </div>
                                                        <div class="text-center">
                                                          <button type="submit" class="btn btn-primary" name="accion_insumo_proveedor" value="Editar">Guardar cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                            <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </td>
                <td>
                    <form method="POST">
                        <div class="row m-0">
                                <input type="hidden" name="txtID" id="txtID"></input>
                                <input type="hidden" name="txtNombreEditar" id="txtNombreEditar" value="<?php echo $insumo['Nombre'] ?>"></input>
                                <input type="hidden" name="txtStockMinimoEditar" id="txtStockMinimoEditar" value="<?php echo $insumo['Stock_minimo'] ?>"></input>
                                <div class="row m-0">
                                  <div class="btn-group" role="group">
                                      <!-- Botón para abrir el modal de agregar proveedor -->
                                      <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#agregarProveedorModal"
                                              data-id="<?php echo $insumo['ID'] ?>">
                                        <i class="fas fa-plus"></i> <!-- Ícono de agregar -->
                                      </button>
                                      <!-- Botón para abrir el modal de modificar insumo -->
                                      <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarInsumoModal"
                                              data-id="<?php echo $insumo['ID'] ?>"
                                              data-nombre="<?php echo $insumo['Nombre'] ?>"
                                              data-stock-minimo="<?php echo $insumo['Stock_minimo'] ?>">
                                        <i class="fas fa-edit"></i> <!-- Ícono de editar -->
                                      </button>
                                      <button type="submit" name="accion" value="Eliminar" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> <!-- Ícono de basurero -->
                                      </button>
                                  </div>
                                </div>
                          </div>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Inicializa DataTables
        var table = $('#tablaInsumos').DataTable({
            "order": [[0, "asc"]]
        });

        // Filtrado personalizado usando la búsqueda integrada de DataTables
        document.getElementById('buscarInsumo').addEventListener('input', function() {
            table.search(this.value).draw();
        });
    });
</script>

<?php
    include_once("../../src/footer.php");
?>