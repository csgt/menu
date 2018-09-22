<?php
namespace Csgt\Menu;

use Route;
use Config;
use Session;

class Menu
{
    protected $text;

    public function getMenu($aCollection)
    {
        $this->level($aCollection, 0);

        return $this->text;
    }

    private function level($aCollection, $aParentId)
    {
        $levels = $aCollection->where('parent_id', $aParentId);
        foreach ($levels as $level) {
            if (config('csgtmenu.use_trans') === true) {
                $title = trans('csgtmenu::titles.' . $level["name"]);
            } else {
                $title = $level["name"];
            }

            $class = '';
            if ($level["route"] != '') {
                $class = ((session()->get('menu-selected') == $level["route"]) ? 'active' : '');
            }
            $hasChildren = $aCollection->where('parent_id', $level["id"])->count() > 0;

            if ($hasChildren) {
                $this->text .= '<li class="treeview ' . ($aParentId == 0 ? 'treeview-padre' : '') . '">';
                $this->text .= "<a href='#'>";

            } else {
                $this->text .= "<li class='" . $class . "'>";
                if (array_key_exists("params", $level)) {
                    $this->text .= "<a href='" . route($level["route"], $level["params"]) . "'>";
                } else {
                    $this->text .= "<a href='" . route($level["route"]) . "'>";
                }
            }
            if ($level["icon"] != '') {
                $this->text .= "<i class='" . $level["icon"] . "'></i>";
            }

            $this->text .= "<span>" . $title . "</span>";
            if ($hasChildren) {
                $this->text .= "<span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>";
            }
            $this->text .= "</a>" . ($hasChildren ? "<ul class='treeview-menu'>" : "");

            $this->level($aCollection, $level["id"]);
            $this->text .= ($hasChildren ? "</ul>" : "") . "</li>";
        }
    }
}
