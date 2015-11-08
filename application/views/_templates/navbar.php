
<div class="masthead" id="navbar">
	<div class="navbar navbar-static-top">
		<div class="navbar-inner">
			<div class="container">
				<!-- .btn-navbar is used as the toggle for collapsed navbar content -->
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>

				<!-- Be sure to leave the brand out there if you want it shown -->
				<a class="brand" href="index.html"> <img src="public/images/logo.png" title="Aerys Technologies" style="max-width:110px; margin-left:35px"></a>

				<!-- Everything you want hidden at 940px or less, place within here -->
				<div class="nav-collapse collapse">
					<!-- .nav, .navbar-search, .navbar-form, etc -->
					<ul class="nav pull-right">
					
						<li class="active"><a href="index.html"><i class="icon-home"></i> Inicio</a></li>
						<li class="active"><a href="<?php echo URL; ?>paquetes/"><i class="icon-circle"></i>Paquetes</a></li>
						<li class="dropdown">
							<a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"><i class="icon-group"></i> Clientes</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
								<li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>personas/">Todos</a></li>	
								<li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>personas/preinscritos">Preinscritos</a></li>
                                                                <li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>personas/activos">Activos</a></li>
                                                                <li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>personas/inactivos">Inactivos</a></li>
							</ul>
						</li>
                                                <li class="dropdown">
                                                        <a class="dropdown-toggle" id="dLabel" role="button" data-toggle="dropdown" data-target="#" href="#"><i class="fa fa-fw fa-book"></i> Concentrados</a>
							<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
								<li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>pagos/mensualidad">Mensualidades</a></li>	
                                                                <li class="disabled"><a tabindex="-1" href="<?php echo URL; ?>pagos/inscripcion">Inscripci&oacute;n</a></li>                                                                
							</ul>        
                                                </li>        
						<li class="active"><a href="<?php echo URL; ?>usuarios/logout"><i class="icon-circle"></i>Salir</a></li>                                                
											
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
	</div> 
		
</div><!--/.masthead -->
