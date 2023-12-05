<x-common-layout>
    <div class="grid place-items-center w-full h-full">
        <form action="{{ route('slides.inviteProcess') }}" method="POST" class="max-w-sm flex flex-col gap-4">
            @csrf
            <x-headings.area>
                @lang('app.enter_invite_code')
            </x-headings.area>

            <x-card>
                <p>
                    @lang('app.enter_invite_code_explanation')
                </p>
                <x-inputs.text name="invite_code" label="Invite code" />
                <x-buttons.primary submit>
                    @lang('app.enter_invite_code')
                </x-buttons.primary>
            </x-card>
        </form>
    </div>
</x-common-layout>
