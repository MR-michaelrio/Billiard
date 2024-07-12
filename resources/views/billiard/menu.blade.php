@extends('layout.main')
@section('content')
<div class="row">
    <a href="{{ route('bl.nonmember', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Non Member</a>
    <a href="{{ route('bl.member', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Member</a>
    <a href="{{ route('bl.stop', $no_meja) }}" class="btn btn-block btn-primary btn-lg">Stop</a>
</div>
@endsection
