<?php

namespace App\Providers;

use App\Model\AdsPremierRequest;
use App\Model\CarRequest;
use App\Model\CompanySubscriptionInvoice;
use App\Model\Lead;
use App\Model\TransactionRequest;
use App\Model\User;
use App\Model\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.sidebar', function ($view) {
            $search = [];
            // $count = User::count_pending_user();
            // $company_subscription_count = CompanySubscriptionInvoice::count_pending_invoice();

            $count = 0;
            $company_subscription_count = 0;

            // $current_route = Route::currentRouteName();
            // $lead_route = [
            //     'lead_ads_offer_listing',
            //     'lead_trade_in_listing',
            //     'lead_new_car_offer_listing'
            // ];
            // $current_lead = array_filter($lead_route, function ($val) use($current_route) {
            //     return ($val == $current_route);
            // });
            // $current_lead = array_shift($current_lead);

            $view->with([
                'dealer_pending' => $count['dealer'] ?? 0,
                'sales_agent_pending' => $count['sa'] ?? 0,
                'broker_pending' => $count['broker'] ?? 0,
                'private_user_pending' => $count['private'] ?? 0,
                'company_subscription_pending' => $company_subscription_count,
                // 'dealer_pending' => User::where('user_type_id', 2)->where('user_application_status_id', 2)->where('is_deleted', 0)->count('user_id'),
                // 'sales_agent_pending' => User::where('user_type_id', 3)->where('user_application_status_id', 2)->where('is_deleted', 0)->count('user_id'),
                // 'broker_pending' => User::where('user_type_id', 4)->where('user_application_status_id', 2)->where('is_deleted', 0)->count('user_id'),
                // 'private_user_pending' =>User::where('user_type_id', 5)->where('user_application_status_id', 2)->where('is_deleted', 0)->count('user_id'),
                // 'dealer_pending' => User::get_verification_count(2),
                // 'sales_agent_pending' => User::get_verification_count(3),
                // 'broker_pending' => User::get_verification_count(4),
                // 'private_user_pending' => User::get_verification_count(5),
                'car_request_pending' =>  0, //CarRequest::where(['car_request_status' => 'Pending', 'is_variant_create' => 1])->count('car_request_id'),
                'transaction_request_count' => 0, //TransactionRequest::get_count_pending_transaction_request(),
                'lead_pending_all' => null, //Lead::get_lead_pending(true),
                'lead_pending' => null, //Lead::get_lead_pending(false,$search),
                'premier_open' => null, //AdsPremierRequest::get_premier_open($search),
                // 'lead_route_display' => $current_lead ?? 'lead_ads_offer_listing'
            ]);
        });
    }
}
