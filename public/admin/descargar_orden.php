<?php
ob_start(); // Inicia el buffer de salida para evitar envíos no deseados
require('../../config/database.php');
require('../../src/fpdf186/fpdf.php');

// Obtener el número de orden y otros datos del proveedor
$txtNumOrden = isset($_POST['txtNumOrden']) ? $_POST['txtNumOrden'] : "";
$sentenciaSQL = $conn->prepare("SELECT * FROM registro_orden_de_compra WHERE ID_Orden_Compra = :ID_Orden_Compra");
$sentenciaSQL->bindParam(':ID_Orden_Compra', $txtNumOrden);
$sentenciaSQL->execute();
$listaRegistrosOrdenCompra = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

// Crear instancia de FPDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// 1. Información fija de la empresa (parte superior)
$pdf->Cell(0, 10, 'Nombre de la Empresa', 0, 1);
$pdf->Cell(0, 10, 'Direccion de la Empresa', 0, 1);
$pdf->Cell(0, 10, 'Telefono: 123-456-7890', 0, 1);
$pdf->Cell(0, 10, 'Correo: contacto@empresa.com', 0, 1);
$pdf->Ln(5);

// 2. Rectángulo superior derecho: Número de orden de compra
$pdf->SetXY(150, 20); // Posición superior derecha
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(40, 10, 'Orden de Compra:', 0, 1, 'C');
$pdf->SetXY(150, 30);
$pdf->Cell(40, 10, $txtNumOrden, 0, 1, 'C');
$pdf->Ln(10);

// 3. Cuadro de información del proveedor (centro de la página)
$pdf->SetXY(10, 60);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Informacion del Proveedor', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->SetXY(10, 70);
$pdf->Cell(0, 10, 'Nombre del Proveedor: ' . 'Nombre Proveedor', 0, 1);
$pdf->Cell(0, 10, 'Direccion del Proveedor: ' . 'Direccion Proveedor', 0, 1);
$pdf->Cell(0, 10, 'Telefono del Proveedor: ' . 'Telefono Proveedor', 0, 1);
$pdf->Ln(15);

// 4. Tabla de productos en la parte inferior
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(20, 10, 'Cantidad', 1);
$pdf->Cell(60, 10, 'Descripcion', 1);
$pdf->Cell(40, 10, 'Presentacion', 1);
$pdf->Cell(30, 10, 'Precio', 1);
$pdf->Cell(30, 10, 'Total', 1);
$pdf->Ln();

$totalOrdenCompra = 0;
$pdf->SetFont('Arial', '', 10);
foreach ($listaRegistrosOrdenCompra as $registro) {
    $cantidad = $registro['Cantidad'];
    $descripcion = $registro['Descripcion'];
    $presentacion = $registro['Presentacion'];
    $precio = $registro['Precio'];
    $total = $cantidad * $precio;

    $pdf->Cell(20, 10, $cantidad, 1);
    $pdf->Cell(60, 10, $descripcion, 1);
    $pdf->Cell(40, 10, $presentacion, 1);
    $pdf->Cell(30, 10, number_format($precio, 0), 1);
    $pdf->Cell(30, 10, number_format($total, 0), 1);
    $pdf->Ln();

    $totalOrdenCompra += $total;
}

// Totales e IVA en la parte inferior
$pdf->Ln();
$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'Total:', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra, 0), 1);
$pdf->Ln();

$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'IVA (19%):', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra * 0.19, 0), 1);
$pdf->Ln();

$pdf->Cell(120, 10, '', 0);
$pdf->Cell(30, 10, 'Total con IVA:', 1);
$pdf->Cell(30, 10, number_format($totalOrdenCompra * 1.19, 0), 1);

// Descargar el archivo PDF
ob_end_clean(); // Limpiar el buffer de salida
$pdf->Output('D', 'orden_de_compra_'.$txtNumOrden.'.pdf');
exit();
?>
