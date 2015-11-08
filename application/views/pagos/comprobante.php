<div class="well">
    <img src="public/images/logo.png" title="Aerys Technologies" style="max-width:110px; margin-left:35px">    
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Mensualidad </h2>
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
                        <strong>Fecha de Pago: </strong><?php echo $pago->fecha; ?>
                    </label>
                </div>
            </div>     
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Mensualidad a Cubrir: </strong>$ <?php echo $pago->monto; ?>
                    </label>
                </div>
            </div>            
            </br></br>
            <div class="row">
                <div class="editor-label">            
                    <label for="titulo">
                        <strong>Paquete: </strong><?php echo $paquete->titulo; ?>
                    </label>
                </div>
            </div>            
                       
        </div>
    </div>

    <div class="custom-divider"></div>
    
</div>
