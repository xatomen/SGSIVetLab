<?php
    require_once '../../config/database.php';
    require_once '../../src/header_admin.php';




?>
<!-- Agregar y modificar -->
<div class="row justify-content-around">
        
        <div class="col-xl"></div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Agregar insumo</h4>
                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtID" class="form-label">Nombre insumo</label>
                                    <input type="text" class="form-control" name="txtTitulo1" id="txtTitulo1" placeholder="Ingrese el nombre del insumo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtStockMinimo" class="form-label">Stock mínimo</label>
                                <input class="form-control" name="txtDescripcion1" id="txtDescripcion1" placeholder="Ingrese el stock mínimo"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Agregar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <div class="col">
                <div class="card p-3 shadow">
                    <h4 class="text-center">Editar insumo seleccionado</h4>
                    <hr>
                    <form method="POST">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtID" class="form-label">ID</label>
                                    <input type="text" class="form-control" name="txtID" id="txtID" value="<?php echo $txtID?>" placeholder="ID">
                                </div>
                            </div>
                            <div class="col"></div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label for="txtTitulo" class="form-label">Nombre insumo</label>
                                    <input type="text" class="form-control" name="txtTitulo" id="txtTitulo" value="<?php echo $txtTitulo?>" placeholder="Ingrese el título">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3">
                                <label for="txtDescripcion" class="form-label">Stock mínimo</label>
                                <input class="form-control" name="txtDescripcion" id="txtDescripcion" value="<?php echo $txtDescripcion?>" placeholder="Ingrese la descripción"></input>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-center">
                                <input class="btn btn-warning" type="submit" value="Editar" name="accion">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl"></div>
    </div>
<!-- Fin -->

<!-- Listado -->
    <div class="card row m-5 shadow overflow-scroll">
        <table class="table table-bordered">
            <thead>
                <h4 class="p-2">Listado de insumos</h4>
            </thead>
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>Nombre insumo</td>
                    <td>Cantidad</td>
                    <td>Stock mínimo</td>
                    <td>Editar elemento</td>
                </tr>
                <?php foreach($listaProductos as $lista){?>
                <tr>
                    <td><?php echo $lista['POSICION_PRODUCTO'] ?></td>
                    <td><?php echo $lista['ID_PRODUCTO'] ?></td>
                    <td><?php echo $lista['TITULO_PRODUCTO'] ?></td>
                    <td><?php echo $lista['DESCRIPCION_PRODUCTO'] ?></td>
                    <td>
                        <?php foreach($listaImagenes as $lista2) { if($lista2['ID_PRODUCTO']==$lista['ID_PRODUCTO']){?>
                            <div class="row border">
                                <div class="col">
                                    <img src="<?php echo $lista2['IMAGEN'] ?>" style="max-width:200px;">
                                </div>
                                <div class="col">
                                    <div class="dropdown">
                                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"></a>
                                        <ul class="dropdown-menu">
                                            <form method="POST">
                                                <div class="row m-1"><input type="hidden" name="txtID2" id="txtID2" value="<?php echo $lista2['ID_IMG_PRODUCTO'] ?>"></input></div>
                                                <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista2['ID_PRODUCTO'] ?>"></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Activar" class="btn btn-success" <?php if($lista2['MOSTRAR_IMAGEN']==1){echo "disabled";}?>></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Desactivar" class="btn btn-success" <?php if($lista2['MOSTRAR_IMAGEN']==0){echo "disabled";}?>></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Subir" class="btn btn-primary" <?php if($lista2['POSICION_IMG']==1){echo "disabled";}?>></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Bajar" class="btn btn-primary"></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Seleccionar" class="btn btn-info"></input></div>
                                                <div class="row m-1"><input type="submit" name="accion_imagen" value="Eliminar" class="btn btn-danger"></input></div>
                                            </form>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php } } ?>
                            <div class="dropdown text-center">
                                <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Agregar imágen</a>
                                <ul class="dropdown-menu">
                                    <div class="card p-3 shadow">
                                        <h4 class="text-center">Agregar imágen</h4>
                                        <hr>
                                        <form method="POST">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="mb-3">
                                                        <input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['ID_PRODUCTO'] ?>"></input>
                                                        <label for="txtLinkImagen" class="form-label">Link imágen</label>
                                                        <input type="text" class="form-control" name="txtLinkImagen" id="txtLinkImagen" placeholder="Ingrese el link">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="text-center">
                                                    <input class="btn btn-warning" type="submit" value="Agregar" name="accion_imagen">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if($lista['MOSTRAR_PRODUCTO']==0){ ?> <p class="bg-danger text-white text-center rounded-pill"> <?php echo "No"; ?></p> <?php }?>
                        <?php if($lista['MOSTRAR_PRODUCTO']==1){ ?> <p class="bg-success text-white text-center rounded-pill"> <?php echo "Si"; ?></p> <?php }?>
                    </td>
                    <td>
                        <form method="POST">
                            <div class="row border">
                                <!-- <div class="col-3"></div> -->
                                <div class="col">
                                    <div class="row m-1"><input type="hidden" name="txtID" id="txtID" value="<?php echo $lista['ID_PRODUCTO'] ?>"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Activar" class="btn btn-success" <?php if($lista['MOSTRAR_PRODUCTO']==1){echo "disabled";}?>></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Desactivar" class="btn btn-success" <?php if($lista['MOSTRAR_PRODUCTO']==0){echo "disabled";}?>></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Subir" class="btn btn-primary" <?php if($lista['POSICION_PRODUCTO']==1){echo "disabled";}?>></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Bajar" class="btn btn-primary"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Seleccionar" class="btn btn-info"></input></div>
                                    <div class="row m-1"><input type="submit" name="accion" value="Eliminar" class="btn btn-danger"></input></div>
                                </div>
                                <!-- <div class="col-3"></div> -->
                            </div>
                        </form>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>

<?php
    require_once '../../src/footer.php'
?>