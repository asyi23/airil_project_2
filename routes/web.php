<?php

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/version', function () {
    phpinfo();
});

Auth::routes(['register' => false]);
/**** Dashboard ****/
Route::match(['get', 'post'], '/', 'AdminController@dashboard')->name('dashboard');
/**** Dashboard ****/

Route::match(['get', 'post'], 'form/listing/{id}', 'FormController@listing')->name('form_listing');
Route::match(['get', 'post'], 'form/add/{id}', 'FormController@add')->name('form_add');
Route::match(['get', 'post'], 'form/edit/{id}', 'FormController@add')->name('form_edit');
Route::match(['get', 'post'], 'form/delete', 'FormController@delete')->name('form_delete');
Route::match(['get', 'post'], 'form/a/{id}', 'FormController@delete')->name('admin_change_password');

Route::match(['get', 'post'], 'form_detail/listing/{id}', 'FormController@form_detail_listing')->name('form_detail_listing');
Route::match(['get', 'post'], 'form_detail_add/add/{id}', 'FormController@form_detail_add')->name('form_detail_add');
Route::match(['get', 'post'], 'form_detail_edit/add/{id}', 'FormController@form_detail_edit')->name('form_detail_edit');
Route::match(['get', 'post'], 'form_detail_edit/delete', 'FormController@delete_form_details')->name('form_detail_delete');
Route::match(['get', 'post'], 'form_detail_edit/download/{id}/{start_date?}/{end_date?}', 'FormController@download_form_details')->name('form_detail_download');

/**** Admin Profile Management ****/
Route::match(['get', 'post'], 'admin/profile', 'AdminController@profile')->name('admin_profile');
Route::post('admin/ajax_upload_admin_profile_photo', 'AdminController@ajax_upload_admin_profile_photo')->name('ajax_upload_admin_profile_photo');
Route::match(['get', 'post'], 'admin/change_password', 'AdminController@change_password')->name('admin_change_password');
/**** Admin Profile Management ****/

/**** Admin Management ****/
Route::group(['middleware' => ['permission:admin_listing']], function () {
    Route::match(['get', 'post'], 'admin/listing', 'AdminController@listing')->name('admin_listing');
});
Route::group(['middleware' => ['permission:admin_manage']], function () {
    Route::match(['get', 'post'], 'admin/add', 'AdminController@add')->name('admin_add');
    Route::match(['get', 'post'], 'admin/edit/{id}', 'AdminController@edit')->name('admin_edit');
    Route::post('admin_status', 'AdminController@status')->name('admin_status');
    Route::match(['get', 'post'], 'admin/assign_permission/{id}', 'AdminController@assign_permission')->name('assign_permission');
});
Route::match(['get', 'post'], 'admin/user_access/{id}', 'AdminController@access_user_account')->name('admin_access_user_account');
Route::match(['get', 'post'], 'admin/user_edit/{id}', 'AdminController@edit_user_account')->name('admin_edit_user_account');
Route::match(['get', 'post'], 'admin/switch_back', 'AdminController@switch_back')->name('admin_switch_back_account');

// Route::match(['get', 'post'], 'admin/ajax_get_admin_details', 'AdminController@ajax_get_admin_details')->name('ajax_get_admin_details');
Route::group(['middleware' => ['permission:admin_role_listing']], function () {
    Route::match(['get', 'post'], 'admin_role/listing', 'AdminRoleController@listing')->name('admin_role_listing');
});
Route::group(['middleware' => ['permission:admin_role_manage']], function () {
    Route::match(['get', 'post'], 'admin_role/edit/{id}', 'AdminRoleController@edit')->name('admin_role_edit');
    Route::match(['get', 'post'], 'admin_role/add', 'AdminRoleController@add')->name('admin_role_add');
});
/**** Admin Management ****/

