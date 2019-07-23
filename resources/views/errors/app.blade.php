@extends('errors.minimal')

@section('title', $exception->getMessage())
@section('code', $exception->getCode())
@section('message', $exception->getMessage())
