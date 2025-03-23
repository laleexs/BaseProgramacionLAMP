<html>
    <head>
        <title>Welcome to LAMP Infrastructure</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container-fluid">
            <?php
                echo "<h1>Hello, Welcome DAW Student!</h1>";
                echo "<h2>mysqli example</h2>";

                $conn = mysqli_connect('db', 'root', 'test', "dbname");
   
                /*
                //sentencia ejemplo de insert
                $insert = "INSERT INTO Person(id, name) VALUES (111, 'NombrePrueba1')";
                $result = mysqli_query($conn, $insert);
                 
                //ejemplo prepared statement
                $stmt = $conn->prepare("INSERT INTO Person(id, name) VALUES (?, ?)");
                $stmt->bind_param("is", $id, $name); //i: integer; s: string
                $id = 222;
                $name = "NombrePrueba2";
                $stmt->execute();
                */

                $query = 'SELECT * From Person';
                $result = mysqli_query($conn, $query);

                echo '<table class="table table-striped">';
                echo '<thead><tr><th>id</th><th>name</th></tr></thead>';
                while($value = $result->fetch_array(MYSQLI_ASSOC)){
                    echo '<tr>';
                    foreach($value as $element){
                        echo '<td>' . $element . '</td>';
                    }

                    echo '</tr>';
                }
                echo '</table>';

                $result->close();
                mysqli_close($conn);

                echo "<h2>pdo example</h2>";
                
                $conn = new PDO("mysql:host=db;dbname=dbname", "root", "test");
                
                /*
                // Ejemplo de inserción directa
                $insert = "INSERT INTO Person(id, name) VALUES (333, 'NombrePrueba3')";
                $result = $conn->exec($insert);

                // Ejemplo de prepared statement
                $stmt = $conn->prepare('INSERT INTO Person(id, name) VALUES (?, ?)');
                $id = 444;
                $name = "NombrePrueba4";
                $stmt->execute([$id, $name]);
                */

                // Consulta de datos
                $query = 'SELECT * FROM Person';
                $stmt = $conn->query($query);

                echo '<table class="table table-striped">';
                echo '<thead><tr><th>id</th><th>name</th></tr></thead>';
                while ($value = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<tr>';
                    foreach ($value as $element) {
                        echo '<td>' . $element . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';

            ?>
        </div>
    </body>
</html>
