<?php

namespace App\Filament\Auth;

use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Pages\Auth\Register as AuthRegister;
use Filament\Forms\Components\FileUpload;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\FrequentShopper;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Facades\Redirect;



class Register extends AuthRegister
{
    public function form(Form $form): Form
    {
        return $form->schema([
            FileUpload::make('profile_image')
                ->avatar(),
            
            // Use Filament's existing form components
            $this->getNameFormComponent()
            ->required()
            ->placeholder('Eg., Claire P. Nakila'),
            $this->getEmailFormComponent()
            ->required()
            ->unique()
            ->validationMessages([
                'unique' => 'Email already exist',
               
            ])
            ->placeholder('Eg., clairenakila@gmail.com'),
            $this->getPasswordFormComponent()
            ->required()
            ->placeholder('Must be atleast 8 characters')
            ->minLength(8)
            ->validationMessages([
                'minLength' => 'Must be atleast 8 characters', 
            ]),
            $this->getPasswordConfirmationFormComponent()
            ->required(),

            // Add custom fields
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
                ->options(function () {
                    // Only return vendor (role_id = 3) and customer (role_id = 4)
                    return Role::whereIn('id', [3, 4])->pluck('name', 'id');
                })
                ->afterStateUpdated(function ($state) {
                    // Automatically set the role_id to 3 (vendor) or 4 (customer) based on the selection
                    if ($state == 3) {
                        return 3;  // Set role_id to 3 for vendor
                    } elseif ($state == 4) {
                        return 4;  // Set role_id to 4 for customer
                    }
                })
                ->preload()
                ->required()
                ->reactive()
                ->searchable(),

            Select::make('is_frequent_shopper')
                ->label('Apply Frequent Shopper Program?')
                ->reactive()
                ->options([
                    1 => 'Yes',
                    0 => 'No',
                ])
                ->default(0) // Default to "No"
                ->visible(fn (callable $get) => $get('role_id') == 4)
                ->required(),
            Select::make('frequent_shopper.is_anonymous')
                ->label('Remain as Anonymous Frequent Shopper?')
                ->reactive()
                ->options([
                    1 => 'Yes',
                    0 => 'No',
                ])
                ->visible(fn($get) => $get('is_frequent_shopper') == 1) // Conditional visibility                
                ->required(),
           

        ])
        ->statePath('data');
    }

    protected function onSubmit(array $data): void
    {
        $user = auth()->user();
        // Create the user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'contact_number' => $data['contact_number'],
            'is_frequent_shopper' => $data['is_frequent_shopper'],
            'role_id' => $data['role_id'],

        ]);
        
        

        // Assign roles to the user using assignRole
        if (isset($data['role_id'])) {
            $user->assignRole($data['role_id']); // Automatically assigns the role based on role_id
        }
        $frequentShopper = FrequentShopper::firstOrCreate(
            ['user_id' => $user->id], // Check if a record already exists for this user
            [
                'is_anonymous' => $data['frequent_shopper'], // Default to 0 if not provided
                'username' => $data['frequent_shopper'], // Handle anonymous or username
                'total_spent' => 0, // Initialize total spent
                'point_balance' => 0, // Initialize point balance
                'membership_date' => now(), // Set the current date as the membership date
                'status' => 0, // Default to inactive (0)
            ]
            );
    

        // Log in the user
        auth()->login($user);
        
    }
}