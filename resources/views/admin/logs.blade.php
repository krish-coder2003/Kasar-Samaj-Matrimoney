@extends('layouts.admin')

@section('title', 'System Logs')

@section('styles')
<style>
    .log-container {
        background: #1e1e1e;
        color: #d4d4d4;
        padding: 2rem;
        border-radius: 20px;
        font-family: 'Courier New', Courier, monospace;
        font-size: 0.9rem;
        max-height: 75vh;
        overflow-y: auto;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        border: 1px solid #333;
    }
    .log-container::-webkit-scrollbar { width: 8px; }
    .log-container::-webkit-scrollbar-thumb { background: #444; border-radius: 10px; }
    
    .log-entry {
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #333;
        transition: 0.2s;
    }
    .log-entry:hover { background: rgba(255,255,255,0.02); }
    .log-timestamp { color: #569cd6; font-weight: bold; margin-bottom: 0.5rem; display: block; font-size: 0.8rem; }
    .log-content { white-space: pre-wrap; word-break: break-all; line-height: 1.6; }
    .log-error { color: #f44747; background: rgba(244, 71, 71, 0.1); padding: 5px 10px; border-radius: 5px; }
    .log-warning { color: #cca700; background: rgba(204, 167, 0, 0.1); padding: 5px 10px; border-radius: 5px; }
    .log-info { color: #4ec9b0; }
</style>
@endsection

@section('content')
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 3rem; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h1 style="font-size: 2.5rem; color: #333; margin: 0 0 0.5rem;">System Debug Logs</h1>
            <p style="color: #888; font-size: 1.1rem; margin: 0;">Monitor backend events and system health</p>
        </div>
        <button onclick="window.location.reload()" class="btn-primary-admin" style="background: #333;">
            <i class="fas fa-sync-alt"></i> Refresh Logs
        </button>
    </div>

    <div class="log-container">
        @forelse($logs as $log)
            <div class="log-entry">
                <span class="log-timestamp"><i class="far fa-clock"></i> {{ $log['timestamp'] }}</span>
                <div class="log-content @if(str_contains($log['content'], 'ERROR')) log-error @elseif(str_contains($log['content'], 'WARNING')) log-warning @endif">
                    {{ $log['content'] }}
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 5rem; color: #666;">
                <i class="fas fa-terminal" style="font-size: 3rem; opacity: 0.1; display: block; margin-bottom: 1rem;"></i>
                <p style="font-size: 1.1rem;">No log entries found. System is running smoothly!</p>
            </div>
        @endforelse
    </div>
@endsection
