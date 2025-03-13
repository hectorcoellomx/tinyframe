<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteConfirmation extends Component
{
    public $actionUrl; // URL para enviar el formulario de eliminación
    public $itemName;  // Nombre del elemento a eliminar (opcional)
    public $itemId;  

    /**
     * Create a new component instance.
     *
     * @param string $actionUrl
     * @param string $itemName
     */
    public function __construct($actionUrl, $itemName = null, $itemId)
    {
        $this->actionUrl = $actionUrl;
        $this->itemName = $itemName;
        $this->itemId = $itemId;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.delete-confirmation');
    }
}