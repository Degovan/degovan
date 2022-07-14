<?php

namespace App\Filament\Resources\ContributorResource\Pages;

use App\Filament\Resources\ContributorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditContributor extends EditRecord
{
    protected static string $resource = ContributorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
