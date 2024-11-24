<?php
    include_once("../../config/database.php");
    include_once("../../src/header_admin.php");

    $txtID = (isset($_POST['txtID']))?$_POST['txtID']:"";
    $txtTipoMuestraAgregar = (isset($_POST['txtTipoMuestraAgregar']))?$_POST['txtTipoMuestraAgregar']:"";
    $txtIDAreaAgregar = (isset($_POST['txtIDAreaAgregar']))?$_POST['txtIDAreaAgregar']:"";
    $txtTipoMuestraEditar = (isset($_POST['txtTipoMuestraEditar']))?$_POST['txtTipoMuestraEditar']:"";
    $txtIDAreaEditar = (isset($_POST['txtIDAreaEditar']))?$_POST['txtIDAreaEditar']:"";
    
    $txtIDInsumo = (isset($_POST['txtIDInsumo']))?$_POST['txtIDInsumo']:"";
    $txtIDMuestra = (isset($_POST['txtIDMuestra']))?$_POST['txtIDMuestra']:"";
    $txtIDComponentePerfilMuestra = (isset($_POST['txtIDComponentePerfilMuestra']))?$_POST['txtIDComponentePerfilMuestra']:"";
    $txtCantidadInsumo = (isset($_POST['txtCantidadInsumo']))?$_POST['txtCantidadInsumo']:"";

    $accion_perfil = (isset($_POST['accion_perfil']))?$_POST['accion_perfil']:"";

    $accion_componente = (isset($_POST["accion_componente"]))?$_POST["accion_componente"]:"";

    switch ($accion_componente){

        case "Añadir":
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID_Componentes_perfil_muestra) AS lastIndex FROM componentes_perfil_muestra;");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;

            $sentenciaSQL = $conn->prepare("INSERT INTO componentes_perfil_muestra (ID_Componentes_perfil_muestra, Cantidad, ID_Muestra, ID_Insumo) VALUES (:ID_Componentes_perfil_muestra, :Cantidad, :ID_Muestra, :ID_Insumo);");
            $sentenciaSQL->bindParam(":ID_Componentes_perfil_muestra", $lastindex);
            $sentenciaSQL->bindParam(":Cantidad",$txtCantidadInsumo);
            $sentenciaSQL->bindParam(":ID_Muestra",$txtID);
            $sentenciaSQL->bindParam(":ID_Insumo",$txtIDInsumo);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();

        case "Eliminar":
            $sentenciaSQL = $conn->prepare("DELETE FROM componentes_perfil_muestra WHERE ID_Componentes_perfil_muestra = :ID_ComponentePerfilMuestra;");
            $sentenciaSQL->bindParam(":ID_ComponentePerfilMuestra", $txtIDComponentePerfilMuestra);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();

        case "Editar":
            $sentenciaSQL = $conn->prepare("UPDATE componentes_perfil_muestra SET Cantidad=:Cantidad WHERE ID_Componentes_perfil_muestra=:ID_ComponentePerfilMuestra");
            $sentenciaSQL->bindParam(":Cantidad",$txtCantidadInsumo);
            $sentenciaSQL->bindParam(':ID_ComponentePerfilMuestra', $txtIDComponentePerfilMuestra);
            $sentenciaSQL->execute();
            $txtCantidadInsumo="";
            header("Location: mantener_perfiles_muestra.php");
            exit();

    }


    switch ($accion_perfil){
        
        case "Seleccionar":
            $sentenciaSQL=$conn->prepare("SELECT * FROM perfil_muestra WHERE ID=:ID");
            $sentenciaSQL->bindParam(':ID',$txtID);
            $sentenciaSQL->execute();
            $ListaSel=$sentenciaSQL->fetch(PDO::FETCH_LAZY);
    
            $txtID = $ListaSel['ID'];
            $txtTipoMuestraEditar = $ListaSel['Tipo_de_muestra'];
            $txtIDAreaEditar = $ListaSel['ID_Area'];

            break;
    
        case "Editar":
            // $mensaje = "Proveedor editado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("UPDATE perfil_muestra SET Tipo_de_muestra=:Tipo_de_muestra, ID_Area=:ID_Area WHERE ID=:ID");
            // echo $txtID;
            // echo $txtIDAreaEditar;
            // echo $txtTipoMuestraEditar;
            $sentenciaSQL->bindParam(':Tipo_de_muestra', $txtTipoMuestraEditar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDAreaEditar);
            $sentenciaSQL->bindParam(':ID', $txtID);
            $sentenciaSQL->execute();
            // $txtID="";
            // $txtIDAreaEditar="";
            // $txtTipoMuestraEditar="";
            header("Location: mantener_perfiles_muestra.php");
            exit();
            // break;
    
        case "Agregar":
            // $mensaje = "Proveedor agregado satisfactoriamente";
            //Obtenemos el último índice y la última posición
            $sentenciaSQL = $conn->prepare("SELECT MAX(ID) AS lastIndex FROM perfil_muestra");
            $sentenciaSQL->execute();
            $resultado = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
            $lastindex = $resultado['lastIndex']+1;
    
            $sentenciaSQL = $conn->prepare("INSERT INTO perfil_muestra (ID, Tipo_de_muestra, ID_Area) VALUES (:ID, :Tipo_de_muestra, :ID_Area)");
            $sentenciaSQL->bindParam(':Tipo_de_muestra', $txtTipoMuestraAgregar);
            $sentenciaSQL->bindParam(':ID_Area', $txtIDAreaAgregar);
            $sentenciaSQL->bindParam(':ID', $lastindex);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();
    
        case "Eliminar":
            // $mensaje = "Proveedor eliminado satisfactoriamente";
            $sentenciaSQL = $conn->prepare("DELETE FROM perfil_muestra WHERE ID=:ID");
            $sentenciaSQL->bindParam(":ID",$txtID);
            $sentenciaSQL->execute();
            header("Location: mantener_perfiles_muestra.php");
            exit();
    
    }

    // $sentenciaSQL= $conn->prepare("SELECT perfil_muestra.ID AS ID, perfil_muestra.Tipo_de_muestra AS Tipo_de_muestra, perfil_muestra.ID_Area AS ID_Area_PM, area.ID AS ID_Area_A, area.Area AS Area FROM perfil_muestra, area WHERE ID_Area_PM = ID_Area_A;");
    // $sentenciaSQL= $conn->prepare("SELECT * FROM perfil_muestra, area WHERE perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL = $conn->prepare("SELECT perfil_muestra.ID AS PerfilID, perfil_muestra.Tipo_de_muestra, perfil_muestra.ID_Area, area.Area FROM perfil_muestra INNER JOIN area ON perfil_muestra.ID_Area = area.ID;");
    $sentenciaSQL->execute();
    $listaPerfilMuestra=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT ID as ID_Insumo, Nombre FROM insumo;");
    $sentenciaSQL->execute();
    $insumos=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM componentes_perfil_muestra;");
    $sentenciaSQL->execute();
    $componentes=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

    $sentenciaSQL = $conn->prepare("SELECT * FROM area");
    $sentenciaSQL->execute();
    $listaAreas = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<!-- Modal -->
