<div class="well">
    <h2>Clientes <p><small>Activar Cliente</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="alert"><h5>&iquest;Est&aacute; seguro que desea Activar este Cliente?</h5></div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2><?php echo str_pad((int) $persona->idpersona,6,"0",STR_PAD_LEFT); ?> </h2>
            <hr class="custom-divider" />
        </div>
    </div>
    <div class="row"> 
                
        <div class="span4 offset4">            
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">Nombre</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="nombre" name="nombre" readonly="True" type="text" value="<?php echo "$persona->nombre $persona->apaterno $persona->amaterno"; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="email">E-Mail</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="email" name="email" readonly="True" type="text" value="<?php echo $persona->email; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="fecharegistro">Fecha de Registro</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="fecharegistro" name="fecharegistro" readonly="True" style="text-align:center;" type="text" value="<?php echo date("d/m/Y", strtotime($persona->fecharegistro)); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="fechainscripcion">Fecha de Inscripci&oacute;n</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="fechainscripcion" name="fechainscripcion" readonly="True" style="text-align:center;" type="text" value="<?php if($persona->inscrito) echo date("d/m/Y", strtotime($persona->fechainscripcion)); ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="montoinscripcion">Monto Pagado por Inscripci&oacute;n</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="montoinscripcion" name="montoinscripcion" readonly="True" type="text" value="<?php if($persona->inscrito) echo "$ $persona->montoinscripcion"; ?>" />
                </div>
            </div>            
        </div>
    </div>
        
    <div class="custom-divider"></div>
    <div class="row-fluid">        
        <form id="setactivepersonaform" action="<?php echo URL; ?>personas/setactiveconfirmed" method="POST">
            <fieldset>            
                <div class="span12 editor-field">
                    <input class="wide-text-box" id="idpersona" name="idpersona" type="hidden" value="<?php echo $persona->idpersona; ?>" />
                </div>                
                <div class="span2 offset1">
                    <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL; ?>personas/index">
                        <i class="icon-fixed-width icon-reply"></i> Cancelar
                    </a>
                </div>
                <div class="span2 offset6">
                    <button class="btn btn-info btn-block" type="submit" value="submit" name="submit_setactive_persona" id="submit_setactive_persona" rel='tooltip' >
                        <i class="icon-fixed-width icon-save"></i> Activar
                    </button>
                </div>        
            </fieldset>        
        </form>
    </div>    
       
</div>