/**** Company Section ****/
// Route::group(['middleware' => ['permission:company_listing_all']], function () {
Route::match(['get', 'post'], 'department/listing', 'CompanyController@listing')->name('company_listing');
Route::match(['get', 'post'], 'company/view/{id}/about_us', 'CompanyController@view_about_us')->name('company_view_about_us');
// });
Route::group(['middleware' => ['permission:company_manage_all']], function () {
    Route::match(['get', 'post'], 'company/add', 'CompanyController@add')->name('company_add');
    Route::match(['get', 'post'], 'company_log/{company_id}', 'CompanyLogController@listing')->name('company_log');
    Route::match(['get', 'post'], 'company/edit/{id}', 'CompanyController@edit')->name('company_edit');
    Route::match(['get', 'post'], 'company/remove_upload', 'CompanyController@remove_upload')->name('company_remove_upload');
    // Route::match(['get', 'post'], 'company/delete', 'CompanyController@delete')->name('company_delete');
    Route::post('company_status', 'CompanyController@status')->name('company_status');
});
Route::group(['middleware' => ['permission:company_profile']], function () {
    Route::match(['get', 'post'], 'company/profile', 'CompanyController@profile')->name('company_profile');
    Route::match(['get', 'post'], 'company/profile/edit/{id}', 'CompanyController@edit')->name('company_profile_edit');
});
Route::match(['get', 'post'], 'company/ajax_upload_company_note_image', 'CompanyController@ajax_upload_company_note_image')->name('ajax_upload_company_note_image');
Route::match(['get', 'post'], 'ajax_get_company_state_by_name', 'CompanyController@ajax_get_company_state_by_name')->name('ajax_get_company_state_by_name');
Route::match(['get', 'post'], 'ajax_get_company_country_by_name', 'CompanyController@ajax_get_company_country_by_name')->name('ajax_get_company_country_by_name');
Route::match(['get', 'post'], '/ajax_get_company_branch', 'CompanyController@ajax_get_company_branch')->name('ajax_get_company_branch');
/**** Company Section ****/

/**** Company Branch Section ****/
// Route::group(['middleware' => ['permission:branch_listing']], function () {
Route::match(['get', 'post'], 'department_equipment/listing/{id}', 'CompanyBranchController@listing')->name('company_branch_listing');
// });
// Route::group(['middleware' => ['permission:branch_manage']], function () {
Route::match(['get', 'post'], 'branch/add/{id}', 'CompanyBranchController@add')->name('company_branch_add');
Route::match(['get', 'post'], 'branch/edit/{id}', 'CompanyBranchController@edit')->name('department_equipment_edit');
Route::match(['get', 'post'], 'branch/remove_upload', 'CompanyBranchController@remove_upload')->name('company_branch_remove_upload');
Route::match(['get', 'post'], 'branch/delete', 'CompanyBranchController@department_equipment_delete')->name('department_equipment_delete');
Route::match(['get', 'post'], 'branch/ajax_upload_company_branch_note_image', 'CompanyBranchController@ajax_upload_company_branch_note_image')->name('ajax_upload_company_branch_note_image');
Route::match(['get', 'post'], 'ajax_get_branch_state_by_name', 'CompanyBranchController@ajax_get_branch_state_by_name')->name('ajax_get_branch_state_by_name');
Route::match(['get', 'post'], 'ajax_get_branch_country_by_name', 'CompanyBranchController@ajax_get_branch_country_by_name')->name('ajax_get_branch_country_by_name');
// });
Route::group(['middleware' => ['permission:branch_profile']], function () {
    Route::match(['get', 'post'], 'branch/profile', 'CompanyBranchController@profile')->name('company_branch_profile');
    Route::match(['get', 'post'], 'branch/profile/edit/{id}', 'CompanyBranchController@edit')->name('company_branch_profile_edit');
});
Route::get('/get-branches/{companyId}', 'CompanyBranchController@getBranches')->name('get.branches');


/**** User Profile Management ****/
Route::match(['get', 'post'], 'user/profile', 'UserController@profile')->name('user_profile');
Route::match(['get', 'post'], 'user/change_password', 'UserController@change_password')->name('user_change_password');
Route::match(['get', 'post'], 'user/profile/ajax_upload_profile_image', 'UserController@ajax_upload_profile_image')->name('ajax_upload_profile_image');
/**** User Profile Management ****/

/**** User Management ****/
Route::group(['middleware' => ['permission:user_listing']], function () {
    Route::match(['get', 'post'], 'user/listing', 'UserController@user_listing')->name('user_listing');
});
Route::group(['middleware' => ['permission:user_manage']], function () {
    Route::match(['get', 'post'], 'user/add', 'UserController@add')->name('user_add');
    Route::match(['get', 'post'], 'user/edit/{id}', 'UserController@edit')->name('user_edit');
    Route::post('user_status', 'UserController@status')->name('user_status');
    Route::match(['get', 'post'], 'user/assign_permission/{id}', 'UserController@assign_permission')->name('user_assign_permission');
});
Route::match(['get', 'post'], 'user/ajax_get_background_url', 'UserController@ajax_get_background_url')->name('ajax_get_background_url');
Route::match(['get', 'post'], 'user/ajax_get_banner_url', 'UserController@ajax_get_banner_url')->name('ajax_get_banner_url');
Route::match(['get', 'post'], 'user/register/{branch_id}/{encrypt_code}', 'UserController@register')->name('user_register');


