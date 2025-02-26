<?php

namespace App\View\Components\layouts;

use Illuminate\View\Component;

class ItemSidebar extends Component
{
    public $icon;
    public $link;

    public $children;

    public function __construct(string $icon = '', string $link = null, array $children = null)
    {
        $this->icon = $icon;
        $this->link = $link;
        $this->children = $children;
    }

    public function render()
    {
        return view('components.layouts.item-sidebar');
    }
}
