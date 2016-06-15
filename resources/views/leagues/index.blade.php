@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-lg-8">
        
        <!-- display leagues -->
        @if (count($leagues) > 0)
            @each('leagues.show', $leagues, 'league')
		@endif
    </div>
    <div class="col-lg-4">
        @include('leagues.join')
        
        @include('leagues.add')
    </div>
</div>

@endsection

@section('page-scripts')


@endsection