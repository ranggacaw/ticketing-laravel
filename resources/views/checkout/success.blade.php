@extends('user.layouts.app')

@section('content')
    <livewire:payment-status :ticket-uuid="$ticket->uuid" />
@endsection
