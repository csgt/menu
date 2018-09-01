<?php
namespace Csgt\Menu;

use Route;
use Config;
use Session;

class Menu
{
    protected $texto;

    public function generarMenu($aCollection)
    {
        $this->generarNivel($aCollection, 0);

        return $this->texto;
    }

    public function generarNivel($aCollection, $aPadreId)
    {
        $niveles = $aCollection->where('padreid', $aPadreId);
        foreach ($niveles as $nivel) {
            if (config('csgtmenu.usarLang') === true) {
                $titulo = trans('csgtmenu::titulos.' . $nivel["nombre"]);
            } else {
                $titulo = $nivel["nombre"];
            }

            $clase = '';
            if ($nivel["ruta"] != '') {
                $clase = ((Session::get('menu-selected') == $nivel["ruta"]) ? 'active' : '');
            }
            $tieneHijos = $aCollection->where('padreid', $nivel["menuid"])->count() > 0;

            if ($tieneHijos) {
                //Tiene hijos
                $this->texto .= '<li class="treeview ' . ($aPadreId == 0 ? 'treeview-padre' : '') . '">';
                $this->texto .= "<a href='#'>";

            } else {
                $this->texto .= "<li class='" . $clase . "'>";
                if (!empty($nivel["params"])) {
                    $this->texto .= "<a href='" . route($nivel["ruta"], $nivel["params"]) . "'>";
                } else {
                    $this->texto .= "<a href='" . route($nivel["ruta"]) . "'>";
                }
            }
            if ($nivel["icono"] != '') {
                $this->texto .= "<i class='" . $nivel["icono"] . "'></i>";
            }

            $this->texto .= "<span>" . $titulo . "</span>";
            if ($tieneHijos) {
                $this->texto .= "<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>";
            }
            $this->texto .= "</a>" . ($tieneHijos ? "<ul class='treeview-menu'>" : "");

            $this->generarNivel($aCollection, $nivel["menuid"]);
            $this->texto .= ($tieneHijos ? "</ul>" : "") . "</li>";
        }
    }
}
