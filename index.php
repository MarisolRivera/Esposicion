<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Facturación</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <script>
        // Variable para verificar si hay productos agregados
        let productosAgregados = [];

        function agregarProducto() {
            var producto = document.getElementById("producto").value;
            var cantidad = document.getElementById("cantidad").value;
            var precio_unitario = document.getElementById("precio_unitario").value;

            // Verificar que los campos no estén vacíos
            if (producto && cantidad && precio_unitario) {
                var listaProductos = document.getElementById("listaProductos");

                // Crear un nuevo elemento de lista para agregar el producto
                var item = document.createElement("li");
                item.innerHTML = `
                    Producto: ${producto}, Cantidad: ${cantidad}, Precio Unitario: Q${parseFloat(precio_unitario).toFixed(2)}, Total: Q${(cantidad * precio_unitario).toFixed(2)}
                    <button type="button" class="btn-delete" onclick="eliminarProducto(this, '${producto}', ${cantidad}, ${precio_unitario})">Eliminar</button>
                `;

                // Agregar el producto a la lista visual
                listaProductos.appendChild(item);

                // Agregar los datos del producto a la lista de productos agregados
                productosAgregados.push({producto, cantidad, precio_unitario});

                // Agregar los datos del producto a un campo oculto que enviará todos los productos como una cadena
                var campoProductos = document.getElementById("campoProductos");
                campoProductos.value += `${producto}:${cantidad}:${precio_unitario}|`;

                // Limpiar los campos
                document.getElementById("producto").value = '';
                document.getElementById("cantidad").value = '';
                document.getElementById("precio_unitario").value = '';

            } else {
                alert("Por favor, completa todos los campos del producto.");
            }
        }

        function eliminarProducto(button, producto, cantidad, precio_unitario) {
            // Eliminar el producto de la lista visual
            var item = button.parentElement;
            item.remove();

            // Eliminar el producto de la lista de productos agregados
            productosAgregados = productosAgregados.filter(p => !(p.producto === producto && p.cantidad == cantidad && p.precio_unitario == precio_unitario));

            // Actualizar el campo oculto
            var campoProductos = document.getElementById("campoProductos");
            campoProductos.value = productosAgregados.map(p => `${p.producto}:${p.cantidad}:${p.precio_unitario}`).join('|') + '|';
        }

        function validarFormulario(event) {
            // Verificar si hay productos antes de permitir el envío
            if (productosAgregados.length === 0) {
                event.preventDefault();
                alert("Debes agregar al menos un producto antes de generar la factura.");
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Generar Factura</h1>
        <form action="procesar_factura.php" method="post" onsubmit="validarFormulario(event)">
            <div class="product-grid">
                <div>
                    <label>NIT:</label>
                    <input type="text" name="nit">

                    <label>Nombre:</label>
                    <input type="text" name="nombre">

                    <label>Dirección:</label>
                    <input type="text" name="direccion">
                </div>
                <div>
                    <label>Fecha:</label>
                    <input type="date" name="fecha">

                    <label>Correlativo:</label>
                    <input type="number" name="correlativo">

                    <label>Número de Autorización FEL:</label>
                    <input type="text" name="num_autorizacion_fel">
                </div>
            </div>

            <h2>Productos</h2>
            <div id="productos">
                <label>Producto:</label>
                <input type="text" id="producto">

                <label>Cantidad:</label>
                <input type="number" id="cantidad">

                <label>Precio Unitario:</label>
                <input type="number" step="0.01" id="precio_unitario">

                <button type="button" class="btn-add" onclick="agregarProducto()">Agregar Producto</button>
            </div>

            <ul id="listaProductos"></ul>

            <!-- Campo oculto para enviar los productos como cadena -->
            <input type="hidden" id="campoProductos" name="campoProductos">

            <br>
            <input type="submit" class="btn-submit" value="Generar Factura">
        </form>
    </div>
</body>
</html>
