@extends('admin.app')

@section('content')
<section class="text-center py-6">
	<div class="container mt-5">
		<div class="row justify-content-center align-items-center">
			<div class="col-lg-6">
			    <h1 class="fw-700 text-center">{{__('Access Denied!')}}</h1>
			    <p class="fs-16 opacity-60 text-center">{{__('You Do not Have The Right Permission To Access.')}}</p>
			</div>
		</div>
    </div>
</section>
@endsection
