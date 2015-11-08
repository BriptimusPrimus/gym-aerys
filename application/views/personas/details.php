<div class="well">
    <h2>Clientes <p><small>Detalles de Cliente</small></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2><?php echo str_pad((int) $persona->idpersona,6,"0",STR_PAD_LEFT); ?> </h2>
            <div class="span4 offset5">
                <?php 
                    if ($persona->inscrito) 
                    {
                        echo '<a href="' . URL . 'pagos/pagosdepersona/' . $persona->idpersona . '"><h5>Ver Pagos</h5></a>' ; 
                    }
                ?>
            </div>    
            <hr class="custom-divider" />
        </div>
    </div>
    <div class="row">        
        <div class="span4 offset4">
            
            <div class="row">
                <div class="editor-label">            
                    <label for="nombre">Nombre</label>
                </div>
                <div class="col-sm-12 form-group" >
                    <input class="input-block-level" id="nombre" name="nombre" readonly="True" type="text" value="<?php echo "$persona->nombre $persona->apaterno $persona->amaterno"; ?>" />
                </div>
            </div>
            <div class="row">
                <div class="editor-label">            
                    <label for="direccion">Direcci;&oacute;n</label>
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
            <div class="row">
                <div class="editor-label">            
                    <label><p><strong>Inscrito: </strong> <?php echo $persona->inscrito ? "Si" : "No"; ?></p></label>
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
            <div class="row">
                <div class="editor-label">            
                    <label><p><strong>Estado Actual: </strong> <?php echo $persona->activo ? "Activo" : "Inactivo"; ?></p></label>
                </div>
            </div>            
            
        </div>
    </div>
    
    <div class="custom-divider"></div>
    <div class="row-fluid">
        <div class="span2 offset1">
            <a class="btn btn-block" type="submit"  title="cancel" rel='tooltip' data-toggle="tooltip" href="<?php echo URL; ?>personas/index">
                <i class="icon-fixed-width icon-reply"></i> Regresar
            </a>
        </div>
        <div class="span2 offset6">
            <div class="btn-group">
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                    Editar/Nuevo Cliente<span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo URL . 'personas/edit/' . $persona->idpersona; ?>">Editar</a></li>
                    <li><a href="<?php echo URL . 'personas/create/' ; ?>">Nuevo</a></li>
                </ul>
            </div>
        </div>
    </div>
    
</div>