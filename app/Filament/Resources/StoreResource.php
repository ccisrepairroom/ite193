<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StoreResource\Pages;
use App\Filament\Resources\StoreResource\RelationManagers;
use App\Models\Store;
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

use Filament\Forms\Components\TimePicker;



class StoreResource extends Resource
{
    protected static ?string $model = Store::class;
    protected static ?string $navigationGroup = 'Stores Management';
    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';
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
            'location' => $record->location ?? 'Unknown',
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'location'];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                   
                ]),
            FileUpload::make('store_image')
                ->image()
                ->preserveFileNames()
                ->imageEditor(),
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder('Eg., PureGold-Surigao'),
            TextInput::make('location')
                ->required()
                ->maxLength(255)
                ->placeholder('Eg., Alegria, Surigao del Norte'),
            TextInput::make('opening_hours')
                ->required()
                ->placeholder ('Eg., 6:00 AM - 5:00 PM'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->deferLoading()
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(50)
            ->columns([
                ImageColumn::make('store_image')
                    ->square()
                    ->size(100)
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('location')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('opening_hours')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->color('warning'),
                Tables\Actions\EditAction::make(),
                DeleteAction::make()
                ->successNotificationTitle('Store deleted'),
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
            'index' => Pages\ListStores::route('/'),
            //'create' => Pages\CreateStore::route('/create'),
            //'edit' => Pages\EditStore::route('/{record}/edit'),
        ];
    }
}
