<?php
namespace Csgt\Menu;

class Menu
{
    protected $text;

    public function getMenu($aCollection)
    {
        $this->level($aCollection, null);

        return $this->text;
    }

    private function level($aCollection, $aParent)
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
                $this->text .= "<li class=\"nav-item has-treeview\">
                    <a href=\"#\" class=\"nav-link\">";

                if ($level["icon"] != "") {
                    $this->text .= "<i class=\"nav-icon " . $level["icon"] . "\"></i>";
                }

                $this->text .= "
                        <p>
                            " . $title . "
                            <i class=\"nav-arrow fas fa-angle-right right\"></i>
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
                }
                $this->text .= "<p>" . $title . "</p>";
                $this->text .= "</a>";
            }

            $this->level($aCollection, $level["route"]);
            $this->text .= ($hasChildren ? "</ul>" : "") . "</li>";
        }
    }
}
