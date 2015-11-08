<div class="well">
    <img src="public/images/logo.png" title="Aerys Technologies" style="max-width:110px; margin-left:35px">
    <label class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label class="pull-right"><strong>Fecha:</strong> <?php echo date("d/m/Y", strtotime($persona->fechainscripcion)); ?></label>        
    </br>
    <label class="pull-right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <label class="pull-right"><strong>Tarifa:</strong> $ <?php echo $persona->montoinscripcion; ?></label>    
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Inscripci&oacute;n</h2> 
            <hr class="custom-divider" />
        </div>
    </div>
    <div class="row">        
        <div class="span4 offset4">            
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Nombre: </strong><?php echo "$persona->nombre $persona->apaterno $persona->amaterno"; ?>
                    </label>
                </div>
            </div>
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Tel&eacute;fono: </strong><?php echo $persona->telefono; ?>
                    </label>
                </div>
            </div>     
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Correo Electr&oacute;nico: </strong><?php echo $persona->email; ?>
                    </label>
                </div>
            </div>            
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>En caso de emergencia: </strong><?php echo $persona->contacto; ?>
                    </label>
                </div>
            </div>
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Tel&eacute;fono: </strong><?php echo $persona->contactotelefono; ?>
                    </label>
                </div>
            </div>              
                       
        </div>
    </div>

    <div class="custom-divider"></div>
    
    
</div>
