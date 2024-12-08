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
use Filament\Forms\Components\Grid;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Filament\Support\Enums\VerticalAlignment;

use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\DeleteAction;




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
        
        return $form
        
        
        ->schema([
            Grid::make([
                'default' => 1,
                'sm' => 2,
                'md' => 3,
                'lg' => 4,
                'xl' => 6,
                '2xl' => 8,
            ]),
            Section::make()
                ->schema([
                    FileUpload::make('profile_image')
                        ->avatar()
                        ->preserveFileNames(),
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
                        ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                    TextInput::make('password_confirmation')
                        ->password()
                        ->requiredWith('password')
                        ->revealable(),
                    TextInput::make('contact_number')
                        ->label('Contact Number')
                        ->required()
                        ->tel()
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
            ->deferLoading()
            ->paginated([10, 25, 50, 100, 'all'])
            ->defaultPaginationPageOption(50)
           
            ->query(User::query())
            ->columns([
                ImageColumn::make('profile_image')
                    ->circular()
                
                    ->toggleable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable()
                    ->weight('bold'),
                TextColumn::make('email')
                    ->searchable()
                    ->toggleable()
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
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('contact_number')
                    ->searchable()
                    ->toggleable()
                    ->grow(false)
                    ->sortable(),
                IconColumn::make('is_frequent_shopper')
                    ->icon(fn($state) => $state ? 'heroicon-o-check' : 'heroicon-o-x-circle')
                    ->color(fn($state) => $state ? 'success' : 'danger')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable()
                    ->sortable(),
                
            ])
            ->filters([
               
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->color('warning'),
                Tables\Actions\EditAction::make(),
                //->slideOver(),
                DeleteAction::make()
                ->successNotificationTitle('User deleted'),
                ForceDeleteAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            //'create' => Pages\CreateUser::route('/create'),
            //'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}