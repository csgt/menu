<?php 

namespace Csgt\Menu;
use Config;
use View;
use AuthMenu;

class Menu {
	
	protected $texto;
	protected $matriz;

	function generarNivel($aID, $aNivel) {
		$primero = true;
		foreach ($this->matriz[$aID] AS $item) {
			switch ($aNivel) {
				case 1:
					$estiloUL = 'nav navbar-nav';
					$estiloLI  = 'dropdown';
					break;
				case 2:
					$estiloUL = 'dropdown-menu';
					$estiloLI = 'dropdown-submenu';
					break;
				default:
					$estiloUL = 'dropdown-menu';
					$estiloLI = 'dropdown-submenu';
					break;
			}

			if ($primero) $this->texto .= "<ul class='" . $estiloUL . "'>";			
			$this->texto .= "<li class='csgtmenu" . $item['menuid'] . ($item['ruta']==''?" " . $estiloLI :"") . "'>";
			
			$icon = "<span class=\"glyphicon " . $item['icono'] . "\"></span>";
			
			if ($item['ruta']=='') {
				if ($aNivel==1) {
					$this->texto .= "<a class='dropdown-toggle' data-toggle='dropdown' href='#'>";
					if ($item['icono']<>'') $this->texto .= $icon;
					$this->texto .= $item['titulo'] . "<b class='caret'></b></a>";
				}
				else {
					$this->texto .= "<a tabindex='-1' href='#'>";
					if ($item['icono']<>'') $this->texto .= $icon;
					$this->texto .= $item['titulo'] . "</a>";
				}
				$this->generarNivel($item['menuid'], $aNivel+1);
			}

			elseif ($item['ruta']=='/') {
				$this->texto .= "<a href='" . $item['ruta'] . "'>";
				if ($item['icono']<>'') $this->texto .= $icon;
				$this->texto .= $item['titulo'] . "</a>";
			}

			else {
				$pos = strpos($item['ruta'], '.index');
				if($pos === false)
					$r = $item['ruta'].'.index';
				else
					$r = $item['ruta'];
				
				$this->texto .= "<a href='" . route($r) . "'>";
				if ($item['icono']<>'') $this->texto .= $icon;
			  $this->texto .= $item['titulo'] . "</a>";
			}
			
			$this->texto .="</li>";
			$primero=false;
		}
		if (!$primero)  $this->texto .= "</ul>";
	}


	function generarMenu($aMenuItems) {
		$padreAnt = 'Primero';
		$k=0;
		
		try{
			foreach($aMenuItems as $m) {
				$m = (object)$m;
				$padreID = (int)$m->padreid;
				if ($padreID<>$padreAnt) $k=0;
				foreach (Config::get('menu::campos') as $key=>$val) {
					$this->matriz[$padreID][$k][$key] = $m->$val;
				}

				$k++;
				$padreAnt = $padreID;
			}

			$this->generarNivel(0,1);
			return View::make('menu::menutemplate')->with('elMenu', $this->texto)->render();
		} catch(\Exception $e){
			return '<div class="alert alert-danger"><strong>Error:</strong> Se ha producido un error con el siguiente mensaje:</div><ul><li>'.$e->getMessage().'</li></ul>';
		}
	}
}
