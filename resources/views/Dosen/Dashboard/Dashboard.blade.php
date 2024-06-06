@extends('Dosen.layouts.master')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Dosen</h1>
    <div class="row">
        <div class="col-md-3">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px; color: white; border-radius: 5px; margin-bottom: 20px; background-color: #007bff;">
                <div style="font-size: 3rem;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div style="flex-grow: 1; text-align: right;">
                    <div>Pembimbing 1</div>
                    <span style="font-size: 1.5rem; font-weight: bold;">2</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px; color: white; border-radius: 5px; margin-bottom: 20px; background-color: #28a745;">
                <div style="font-size: 3rem;">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div style="flex-grow: 1; text-align: right;">
                    <div>Pembimbing 2</div>
                    <span style="font-size: 1.5rem; font-weight: bold;">53</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px; color: white; border-radius: 5px; margin-bottom: 20px; background-color: #ffc107;">
                <div style="font-size: 3rem;">
                    <i class="fas fa-user-check"></i>
                </div>
                <div style="flex-grow: 1; text-align: right;">
                    <div>Penguji 1</div>
                    <span style="font-size: 1.5rem; font-weight: bold;">44</span>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div style="display: flex; align-items: center; justify-content: space-between; padding: 20px; color: white; border-radius: 5px; margin-bottom: 20px; background-color: #dc3545;">
                <div style="font-size: 3rem;">
                    <i class="fas fa-user-tie"></i>
                </div>
                <div style="flex-grow: 1; text-align: right;">
                    <div>Penguji 2</div>
                    <span style="font-size: 1.5rem; font-weight: bold;">65</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
