<x-jet-confirmation-modal wire:model="confirmingApplicationDeletion">
    <x-slot name="title">
        Delete Application
    </x-slot>

    <x-slot name="content">
        Are you sure you want to delete this application? Once your applications is deleted, all of the messages associated with it will be permanently deleted.
    </x-slot>

    <x-slot name="footer">
        <x-jet-secondary-button wire:click="$toggle('confirmingApplicationDeletion')" wire:loading.attr="disabled">
            Nevermind
        </x-jet-secondary-button>

        <x-jet-danger-button class="ml-2" wire:click="delete" wire:loading.attr="disabled">
            Delete Application
        </x-jet-danger-button>
    </x-slot>
</x-jet-confirmation-modal>
