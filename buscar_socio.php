<?php
$adminSocios = new AdminSocios();
if ($_POST['buscar'] == "true") {
    $socios = $adminSocios->listarSocios($_POST['nombre']);
} else {
    $socios = $adminSocios->listarSocios("");
}
if ($socios != null) {
    $totalSocios = $socios->size();
    $socios->sort();
} else {
    $totalSocios = 0;
}
$i = 0;
while ($i < $totalSocios) {
    $diasSobrantes = Util::diasSobrantes($socios->get($i)->getFechaFinMembresia());
    $idSocio = $socios->get($i)->getIdSocio();
    ?>
    <tr <?php if ($diasSobrantes <= 0) echo "class=\"table-danger\""; else if (($diasSobrantes > 0) && ($diasSobrantes <= 5)) echo "class=\"table-warning\"";?>>
        <td>
            <?php echo $i + 1;?>
        </td>

        <td>
            <img class="rounded-circle" height="120" width="120"
                 src="<?php echo $socios->get($i)->getRutaFotografia(); ?>"/>
        </td>

        <td>
            <?php echo $socios->get($i)->getNombrePila();?>
        </td>

        <td>
            <?php echo $socios->get($i)->getApellido1() . " "
                . $socios->get($i)->getApellido2();?>
        </td>

        <td>
            <?php if($diasSobrantes > 0) echo "Activo"; else echo "Inactivo";?>
        </td>

        <td>
            <?php echo Util::formatearFecha($socios->get($i)->getFechaFinMembresia());?>
        </td>

        <td>
            <a class="btn btn-info btn-xs"
               href="frm_editar_socio.php?id=<?php echo $idSocio;?>">
                Editar
            </a>
        </td>

        <?php
        if ($_SESSION['usuario']['root']) { ?>
            <td>
                <a class="btn btn-danger btn-xs"
                   href="frm_eliminar_socio.php?id=<?php echo $idSocio;?>">
                    Eliminar
                </a>
            </td>
            <?php
        }
        ?>
        <td>
            <a class="btn btn-success btn-xs"
               href="frm_renovar_membresia.php?id=<?php echo $idSocio;?>">
                Cobrar
            </a>
        </td>
        <td>
            <a class="btn btn-warning btn-xs"
               href="ocultar_socio.php?id=<?php echo $idSocio;?>">
                Ocultar
            </a>
        </td>
    </tr>
    <?php
    $i++;
}
if ($totalSocios == 0) {
    echo "" .
    "<div class='alert alert-warning text-center'>" .
        "<strong>¡Upps!</strong> Parece que no tenemos registros de lo" .
        "que buscas. ".
    "</div>";
}
?>