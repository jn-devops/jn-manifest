<?php

namespace App\Livewire;

use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class AttendanceForm extends Component implements HasForms
{
    use InteractsWithForms;
    public ?float $latitude = null;
    public ?float $longitude = null;
    public ?array $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->inlineLabel()
                    ->required(),
                Forms\Components\TextInput::make('first_name')
                    ->label('First Name: ')
                    ->required()
                    ->maxLength(255)
                    ->inlineLabel(),
                // Forms\Components\TextInput::make('middle_name')
                //     ->label('Middle Name: ')
                //     ->required()
                //     ->maxLength(255)
                //     ->inlineLabel(),
                Forms\Components\TextInput::make('last_name')
                    ->label('Last Name: ')
                    ->required()
                    ->maxLength(255)
                    ->inlineLabel(),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        dd($this->latitude, $this->longitude);
        //
    }

    public function render(): View
    {
        return view('livewire.attendance-form');
    }
}
