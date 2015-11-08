<div class="container">
    <!-- main content output -->
    <div>
        <h3>Lista de paquetes</h3>
        <table class="table table-striped table-bordered table-hover" id="paquetes-table" style="background-color:white;">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Paquete</td>
                <td>Nombre</td>
                <td>Precio</td>                               
                <td>Descripci;&oacute;n</td>                
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($paqueteList as $record) { ?>    
                <tr>
                    <td><?php if (isset($record->idpaquete)) echo $record->idpaquete; ?></td>
                    <td><?php if (isset($record->titulo)) echo $record->titulo; ?></td>
                    <td style="text-align:right;"><?php if (isset($record->costo)) echo "$ $record->costo"; ?></td>
                    <td><?php if (isset($record->descripcion)) echo $record->descripcion; ?></td>
                    <td>
                        <a href="<?php echo URL . 'paquetes/edit/' . $record->idpaquete; ?>" class="btn">Editar</a> 
                        <a href="<?php echo URL . 'paquetes/details/' . $record->idpaquete; ?>" class="btn">Detalles</a> 
                        <a href="<?php echo URL . 'paquetes/delete/' . $record->idpaquete; ?>" class="btn">Eliminar</a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <p>           
            <a href="<?php echo URL . 'paquetes/create'; ?>" role="button" class="btn btn-primary">
                <i class="icon-plus-sign icon-white"></i>Nuevo Paquete
            </a>
        </p>        
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
            $('#paquetes-table').dataTable({
                //"bAutoWidth": false
                "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
            });
        });    
</script>