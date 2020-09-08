@extends('layouts.app')

@section('content')
  <div class="container pt-5">  
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-3">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">STOCK REQUEST</p>
              <p class="card-text">258</p>
            </div>
          </div>
      </div>
      <div class="col-sm-3">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">SERVICE UNITS</p>
              <p class="card-text">258</p>
            </div>
        </div>
      </div>
      <div class="col-sm-3">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">SPARE PARTS</p>
              <p class="card-text">258</p>
            </div>
        </div>
      </div>
      <div class="col-sm-3">
          <div class="card bg-card">
            <div class="card-body text-center">
              <p class="card-text">RETURNS</p>
              <p class="card-text">258</p>
            </div>
          </div>
      </div>
    </div>  
  </div>
</div>
  <ul class="nav nav-tabs">
    <li class="nav-item">
      <a>USER ACTIVITIES</a>
    </li>
  </ul>
  <div class="table-responsive">
    <table class="table">
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
      <tbody>
        @for($i = 1; $i<=6; $i++)
          <tr>
            <td>
              ----
            </td>
            <td>
              ----
            </td>
            <td>
              ----
            </td>
            <td>
              ----
            </td>
            <td>
              ----
            </td>
            <td>
              ----
            </td>
          </tr>
          @endfor
      </tbody>
    </table>
  </div>
@endsection