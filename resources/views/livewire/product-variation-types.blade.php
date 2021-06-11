{{--<div>--}}
{{--    --}}{{-- Knowing others is intelligence; knowing yourself is true wisdom. --}}
{{--</div>--}}
<nav class="list-filter" wire:ignore>
{{--    {{dd($variationTypes)}}--}}
    @foreach($this->types as $index => $type)
        <a class="{{$index == 0 ? 'active' : ''}}" :key="'variation-type'.$type['id']" href="#" wire:click="changeVariationType({{$type['id']}})">{{$type['name']}}</a>
    @endforeach
</nav>
