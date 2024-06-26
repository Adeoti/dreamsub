<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PrivateChatResource\Pages;
use App\Filament\Resources\PrivateChatResource\RelationManagers;
use App\Models\PrivateChat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PrivateChatResource extends Resource
{
    protected static ?string $model = PrivateChat::class;
    protected static bool $isDiscovered = false;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = "Messaging";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListPrivateChats::route('/'),
            'create' => Pages\CreatePrivateChat::route('/create'),
            'edit' => Pages\EditPrivateChat::route('/{record}/edit'),
        ];
    }
}
