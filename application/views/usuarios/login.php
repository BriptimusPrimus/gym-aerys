<div class="well">
    <h2>Ingresar <p></p></h2>
</div>
<br />
<div class="container" style="margin:0 auto;">
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2"><h2>Datos de Usuario </h2>
            <hr class="custom-divider" />
        </div>
    </div>
    <form id="loginform" action="<?php echo URL; ?>usuarios/trylogin" method="POST">
        <fieldset>
            
            <div class="row-fluid">
                <div class="span4 offset4">

                    <div class="editor-label">
                        <label for="cuenta">Nombre de Usuario</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="wide-text-box" id="cuenta" name="cuenta" type="text" value="" />                        
                    </div>

                    <div class="editor-label">
                        <label for="password">Contrase&ntilde;a</label>
                    </div>
                    <div class="span12 editor-field">
                        <input class="wide-text-box" id="password" name="password" type="password" value="" />                        
                    </div>                                      

                </div>
            </div>

            <div class="custom-divider"></div>
            <div class="row-fluid">
                <div class="span2 offset4">
                    <button class="btn btn-info btn-block" type="submit" value="submit" 
                            name="submit_login" id="submit_login" rel='tooltip' 
                            onclick="formhash(this.form, this.form.password);">
                        <i class="icon-fixed-width icon-save"></i> Aceptar
                    </button>
                </div>
            </div>
        
        </fieldset>        
    </form>
</div>      