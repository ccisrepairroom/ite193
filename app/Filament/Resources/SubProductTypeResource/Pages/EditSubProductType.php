<?php

namespace App\Filament\Resources\SubProductTypeResource\Pages;

use App\Filament\Resources\SubProductTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSubProductType extends EditRecord
{
    protected static string $resource = SubProductTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
