{{-- If your happiness depends on money, you will never be happy with yourself. --}}
<nav class="list-filter">
    @foreach($filters as $index => $filter)
        <livewire:single-list-filter key="'single-list-filter-'.$filter['id']" :filter="$filter" :activeClass="$index == 0 ? 'active' : ''"/>
    @endforeach
</nav>