<div class="modal fade" id="agregarPerfilModal" tabindex="-1" aria-labelledby="agregarPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarPerfilModalLabel">Agregar perfil de muestra</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- Tipo de muestra -->
          <div class="row">
            <div class="mb-3">
              <label for="txtTipoMuestraAgregar" class="form-label">Tipo de muestra</label>
              <input class="form-control" name="txtTipoMuestraAgregar" id="txtTipoMuestraAgregar" placeholder="Ingrese el tipo de muestra"></input>
            </div>
          </div>
          <!-- ID Área -->
          <div class="row">
            <div class="mb-3">
              <label for="txtIDAreaAgregar" class="form-label">Área</label>
              <select id="insumosList" name="txtIDAreaAgregar" class="form-control">
                <?php foreach ($listaAreas as $area): ?>
                  <option value="<?php echo $area['ID']; ?>"><?php echo $area['Area']; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <!-- Botón agregar -->
          <div class="row">
            <div class="text-center">
              <input class="btn btn-warning" type="submit" value="Agregar" name="accion_perfil">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal de edición -->
<div class="modal fade" id="editarPerfilModal" tabindex="-1" aria-labelledby="editarPerfilModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarPerfilModalLabel">Editar perfil de muestra seleccionado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <!-- ID -->
          <div class="row">
            <div class="col">
              <div class="mb-3">
                <input type="hidden" class="form-control" name="txtID" id="txtID" placeholder="ID">
              </div>
            </div>
            <div class="col"></div>
          </div>
          <!-- Tipo de muestra -->
          <div class="row">
            <div class="mb-3">
              <label for="txtTipoMuestraEditar" class="form-label">Tipo de muestra</label>
              <input type="text" class="form-control" name="txtTipoMuestraEditar" id="txtTipoMuestraEditar" value="<?php echo $txtTipoMuestraEditar?>" placeholder="Ingrese el tipo de muestra">
            </div>
          </div>
          <!-- ID Área -->
          <div class="row">
            <div class="mb-3">
            <label for="txtIDAreaEditar" class="form-label">Seleccionar área</label>
                    <select id="txtIDAreaEditar" name="txtIDAreaEditar" class="form-control">
                      <option value="">Seleccione un área</option>
                      <?php foreach ($listaAreas as $area): ?>
                        <option value="<?php echo $area['ID']; ?>" <?php echo ($area['ID'] == $txtIDAreaEditar) ? 'selected' : ''; ?>>
                          <?php echo $area['Area']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
            </div>
          </div>
          <!-- Editar y Deseleccionar -->
          <div class="row">
            <div class="col text-center">
              <input class="btn btn-warning" type="submit" value="Editar" name="accion_perfil">
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var editarPerfilModal = document.getElementById('editarPerfilModal');
  editarPerfilModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');
    var tipo = button.getAttribute('data-tipo');
    var area = button.getAttribute('data-area');

    var modal = this;
    modal.querySelector('.modal-body #txtID').value = id;
    modal.querySelector('.modal-body #txtTipoMuestraEditar').value = tipo;
    modal.querySelector('.modal-body #txtIDAreaEditar').value = area;
  });
