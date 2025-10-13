<?php
$total = count($_REQUEST);
$aprob = 0;
$reprob = 0;
$np = 0;
$suma = 0;   
$cali = 0;   
$mejor = null;
$peor = null;


foreach ($_REQUEST as $calif) {
    if ($calif === "NP") {
        $np++;
    } elseif ($calif >= 0 && $calif <= 10) { 
        $suma += $calif;
        $cali++;

        
        if ($mejor === null || $calif > $mejor) {
            $mejor = $calif;
        }
        if ($peor === null || $calif < $peor) {
            $peor = $calif;
        }

        
        if ($calif >= 6) {
            $aprob++;
        } else {
            $reprob++;
        }
    }
}

if ($cali > 0) {
    $promedio = $suma / $cali;
} else {
    $promedio = 0;
    $mejor = 0;
    $peor = 0;
}

echo "<h1>RESULTADOS DE LOS ALUMNOS:</h1>";
echo "Alumnos aprobados: $aprob (" . round(($aprob / $total) * 100) . "%)<br>";
echo "Alumnos reprobados: $reprob (" . round(($reprob / $total) * 100) . "%)<br>";
echo "Alumnos con NP: $np <br><br>";
echo "Promedio: " . round($promedio,2) . "<br>";
echo "Mejor calificación: $mejor<br>";
echo "Peor calificación: $peor<br>";