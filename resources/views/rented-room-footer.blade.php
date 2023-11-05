<x-tables::row>
    <x-tables::cell
            wire:loading.remove.delay
            wire:target="{{ implode(',', \Filament\Tables\Table::LOADING_TARGETS) }}"
        >
                <div class="filament-tables-column-wrapper" style="position: relative;">
                    <div class="filament-tables-text-column px-4 py-2 flex w-full justify-end text-end" style="position: relative; bottom: 0; right: 0;">
                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                            <span class="font-medium">
                                Total price: {{ $this->records->sum('price') }}
                            </span>
                        </div>
                    </div>
                </div>

        </x-tables::cell>
</x-tables::row>