</script>

<!-- Modal de añadir componente -->
<div class="modal fade" id="añadirComponenteModal" tabindex="-1" aria-labelledby="añadirComponenteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="añadirComponenteModalLabel">Añadir componente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="row m-1">
            <input type="hidden" name="txtID" id="txtID" value="">
          </div>
          <!-- Script de búsqueda -->
          <script>
            // Filtrar insumos al escribir en el campo de búsqueda
            document.getElementById('buscarInsumo').addEventListener('input', function() {
              const searchTerm = this.value.toLowerCase();
              const options = document.querySelectorAll('#insumosList option');
              options.forEach(option => {
                const text = option.textContent.toLowerCase();
                option.style.display = text.includes(searchTerm) ? '' : 'none';
              });
            });
          </script>
          <div class="row m-1">
            <label for="txtIDInsumo" class="form-label">Insumo</label>
            <!-- Campo de búsqueda -->
            <input type="text" id="buscarInsumo" class="form-control mb-2" placeholder="Filtrar listado">
            <!-- Listado de insumos filtrado por búsqueda -->
            <select id="insumosList" name="txtIDInsumo" class="form-control">
              <?php foreach ($insumos as $insumo): ?>
                <option value="<?php echo $insumo['ID_Insumo']; ?>"><?php echo $insumo['Nombre']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="row m-1">
            <label for="txtCantidadInsumo" class="form-label">Cantidad</label>
            <input type="text" name="txtCantidadInsumo" class="form-control mb-2" id="txtCantidadInsumo" value="">
          </div>
          <div class="row m-1">
            <input type="submit" name="accion_componente" value="Añadir" class="btn btn-success">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var añadirComponenteModal = document.getElementById('añadirComponenteModal');
  añadirComponenteModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');

    var modal = this;
    modal.querySelector('.modal-body #txtID').value = id;
  });
</script>

<!-- Modal de editar cantidad -->
<div class="modal fade" id="editarCantidadModal" tabindex="-1" aria-labelledby="editarCantidadModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarCantidadModalLabel">Editar cantidad</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST">
          <div class="row m-1">
            <input type="hidden" name="txtIDComponentePerfilMuestra" id="txtIDComponentePerfilMuestra" value="">
          </div>
          <div class="row m-1">
            <label for="txtCantidadInsumo" class="form-label">Cantidad</label>
            <input type="text" name="txtCantidadInsumo" class="form-control mb-2" id="txtCantidadInsumo" value="">
          </div>
          <div class="row m-1">
            <input type="submit" name="accion_componente" value="Editar" class="btn btn-warning">
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var editarCantidadModal = document.getElementById('editarCantidadModal');
  editarCantidadModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var id = button.getAttribute('data-id');

    var modal = this;
    modal.querySelector('.modal-body #txtIDComponentePerfilMuestra').value = id;
  });
