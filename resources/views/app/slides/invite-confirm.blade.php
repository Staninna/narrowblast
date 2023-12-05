<x-common-layout>
    <div class="grid place-items-center w-full h-full">
        <form action="{{ route('slides.inviteConfirm') }}" method="POST" class="max-w-sm flex flex-col gap-4">
            @csrf
            <input type="hidden" name="invite_code" value="{{ $inviteSystem->latest_code }}">
            <x-headings.area>
                @lang('app.confirm_invite_code')
            </x-headings.area>

            <x-card>
                @if($inviteSystem->entry_fee_in_credits <= auth()->user()->credits)
                    <p>
                        @lang('app.confirm_invite_code_intro', ['user' => $inviteSystem->user->name])
                    </p>
                    <p class="font-bold">
                        @lang('app.confirm_invite_code_entry_fee', ['credits' => $inviteSystem->entry_fee_in_credits])
                    </p>
                    <p>
                        @lang('app.confirm_invite_code_confirm')
                    </p>
                    <div class="mt-4 flex flex-col gap-4">
                        <x-buttons.danger submit>
                            @lang('app.confirm_invite_code_confirm_yes', ['credits' => $inviteSystem->entry_fee_in_credits])
                        </x-buttons.danger>
                        <x-buttons.primary big href="{{ route('slides.inviteEnter') }}">
                            @lang('app.confirm_invite_code_confirm_no')
                        </x-buttons.primary>
                    </div>
                @else
                    <p>
                        @lang('app.confirm_invite_code_not_enough_credits', ['credits' => $inviteSystem->entry_fee_in_credits, 'user_credits' => $inviteSystem->user->credits])
                    </p>
                    <div class="mt-4 flex flex-col gap-4">
                        <x-buttons.primary big href="{{ route('home') }}">
                            @lang('app.confirm_invite_code_take_me_back')
                        </x-buttons.primary>
                    </div>
                @endif
            </x-card>
        </form>
    </div>
</x-common-layout>
