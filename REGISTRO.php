<?php
$alumnos = ["Erik","Alejandro","Fernanda","Daniel","Brenda","Karime","Aldo","Karen","Carlos","Andrea"];
$califs = ["0","1","2","3","4","5","6","7","8","9","10","NP"];
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Registro De Calificaciones</title>
    <style>
        #tabla {
            border-collapse: collapse;
            padding: 1px;
            text-align: center; 
            width: 10%;
        }

        #tabla th {
            background-color: beige;
        }
    </style>
</head>
<body>
 <form method="POST" action="RESULTADOS.php">
    <h1>REGISTRO DE CALIFICACIONES:</h1>
    <br>
    <table id="tabla" border>
        <tr>
            <th>Nombre</th>
            <th>Calificación</th>  
        </tr>
        <?php foreach($alumnos as $alumno): ?>
        <tr>
            <td><label><?php echo $alumno; ?></label></td>
            <td>
                <select name="cbo<?php echo $alumno; ?>">
                    <?php foreach($califs as $calif): ?>
                        <option><?php echo $calif; ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <input type="submit" value="Resultados">
</form>
</body>
</html>

