<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Howdu\FilamentRecordSwitcher\Filament\Concerns\HasRecordSwitcher;
use STS\FilamentImpersonate\Pages\Actions\Impersonate;

class EditUser extends EditRecord
{
    use HasRecordSwitcher;

    protected static string $resource = UserResource::class;



    protected function getHeaderActions(): array
    {
        return [
            Impersonate::make()->record($this->getRecord()) ,
            Actions\DeleteAction::make(),
        ];
    }

}
