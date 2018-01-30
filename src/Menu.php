<?php

namespace Csgt\Menu;

use Config, View, Exception, Request, Route, Session;

class Menu {
	protected $texto;

	function generarMenu($aCollection){
		$this->generarNivel($aCollection, 0);
		return $this->texto;
	}

	function generarNivel($aCollection, $aPadreId) {
		$niveles = $aCollection->where('parent_id', $aPadreId);
		foreach ($niveles as $nivel) {
			if(config('csgtmenu.use_trans')===true) {
				$titulo = trans('csgtmenu::titles.' . $nivel["name"]);
			}
			else {
				$titulo = $nivel["name"];
			}

			$clase = '';
			if ($nivel["route"] <> '') {
				$clase = ((session()->get('menu-selected')==$nivel["route"])?'active':'');
			}
			$tieneHijos = $aCollection->where('parent_id', $nivel["id"])->count()>0;

			if ($tieneHijos) { //Tiene hijos
				$this->texto .= '<li class="treeview ' . ($aPadreId==0?'treeview-padre':'') . '">';
				$this->texto .= "<a href='#'>";

			}
			else {
				$this->texto .= "<li class='" . $clase . "'>";
				$this->texto .= "<a href='" . route($nivel["route"]) . "'>";
			}
			if ($nivel["icon"] <>'') $this->texto .= "<i class='" . $nivel["icon"] . "'></i>";
			$this->texto .= "<span>" . $titulo . "</span>";
			if($tieneHijos) {
				$this->texto .= "<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>";
			}
			$this->texto .= "</a>" . ($tieneHijos?"<ul class='treeview-menu'>":"");

			$this->generarNivel($aCollection, $nivel["id"]);
			$this->texto .= ($tieneHijos?"</ul>":"") . "</li>";
		}
	}
}
