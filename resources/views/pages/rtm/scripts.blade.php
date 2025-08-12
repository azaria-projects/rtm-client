@push('scripts-body')
    {{-- independent scripts --}}
    @include('scripts.sidebar')
    @include('scripts.rtm.charts')
    @include('scripts.rtm.prediction')

    {{-- dependant scripts --}}
    @include('scripts.rtm.index')
    @include('scripts.rtm.table')
@endpush