<?php
namespace Csgt\Menu;

class Menu
{
    protected $text;

    public function getMenu($aCollection)
    {
        $this->level($aCollection, null, 0);

        return $this->text;
    }

    private function level($aCollection, $aParent, $depth = 0)
    {
        $levels = $aCollection->where('parent_route', $aParent);
        foreach ($levels as $level) {
            $title = __($level["name"]);
            $class = '';
            if ($level["route"] != '') {
                $class = ((session()->get('menu-selected') == $level["route"]) ? 'active' : '');
            }
            //$hasChildren = $aCollection->where('parent_route', $level["route"])->count() > 0;
            $hasChildren = $level['has_children'];

            if ($hasChildren) {
                $this->text .= "<li class=\"nav-item has-treeview\"" . $this->navMargin($depth) . ">
                    <a href=\"#\" class=\"nav-link\">";

                if ($level["icon"] != "") {
                    $this->text .= "<i class=\"nav-icon " . $level["icon"] . "\"></i>";
                }

                $this->text .= "
                        <p class='ml-2'>
                            " . $title . "
                            <i class=\"nav-arrow fas fa-angle-right right\"></i>
                        </p>
                    </a>
                    <ul class=\"nav nav-treeview\">";

            } else {
                $this->text .= "<li class=\"nav-item\"" . $this->navMargin($depth) . ">";
                if (array_key_exists("params", $level)) {
                    $this->text .= "<a href=\"" . route($level["route"], $level["params"]) . "\" class=\"$class nav-link\">";
                } else {
                    $this->text .= "<a href=\"" . route($level["route"]) . "\" class=\"$class nav-link\">";
                }
                if ($level["icon"] != "") {
                    $this->text .= "<i class=\"nav-icon " . $level["icon"] . "\"></i>";
                }
                $this->text .= "<p>" . $title . "</p>";
                $this->text .= "</a>";
            }

            $this->level($aCollection, $level["route"], $depth + 1);
            $this->text .= ($hasChildren ? "</ul>" : "") . "</li>";
        }
    }

    private function navMargin($depth)
    {
        return " style=\"margin-left: " . ($depth * 15) . "px;\"";
    }
}
