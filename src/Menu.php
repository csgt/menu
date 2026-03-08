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
            $title       = __($level["name"]);
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
                            <i class=\"nav-arrow bi bi-chevron-right\"></i>
                        </p>
                    </a>
                    <ul class=\"nav nav-treeview\">";

            } else {
                $this->text .= "<li class=\"nav-item\"" . $this->navMargin($depth) . ">";
                $this->text .= '<a href="' . route($level['route'], $level['params'] ?? []) . "\" class=\"nav-link\">";
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
