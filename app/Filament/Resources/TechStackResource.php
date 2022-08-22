<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TechStackResource\Pages;
use App\Models\TechStack;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class TechStackResource extends Resource
{
    protected static ?string $model = TechStack::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('font')
                            ->prefix('fa-brands fa-')
                            ->required()
                            ->placeholder('laravel'),
                ColorPicker::make('color')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('font'),
                TextColumn::make('color'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTechStacks::route('/'),
            'create' => Pages\CreateTechStack::route('/create'),
            'edit' => Pages\EditTechStack::route('/{record}/edit'),
        ];
    }
}
