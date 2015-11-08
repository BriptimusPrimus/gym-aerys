<div class="well">
    <h2>
        Pagos del Cliente
        </br></br>
        <p><small><strong>Nombre: </strong><?php echo "$persona->nombre $persona->apaterno $persona->amaterno "; ?></small></p>
        <p><small><strong>Estado: </strong><?php echo $persona->activo ? "Activo" : "Inactivo"; ?></small></p>
    </h2>
</div>
<div class="container">
    <!-- main content output -->
    <div>        
        <table class="table table-striped table-bordered table-hover" id="paquetes-table" style="background-color:white;">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Mes</td>
                <td>Fecha de Pago</td>
                <td>Monto Pagado</td>
                <td>Descuento</td>                               
                <td>Paquete</td>                
                <td>Comentarios</td>
                <td></td>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pagoList as $record) { ?>    
                <tr>
                    <td><?php if (isset($record->mes)) echo $record->mes; ?></td>
                    <td style="text-align:center;"><?php if (isset($record->fecha)) echo date("d/m/Y", strtotime($record->fecha)); ?></td>
                    <td style="text-align:right;"><?php if (isset($record->monto)) echo "$ $record->monto"; ?></td>
                    <td style="text-align:center;"><?php if (isset($record->descuento)) echo $record->descuento ? "$record->descuento %" : "No" ; ?></td>
                    <td><?php if (isset($record->titulo)) echo $record->titulo; ?></td>
                    <td><?php if (isset($record->comentarios)) echo $record->comentarios; ?></td>                    
                    <td>
                        <a href="<?php echo URL . 'reportes/comprobante/' . $record->idpago; ?>" class="btn">Comprobante</a> 
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        
        <div class="custom-divider"></div>
        <div class="row-fluid">
            <div class="span2 offset1">
                <a class="btn btn-block" title="regresar" rel='tooltip' data-toggle="tooltip" href="javascript:Previous()">
                    <i class="icon-fixed-width icon-reply"></i> Regresar
                </a>
            </div>
            <div class="span2 offset6">
                <?php if ($persona->activo) { ?>
                    <p>
                        <strong>Proximo Pago: </strong><?php echo $fechaPago->format('d/m/Y') ; ?>
                    </p>
                    <p>   
                        <a href="<?php echo URL . 'pagos/create/' . $persona->idpersona; ?>" role="button" class="btn btn-primary">
                            Cobrar Periodo
                        </a>
                    </p> 
                <?php } ?>                
            </div>
        </div>        
        
        
    </div>
</div>
<script type="text/javascript">
    function Previous() {
        window.history.back()
    };    
    
    $(document).ready(function() {
        $('#paquetes-table').dataTable({
            "bSort" : false,
            //"bAutoWidth": false
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
        });
    });    
</script>