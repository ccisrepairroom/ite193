<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubProductTypeResource\Pages;
use App\Filament\Resources\SubProductTypeResource\RelationManagers;
use App\Models\SubProductType;
use App\Models\ProductType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Forms\Components\Grid;
use Spatie\Permission\Models\Role;
use Filament\Tables\Columns\Layout\Stack;
use Carbon\Carbon;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\DeleteAction;

class SubProductTypeResource extends Resource
{
    protected static ?string $model = SubProductType::class;
    protected static ?string $navigationGroup = 'Stores Management';
    protected static ?string $navigationIcon = 'tabler-category-plus';
    protected static ?int $navigationSort = 5;
    protected static ?string $pollingInterval = '1s';
    protected static bool $isLazy = false;
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Name' => $record->name ?? 'Unknown',
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                   
                ]),
                TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder('Eg., Pepsi'),
                Select::make('product_type_id')
                ->label('Main Product Type')
                ->required()
                ->multiple()  // Allow multiple selections
                ->options(
                    ProductType::all()->pluck('name', 'id')->toArray()  // Proper format for options
                )
                ->searchable()
                ->placeholder('Eg., Pepsi')
                ->createOptionUsing(fn($data) => ProductType::create(['name' => $data['name']]))  // Handle new product type creation
                ->createOptionForm([
                    Forms\Components\TextInput::make('name')
                        ->label('Create New Main Product Type')
                        ->placeholder('Eg., Pepsi')
                        ->required()
                        ->maxLength(255),
                
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(50)
            ->columns([
                Stack::make ([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('product_type_id')
                    ->label('Main Product Type')
                    ->searchable()
                    ->sortable()
                    ->getStateUsing(fn ($record) => $record->productType ? $record->productType->name : 'N/A')
                    ->toggleable(),
                    ])
                   
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->color('warning'),
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
                ->successNotificationTitle('Sub-Product Type deleted'),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                ->action(fn($records) => $records->each->delete())
                ->requiresConfirmation()
                ->color('danger')
                ->label('Delete Selected'),
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
            'index' => Pages\ListSubProductTypes::route('/'),
           //'create' => Pages\CreateSubProductType::route('/create'),
            //'edit' => Pages\EditSubProductType::route('/{record}/edit'),
        ];
    }
}
