{{-- The best athlete wants his opponent at his best. --}}
<nav class="list-filter">
    <livewire:filter.clear-filter :key="'clear-list-filter'"/>
    @foreach($filters as $index => $filter)
        <livewire:single-list-filter :key="'single-list-filter-'.$filter->id" :filter="$filter" />
    @endforeach
</nav>
