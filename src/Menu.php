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
                $this->text .= "<li class=\"nav-item has-treeview\">
                    <a href=\"#\" class=\"nav-link\">";

                if ($level["icon"] != "") {
                    $this->text .= "<i class=\"nav-icon " . $level["icon"] . "\"></i>";
                }

                $this->text .= "
                        <p>
                            " . $title . "
                            <i class=\"fas fa-angle-left right\"></i>
                        </p>
                    </a>
                    <ul class=\"nav nav-treeview\">";

            } else {
                $this->text .= "<li class=\"nav-item\">";
                if (array_key_exists("params", $level)) {
                    $this->text .= "<a href=\"" . route($level["route"], $level["params"]) . "\" class=\"$class nav-link\">";
                } else {
                    $this->text .= "<a href=\"" . route($level["route"]) . "\" class=\"$class nav-link\">";
                }
                if ($level["icon"] != "") {
                    $this->text .= "<i class=\"nav-icon " . $level["icon"] . "\"></i>";
                } else {
                    $this->text .= "<i class=\"nav-icon far fa-circle\"></i>";
                }
                $this->text .= "<p>" . $title . "</p>";
                $this->text .= "</a>";
            }

            $this->level($aCollection, $level["id"]);
            $this->text .= ($hasChildren ? "</ul>" : "") . "</li>";
        }
    }
}
