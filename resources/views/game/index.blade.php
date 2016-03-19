@extends('layouts.dashboard')
@section('page-script')
    <script type="text/javascript" src="{{ asset('assets/scripts/phaser.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/scripts/rat_attack.js') }}"></script>
    <script type="text/javascript">

    </script>
@stop
@section('page_heading_tree')
@stop
@section('page_heading','Stay safe')
@section('section')
    <div>
        <div id="phaser-example"></div>
    </div>
@endsection