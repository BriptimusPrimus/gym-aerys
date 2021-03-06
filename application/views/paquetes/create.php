<div class="well">
    <h2>Paquetes <p><small>Nuevo Paquete</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Nuevo Paquete </h2>
            <hr class="custom-divider" />
        </div>
    </div>
    <form id="newpaqueteform" action="<?php echo URL; ?>paquetes/addpaquete" method="POST">
        <fieldset>
            
            <div class="row-fluid">
                <div class="span4 offset4">

                    <div class="editor-label">
                        <label for="titulo">Nombre</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="titulo" name="titulo" type="text" maxlength="45" value="" />                        
                    </div>

                    <div class="editor-label">
                        <label for="costo">Precio</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="costo" name="costo" type="text" onkeyUp="return ValNumero(this);" value="" />                        
                    </div>                    
                    
                    <div class="editor-label">
                        <label for="descripcion">Descripci;&oacute;n</label>
                    </div>
                    <div class="span12 editor-field">                         
                        <textarea class="input-block-level" cols="20" rows="2" id="descripcion" name="descripcion"></textarea>
                    </div>                    

                </div>
            </div>

            <div class="custom-divider"></div>
            <div class="row-fluid">
                <div class="span2 offset1">
                    <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL; ?>paquetes/index">
                        <i class="icon-fixed-width icon-reply"></i> Cancelar
                    </a>
                </div>
                <div class="span2 offset6">
                    <button class="btn btn-info btn-block" type="submit" value="submit" name="submit_add_paquete" id="submit_add_paquete" rel='tooltip' >
                        <i class="icon-fixed-width icon-save"></i> Guardar
                    </button>
                </div>
            </div>
        
        </fieldset>        
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        //validar datos antes de permitir submit
        $('#newpaqueteform').submit(function(e){
            if( $("#titulo").attr("value").trim() == '')    
            {
                alert('Debe capturarse el nombre del paquete'); 
                e.preventDefault(e);
                return;
            }  
            if( $("#costo").attr("value").trim() == '')    
            {
                alert('Debe capturarse el precio del paquete'); 
                e.preventDefault(e);
                return;
            }               
        });        
    });
</script>        