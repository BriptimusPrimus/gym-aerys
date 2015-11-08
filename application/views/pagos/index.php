<div class="container">
    <!-- main content output -->
    <div>
        <h3>Relacion de Pagos Pendientes</h3>
        <table class="table table-bordered table-hover" id="pagos-table" style="background-color:white;">
            <thead style="background-color: #ddd; font-weight: bold;">
                <tr>
                    <td>Cliente</td>
                    <td>Nombre</td>
                    <td style="text-align:center;">Fecha de Corte</td>                               
                    <td style="text-align:center;">Dias Vencimiento</td>                
                    <td></td>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($pagoList as $record) { 
                $rowStyle = "";
                if (isset($record->diasVencidos))
                {
                    if ($record->diasVencidos > 0){$rowStyle = 'style="background-color: #ebcccc"';}
                    else if ($record->diasVencidos == 0){$rowStyle = 'style="background-color: #fcf8e3"';}
                }
            ?>    
                <tr <?php echo $rowStyle?>>
                    <td><?php if (isset($record->idpersona)) echo str_pad((int) $record->idpersona,6,"0",STR_PAD_LEFT); ?></td>
                    <td><?php if (isset($record->nombre)) echo "$record->nombre $record->apaterno $record->amaterno"; ?></td>
                    <td style="text-align:center;"><?php if (isset($record->fechaCorte)) echo date("d/m/Y", strtotime($record->fechaCorte)); ?></td>
                    <td style="text-align:right;"><?php if (isset($record->diasVencidos)) echo $record->diasVencidos; ?></td>
                    <td>
                        <a href="<?php echo URL . 'pagos/pagosdepersona/' . $record->idpersona; ?> " class="btn">Ver Pagos</a> 
                        <a href="<?php echo URL . 'pagos/create/' . $record->idpersona; ?>" class="btn">Cobrar</a>                        
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>       
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
            $('#pagos-table').dataTable({                
                "aaSorting": [[ 3, "desc" ]],
                "asStripClasses":[],
                //"bAutoWidth": false
                "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
            });
        });    
</script>