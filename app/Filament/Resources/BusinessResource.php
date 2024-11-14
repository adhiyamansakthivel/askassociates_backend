<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BusinessResource\Pages;
use App\Filament\Resources\BusinessResource\RelationManagers;
use App\Models\Business;
use Doctrine\DBAL\Schema\Column;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BusinessResource extends Resource
{
    protected static ?string $model = Business::class;

    protected static ?string $navigationIcon = 'heroicon-s-building-storefront';

    protected static ?string $navigationLabel = 'Manage Store Profile';



    public static function form(Form $form): Form
    {
        return $form
        ->schema([

            Section::make('Store Logo')
            ->schema([
                FileUpload::make('logo')->label('Store Logo')->disk('public')->directory('store_logo')->required()
                ->helperText(' Just Drag n Drop images. max Size 100kb. we recommend 50kb file for Speed load.')
                ->image()
                ->imageEditor()
                ->uploadingMessage('Uploading image...'),

            ]),

            Section::make('Store Profile')
            ->description('Create Details over here. (*) are Mandatory Fields')
            ->schema([
                
                TextInput::make('name')->label('Store Name')->required()->prefixIcon('heroicon-s-building-storefront'),

                TextInput::make('email')->email()->required()
                ->helperText('Contact Email')->prefixIcon('heroicon-s-at-symbol'),

                TextInput::make('phone_one')->label('Primary Number')->required()->tel() ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')->minLength(10)->maxLength(10)->prefixIcon('heroicon-s-phone'),

                TextInput::make('phone_two')->label('Secondary Number')->tel() ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')->minLength(10)->maxLength(10)->prefixIcon('heroicon-s-phone'),
                
                TextInput::make('whatsapp')->label('whatsapp')->tel() ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')->minLength(10)->maxLength(10)->prefixIcon('heroicon-s-device-phone-mobile'),

                TextInput::make('gst_number')->label('GST No.')->helperText('GST Number')->prefixIcon('heroicon-s-banknotes'),

                ])->columns(2),

                Section::make('Store Address')
                ->schema([ 
                                                         
                    Textarea::make('address')->minLength(2)
                    ->maxLength(200)->label('address')
                    ->required(),

                    Textarea::make('map')->label('Google Map'),

                ]),
               

                Section::make('Store Working Hours')
                ->schema([ 
                
                Repeater::make('open_hours')->label('Working Hours')
                ->schema([
                        
                        TextInput::make('days')->label('Day')->required(),

                        Select::make('status')
                        ->options([
                            'open' => 'Open',
                            'closed' => 'Closed'
                        ])->default('open')
                        ->required(),

                    Select::make('open')->label('Opening time')
                        ->options([
                            '12:00AM' => '12:00AM',
                            '1:00AM' => '1:00AM',
                            '2:00AM' => '2:00AM',
                            '3:00AM' => '3:00AM',
                            '4:00AM' => '4:00AM',
                            '5:00AM' => '5:00AM',
                            '6:00AM' => '6:00AM',
                            '7:00AM' => '7:00AM',
                            '8:00AM' => '8:00AM',
                            '9:00AM' => '9:00AM',
                            '10:00AM' => '10:00AM',
                            '11:00AM' => '11:00AM',
                            '12:00PM' => '12:00PM',
                            '1:00PM' => '1:00PM',
                            '2:00PM' => '2:00PM',
                            '3:00PM' => '3:00PM',
                            '4:00PM' => '4:00PM',
                            '5:00PM' => '5:00PM',
                            '6:00PM' => '6:00PM',
                            '7:00PM' => '7:00PM',
                            '8:00PM' => '8:00PM',
                            '9:00PM' => '9:00PM',
                            '10:00PM' => '10:00PM',
                            '11:00PM' => '11:00PM',
                        ]),

                        Select::make('close')->label('Closing time')
                        ->options([
                            '12:00AM' => '12:00AM',
                            '1:00AM' => '1:00AM',
                            '2:00AM' => '2:00AM',
                            '3:00AM' => '3:00AM',
                            '4:00AM' => '4:00AM',
                            '5:00AM' => '5:00AM',
                            '6:00AM' => '6:00AM',
                            '7:00AM' => '7:00AM',
                            '8:00AM' => '8:00AM',
                            '9:00AM' => '9:00AM',
                            '10:00AM' => '10:00AM',
                            '11:00AM' => '11:00AM',
                            '12:00PM' => '12:00PM',
                            '1:00PM' => '1:00PM',
                            '2:00PM' => '2:00PM',
                            '3:00PM' => '3:00PM',
                            '4:00PM' => '4:00PM',
                            '5:00PM' => '5:00PM',
                            '6:00PM' => '6:00PM',
                            '7:00PM' => '7:00PM',
                            '8:00PM' => '8:00PM',
                            '9:00PM' => '9:00PM',
                            '10:00PM' => '10:00PM',
                            '11:00PM' => '11:00PM',
                        ]),

                       

                ])->reorderableWithDragAndDrop(false)  
                 ->maxItems(7)->deletable(false)->columns(4)

                    ]),

               
                // TextInput::make('title')->label('Title')
        
            
            
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo'),
                TextColumn::make('name')->label('Store Name'),
                TextColumn::make('email')->label('Contact Email'),
                TextColumn::make('phone_one')->label('Primary Mobile'),
                TextColumn::make('whatsapp')->label('Whatsapp Number'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                   // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListBusinesses::route('/'),
             'create' => Pages\CreateBusiness::route('/create'),
            'edit' => Pages\EditBusiness::route('/{record}/edit'),
        ];
    }
}
