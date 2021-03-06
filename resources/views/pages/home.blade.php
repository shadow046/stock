@extends('layouts.app')

@section('content')
@if(!auth()->user()->hasrole('Repair'))
  <div class="container pt-5">  
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3">
        <a href="{{ route('stock.index')}}">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">STOCK REQUEST</p>
              <p class="card-text">{{ $stockreq }}</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="{{ route('stocks.index')}}">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">STOCKS</p>
              <p class="card-text">{{ $units }}</p>
            </div>
          </div>
        </a>
      </div>
      <div class="col-sm-3">
        <a href="{{ route('return.index')}}">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">RETURNS</p>
              <p class="card-text">{{ $returns }}</p>
            </div>
          </div>
        </a>
      </div>
    </div>  
  </div>
</div>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a>USER ACTIVITIES</a>
    </li>
  </ul>
@endif
  <br><br>
  <div class="table-responsive">
    <table class="table activityTable" id="activityTable">
      <thead class="thead-dark">
        <tr>
          <th>
            DATE
          </th>
          <th>
            TIME
          </th>
          <th>
            USER NAME
          </th>
          <th>
            FULL NAME
          </th>
          <th>
            USER LEVEL
          </th>
          <th>
            ACTIVITY  
          </th>
        </tr>
      </thead>
    </table>
  </div>
@endsection