Route::group(['middleware' => ['permission:user_role_listing']], function () {
    Route::match(['get', 'post'], 'user_role/listing', 'UserRoleController@listing')->name('user_role_listing');
});
Route::group(['middleware' => ['permission:user_role_manage']], function () {
    Route::match(['get', 'post'], 'user_role/edit/{id}', 'UserRoleController@edit')->name('user_role_edit');
    Route::match(['get', 'post'], 'user_role/add', 'UserRoleController@add')->name('user_role_add');
});
/**** User Management ****/

/**** Porduct Section ****/
Route::group(['middleware' => ['permission:product_listing']], function () {
    Route::match(['get', 'post'], 'product/listing', 'ProductController@listing')->name('product_listing');
});
Route::group(['middleware' => ['permission:product_manage']], function () {
    Route::match(['get', 'post'], 'product/add', 'ProductController@add')->name('product_add');
    Route::match(['get', 'post'], 'product/edit/{id}', 'ProductController@edit')->name('product_edit');
    Route::post('product_status', 'ProductController@status')->name('product_status');
    Route::match(['get', 'post'], 'product/remove_upload', 'ProductController@remove_upload')->name('product_remove_upload');
    Route::match(['get', 'post'], 'product/ajax_upload_product_note_image', 'ProductController@ajax_upload_product_note_image')->name('ajax_upload_product_note_image');
    Route::match(['get', 'post'], 'product/ajax_revert_product_image', 'ProductController@ajax_revert_product_image')->name('ajax_revert_product_image');
    Route::match(['get', 'post'], 'product/ajax_upload_product_image', 'ProductController@ajax_upload_product_image')->name('ajax_upload_product_image');
    Route::match(['get', 'post'], 'product/ajax_remove_product_images', 'ProductController@ajax_remove_product_images')->name('ajax_remove_product_images');
    Route::match(['get', 'post'], 'product/product_category_dropdown', 'ProductController@product_category_dropdown')->name('product_category_dropdown');
});
/**** Porduct Section ****/

/**** Porduct Category Section ****/
Route::group(['middleware' => ['permission:product_category_listing']], function () {
    Route::match(['get', 'post'], 'product_category/listing', 'ProductCategoryController@listing')->name('product_category_listing');
});

Route::group(['middleware' => ['permission:product_category_manage']], function () {
    Route::match(['get', 'post'], 'product_category/add', 'ProductCategoryController@add')->name('product_category_add');
    Route::match(['get', 'post'], 'product_category/edit/{id}', 'ProductCategoryController@edit')->name('product_category_edit');
    Route::post('product_category_status', 'ProductCategoryController@status')->name('product_category_status');
});
/**** Porduct Category Section ****/

/**** Promotion Section ****/
Route::group(['middleware' => ['permission:promotion_listing']], function () {
    Route::match(['get', 'post'], 'promotion/listing', 'PromotionController@listing')->name('promotion_listing');
});
Route::group(['middleware' => ['permission:promotion_manage']], function () {
    Route::match(['get', 'post'], 'promotion/add', 'PromotionController@add')->name('promotion_add');
    Route::match(['get', 'post'], 'promotion/edit/{id}', 'PromotionController@edit')->name('promotion_edit');
    Route::post('promotion_status', 'PromotionController@status')->name('promotion_status');
    Route::match(['get', 'post'], 'promotion/ajax_upload_promotion_note_image', 'PromotionController@ajax_upload_promotion_note_image')->name('ajax_upload_promotion_note_image');
});
/**** Promotion Section ****/

