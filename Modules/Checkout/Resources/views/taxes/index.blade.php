@extends('layouts/contentNavbarLayout')

@section('page-script')
  <style type="text/css">
      .btn-tax {
          width: 100%;
          margin-bottom: 10px;
      }
      .nav-pills .nav-link {
          display: flex;
          align-items: center;
          justify-content: center;
          padding: 10px 20px;
          background-color: #f8f9fa;
          border: 1px solid #dee2e6;
          border-radius: 30px;
          transition: all 0.3s ease;
      }
      .nav-pills .nav-link.active {
          background-color: #007bff;
          color: #fff;
      }
      .nav-pills .nav-link:hover {
          background-color: #e2e6ea;
      }
      .nav-pills .nav-link i {
          margin-right: 8px;
      }
  </style>
@endsection

@section('content')
  <h4 class="py-3 mb-4">
    <span class="text-muted fw-light">Settings /</span> Taxes Management
  </h4>
  <div class="row">
    <div class="col-md-12">
      <ul class="nav nav-pills flex-column flex-md-row mb-4 gap-2 gap-lg-0">
        <li class="nav-item">
          <a class="nav-link active btn-tax" href="{{ route('taxes.index') }}">
            <i class="mdi mdi-cash-multiple mdi-20px"></i>
            Taxes
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn-tax" href="{{ route('taxrules.index') }}">
            <i class="mdi mdi-gavel mdi-20px"></i>
            Tax Rules
          </a>
        </li>
      </ul>
    </div>
  </div>
@endsection
