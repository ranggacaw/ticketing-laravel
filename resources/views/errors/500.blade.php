@extends('errors.layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Server Error'))
@section('friendly_message', 'Oops! Something went wrong.')
@section('description', 'We encountered an internal error. Please try again later.')
