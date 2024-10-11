<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "facturacion";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos de la factura
$nit = $_POST['nit'];
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$fecha = $_POST['fecha'];
$correlativo = $_POST['correlativo'];
$num_autorizacion_fel = $_POST['num_autorizacion_fel'];

// Inicializar valores
$subtotal = 0;
$productos_factura = [];

// Verificar si se enviaron productos
if (!empty($_POST['campoProductos'])) {
    $productos_cadena = $_POST['campoProductos'];
    $productos = explode('|', rtrim($productos_cadena, '|'));

    foreach ($productos as $producto) {
        list($nombre_producto, $cantidad, $precio_unitario) = explode(':', $producto);
        $total_producto = $cantidad * $precio_unitario;
        $subtotal += $total_producto;
        $productos_factura[] = [
            'producto' => $nombre_producto,
            'cantidad' => $cantidad,
            'precio_unitario' => $precio_unitario,
            'total' => $total_producto
        ];
    }
}

// Calcular el IVA (12%) solo si hay productos
$iva = $subtotal > 0 ? $subtotal * 0.12 : 0;
$total = $subtotal + $iva;

// Insertar la factura en la base de datos (incluso sin productos)
$stmt = $conn->prepare("INSERT INTO facturas (nit, nombre, direccion, fecha, correlativo, num_autorizacion_fel, subtotal, iva, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisdss", $nit, $nombre, $direccion, $fecha, $correlativo, $num_autorizacion_fel, $subtotal, $iva, $total);
$stmt->execute();

// Mostrar la factura generada
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura Generada</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Factura Generada</h1>
        <div class="factura-detalle">
            <p><strong>NIT:</strong> <?php echo $nit; ?></p>
            <p><strong>Nombre:</strong> <?php echo $nombre; ?></p>
            <p><strong>Dirección:</strong> <?php echo $direccion; ?></p>
            <p><strong>Fecha:</strong> <?php echo $fecha; ?></p>
            <p><strong>Correlativo:</strong> <?php echo $correlativo; ?></p>
            <p><strong>Número de Autorización FEL:</strong> <?php echo $num_autorizacion_fel; ?></p>

            <?php if (!empty($productos_factura)): ?>
                <h2>Productos</h2>
                <table style="width:100%">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario (Q)</th>
                            <th>Total (Q)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productos_factura as $producto): ?>
                            <tr>
                                <td><?php echo $producto['producto']; ?></td>
                                <td><?php echo $producto['cantidad']; ?></td>
                                <td><?php echo number_format($producto['precio_unitario'], 2); ?></td>
                                <td><?php echo number_format($producto['total'], 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p><strong>No se agregaron productos en esta factura.</strong></p>
            <?php endif; ?>

            <h2>Resumen</h2>
            <p><strong>Subtotal:</strong> Q<?php echo number_format($subtotal, 2); ?></p>
            <p><strong>IVA (12%):</strong> Q<?php echo number_format($iva, 2); ?></p>
            <p><strong>Total a Pagar:</strong> Q<?php echo number_format($total, 2); ?></p>
        </div>
        <a href="index.php" class="btn-submit">Generar Nueva Factura</a>
    </div>
</body>
</html>
