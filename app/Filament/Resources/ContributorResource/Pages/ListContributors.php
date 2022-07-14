<?php

namespace App\Filament\Resources\ContributorResource\Pages;

use App\Filament\Resources\ContributorResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListContributors extends ListRecords
{
    protected static string $resource = ContributorResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
