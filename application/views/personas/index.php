<div class="container">
    <!-- main content output -->
    <div>
        <h3>Lista de Clientes</h3>
        <table class="table table-striped table-bordered table-hover" id="personas-table" style="background-color:white;">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>N&uacute;mero</td>
                <td>Nombre</td>
                <td>Tel&eacute;fono</td>
                <td>Email</td>                               
                <td>Fecha de Registro</td>
                <td>Inscrito</td>
                <td>Activo</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($personaList as $record) {?>    
                <tr>
                    <td><?php if (isset($record->idpersona)) echo str_pad((int) $record->idpersona,6,"0",STR_PAD_LEFT); ?></td>
                    <td><?php if (isset($record->nombre)) echo "$record->nombre $record->apaterno $record->amaterno"; ?></td>
                    <td><?php if (isset($record->telefono)) echo $record->telefono; ?></td>
                    <td><?php if (isset($record->email)) echo $record->email; ?></td>
                    <td style="text-align:center;"><?php if (isset($record->fecharegistro)) echo date("d/m/Y", strtotime($record->fecharegistro)); ?></td>
                    <td><?php if (isset($record->inscrito)) echo $record->inscrito ? '<a href="' . URL . 'reportes/inscripcion/' . $record->idpersona . '">Si</a>' : 'No'; ?></td>
                    <td><?php if (isset($record->activo)) echo $record->activo ? "Si" : "No"; ?></td>
                    <td>
                        <a href="<?php echo URL . 'personas/edit/' . $record->idpersona; ?>" class="btn">Editar</a> 
                        <a href="<?php echo URL . 'personas/details/' . $record->idpersona; ?>" class="btn">Detalles</a> 
                        <a href="<?php echo URL . 'personas/delete/' . $record->idpersona; ?>" class="btn">Eliminar</a>
                        <?php
                            if (!$record->inscrito) echo ' <a href="' . URL . 'personas/enrollclient/' . $record->idpersona . '" class="btn">Inscribir</a>' ; 
                            if (!$record->activo && $record->inscrito) echo ' | <a href="' . URL . 'personas/setactive/' . $record->idpersona . '" class="btn">Activar</a>' ;
                            if ($record->activo) echo ' <a href="' . URL . 'personas/setinactive/' . $record->idpersona . '" class="btn">Desactivar</a>' ;    
                            if ($record->inscrito) echo ' <a href="' . URL . 'pagos/pagosdepersona/' . $record->idpersona . '" class="btn">Pagos</a>' ;
                        ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <p>           
            <a href="<?php echo URL . 'personas/create'; ?>" role="button" class="btn btn-primary">
                <i class="icon-plus-sign icon-white"></i>Nuevo Cliente
            </a>
        </p>        
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
            $('#personas-table').dataTable({
                //"bAutoWidth": false
                "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
            });
        });    
</script>