<?php

namespace App\Livewire;

use App\Models\Attendance;
use Livewire\Component;

class MapComponent extends Component
{
    public ?Attendance $record = null;
    public function render()
    {
        return view('livewire.map-component');
    }
}
