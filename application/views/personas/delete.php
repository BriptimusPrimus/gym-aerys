<div class="well">
    <h2>Clientes <p><small>Eliminar Cliente</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="alert alert-danger"><h5>&iquest;Est&aacute; seguro que desea Eliminar este Cliente?</h5></div>
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
                    <label for="direccion">Direcci&oacute;n</label>
                </div>
                <div class="input-block-level" >                    
                    <textarea class="input-block-level" cols="20" id="direccion" name="direccion" rows="2" readonly="True" ><?php echo $persona->direccion; ?></textarea>                    
                </div>
            </div>            
            <div class="row">
                <div class="editor-label">            
                    <label for="telefono">Tel&eacute;fono</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="telefono" name="telefono" readonly="True" type="text" value="<?php echo $persona->telefono; ?>" />
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
                    <label for="contacto">Contacto</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="contacto" name="contacto" readonly="True" type="text" value="<?php echo $persona->contacto; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="contactotelefono">Tel&eacute;fono del Contacto</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="contactotelefono" name="contactotelefono" readonly="True" type="text" value="<?php echo $persona->contactotelefono; ?>" />
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
        </div>
    </div>
        
    <div class="custom-divider"></div>
    <div class="row-fluid">        
        <form id="deletepersonaform" action="<?php echo URL; ?>personas/deleteconfirmed" method="POST">
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
                    <button class="btn btn-danger btn-block" type="submit" value="submit" name="submit_delete_persona" id="submit_delete_persona" rel='tooltip' >
                        <i class="fa fa-fw fa-trash-o"></i> Eliminar
                    </button>
                </div>        
            </fieldset>        
        </form>
    </div>    
       
</div>
