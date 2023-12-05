<?php

namespace App\Livewire;

use App\Models\CreditCode;
use App\Models\Slide;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use DanHarrin\LivewireRateLimiting\WithRateLimiting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\ValidationException;

class CreditRedeemCode extends Component implements HasForms
{
    use InteractsWithForms;
    use WithRateLimiting;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
            ])
            ->statePath('data')
            ->columns(1)
            ->model(Slide::class);
    }

    public function redeem(): void
    {
        try {
            $this->rateLimit(3);
        } catch (TooManyRequestsException $exception) {
            Notification::make()
                ->title(__('Slow down! Please wait another :throttle_seconds seconds to try redeem another code.', [
                    'throttle_seconds' => $exception->secondsUntilAvailable,
                ]))
                ->danger()
                ->send();
            return;
        }

        $data = $this->form->getState();
        $user = auth()->user();

        $creditCode = CreditCode::unredeemed()
            ->where('code', $data['code'])
            ->first();

        if ($creditCode === null) {
            Notification::make()
                ->title(__('Invalid code!'))
                ->danger()
                ->send();
            return;
        }

        $creditCode->redeem($user);

        Notification::make()
            ->title('Redeemed successfully!')
            ->success()
            ->send();
    }

    public function render(): View
    {
        return view('livewire.credit-redeem-code');
    }
}
