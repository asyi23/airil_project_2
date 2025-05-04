@extends('errors::caricarz')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Access is denied due to invalid credentials.'))
