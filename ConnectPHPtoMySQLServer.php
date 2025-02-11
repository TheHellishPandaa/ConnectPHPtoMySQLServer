<?php
$servername = "localhost";
$username = "tusuariobd";
$password = "passbbd";
$dbname = "nombredb";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear tabla de productos si no existe
$sql_create_table = "CREATE TABLE IF NOT EXISTS productos (
    codigo VARCHAR(10) PRIMARY KEY,
    nombre VARCHAR(35) NOT NULL,
    seccion VARCHAR(45) NOT NULL,
    stock VARCHAR(15) NOT NULL,
    codProveedor VARCHAR(10) NOT NULL
)";
$conn->query($sql_create_table);

// Dar de baja un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cliente_id'])) {
    $cliente_id = $_POST['cliente_id'];
    
    $sql = "DELETE FROM clientes WHERE id='$cliente_id'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Cliente dado de baja con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Dar de alta un cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $telefono = $_POST['telefono'];
    
    $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES ('$nombre', '$email', '$telefono')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Cliente registrado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Dar de alta un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_producto'])) {
    $codigo = $_POST['codigo_producto'];
    $nombre = $_POST['nombre_producto'];
    $seccion = $_POST['seccion'];
    $stock = $_POST['stock'];
    $codProveedor = $_POST['codProveedor'];
    
    $sql = "INSERT INTO productos (codigo, nombre, seccion, stock, codProveedor) VALUES ('$codigo', '$nombre', '$seccion', '$stock', '$codProveedor')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto registrado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Dar de baja un producto
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['codigo_eliminar'])) {
    $codigo = $_POST['codigo_eliminar'];
    
    $sql = "DELETE FROM productos WHERE codigo='$codigo'";
    
    if ($conn->query($sql) === TRUE) {
        echo "Producto eliminado con éxito.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Obtener todos los clientes y productos
$clientes = $conn->query("SELECT * FROM clientes");
$productos = $conn->query("SELECT * FROM productos");

if (!$clientes || !$productos) {
    die("Error en la consulta: " . $conn->error);
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gestión de Productos Tienda Jaime Galvez</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            padding: 50px;
        }
        .form-container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin: auto;
            margin-bottom: 20px;
        }
        input, button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #5cb85c;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <h1>Gestión de Productos Tienda Jaime Galvez</h1>
    <nav> | 
        <a href="tiendajaime4ene2025.php">Clientes</a> | 
        <a href="BBDDtiendaConTablaProductosJaimeGal4feb2025.php">Productos</a>
    </nav>
    
    <div class="form-container">
        <h2>Añadir Producto</h2>
        <form method="post" action="">
            <label>Código:</label>
            <input type="text" name="codigo_producto" required><br>
            <label>Nombre:</label>
            <input type="text" name="nombre_producto" required><br>
            <label>Sección:</label>
            <input type="text" name="seccion" required><br>
            <label>Stock:</label>
            <input type="text" name="stock" required><br>
            <label>Código Proveedor:</label>
            <input type="text" name="codProveedor" required><br>
            <button type="submit">Añadir Producto</button>
        </form>
    </div>
    
    <div class="form-container">
        <h2>Eliminar Producto</h2>
        <form method="post" action="">
            <label>Código del Producto:</label>
            <input type="text" name="codigo_eliminar" required><br>
            <button type="submit">Eliminar Producto</button>
        </form>
    </div>
    
    <div class="form-container">
        <h2>Lista de Productos</h2>
        <table border="1" style="width: 100%; text-align: left;">
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Sección</th>
                <th>Stock</th>
                <th>Código Proveedor</th>
            </tr>
            <?php while ($row = $productos->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    <td><?php echo $row['seccion']; ?></td>
                    <td><?php echo $row['stock']; ?></td>
                    <td><?php echo $row['codProveedor']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
