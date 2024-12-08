<?php
ob_start(); // Inicia el buffer de salida para evitar envíos no deseados
require('../../config/database.php');
require('../../src/tfpdf/tfpdf.php');



// Obtener el número de orden y otros datos del proveedor
$txtNumOrden = isset($_POST['txtNumOrden']) ? $_POST['txtNumOrden'] : "";

// Obtener la orden de compra
$sentenciaSQL = $conn->prepare("SELECT * FROM orden_de_compra WHERE Num_Orden_de_Compra = :Num_Orden_de_Compra");
$sentenciaSQL->bindParam(':Num_Orden_de_Compra', $txtNumOrden);
$sentenciaSQL->execute();
$ordenCompra = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);
$txtIDProveedor = $ordenCompra['ID_Proveedor'];

// Registros de la orden de compra
$sentenciaSQL = $conn->prepare("SELECT * FROM registro_orden_de_compra WHERE ID_Orden_Compra = :ID_Orden_Compra");
$sentenciaSQL->bindParam(':ID_Orden_Compra', $txtNumOrden);
$sentenciaSQL->execute();
$listaRegistrosOrdenCompra = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Obtener el proveedor
$sentenciaSQL = $conn->prepare("SELECT * FROM proveedor WHERE ID = :ID");
$sentenciaSQL->bindParam(':ID', $txtIDProveedor);
$sentenciaSQL->execute();
$proveedor = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

// Obtener fecha en día, mes y año, y guardarla en tres variables, además el mes queda en español
$fecha = date_create($ordenCompra['Fecha']);
$dia = date_format($fecha, 'd');
$mes = date_format($fecha, 'm');
$anio = date_format($fecha, 'Y');
$meses = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
$mes = $meses[$mes - 1];

// Crear instancia de FPDF
$pdf = new tFPDF();

$pdf->AddPage();
$pdf->AddFont('DejaVu','','DejaVuSansCondensed.ttf',true);
$pdf->SetFont('DejaVu', '', 10);

// 1. Información fija de la empresa (parte superior)
$pdf->Image('../../src/LogoOrden.png', 10, 10, 30); // Ajusta la ruta y las dimensiones según sea necesario
$pdf->SetXY(10,40);
$pdf->Cell(0, 5, 'Razón social: Servicios Vetlab Limitada', 0, 1);
$pdf->Cell(0, 5, 'Giro: Laboratorio Clínico', 0, 1);
$pdf->Cell(0, 5, 'Fono: 9256527 - Fax: 9256526', 0, 1);
$pdf->Cell(0, 5, 'Dirección: Jose Joaquin Prieto 4274 - San Miguel.', 0, 1);
$pdf->Ln(5);

// 2. Rectángulo superior derecho: Número de orden de compra
$pdf->SetXY(150, 20); // Posición superior derecha
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(40, 10, 'R.U.T: 76.092.658-2', 0, 1, 'C');
$pdf->SetXY(150, 25); // Posición superior derecha
$pdf->SetFont('DejaVu', '', 12);
$pdf->Cell(40, 10, 'ORDEN DE COMPRA', 0, 1, 'C');
$pdf->SetXY(150, 30);
$pdf->Cell(40, 10, 'N° ' . $txtNumOrden, 0, 1, 'C');
$pdf->Ln(10);

// 3. Cuadro de información del proveedor (centro de la página)
$pdf->SetFont('DejaVu', '', 10);

$pdf->SetXY(10,70);
$pdf->Cell(100, 5, 'Santiago, ' . $dia . " de " . $mes . " de " . $anio, 0);
$pdf->Ln();

$pdf->Cell(100, 5, 'Sr (es): ' . $proveedor['Nombre'], 0);
$pdf->Cell(50, 5, 'RUT: ' . $proveedor['RUT'], 0);
$pdf->Ln();

$pdf->Cell(100, 5, 'Dirección: ' . $proveedor['Direccion'], 0);
$pdf->Cell(50, 5, 'Comuna: ' . $proveedor['Comuna'], 0);
$pdf->Ln();

$pdf->Cell(50, 5, 'Ciudad: ' . $proveedor['Ciudad'], 0);
$pdf->Cell(50, 5, 'Fonos: ' . $proveedor['Fono'], 0);
$pdf->Cell(60, 5, 'Giro: ' . $proveedor['Giro'], 0);
$pdf->Ln();

$pdf->Cell(100, 5, 'G. Despacho: ', 0);
$pdf->Cell(50, 5, 'Cotización: ', 0);
$pdf->Ln();

$pdf->Cell(100, 5, 'Cond. De Venta: ', 0);
$pdf->Cell(50, 5, 'Vencimiento: ', 0);
$pdf->Ln(15);

// 4. Tabla de productos en la parte inferior
$pdf->SetFont('DejaVu', '', 8);
$pdf->Cell(20, 10, 'CODIGO', 1);
$pdf->Cell(20, 10, 'CANTIDAD', 1);
$pdf->Cell(80, 10, 'DESCRIPCION DEL PRODUCTO', 1);
$pdf->Cell(30, 10, 'P. UNITARIO', 1);
$pdf->Cell(30, 10, 'VALOR TOTAL', 1);
$pdf->Ln();

$totalOrdenCompra = 0;
$pdf->SetFont('DejaVu', '', 8);
foreach ($listaRegistrosOrdenCompra as $registro) {
    $cantidad = $registro['Cantidad'];
    // Debemos encontrar el insumo
    $sentenciaSQL = $conn->prepare("SELECT * FROM provee WHERE ID_Provee = :ID_Provee");
    $sentenciaSQL->bindParam(':ID_Provee', $registro['ID_Provee']);
    $sentenciaSQL->execute();
    $insumo = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

    $descripcion = $insumo['Descripcion'];
    $presentacion = $insumo['Presentacion'];

    $precio = $registro['Precio_unitario'];
    $total = $cantidad * $precio;

    $pdf->Cell(20, 10, $insumo['Codigo_Insumo'], 1);
    $pdf->Cell(20, 10, $cantidad, 1);
    $pdf->Cell(80, 10, $descripcion." - ".$presentacion, 1);
    $pdf->Cell(30, 10, number_format($precio, 0), 1);
    $pdf->Cell(30, 10, number_format($total, 0), 1);
    $pdf->Ln();

    $totalOrdenCompra += $total;
}

// Totales e IVA en la parte inferior
// $pdf->Ln();
$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'Total Afecto:', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra, 0), 1);
$pdf->Ln();

$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'I.V.A. (19%):', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra * 0.19, 0), 1);
$pdf->Ln();

$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'Valor Total:', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra * 1.19, 0), 1);

// Añadimos los recuadros con borde
$pdf->Rect(150, 20, 40, 20);
$pdf->Rect(10, 70, 150, 30);


// Descargar el archivo PDF
ob_end_clean(); // Limpiar el buffer de salida
$pdf->Output('D', 'orden_de_compra_'.$txtNumOrden.'.pdf');
exit();
?>
