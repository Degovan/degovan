<?php

namespace App\Filament\Resources\AboutResource\Pages;

use App\Filament\Resources\AboutResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAbout extends EditRecord
{
    protected static string $resource = AboutResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
