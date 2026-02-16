@extends('errors.layout')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __('Forbidden'))
@section('friendly_message', 'Access Denied')
@section('description', 'You do not have permission to access this page.')
