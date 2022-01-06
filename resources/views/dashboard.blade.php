@extends('layouts.headerPrimary')
@section('isicard')
<section id="main-content">
	<section class="wrapper">
		<!-- //market-->
		<div class="container-fluid mt--6">
      <div class="row">
        <div class="col-8">
          <div class="card bg-default">
            <div class="card-header bg-info">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 text-white mb-0">Total Penyewaan</h5>
                </div>
              </div>
            </div>
            <div class="card-body bg-secondary">
              <!-- Chart -->
              <div class="chart">
                <!-- Chart wrapper -->
                <canvas id="myChart"></canvas>
              </div>
            </div>
          </div>
        </div>
        <div class="col-4">
          <div class="card">
            <div class="card-header bg-transparent">
              <div class="row align-items-center">
                <div class="col">
                  <h5 class="h3 mb-0">Rekapitulasi</h5>
                </div>
              </div>
            </div>
            <div class="card-body">
              <!-- Chart -->
              <div class="chart">
                <canvas id="chartbar" style="height: 100%"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Footer -->
@endsection