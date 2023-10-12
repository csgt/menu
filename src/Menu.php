<?php
namespace Csgt\Menu;

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
                $clase = ((Session::get('menu-selected') == $nivel["ruta"]) ? 'nav-link active' : 'nav-link');
            }
            $tieneHijos = $aCollection->where('padreid', $nivel["menuid"])->count() > 0;

            if ($tieneHijos) {
                //Tiene hijos
                $this->texto .= '<li class="nav-item has-treeview">';
                $this->texto .= "<a href='#' class='nav-link'>";

            } else {
                $this->texto .= "<li class=\"nav-item\">";
                if (!empty($nivel["params"])) {
                    $this->texto .= "<a class='" . $clase . "' href='" . route($nivel["ruta"], $nivel["params"]) . "'>";
                } else {
                    $this->texto .= "<a class='" . $clase . "' href='" . route($nivel["ruta"]) . "'>";
                }
            }
            if ($nivel["icono"] != '') {
                $this->texto .= "<i class='nav-icon " . $nivel["icono"] . "'></i>";
            }

            $this->texto .= "<p>" . $titulo . "</p>";
            if ($tieneHijos) {
                $this->texto .= "<p><i class='fas fa-angle-right right'></i></p>";
            }
            $this->texto .= "</a>" . ($tieneHijos ? "<ul class='nav nav-treeview'>" : "");

            $this->generarNivel($aCollection, $nivel["menuid"]);
            $this->texto .= ($tieneHijos ? "</ul>" : "") . "</li>";
        }
    }
}
