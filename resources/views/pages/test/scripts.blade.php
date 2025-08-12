@push('scripts-body')
    {{-- independent scripts --}}
    @include('scripts.sidebar')
    @include('scripts.test.charts')
    @include('scripts.test.prediction')

    {{-- dependant scripts --}}
    @include('scripts.test.index')
    @include('scripts.test.table')
@endpush