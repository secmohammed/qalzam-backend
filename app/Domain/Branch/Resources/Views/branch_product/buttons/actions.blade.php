<div class="flex space-x-1">
    <a href="{{ route('branches.show', [$id]) }}"
       class="p-1 text-teal-600 hover:bg-teal-600 hover:text-white rounded">
        <span class="svg-icon svg-icon-1.5x">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path
                    d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd"
                                                                     d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                                     clip-rule="evenodd"></path></svg>
        </span>
    </a>

    <a href="{{ route('branches.edit', [$id]) }}"
       class="p-1 text-blue-600 hover:bg-blue-600 hover:text-white rounded">
        <span class="svg-icon svg-icon-1.5x">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path
                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg>
        </span>
    </a>

    <a href="{{ route('branches.destroy', [$id]) }}"
       class="p-1 text-red-600 hover:bg-red-600 hover:text-white rounded" data-toggle="modal"
       data-target="#delete_{{$id}}">
        <span class="svg-icon svg-icon-1.5x">
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path
                    fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd"></path></svg>
        </span>
    </a>
</div>

<div class="modal fade" id="delete_{{$id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('main.delete') }} {{ __('main.branches') }}:
                    #{{ $id }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <form action="{{ route('branches.destroy', [$id]) }}" method="post">
                @csrf
                @method("DELETE")
                <div class="modal-body">
                    {{ __('main.delete') }} {{ __('main.branches') }}: #{{ $id }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('main.delete') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>