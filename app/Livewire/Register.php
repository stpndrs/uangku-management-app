<?php

namespace App\Livewire;

use App\Models\User;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Register extends Component
{
    use InteractsWithForms;

    public User $user;

    public $name = '';
    public $email = '';
    public $password = '';
    public $passwordConfirmation  = '';

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Wizard::make([
                Wizard\Step::make('Personal Information')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->maxLength(50)
                            ->unique(User::class),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->maxLength(50)
                            ->minLength(8)
                            ->same('passwordConfirmation')
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state)),
                        TextInput::make('passwordConfirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required()
                            ->maxLength(50)
                            ->minLength(8)
                            ->dehydrated(false),
                    ])
                    ->columns([
                        'sm' => 2,
                    ])
                    ->columnSpan([
                        'sm' => 2,
                    ])
            ])
                ->columns([
                    'sm' => 1,
                ])
                ->columnSpan([
                    'sm' => 1,
                ])
                ->submitAction(new HtmlString(html: '<button type="submit">Register</button>'))

        ];
    }

    public function register()
    {
        $user = User::create($this->form->getState());
        Filament::auth()->login(user: $user, remember: true);
        return redirect()->intended(Filament::getUrl('filament.pages.dashboard'));
    }

    public function render()
    {
        return view('livewire.register');
    }
}
