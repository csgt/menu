<?php
	/*******************************************/
	/*Laravel CS Core - No hacer cambios 
	ver 1.1 - Iconos en menu
	*/
?>
<style>
  .dropdown-submenu{position:relative;}
  .dropdown-submenu>.dropdown-menu{top:0;left:100%;margin-top:-6px;margin-left:-1px;-webkit-border-radius:0 6px 6px 6px;-moz-border-radius:0 6px 6px 6px;border-radius:0 6px 6px 6px;}
  .dropdown-submenu:hover>.dropdown-menu{display:block;}
  .dropdown-submenu>a:after{display:block;content:" ";float:right;width:0;height:0;border-color:transparent;border-style:solid;border-width:5px 0 5px 5px;border-left-color:#cccccc;margin-top:5px;margin-right:-10px;}
  .dropdown-submenu:hover>a:after{border-left-color:#ffffff;}
  .dropdown-submenu.pull-left{float:none;}.dropdown-submenu.pull-left>.dropdown-menu{left:-100%;margin-left:10px;-webkit-border-radius:6px 0 6px 6px;-moz-border-radius:6px 0 6px 6px;border-radius:6px 0 6px 6px;}
	.navbar span.glyphicon {
		padding-right: 2px;
	}
</style>
<div class="{{Config::get('menu::estilos','navbar navbar-default navbar-fixed-top')}}" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="{{ URL::route(Config::get('menu::logo.ruta','index.index')) }}">
      	{{ HTML::image(Config::get('menu::logo.imagen','images/logo-menu.png'), $alt=Config::get('menu::logo.alt','Logo')) }}
      </a>
    </div>
    <div class="navbar-collapse collapse">
      {{ $elMenu }}
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
          @if(Config::get('menu::rendernombremenu'))
            @if (Auth::user()) {{ Auth::user()->nombre }}&nbsp; @endif
          @endif
          <span class="glyphicon glyphicon-user"></span><b class="caret"></b></a>
          <ul class="dropdown-menu">
            @if(Config::get('menu::editprofile'))
              <li><a href="{{ URL::to(Config::get('menu::editprofileurl')) }}"><span class="glyphicon glyphicon-tasks"></span> Editar Perfil</a></li>
              <li role="presentation" class="divider"></li>
            @endif

            @if(Config::get('menu::viewhelp') || Config::get('menu::viewabout'))
              @if(Config::get('menu::viewhelp'))
                <li><a href="{{ URL::to(Config::get('menu::viewhelpurl')) }}"><span class="glyphicon glyphicon-question-sign"></span> Ayuda</a></li>
              @endif
              @if(Config::get('menu::viewabout'))
                <li>
                  <a href="{{ URL::to(Config::get('menu::viewabouturl')) }}">
                    <span class="glyphicon glyphicon-info-sign"></span> 
                    Acerca de...
                  </a>
                </li>
              @endif
              <li role="presentation" class="divider"></li>
            @endif

            <li><a href="{{ URL::to('logout') }}"><span class="glyphicon glyphicon-lock"></span> Cerrar sesi&oacute;n</a></li>
          </ul>
        </li>
      </ul>
    </div><!--/.nav-collapse -->
  </div> <!--container-->
</div> <!--navbar -->