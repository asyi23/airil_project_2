@extends('layouts.master')

@section('title') Financial Calculator @endsection

@section('css') 
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/select2/select2.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.css')}}">

        <link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/libs/dropzone/dropzone.min.css')}}">
@endsection
@section('content')

<style>

    h3{
        color: green;
    }
    
</style>
<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-flex align-items-center justify-content-between">
			<h4 class="mb-0 font-size-18"> Financial Calculator</h4>
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item">
						<a href="javascript: void(0);">Financial Calculator</a>
					</li>
					<li class="breadcrumb-item active">Form</li>
				</ol>
			</div>
		</div>
	</div>
</div>
<!-- end page title -->
@if($errors->any())
    @foreach($errors->all() as $error)
    <div class="alert alert-danger" role="alert">
        {{ $error }}
    </div>
    @endforeach
@enderror
<div class="row">
    <div class="col-12">
        <form name="loandata">
            @csrf
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Financial Calculator</h4>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="vehicle_price">Vehicle Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="validationTooltipUsernamePrepend">RM</span>
                                    </div>
                                    <input id="vehicle_price" name="vehicle_price" type="text" class="form-control" value="" placeholder="0.00" onchange="calculate(); required">
                                </div>
                                
                            </div> 
                            <div class="form-group">
                                <label for="deposit_amount">Deposit Amount</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="validationTooltipUsernamePrepend">RM</span>
                                    </div>
                                <input id="deposit_amount" name="deposit_amount" type="text" class="form-control" value="" placeholder="0.00" onchange="calculate();">
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="bank_rates">Bank Rates</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="validationTooltipUsernamePrepend">%</span>
                                    </div>
                                <input id="bank_rates" name="bank_rates" type="text" class="form-control" value="" placeholder="0" onchange="calculate();">
                                </div>
                            </div> 

                            <div class="form-group">
                                <label for="repayment_period">Repayment Period (Years)</label>
                                <input id="repayment_period" name="repayment_period" type="number" class="form-control" value="0" min ="0" placeholder="0" onchange="calculate();">
                            </div>

                            <input type="button" value="Calculate Monthly Installment" onclick="calculate(); show();">
                            <input type="reset">
                            <br>

                            <label hidden>Your loan amount: </label>
                            <input type="text" name="loan" size="12" readonly hidden>

                            <label hidden>Your total interest: </label>
                            <input type="text" name="interest" size="12" readonly hidden><br>

                            <label hidden>Your monthly interest: </label>
                            <input type="text" name="month" size="12" readonly hidden><br>

                            <label hidden>Your monthly installment: </label>
                            <input type="text" name="installment" size="12" readonly hidden>

                            <h3 id= "monthlyinstallment"></h3>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>     

@endsection

@section('script')
    <script src="{{ URL::asset('assets/libs/parsleyjs/parsleyjs.min.js')}}"></script> 
    <!-- Plugins js -->
    <script src="{{ URL::asset('assets/js/pages/form-validation.init.js')}}"></script> 

    <script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-touchspin/bootstrap-touchspin.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/form-advanced.init.js')}}"></script> 

    <script src="{{ URL::asset('assets/libs/dropzone/dropzone.min.js')}}"></script> 

    <script>
        function calculate(){
            
            var loanAmount = document.loandata.vehicle_price.value - document.loandata.deposit_amount.value;
            var totalInterest = (document.loandata.bank_rates.value/100) * loanAmount * document.loandata.repayment_period.value;           
            var monthlyInterest = totalInterest/(document.loandata.repayment_period.value * 12);            
            var monthlyInstallment = (loanAmount + totalInterest)/(document.loandata.repayment_period.value * 12);

            document.loandata.loan.value = loanAmount;
            document.loandata.interest.value = round(totalInterest);
            document.loandata.month.value = round(monthlyInterest);
            document.loandata.installment.value = "RM" + round(monthlyInstallment);

            if(isNaN(monthlyInstallment)){
                document.loandata.installment.value = "-";
            }

            else if(!isFinite(monthlyInstallment)){
                document.loandata.installment.value = "-";
            }
        }

        function round(x){
            return Math.round(x*100)/100;
        }

        function show(){
            document.getElementById("monthlyinstallment").innerHTML =  "Monthly Installment: " + document.loandata.installment.value;
        }

    </script>
    
@endsection
