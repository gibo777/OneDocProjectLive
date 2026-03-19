<x-slot name="header">
    {{ __('BENEFITS - LEAVE CREDITS GROUP') }}
</x-slot>

<div class="space-y-2">
    <div>
        Server Timezone: <b>{{ $serverTz }}</b> | <b>{{ $serverGmt }}</b>
    </div>
    <div>
        Server Time: <b>{{ $serverTime }}</b>
    </div>
    <br>
    <div>
        User's Timezone:
        <input type="text" readonly class="border p-1" wire:model="userTz" />
    </div>
    <div>
        User's Time:
        <input type="text" readonly class="border p-1" wire:model="userTime" />
    </div>
    <div>
        User GMT:
        <input type="text" readonly class="border p-1" wire:model="userGmt" />
    </div>
    <br>
    <x-jet-button type="button" id="detectTimezone">
        <i class="fa-regular fa-clock"></i>&nbsp;Detect Time
    </x-jet-button>
</div>

<script>
    document.addEventListener('livewire:load', function() {
        $('#detectTimezone').click(function() {
            const tz = Intl.DateTimeFormat().resolvedOptions().timeZone;
            @this.detectUserTimezone(tz);
        });
    });

    window.addEventListener('user-time-detected', event => {
        Swal.fire({
            title: 'Time Log',
            html: `
            <b>Server Timezone:</b> ${event.detail.serverTz} | ${event.detail.serverGmt} <br>
            <b>Server Time:</b> ${event.detail.serverTime} <br><br>
            <b>User Timezone:</b> ${event.detail.userTz} | ${event.detail.userGmt} <br>
            <b>User Time:</b> ${event.detail.userTime} <br>
        `,
            showConfirmButton: true
        });
    });
</script>