</script>

<!-- Listado -->
    <div class="card row m-5 shadow">
        <table id="tablaPerfilesMuestra" class="table table-bordered">
            <h4 class="p-2">Listado de perfiles de muestra</h4>
            <hr>
            <div class="p-2">
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#agregarPerfilModal">
                Agregar perfil de muestra
                </button>
            </div>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tipo de muestra</t>
                    <th>Área</th>
                    <th>Componentes</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <hr>
            <tbody>
                <?php foreach($listaPerfilMuestra as $lista){?>
                <tr>
                    <td><?php echo $lista["PerfilID"] ?></td>
                    <td><?php echo $lista['Tipo_de_muestra'] ?></td>
                    <td><?php echo $lista['Area'] ?></td>
                    <td>
                    <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Nombre</th>
                                  <th>Cantidad</t>
                                  <th>Acción</th>
                              </tr>
                          </thead>
                        <?php foreach($componentes as $componente){
                            foreach($insumos as $insumo){
                                if($componente['ID_Muestra'] == $lista['PerfilID'] && $componente['ID_Insumo'] == $insumo['ID_Insumo']){ ?>
                        
                            <tbody>
                                <tr>
                                    <td><?php echo $insumo['ID_Insumo']?></td>
                                    <td><?php echo $insumo['Nombre']?></td>
                                    <td><?php echo $componente['Cantidad']?></td>
                                    <td>
                                        <form method="POST">
                                            <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['PerfilID'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDMuestra" id="txtIDMuestra" value="<?php echo $componente['ID_Muestra'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDInsumo" id="txtIDInsumo" value="<?php echo $componente['ID_Insumo'] ?>"></input></div>
                                            <div class="row m-1"><input type="hidden" name="txtIDComponentePerfilMuestra" id="txtIDComponentePerfilMuestra" value="<?php echo $componente['ID_Componentes_perfil_muestra'] ?>"></input></div>
                                            <div class="row m-1">
                                                <!-- Botón para abrir el modal de editar cantidad -->
                                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarCantidadModal" data-id="<?php echo $componente['ID_Componentes_perfil_muestra']; ?>">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                            <div class="row m-1">
                                                <button type="submit" name="accion_componente" value="Eliminar" class="btn btn-danger">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                            
                                        </form>
                                    </td>
                                </tr>
                            
                        <?php }
                            }
                        } ?>
                        </tbody>
                        </table>
                    </td>
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <div class="col">
                                    <div class="row m-1">
                                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['PerfilID'] ?>"></input>
                                    </div>
                                    <div class="row m-1">
                                        <input type="hidden" name="txtTipoMuestraEditar" id="txtTipoMuestraEditar" value="<?php echo $lista['Tipo_de_muestra'] ?>"></input>
                                    </div>
                                    <div class="row m-1">
                                        <input type="hidden" name="txtIDAreaEditar" id="txtIDAreaEditar" value="<?php echo $lista['ID_Area'] ?>"></input>
                                    </div>
                                    <!-- Botón para abrir el modal de añadir componente -->
                                    <div class="row m-1">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#añadirComponenteModal" data-id="<?php echo $lista['PerfilID']; ?>">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                    <!-- Botón para abrir el modal de edición -->
                                    <div class="row m-1">
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editarPerfilModal" data-id="<?php echo $lista['PerfilID']; ?>" data-tipo="<?php echo $lista['Tipo_de_muestra']; ?>" data-area="<?php echo $lista['ID_Area']; ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </div>
                                    <!-- Eliminar -->
                                    <div class="row m-1">
                                        <button type="submit" name="accion_perfil" value="Eliminar" class="btn btn-danger">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </div>
                                </div>
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
        $('#tablaPerfilesMuestra').DataTable({
            "order": [[0, "asc"]]
        });
    });
</script>

<?php
    include_once("../../src/footer.php");
?>