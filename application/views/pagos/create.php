<div class="well">
    <h2>
        Pagos del Cliente        
        <p><small><strong>Nombre: </strong><?php echo "$persona->nombre $persona->apaterno $persona->amaterno "; ?></small></p>
        <p><small><strong>Estado: </strong><?php echo $persona->activo ? "Activo" : "Inactivo"; ?></small></p>
    </h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Nuevo Pago </h2>
            <hr class="custom-divider" />
        </div>
    </div>
    <form id="newpagoform" action="<?php echo URL; ?>pagos/addpago" method="POST">
        <fieldset>
            
            <div class="row-fluid">
                <div class="span4 offset4">

                    <div class="span12 editor-field">
                        <input class="input-block-level" id="idpersona" name="idpersona" type="hidden" value="<?php echo $persona->idpersona; ?>" />
                    </div>                    

                    <div class="editor-label">
                        <label for="combopaquete">Paquete</label>
                    </div>
                    <div class="span12 editor-field">
                        <?php echo $HTMLpaquetesSelect; ?>
                    </div>
                    
                    <div class="editor-label">
                        <label for="monto">Monto</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="monto" name="monto" readonly="True" type="text" value="" />                        
                    </div>
                    
                    <div class="editor-label">
                        <label for="fecha">Fecha de Pago</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="fecha" name="fecha" readonly="True" style="text-align:center;" type="text" value="<?php echo $fechaPago->format('d/m/Y'); ?>" />            
                    </div>                    
                    
                    <div class="editor-label">
                        <label for="descuento">Descuento</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="descuento" name="descuento" type="text" onkeyUp="return ValEntero(this);" value="0" />                        
                        <span class="field-validation-valid alert alert-danger" data-valmsg-for="descuento" data-valmsg-replace="true" id="mensajedescuento" style="display:none;"></span>
                    </div>
                    
                    <div class="editor-label">
                        <label for="comentarios">Comentarios</label>
                    </div>
                    <div class="span12 editor-field">                         
                        <textarea class="input-block-level" cols="20" rows="2" id="comentarios" name="comentarios"></textarea>
                    </div>                                        

                </div>
            </div>

            <div class="custom-divider"></div>
            <div class="row-fluid">
                <div class="span2 offset1">
                    <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL . 'pagos/pagosdepersona/' . $persona->idpersona; ?>">
                        <i class="icon-fixed-width icon-reply"></i> Cancelar
                    </a>
                </div>
                <div class="span2 offset6">
                    <button class="btn btn-info btn-block" type="submit" value="submit" name="submit_add_pago" id="submit_add_pago" rel='tooltip' >
                        <i class="icon-fixed-width icon-save"></i> Guardar
                    </button>
                </div>
            </div>
        
        </fieldset>        
    </form>
</div>

<script type="text/javascript">
    function mostrarDescuento() {
        var monto = $('#monto').val();
        var descuento = $('#descuento').val();
        var nuevoPrecio = monto - (monto * descuento / 100);
        $('#mensajedescuento').html("Precio con descuento: $" + nuevoPrecio);
        $("#mensajedescuento").show().delay(5000).fadeOut();        
    }
        
    $(document).ready(function() {
                
        $("#combopaquete").attr("class", "input-block-level");
        
        //validar datos antes de permitir submit
        $('#newpagoform').submit(function(e){            
            if($('#combopaquete').val() == 0)        
            {
                alert('Debe seleccionar el paquete'); 
                e.preventDefault(e);
                return;
            }
        });         
        
        //colocar el precio del paquete en la caja de texto monto
        $("#combopaquete").change(function(e){
            var optionSelected = $(this).find("option:selected");
            var valueSelected  = optionSelected.val();
            var textSelected   = optionSelected.text();
            var arr = valueSelected.split('#');
            $("#monto").val(arr[1]);
            mostrarDescuento();
        });               
        
        //calcular el precio con descuento y mostrarlo
        $('#descuento').keyup(function(e){
            if($('#monto').val().trim() == '')
            {
                alert("No ha seleccionado el paquete");
                $('#descuento').val('0');
            }
            else
            {
                mostrarDescuento();
            }
        });
        
    });
</script>        