<div class="well">
    <h2>Clientes <p><small>Nuevo Cliente</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Nuevo Cliente </h2>
            <hr class="custom-divider" />
        </div>
    </div>
    <form id="newpersonaform" action="<?php echo URL; ?>personas/addpersona" method="POST">
        <fieldset>
            
            <div class="row-fluid">
                <div class="span4 offset4">

                    <div class="editor-label">
                        <label for="nombre">Nombre</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="nombre" name="nombre" type="text" maxlength="100" value="" />                        
                    </div>
                    <div class="editor-label">
                        <label for="apaterno">Apellido Paterno</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="apaterno" name="apaterno" type="text" maxlength="50" value="" />                        
                    </div>
                    <div class="editor-label">
                        <label for="amaterno">Apellido Materno</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="amaterno" name="amaterno" type="text" maxlength="50" value="" />                        
                    </div>
                    
                    <div class="editor-label">
                        <label for="direccion">Direcci&oacute;n</label>
                    </div>
                    <div class="span12 editor-field">                         
                        <textarea class="input-block-level" cols="20" rows="2" id="direccion" name="direccion"></textarea>
                    </div>                     

                    <div class="editor-label">
                        <label for="telefono">Tel&eacute;fono</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="telefono" name="telefono" type="text" maxlength="45" value="" />                        
                    </div>                    
                    
                    <div class="editor-label">
                        <label for="email">E-Mail</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="email" name="email" type="text" maxlength="45" value="" />                        
                    </div>
                    
                    <div class="editor-label">
                        <label for="contacto">Contacto</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="contacto" name="contacto" type="text" maxlength="100" value="" />                        
                    </div>
                    
                    <div class="editor-label">
                        <label for="contactotelefono">Tel&eacute;fono del Contacto</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="contactotelefono" name="contactotelefono" type="text" maxlength="45" value="" />                        
                    </div>                    

                    <div class="editor-label">
                        <label for="fecharegistro">Fecha de Registro</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="fecharegistro" name="fecharegistro" readonly="True" style="text-align:center;" type="text" value="<?php echo date('d/m/Y'); ?>" />            
                    </div>
                    
                </div>
            </div>

            <div class="custom-divider"></div>
            <div class="row-fluid">
                <div class="span2 offset1">
                    <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL; ?>personas/index">
                        <i class="icon-fixed-width icon-reply"></i> Cancelar
                    </a>
                </div>
                <div class="span2 offset6">
                    <button class="btn btn-info btn-block" type="submit" value="submit" name="submit_add_persona" id="submit_add_personas" rel='tooltip' >
                        <i class="icon-fixed-width icon-save"></i> Guardar
                    </button>
                </div>
            </div>
        
        </fieldset>        
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        var regDate = $("#fecharegistro").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minView: 2,
            language: 'es'
        }).on('changeDate', function (ev) {
            regDate.hide();
        }).data('datepicker');
        
                
        //validar datos antes de permitir submit
        $('#newpersonaform').submit(function(e){
            if( $("#nombre").attr("value").trim() == '')    
            {
                alert('Debe capturarse el nombre'); 
                e.preventDefault(e);
                return;
            }  
            if( $("#apaterno").attr("value").trim() == '')    
            {
                alert('Debe capturarse el apellido paterno'); 
                e.preventDefault(e);
                return;
            } 
            if( $("#fecharegistro").attr("value").trim() == '')    
            {
                alert('Debe capturarse la fecha de registro'); 
                e.preventDefault(e);
                return;
            }            
        });        
    });
</script>        