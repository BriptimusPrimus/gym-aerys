<div class="well">
    <h2>Paquetes <p><small>Eliminar Paquete</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="alert alert-danger"><h5>&iquest;Est&aacute; seguro que desea Eliminar este Paquete?</h5></div>
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2><?php echo $paquete->idpaquete; ?> </h2>
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
                    <input class="input-block-level" id="titulo" name="titulo" readonly="True" type="text" value="<?php echo $paquete->titulo; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="costo">Precio</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="costo" name="costo" readonly="True" type="text" value="<?php echo $paquete->costo; ?>" />
                </div>
            </div>           
            <div class="row">
                <div class="editor-label">            
                    <label for="descripcion">Descripci;&oacute;n</label>
                </div>
                <div class="input-block-level" >                    
                    <textarea class="input-block-level" cols="20" id="descripcion" name="descripcion" rows="2" readonly="True" ><?php echo $paquete->descripcion; ?></textarea>                    
                </div>
            </div>            
        </div>
    </div>
        
    <div class="custom-divider"></div>
    <div class="row-fluid">        
        <form id="deletepaqueteform" action="<?php echo URL; ?>paquetes/deleteconfirmed" method="POST">
            <fieldset>            
                <div class="span12 editor-field">
                    <input class="wide-text-box" id="idpaquete" name="idpaquete" type="hidden" value="<?php echo $paquete->idpaquete; ?>" />
                </div>                
                <div class="span2 offset1">
                    <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL; ?>paquetes/index">
                        <i class="icon-fixed-width icon-reply"></i> Cancelar
                    </a>
                </div>
                <div class="span2 offset6">
                    <button class="btn btn-danger btn-block" type="submit" value="submit" name="submit_delete_paquete" id="submit_delete_paquete" rel='tooltip' >
                        <i class="fa fa-fw fa-trash-o"></i> Eliminar
                    </button>
                </div>        
            </fieldset>        
        </form>
    </div>    
       
</div>
