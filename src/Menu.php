<?php 

namespace Csgt\Menu;
use Config, View, Exception;

class Menu {
	
	protected $texto;
	protected $matriz;

	function generarNivel($aID, $aNivel) {
		$primero = true;
		foreach ($this->matriz[$aID] AS $item) {
			switch ($aNivel) {
				case 1:
					$estiloUL = 'nav navbar-nav';
					$estiloLI  = '';
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

			if(config('csgtmenu.usarLang')===true) {
				$titulo = trans('csgtmenu::titulos.' . $item['titulo']);
			}
			else {
				$titulo = $item['titulo'];
			}
			
			if ($item['padreid']) {

			}

			$this->texto .= "<li class='csgtmenu" . $item['menuid'] . ($item['ruta']==''?" " . $estiloLI :"") . "'>";
			
			$icon = "<i class=\"" . $item['icono'] . "\"></i>";
			
			if ($item['ruta']=='') {
				if ($aNivel==1) {
					$this->texto .= "<a href='#'>";
					if ($item['icono']<>'') $this->texto .= $icon;
					$this->texto .= $titulo . "<b class='caret'></b></a>";
				}
				else {
					$this->texto .= "<a tabindex='-1' href='#'>";
					if ($item['icono']<>'') $this->texto .= $icon;
					$this->texto .= $titulo . "</a>";
				}
				$this->generarNivel($item['menuid'], $aNivel+1);
			}

			elseif ($item['ruta']=='/') {
				$this->texto .= "<a href='" . $item['ruta'] . "'>";
				if ($item['icono']<>'') $this->texto .= $icon;
				$this->texto .= $titulo . "</a>";
			}

			else {
				$this->texto .= "<a href='" . route($item['ruta']) . "'>";
				if ($item['icono']<>'') $this->texto .= $icon;
			  $this->texto .= $titulo . "</a>";
			}
			
			$this->texto .="</li>";
			$primero=false;
		}
	}

	function generarMenu($aCollection) {
		$tops = $aCollection->where('padreid', 0);
		foreach ($tops as $top) {
			if(config('csgtmenu.usarLang')===true) {
				$titulo = trans('csgtmenu::titulos.' . $top["nombre"]);
			}
			else {
				$titulo = $top["nombre"];
			}

			$tieneHijos = $aCollection->where('padreid', $top["menuid"])->count()>0;

			if ($tieneHijos) { //Tiene hijos
				$this->texto .= '<li class="treeview">';
				$this->texto .= "<a href='#'>";
					
			}
			else {
				$this->texto .= "<li>";
				$this->texto .= "<a href='" . route($top["ruta"]) . "'>";
			}
			if ($top["icono"] <>'') $this->texto .= "<i class='" . $top["icono"] . "'></i>";
			$this->texto .= "<span>" . $titulo . "</span>";
			if($tieneHijos) {
				$this->texto .= "<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>";
			}
			$this->texto .= "</a>";
			$this->texto .= "</li>";
		}
		return $this->texto;
		// $a = $tops->map(
		// 	function($menuItem) use ($aCollection){
		// 		$collectionMenuItem = collect($menuItem);
		// 		dd($collectionMenuItem);
		// 		return $collectionMenuItem->put('hijos', collect($aCollection->where('padreid', $collectionMenuItem->menuid)));	
		// 	}
		// );

		//dd($a);

		/*
		$padreAnt = 'Primero';
		$k=0;
		if (sizeof($aMenuItems)==0) 
			return view('layouts.menu')->with('elMenu', '&nbsp;')->render();

			foreach($aMenuItems as $m) {
				$m = (object)$m;
				$padreID = (int)$m->padreid;
				if ($padreID<>$padreAnt) $k=0;
				foreach (config('csgtmenu.campos') as $key=>$val) {
					$this->matriz[$padreID][$k][$key] = $m->$val;
				}

				$k++;
				$padreAnt = $padreID;
			}

			$this->generarNivel(0,1);
			dd($this->texto);
			return view('layouts.menu')->with('elMenu', $this->texto)->render();
			*/
	}
}