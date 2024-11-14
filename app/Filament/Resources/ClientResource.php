<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-s-user-group';

    
    protected static ?string $navigationGroup = 'Manage Addons';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make('Create a Client List')
            ->description('Create Clients over here. (*) are Mandatory Fields')
            ->schema([

                TextInput::make('name')->label('Client Name')->required(),

                FileUpload::make('logo')->label('Client logo')->disk('public')->directory('client_logos')->required()
                ->helperText(' Just Drag n Drop images. max Size 200kb. we recommend 50kb file for Speed load.')
                ->image()
                ->imageEditor()
                ->maxSize(200)
                ->uploadingMessage('Uploading image...'),

               
            ])->columnSpan(1)->columns(1),

              
            
           
        ])->columns([
            'default' => 2,
            'sm' => 2,
            'md' => 2,
            'lg' => 2
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->label('Gallery Image'),
                TextColumn::make('name')->label('Title')->searchable(),
                TextColumn::make('created_at')->label('Published On')->dateTime('M j, Y g:i a')->sortable()            

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
