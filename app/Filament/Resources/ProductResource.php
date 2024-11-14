<?php

namespace App\Filament\Resources;

use App\Enums\ProductStatusEnum;
use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TagsInput;
use Illuminate\Support\Carbon;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\HtmlString;
use Str;
use Filament\Forms\Set;
use Filament\Forms\Get;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-s-bolt';

    protected static ?string $navigationGroup = 'Manage Products';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            
            Section::make('Product Images')
            ->schema([
                FileUpload::make('product_images')->label('Product Images')->multiple()->disk('public')->directory('product_images')->required()
                ->helperText('upload one or more upto 5, product images , Just Drag n Drop images. max Size 200kb. we recommend 50kb file for Speed load.')
                ->image()
                ->minFiles(1)
                ->maxFiles(5)
                ->imageEditor()
                ->reorderable()
                ->uploadingMessage('Uploading image...'),

            ]),

            Section::make('Create a Product')
            ->description('Create product over here. (*) are Mandatory Fields')
            ->schema([

                TextInput::make('title')->label('Product Name')->required()->unique(ignoreRecord: true)
                 ->helperText('We recommend Title length must be 50 to 60 charcters maximum.'),

                Select::make('brand_id')->label('Brand')
                ->live()
                ->preload()
                ->searchable()
                ->relationship('brand', 'name')
                ->reactive(),
               
                
                Select::make('category_id')->label('Category')
                ->preload()
                ->searchable()
                ->relationship('category', 'name')->required()
                ->afterStateUpdated(fn(Set $set)=>$set('subcategory_id', null))->required(),
                
                Select::make('subcategory_id')->label('Sub Category')
                ->preload()
                ->live()
                ->searchable()
                ->relationship(name:'subcategory', titleAttribute:'name',
                    modifyQueryUsing: fn(Builder $query, Get $get) => $query
                    ->when($get('category_id') != '', function(Builder $query) use($get) {
                        $query->whereHas('category', fn(Builder $query) => $query
                        ->where('categories.id', $get('category_id')));
                    }),
                                    
                ),

                Fieldset::make()
                ->schema([
                    TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->inputMode('decimal')
                    ->prefixIcon('heroicon-o-currency-rupee'),
    
                    Select::make('price_per')->label('Price /')
                        ->options([
                            'Piece' => 'Piece',
                            'Bag' => 'Bag',
                            'Ton' => 'Ton',
                            'Kg' =>  'Kg',
                            'Cubic Meter' => 'Cubic Meter'
                        
                        ])
                        ->native(false)
                        

                ])->columns(1)->columns(2),

                
                   


           
            ])->columnSpan(1)->columns(1),

           

           
            Group::make()->schema([

                Section::make('Available Status')
                ->schema([
                    ToggleButtons::make('status')
                    ->translateLabel()
                    ->required()
                    ->options(ProductStatusEnum::class)
                    ->enum(ProductStatusEnum::class)->default('available'),

                ])->columnSpan(1),

                TagsInput::make('tags')->splitKeys(['Tab', ','])->helperText('Ex: Cements, bricks, sand. Note(click: Tab or Comma )'),


               
            ]),   
            
            Section::make('Product Broucher')
            ->schema([
                FileUpload::make('product_broucher')->label('Product Broucher')->disk('public')->directory('product_document')
                ->helperText('Please upload .pdf format file.')
                ->acceptedFileTypes(['application/pdf'])
                ->preserveFilenames()                
                ->downloadable(),

            ]),


            RichEditor::make('description')->label('Description')
            ->toolbarButtons([
                'blockquote',
                'bold',
                'bulletList',
                'codeBlock',
                'h2',
                'h3',
                'italic',
                'link',
                'orderedList',
                'redo',
                'strike',
                'underline',
                'undo',
            ])
            ->required()->columnSpan([
                'sm' => 1,
                'md' => 1,
                'lg' => 2
            ]),
           
           
        ])->columns([
            'sm' => 1,
            'md' => 1,
            'lg' => 2
        ]);


    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('product_images')->limit(1),
                TextColumn::make('title')->label('Title')->sortable()->searchable(isIndividual: true),
                TextColumn::make('product_url')->label('slug'),
                TextColumn::make('brand.name')->label('Brand')->searchable(isIndividual: true),
                TextColumn::make('category.name')->label('Category')->searchable(isIndividual: true),
                TextColumn::make('subcategory.name')->label('Sub Category')->searchable(isIndividual: true),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')->label('Published On')->dateTime('M j, Y g:i a')->sortable()
            ])->defaultSort('created_at', 'desc')

            ->filters([
                SelectFilter::make('brand_id')
                ->label('Brand')
                ->relationship('brand', 'name')
                ->searchable()
                ->preload()
                ->multiple(),

                SelectFilter::make('category_id')
                ->label('Category')
                ->relationship('category', 'name')
                ->searchable()
                ->preload()
                ->multiple(),


                SelectFilter::make('subcategory_id')
                ->label('Sub Category')
                ->relationship('subcategory', 'name')
                ->searchable()
                ->preload()
                ->multiple(),


                Filter::make('created_at')
                ->form([
                    DatePicker::make('from'),
                    DatePicker::make('until'),
                ])
                ->indicateUsing(function (array $data): array {
                    $indicators = [];
             
                    if ($data['from'] ?? null) {
                        $indicators[] = Indicator::make('Created from ' . Carbon::parse($data['from'])->toFormattedDateString())
                            ->removeField('from');
                    }
             
                    if ($data['until'] ?? null) {
                        $indicators[] = Indicator::make('Created until ' . Carbon::parse($data['until'])->toFormattedDateString())
                            ->removeField('until');
                    }
             
                    return $indicators;
                })
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['from'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        )
                        ->when(
                            $data['until'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                        );
                })
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
