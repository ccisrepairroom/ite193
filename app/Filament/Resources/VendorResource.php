<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VendorResource\Pages;
use App\Filament\Resources\VendorResource\RelationManagers;
use App\Models\Vendor;
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
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\DeleteAction;

class VendorResource extends Resource
{
    protected static ?string $model = Vendor::class;

    protected static ?string $navigationIcon = 'ionicon-man-outline';
    protected static ?string $navigationGroup = 'Stores Management';
    protected static ?int $navigationSort = 5;
    protected static ?string $pollingInterval = '1s';
    protected static bool $isLazy = false;

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
            FileUpload::make('vendor_image')
                ->image()
                ->preserveFileNames()
                ->imageEditor(),
            TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->placeholder('Eg., Magnolia-Surigao'),
            TextInput::make('contact_number')
                ->required()
                ->tel()
                ->placeholder('Eg., Magnolia-Surigao'),
            TextInput::make('location')
                ->required()
                ->maxLength(255)
                ->placeholder('Eg., Alegria, Surigao del Norte'),
                
            
                
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
                    ->width(100)
                    ->height(100)
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('contact_number')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('location')
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
                ->successNotificationTitle('Vendor deleted'),
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
            'index' => Pages\ListVendors::route('/'),
           // 'create' => Pages\CreateVendor::route('/create'),
           //'edit' => Pages\EditVendor::route('/{record}/edit'),
        ];
    }
}
