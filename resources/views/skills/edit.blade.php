@extends('skills.create')
@section('editId', route('skill.update', $skill->id))

@section('editMethod')
	{{method_field('PUT')}}
@endsection