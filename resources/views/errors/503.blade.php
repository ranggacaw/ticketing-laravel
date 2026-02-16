@extends('errors.layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __('Service Unavailable'))
@section('friendly_message', 'Under Maintenance')
@section('description', 'We are currently performing maintenance. Please check back soon.')
