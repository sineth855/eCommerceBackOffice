<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
// Route::group(['middleware' => ['SettingConfig','cors']], function () {
    // Route::Resource('/order_status','BackEnd\OrderStatus\OrderStatusController');
// });
Route::group(['middleware' => ['auth:api','SettingConfig','cors']], function () {
    Route::post('logout', 'Auth\LoginController@logout');
    //****catalog****
    //stock status
    Route::Resource('/stock_status','BackEnd\Stocks\StocksController');
    //attribute
    Route::Resource('/attribute','BackEnd\Attributes\AttributesController');
    Route::Resource('/attribute_group','BackEnd\Attributes\AttributeGroupController');
    // category
    Route::Resource('/category','BackEnd\Category\CategoryController');
    //currency
    Route::Resource('/currency_rate','BackEnd\Currencies\CurrencyRateController');
    
    Route::resource('/supplier', 'BackEnd\Supplier\SupplierController');

    Route::Resource('/users','BackEnd\Users\UsersController');
    Route::Resource('/user_group','BackEnd\UserGroups\UserGroupsController');
    Route::resource('/user_role', 'BackEnd\Settings\GroupRolesController');
    
    Route::Resource('/resellers','BackEnd\Reseller\ResellerController');

    Route::Resource('/carriers','BackEnd\Carriers\CarriersController');

    //======Language API
    Route::Resource('/languages','BackEnd\Languages\LanguagesController');

    //======Currency API
    Route::Resource('/currencies','BackEnd\Currencies\CurrenciesController');

    //======Stock Status API
    Route::Resource('/stock_status','BackEnd\Stocks\StocksController');

    //======Store
    Route::Resource('/store', 'BackEnd\Store\StoreController');
    
    //======Order Status API
    Route::Resource('/order_status','BackEnd\OrderStatus\OrderStatusController');

    //======Payment Method API
    Route::Resource('/payment_methods','BackEnd\Payment\PaymentMethodController');

    //======Credit Type API
    Route::Resource('/credit_type','BackEnd\CreditOptions\CreditTypesController');
    
    //======Credit Type Value API
    Route::Resource('/credit_type_value','BackEnd\CreditOptions\CreditTypeValuesController');

    //======Geo Zone
    Route::Resource('/geo_zone','BackEnd\GeoZone\GeoZoneController');
    
    //======Country
    Route::Resource('/country','BackEnd\Country\CountryController');

    //======Zone
    Route::Resource('/zone','BackEnd\Zone\ZoneController');

    //======Tax API
    Route::Resource('/tax_class','BackEnd\Taxs\TaxClass\TaxClassController');
    Route::Resource('/tax_rule','BackEnd\Taxs\TaxRule\TaxRuleController');
    Route::Resource('/tax_rate','BackEnd\Taxs\TaxRate\TaxRateController');
    Route::Resource('/tax_rate_to_customer_group','BackEnd\Taxs\TaxRateToCustomerGroup\TaxRateToCustomerGroupController');

    //======Weight API
    Route::Resource('/weight_class','BackEnd\Weights\WeightsController');

    //======Length API
    Route::Resource('/length_class','BackEnd\Lengths\LengthsController');

    //======Manufacturer API
    Route::Resource('/manufacturers','BackEnd\Manufacturers\ManufacturersController');

    //======Download API
    Route::Resource('/downloads','BackEnd\Downloads\DownloadsController');

    //======Preview API
    Route::Resource('/previews','BackEnd\Previews\PreviewsController');

    //======Product Attribute API
    Route::Resource('/product_attribute','BackEnd\Products\Attributes\AttributeController');

    //======Product Attribute Group API
    Route::Resource('/product_attribute_group','BackEnd\Products\AttributeGroups\AttributeGroupController');

    //======Product 
    Route::resource('products', 'BackEnd\Products\ProductsController');

    //======Review
    Route::Resource('/reviews','BackEnd\Reviews\ReviewsController');

    //======Attribute API
    Route::Resource('/attribute','BackEnd\Attributes\AttributesController');
    Route::Resource('/attribute_group','BackEnd\Attributes\AttributeGroupController');

    //======Filter API
    Route::Resource('/filters','BackEnd\Filter\FiltersController');
    Route::Resource('/filters_group','BackEnd\Filter\FilterGroupController');

    //======CategoryType API
    Route::Resource('/category_type','BackEnd\CategoryType\CategoryTypeController');

    //======Information API
    Route::Resource('/informations','BackEnd\Informations\InformationsController');

    //======Option API
    Route::Resource('/options','BackEnd\Options\OptionsController');

    //======Option API
    Route::Resource('/banners','BackEnd\Customers\BannersController');

    //======Customer API
    Route::Resource('/customers','BackEnd\Customers\CustomersController');
    Route::Resource('/customer_groups','BackEnd\Customers\CustomerGroupsController');
    Route::post('/filterCustomer','BackEnd\Customers\CustomersController@filterCustomer');

    //=====Sale order=============================
    Route::resource('sale_order', 'BackEnd\Order\SaleOrderController');
    Route::post('sale_order/create_order_payment', 'BackEnd\Order\SaleOrderController@createOrderPayment');
    Route::resource('order_shippment', 'BackEnd\Order\OrderShipmentController');

    //=====file upload service ===================
    Route::post('file_upload', 'Services\FileUploadController@fileUploadService');

    //=====get menu =====================
    Route::get('getMenus', 'Backend\Settings\GroupRolesController@getMenus');

    //user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::patch('settings/profile', 'Settings\UpdateProfile');
    Route::patch('settings/password', 'Settings\UpdatePassword');
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});
