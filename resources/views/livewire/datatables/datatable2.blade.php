<div>
    @if($beforeTableSlot)
        <div class="mt-8">
            @include($beforeTableSlot)
        </div>
    @endif

    <div class="relative">
        <div class="flex justify-between items-center mb-1">
            <div class="flex-grow h-10 flex items-center">
                @if($this->searchableColumns()->count())
                    <div class="min-w-250px flex rounded-lg shadow-sm mb-7">
                        <div class="relative flex-grow focus-within:z-10">
                            <div class="absolute inset-y-0 reverse_custom_direction pl-3 flex items-center pointer-events-none">
                            <span>
                                <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" stroke="currentColor" fill="none">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </span>
                            </div>
                            <input wire:model.debounce.500ms="search" class="form-control form-input block bg-gray-50 focus:bg-white w-full rounded-md pl-10 transition ease-in-out duration-150 sm:text-sm sm:leading-5" placeholder="{{ __('main.search_in') }} {{ $this->searchableColumns()->map->label->join(', ') }}" />
                            <div class="absolute inset-y-0 custom_direction pr-3 flex items-center">
                                <button wire:click="$set('search', null)" class="text-gray-300 hover:text-red-600 focus:outline-none custom_margin">
                                    <x-icons.x-circle class="h-5 w-5 stroke-current" />
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="flex items-center space-x-1">
                @if($this->selected)
                    @php
                        $selectedIds = implode(',', $this->selected);
                    @endphp
                    <form action="{{ route("{$this->params}.destroy", $selectedIds) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="flex items-center space-x-2 px-3 border text-red-600 hover:bg-red-600 hover:text-white rounded text-xs leading-4 font-medium uppercase tracking-wider focus:outline-none">
                            <span>{{ __('main.multi_delete') }}</span>
                            <span class="svg-icon svg-icon-2x">
                              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                            </span>
                        </button>
                    </form>
                @endif

                @if (Str::contains($this->params, 'admin_'))

                    @php
                        $params = explode('_', $this->params)[1];
                    @endphp

                    <a href="{{ route("{$this->params}.create") }}" class="flex items-center space-x-2 px-3 border border-green-400 rounded-md bg-white text-blue-500 text-xs leading-4 font-medium uppercase tracking-wider hover:bg-blue-100 focus:outline-none" style="a:hover{ background: #81bbeb !important;}"><span>{{ __('main.add') }} {{ __("main.{$params}") }}</span>
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                </g>
                            </svg>
                        </span>
                    </a>

                @elseif($this->params == 'types')
                    <a href="{{ route("{$this->params}.create") }}" class="flex items-center space-x-2 px-3 border border-green-400 rounded-md bg-white text-blue-500 text-xs leading-4 font-medium uppercase tracking-wider hover:bg-blue-100 focus:outline-none" style="a:hover{ background: #81bbeb !important;}"><span>{{ __('main.add') }} {{ __("main.complain_{$params}") }}</span>
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                @else
                    <a href="{{ route("{$this->params}.create") }}" class="flex items-center space-x-2 px-3 border border-green-400 rounded-md bg-white text-blue-500 text-xs leading-4 font-medium uppercase tracking-wider hover:bg-blue-100 focus:outline-none" style="a:hover{ background: #81bbeb !important;}"><span>{{ __('main.add') }} {{ __("main.{$this->params}") }}</span>
                        <span class="svg-icon svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect fill="#000000" x="4" y="11" width="16" height="2" rx="1"/>
                                    <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-270.000000) translate(-12.000000, -12.000000) " x="4" y="11" width="16" height="2" rx="1"/>
                                </g>
                            </svg>
                        </span>
                    </a>
                @endif


                <x-icons.cog wire:loading class="h-9 w-9 animate-spin text-gray-400" />
                @if($exportable)
                    <div x-data="{ init() {
                    window.livewire.on('startDownload', link => window.open(link,'_blank'))
                } }" x-init="init">
                        <button wire:click="export" class="flex items-center space-x-2 px-3 border border-green-400 rounded-md bg-white text-green-500 text-xs leading-4 font-medium uppercase tracking-wider hover:bg-green-200 focus:outline-none"><span>{{ __('main.export') }}</span>
                            <x-icons.excel class="m-2" /></button>
                    </div>
                @endif

                @if($hideable === 'select')
                    @include('datatables::hide-column-multiselect')

                @endif
            </div>
        </div>

        @if($hideable === 'buttons')
            <div class="p-2 grid grid-cols-8 gap-2">
                @foreach($this->columns as $index => $column)
                    <button wire:click.prefetch="toggle('{{ $index }}')" class="px-3 py-2 rounded text-white text-xs focus:outline-none
            {{ $column['hidden'] ? 'bg-blue-100 hover:bg-blue-300 text-blue-600' : 'bg-blue-500 hover:bg-blue-800' }}">
                        {{ $column['label'] }}
                    </button>
                @endforeach
            </div>
        @endif

        <div class="rounded-lg shadow-lg bg-white max-w-screen overflow-x-scroll">
            <div class="rounded-lg @unless($this->hidePagination) rounded-b-none @endif">
                <div class="table align-middle min-w-full">
                    @unless($this->hideHeader)
                        <div class="table-row divide-x divide-gray-200">
                            @foreach($this->columns as $index => $column)
                                @if($hideable === 'inline')
                                  @include('datatables::header-inline-hide', ['column' => $column, 'sort' => $sort])

                                @elseif($column['type'] === 'checkbox')
                                    <div class="relative table-cell h-12 w-48 overflow-hidden align-top px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider flex items-center focus:outline-none">
                                        <div class="px-3 py-1 rounded @if(count($selected)) bg-orange-400 @else bg-gray-200 @endif text-white text-center">
                                            {{ count($selected) }}
                                        </div>
                                    </div>
                                @else
                                 @include('datatables::header-no-hide', ['column' => $column, 'sort' => $sort])
                                @endif
                            @endforeach
                        </div>

                        <div class="table-row divide-x" style="background-color: #f3f6f9;">
                            @foreach($this->columns as $index => $column)
                                @if($column['hidden'])
                                    @if($hideable === 'inline')
                                        <div class="table-cell w-5 overflow-hidden align-top bg-blue-100"></div>
                                    @endif
                                @elseif($column['type'] === 'checkbox')
                                    <div class=" overflow-hidden align-top px-6 py-5 border-b border-gray-200 bg-gray-50 text-center text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider flex h-full flex-col items-center space-y-2 focus:outline-none">
                                        <div>{{ __('main.select_all') }}</div>
                                        <div>
                                            <input type="checkbox" wire:click="toggleSelectAll" @if(count($selected) === $this->results->total()) checked @endif class="form-checkbox mt-1 h-4 w-4 text-blue-600 transition duration-150 ease-in-out" />
                                        </div>
                                    </div>
                                @else
                                    <div class="table-cell overflow-hidden align-top">
                                        @isset($column['filterable'])
                                            @if( is_iterable($column['filterable']) )
                                               @include('datatables::filters.select', ['index' => $index, 'name' => $column['label'], 'options' => $column['filterable']])
                                            @else
                                                <div wire:key="{{ $index }}">
                                                    @include('datatables::filters.' . ($column['filterView'] ?? $column['type']), ['index' => $index, 'name' => $column['label']])
                                                </div>
                                            @endif
                                        @endisset
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @forelse($this->results as $result)
                        <div class="table-row p-1 divide-x divide-gray-100 {{ isset($result->checkbox_attribute) && in_array($result->checkbox_attribute, $selected) ? 'bg-orange-100' : ($loop->even ? 'bg-gray-100' : 'bg-gray-50') }}">
                            @foreach($this->columns as $column)
                                @if($column['hidden'])
                                    @if($hideable === 'inline')
                                        <div class="table-cell w-5 overflow-hidden align-top"></div>
                                    @endif
                                @elseif($column['type'] === 'checkbox')
                                    @include('datatables::checkbox', ['value' => $result->checkbox_attribute])
                                @else
                                    <div class="px-6 py-2 whitespace-no-wrap text-sm leading-5 text-gray-900 table-cell position-text-custom">
                                        {!! $result->{$column['name']} ?? 'N/A' !!}
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @empty
                        <p class="p-3 text-lg text-teal-600">
                            There's Nothing to show at the moment
                        </p>
                    @endforelse
                </div>
            </div>
            @unless($this->hidePagination)
                <div class="rounded-lg rounded-t-none max-w-screen rounded-lg border-b border-gray-200 bg-white">
                    <div class="p-2 sm:flex items-center justify-between">
                        {{-- check if there is any data --}}
                        <div class="my-2 sm:my-0 flex items-center" style="background-color: #f3f6f9;">
                            <select name="perPage" class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5" style="background-color: #f3f6f9" wire:model="perPage">
                                <option value="10" selected>10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="99999999">{{ __('main.All') }}</option>
                            </select>
                        </div>

                        <div class="my-4 sm:my-0">
                            <div class="lg:hidden">
                                <span class="space-x-2">{{ $this->results->links('datatables::tailwind-simple-pagination') }}</span>
                            </div>
                            @if($this->results->total() > $this->results->perPage())
                                <div class="lg:flex justify-center">
                                    <span>{{ $this->results->links('datatables::tailwind-pagination') }}</span>
                                </div>
                            @endif

                        </div>

                        <div class="flex justify-end text-gray-600">
                            {{ __('main.results') }} {{ $this->results->firstItem() }} - {{ $this->results->lastItem() }} {{ __('main.of') }}
                            {{ $this->results->total() }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @if($afterTableSlot)
        <div class="mt-8">
            @include($afterTableSlot)
        </div>
    @endif
</div>
