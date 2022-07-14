<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContributorResource\Pages;
use App\Models\Contributor;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContributorResource extends Resource
{
    protected static ?string $model = Contributor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->disk('cdn')
                    ->directory('contributors'),
                Forms\Components\TextInput::make('role')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('quotes')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('photo'),
                Tables\Columns\TextColumn::make('role'),
                Tables\Columns\TextColumn::make('quotes'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListContributors::route('/'),
            'create' => Pages\CreateContributor::route('/create'),
            'edit' => Pages\EditContributor::route('/{record}/edit'),
        ];
    }
}
