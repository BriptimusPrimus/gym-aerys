<div class="well">
    <h2>Clientes <p><small>Inscribir Cliente</small></p></h2>
</div>
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Datos del Cliente </h2>
            
            <div class="row-fluid">
                <div class="span4 offset4">
                    
                        <div class="editor-label">            
                            <label for="nombre">Nombre</label>
                        </div>
                        <div class="col-sm-12 form-group" >
                            <input class="wide-text-box" id="nombre" name="nombre" readonly="True" type="text" value="<?php echo "$persona->nombre $persona->apaterno $persona->amaterno"; ?>" />
                        </div>

                        <div class="editor-label">            
                            <label for="email">E-Mail</label>
                        </div>
                        <div class="col-sm-12 form-group" >
                            <input class="wide-text-box" id="email" name="email" readonly="True" type="text" value="<?php echo $persona->email; ?>" />
                        </div>

                        <div class="editor-label">            
                            <label for="fecharegistro">Fecha de Registro</label>
                        </div>
                        <div class="col-sm-12 form-group" >
                            <input class="wide-text-box" id="fecharegistro" name="fecharegistro" readonly="True" style="text-align:center;" type="text" value="<?php echo date("d/m/Y", strtotime($persona->fecharegistro)); ?>" />
                        </div>
                                        
                </div>
            </div>    
            
            <hr class="custom-divider" />
            <h3><p>Inscribir</p></h3>
        </div>
    </div>
    <form id="enrollpersonaform" action="<?php echo URL; ?>personas/enrollconfirmed" method="POST">
        <fieldset>
            
            <div class="row-fluid">
                <div class="span4 offset4">
                    
                    <div class="span12 editor-field">
                        <input class="input-block-level" id="idpersona" name="idpersona" type="hidden" value="<?php echo $persona->idpersona; ?>" />
                    </div>
                    
                    <div class="row">
                        <div class="editor-label">
                            <label for="fechainscripcion">Fecha de Inscripci&oacute;n</label>
                        </div>
                        <div class="col-sm-12 form-group">
                            <input class="input-block-level" id="fechainscripcion" name="fechainscripcion" readonly="True" style="text-align:center;" type="text" value="<?php echo date('d/m/Y'); ?>" />            
                        </div>   
                    </div>
                    <div class="row">
                        <div class="editor-label">
                            <label for="montoinscripcion">Monto de Inscripci&oacute;n</label>
                        </div>
                        <div class="col-sm-12 form-group">
                            <input class="input-block-level" id="montoinscripcion" name="montoinscripcion" type="text" onkeyUp="return ValNumero(this);" value="" />                        
                        </div>
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
                    <button class="btn btn-info btn-block" type="submit" value="submit" name="submit_enroll_persona" id="submit_enroll_persona" rel='tooltip' >
                        <i class="icon-fixed-width icon-save"></i> Inscribir
                    </button>
                </div>
            </div>
        
        </fieldset>        
    </form>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        
        var regDate = $("#fechainscripcion").datepicker({
            format: "dd/mm/yyyy",
            autoclose: true,
            minView: 2,
            language: 'es'
        }).on('changeDate', function (ev) {
            regDate.hide();
        }).data('datepicker');
                
        //validar datos antes de permitir submit
        $('#enrollpersonaform').submit(function(e){
            if( $("#montoinscripcion").attr("value").trim() == '')    
            {
                alert('Debe capturarse el monto'); 
                e.preventDefault(e);
                return;
            }              
        });        
    });
</script>        