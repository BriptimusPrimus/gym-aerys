<div class="container">
    
    </br></br>
    <div class="well">
	
        <h2>Concentrado Mensual de Pagos <p><small>Seleccione Periodo</small></p></h2>
            </br>
                <!-- Form DateTime Pickers -->
                <div class="row-fluid">
                    <form id="mensualidadform" action="<?php echo URL; ?>pagos/mensualidad" class="form-horizontal" method="POST">           
                        <div class="span1 offset1"><label></label></div>
                            <div class="span2 input-prepend date">
                                <button class="btn" disabled style="width:100px"><i class="icon-fixed-width icon-calendar"></i> Mes/A&ntilde;o</button>
                                <input id="monthdate" name="monthdate" readonly="true" style="text-align:center; width:80%" type="text" value="<?php echo "$mes/$anho";?>" />
                            </div>
                        <div class="span2 offset2">
                            <button class="btn btn-block" type="submit"  value="submit" name="submit_period" id="submit_period" rel='tooltip' data-toggle="tooltip"> Ver</button>
                        </div>
                    </form>
                </div>			
                <!-- Form DateTime Pickers -->

            </br>
	</div>
	<hr class="custom-divider" />            
    
    <!-- main content output -->
    <div>
        <table class="table table-striped table-bordered table-hover" id="mensualidades-table" style="background-color:white;">
            <thead style="background-color: #ddd; font-weight: bold;">
            <tr>
                <td>Num. Cliente</td>
                <td>Nombre</td>
                <td style="text-align:center;">Fecha Pago</td>                               
                <td style="text-align:center;">Monto</td>                
            </tr>
            </thead>
            <tbody>
            <?php foreach ($pagoList as $record) { ?>    
                <tr>
                    <td><?php if (isset($record->idpersona)) echo str_pad((int) $record->idpersona,6,"0",STR_PAD_LEFT); ?></td>
                    <td><?php if (isset($record->nombre)) echo "$record->nombre $record->apaterno $record->amaterno"; ?></td>
                    <td style="text-align:center;"><?php if (isset($record->fecha)) echo date("d/m/Y", strtotime($record->fecha)); ?></td>
                    <td style="text-align:right;"><?php if (isset($record->monto)) echo "$ $record->monto"; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>    
        
        <h5>Total: <?php echo " $ " . number_format($total, 2); ?></h5>
        
        <div class="custom-divider"></div>
        <div class="row-fluid">
            <div class="span2 offset1">

            </div>
            <div class="span2 offset6">
                <a id="print" href="<?php echo URL . 'reportes/mensualidades'; ?>" role="button" class="btn btn-info btn-block">
                    <i class="icon-print icon-white"></i> Imprimir
                </a>                    
            </div>
        </div>
            
    </div>
    
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var payDate = $("#monthdate").datepicker({
            format: "mm/yyyy",
            autoclose: true,
            minView: 2,
            language: 'es',
            viewMode: "months", 
            minViewMode: "months"            
        }).on('changeDate', function (ev) {
            payDate.hide();
        }).data('datepicker');        
        
        $('#mensualidades-table').dataTable({
            //"bAutoWidth": false,
            "sDom": "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>"
            //"oLanguage": {"sUrl": "public/DataTables/dataTable.Es.txt"}            
        });
        
        $('#print').click(function(e){
            e.preventDefault(e);
            $('#mensualidadform').attr("action", "reportes/mensualidades");
            $('#mensualidadform').submit();
        });        
    });    
</script>