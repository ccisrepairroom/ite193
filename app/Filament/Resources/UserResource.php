<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Actions\BulkAction;
use Illuminate\Database\Eloquent\Model;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Filament\Tables\Actions\ForceDeleteAction;


class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationGroup = 'User Management';
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?int $navigationSort = 5;
    protected static ?string $pollingInterval = '1s';
    protected static bool $isLazy = false;
    protected static ?string $recordTitleAttribute = 'name';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Name' => $record->name ?? 'Unknown',
            'Email' => $record->email ?? 'Unknown',
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->schema([
                    FileUpload::make('profile_image')
                        ->avatar(),
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('Eg., Claire P. Nakila'),
                    TextInput::make('email')
                        ->email()
                        ->unique(
                            table: User::class, // Specify the model's table
                            column: 'email',    // The column to check uniqueness for
                            ignorable: fn($record) => $record // Ignore the current record during edit
                        )
                        ->validationMessages([
                            'unique' => 'Email already exists',
                        ])
                        ->placeholder('Eg., clairenakila@gmail.com'),
                    TextInput::make('password')
                        ->password()
                        ->confirmed()
                        ->required()
                        ->revealable()
                        ->dehydrateStateUsing(fn($state) => Hash::make($state))
                        ->visible(fn($livewire) => $livewire instanceof Pages\CreateUser),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->requiredWith('password')
                        ->revealable()
                        ->visible(fn($livewire) => $livewire instanceof Pages\CreateUser),
                    TextInput::make('contact_number')
                        ->label('Contact Number')
                        ->required()
                        ->maxLength(11)
                        ->placeholder('11 digits only. Eg., 09918895966')
                        ->numeric()
                        ->validationMessages([
                            'numeric' => 'Only numbers are accepted',
                            'maxLength' => 'Contact number must be exactly 11 digits',
                        ]),
                    Select::make('role_id')
                        ->label('Role')
                        ->required()
                        ->options(Role::pluck('name', 'id')->toArray()),
                ])
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
        
            ->query(User::query())
            ->columns([
                ImageColumn::make('profile_image')
                    ->circular()
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('role_id')
                    ->label('Role')
                    ->getStateUsing(fn($record) => match ($record->role_id) {
                        1 => 'Super Admin',
                        2 => 'Admin',
                        3 => 'Vendor',
                        4 => 'Customer',
                        default => 'Unknown',
                    })
                    ->badge()
                    ->sortable(),
                TextColumn::make('contact_number')
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_frequent_shopper')
                    ->icon(fn($state) => $state ? 'heroicon-o-check' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
               
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkAction::make('delete')
                ->action(fn($records) => $records->each->delete())
                ->requiresConfirmation()
                ->label('Delete Selected'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}