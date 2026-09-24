<?php

namespace Csgt\Menu;

use Session;

class Menu
{
    protected $texto = '';

    public function generarMenu($aCollection)
    {
        $this->texto = '';

        $this->generarNivel($aCollection, 0);

        return $this->texto;
    }

    public function generarNivel($aCollection, $aPadreId)
    {
        $niveles = $aCollection->where('padreid', $aPadreId);

        foreach ($niveles as $nivel) {
            if (config('csgtmenu.usarLang') === true) {
                $titulo = trans('csgtmenu::titulos.'.$nivel['nombre']);
            } else {
                $titulo = $nivel['nombre'];
            }
            
            $hijos = $aCollection->where('padreid', $nivel['menuid']);

            $tieneHijos = $hijos->count() > 0;

            $esActivo = (! empty($nivel['ruta']) && Session::get('menu-selected') == $nivel['ruta']);

            if ($tieneHijos) {
                $hijoActivo = $this->tieneActivo($aCollection, $nivel['menuid']);

                $claseLi = 'nav-item has-treeview';

                if ($esActivo || $hijoActivo) {
                    $claseLi .= ' menu-open';
                }

                $this->texto .= '<li class="'.$claseLi.'">';
                $this->texto .= '<a href="#" class="nav-link">';

                if (! empty($nivel['icono'])) {
                    $this->texto .= '<i class="nav-icon '.e($nivel['icono']).'"></i>';
                }

                $this->texto .= '<p>';
                $this->texto .= e($titulo);
                $this->texto .='<i class="right fas fa-angle-left"></i>';
                $this->texto .= '</p>';
                $this->texto .= '</a>';
                $this->texto .= '<ul class="nav nav-treeview">';

                $this->generarNivel($aCollection, $nivel['menuid']);

                $this->texto .= '</ul>';
                $this->texto .= '</li>';
            } else {
                $clase = 'nav-link';

                if ($esActivo) {
                    $clase .= ' active';
                }

                if (! empty($nivel['ruta'])) {
                    if (! empty($nivel['params'])) {
                        $url = route($nivel['ruta'], $nivel['params']);
                    } else {
                        $url = route($nivel['ruta']);
                    }
                } else {
                    $url = '#';
                }

                $this->texto .= '<li class="nav-item">';

                $this->texto .=
                    '<a class="'.$clase.'" href="'.
                    e($url).
                    '">';

                if (! empty($nivel['icono'])) {
                    $this->texto .= '<i class="nav-icon '.e($nivel['icono']).'"></i>';
                }

                $this->texto .='<p>'.e($titulo).'</p>';
                $this->texto .= '</a>';
                $this->texto .= '</li>';
            }
        }
    }

    protected function tieneActivo($aCollection, $padreId)
    {
        $hijos = $aCollection->where('padreid', $padreId);

        foreach ($hijos as $hijo) {
            if (! empty($hijo['ruta']) && Session::get('menu-selected') == $hijo['ruta']) {
                return true;
            }

            $tieneHijos = $aCollection->where('padreid', $hijo['menuid'])->count() > 0;

            if ($tieneHijos) {
                if ($this->tieneActivo($aCollection, $hijo['menuid'])) {
                    return true;
                }
            }
        }

        return false;
        
    }
}
