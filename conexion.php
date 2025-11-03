<?php
function ejecutar($query, $server, $base, $usr, $pass) {
    $cnx = mysqli_connect($server, $usr, $pass, $base);
    if (mysqli_connect_errno()) {
        return false;
    }

    $res = mysqli_query($cnx, $query);
    mysqli_close($cnx);

    return $res;
}

function seleccionar($query, $server, $base, $usr, $pass) {
    $resultados = [];
    $cnx = mysqli_connect($server, $usr, $pass, $base);
    if (mysqli_connect_errno()) {
        return false;
    }

    $res = mysqli_query($cnx, $query);
    while ($registro = mysqli_fetch_row($res)) {
        $resultados[] = $registro;
    }

    mysqli_free_result($res);
    mysqli_close($cnx);

    return $resultados;
}
?>