/**** Brochure Section ****/
Route::group(['middleware' => ['permission:brochure_listing']], function () {
    Route::match(['get', 'post'], 'brochure/listing', 'BrochureController@listing')->name('brochure_listing');
});
Route::group(['middleware' => ['permission:brochure_manage']], function () {
    Route::match(['get', 'post'], 'brochure/add', 'BrochureController@add')->name('brochure_add');
    Route::match(['get', 'post'], 'brochure/edit/{id}', 'BrochureController@edit')->name('brochure_edit');
    Route::post('brochure_status', 'BrochureController@status')->name('brochure_status');
    Route::match(['get', 'post'], 'brochure/remove_upload', 'BrochureController@remove_upload')->name('brochure_remove_upload');
    // Route::match(['get', 'post'], 'promotion/ajax_upload_promotion_note_image', 'PromotionController@ajax_upload_promotion_note_image')->name('ajax_upload_promotion_note_image');
});
Route::get('/brochure/get-car-models/{companyId}', 'BrochureController@get_car_model')->name('get.car_model');

/**** Brochure Section ****/

/**** Pricelist Section ****/
Route::group(['middleware' => ['permission:pricelist_listing']], function () {
    Route::match(['get', 'post'], 'pricelist/listing', 'PricelistController@listing')->name('pricelist_listing');
});
Route::group(['middleware' => ['permission:pricelist_manage']], function () {
    Route::match(['get', 'post'], 'pricelist/add', 'PricelistController@add')->name('pricelist_add');
    Route::match(['get', 'post'], 'pricelist/edit/{id}', 'PricelistController@edit')->name('pricelist_edit');
    Route::post('pricelist_status', 'PricelistController@status')->name('pricelist_status');
    Route::match(['get', 'post'], 'pricelist/remove_upload', 'PricelistController@remove_upload')->name('pricelist_remove_upload');
});
Route::get('/pricelist/get-car-models/{companyId}', 'PricelistController@get_car_model')->name('pricelist_get.car_model');

/**** Pricelist Section ****/

/**** Lead Section ****/
Route::group(['middleware' => ['permission:lead_report']], function () {
    Route::match(['get', 'post'], 'lead/report', 'DealerViewController@report')->name('lead_report');
});
/**** Lead Section ****/

/**** Setting Banner ****/
Route::group(['middleware' => ['permission:setting_banner']], function () {
    Route::match(['get', 'post'], 'setting_banner/listing', 'SettingBannerController@listing')->name('setting_banner_listing');
    Route::match(['get', 'post'], 'setting_banner/add', 'SettingBannerController@add')->name('setting_banner_add');
    Route::match(['get', 'post'], 'setting_banner/edit/{banner_id}', 'SettingBannerController@edit')->name('setting_banner_edit');
});
/**** Setting Banner ****/

/**** Setting Background ****/
Route::group(['middleware' => ['permission:setting_background']], function () {
    Route::match(['get', 'post'], 'setting_background/listing', 'SettingBackgroundController@listing')->name('setting_background_listing');
    Route::match(['get', 'post'], 'setting_background/add', 'SettingBackgroundController@add')->name('setting_background_add');
    Route::match(['get', 'post'], 'setting_background/edit/{background_id}', 'SettingBackgroundController@edit')->name('setting_background_edit');
});
/**** Setting Background ****/

/**** Setting Location ****/
Route::group(['middleware' => ['permission:setting_location']], function () {
    // Setting State
    Route::match(['get', 'post'], 'setting_state/listing', 'SettingStateController@listing')->name('setting_state_listing');
    //Route::match(['get', 'post'], 'setting_state/add', 'SettingStateController@add')->name('setting_state_add');
    Route::match(['get', 'post'], 'setting_state/edit/{id}', 'SettingStateController@edit')->name('setting_state_edit');
    Route::post('setting_state_delete', 'SettingStateController@delete')->name('setting_state_delete');
    Route::post('ajax_get_state_sel', 'SettingStateController@ajax_get_state_sel')->name('ajax_get_state_sel');
    // Setting City
    //Route::match(['get', 'post'], 'setting_city/listing/{id}', 'SettingCityController@listing')->name('setting_city_listing');
    Route::match(['get', 'post'], 'setting_city/add/{id}', 'SettingCityController@add')->name('setting_city_add');
    Route::match(['get', 'post'], 'setting_city/edit/{id}', 'SettingCityController@edit')->name('setting_city_edit');
    Route::post('setting_city_delete', 'SettingCityController@delete')->name('setting_city_delete');
    Route::match(['get', 'post'], 'company/ajax_get_city_sel', 'SettingCityController@ajax_get_city_sel')->name('ajax_get_city_sel');
    Route::match(['get', 'post'], 'company/ajax_get_setting_city', 'SettingCityController@ajax_get_setting_city')->name('ajax_get_setting_city');
});
