<?php
// require __DIR__ . '/../../autoload.php';

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\Printer; 
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        $role = $user->role;
        $id = $user->id;
        if ($role == 'manager') {
            return redirect()->route('manager.ui');
        } elseif ($role == 'kasir') {
            return redirect()->route('kasir.ui');
        } elseif ($role == 'resepsionist') {
            return redirect()->route('resepsionist.ui');
        } elseif ($role == 'manager_center') {
            // todo
            return redirect()->route('manager_center_home.ui');
        }
    }
    return view('welcome');
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


// rute manager home
Route::get('/manager', 'Manager\ManagerController@index')->name('manager.ui');
Route::get('/manager/karyawan', 'Manager\ManagerController@get_karyawan')->name('manager.karyawan.ui');
Route::get('/manager/karyawan/{id}/edit', 'Manager\ManagerController@get_karyawan_edit')->name('manager.karyawan.edit.ui');
Route::get('/manager/karyawan/create', 'Manager\ManagerController@get_karyawan_create')->name('manager.karyawan.create.ui');
Route::get('/manager/product', 'Manager\ManagerController@get_products')->name('manager.products.ui');
Route::get('/manager/product/create', 'Manager\ManagerController@get_products_create')->name('manager.products.create.ui');
Route::get('/manager/product/{id}/edit', 'Manager\ManagerController@get_products_edit')->name('manager.products.edit.ui');
Route::get('/manager/budgeting', 'Manager\ManagerController@get_budgeting')->name('manager.budgeting.ui');
Route::get('/manager/budgeting/create', 'Manager\ManagerController@get_budgeting_create')->name('manager.budgeting.create.ui');
Route::get('/manager/budgeting/{id}/edit', 'Manager\ManagerController@get_budgeting_edit')->name('manager.budgeting.edit.ui');
Route::get('/manager/budgeting/realization', 'Manager\ManagerController@get_realization')->name('manager.realization.ui');
Route::get('/manager/budgeting/realization/create', 'Manager\ManagerController@get_realization_create')->name('manager.realization.create.ui');
Route::get('/manager/budgeting/realization/{id}/edit', 'Manager\ManagerController@get_realization_edit')->name('manager.realization.edit.ui');
Route::get('/manager/transactions', 'Manager\ManagerController@get_transactions')->name('manager.transactions.ui');
Route::get('/manager/transactions/is_paid_off={boolean}', 'Manager\ManagerController@get_transactions_filter_is_paid_off')
    ->name('manager.transactions.is.paid.off.ui');
Route::get('/manager/transactions/search', 'Manager\TransactionController@show_by_nik')->name('manager.transactions.search.customer.id.ui');
Route::get('/manager/transactions/{id}/edit', 'Manager\ManagerController@get_transactions_edit')->name('manager.transactions.edit.ui');
Route::get('/api/v1/manager/transactions/{id}', 'Manager\ManagerController@get_transactions_api')->name('manager.transactions.rest');
Route::get('/manager/customer', 'Manager\ManagerController@get_customer')->name('manager.customer.ui');
Route::get('/manager/customer/{id}/Edit', 'Manager\ManagerController@get_customer_edit')->name('manager.customer.edit.ui');
Route::get('/manager/customer/cari', 'Manager\ManagerController@cari_customer')->name('manager.customer.cari.ui');
Route::get('/manager/warehouse_products', 'Manager\ManagerController@get_all_warehuse_products')->name('manager.warehouse.products.ui');
Route::get('/manager/warehouse_products/{id}/edit', 'Manager\ManagerController@get_warehouse_edit')->name('manager.warehouse.products.edit.ui');
Route::get('/manager/warehouse_products/create', 'Manager\ManagerController@get_warehouse_create')->name('manager.warehouse.products.create.ui');
Route::get('/manager/stores', 'Manager\ManagerController@get_stores')->name('manager.stores.ui');
Route::get('/manager/stores/{store_id}', 'Manager\ManagerController@get_products')->name('manager.stores.products.ui');
Route::get('/manager/stores/{store_id}/create', 'Manager\ManagerController@get_products_create')->name('manager.stores.products.create.ui');
Route::get('/api/v1/manager/stores/{store_id}', 'Manager\ManagerController@get_all_products_rest')->name('manager.stores.products.rest');
Route::get('/api/v1/manager/warehouse_products', 'Manager\ManagerController@get_all_warehouse_products_rest')->name('manager.store.warehouse.products.rest');
Route::get('/api/v1/manager/reports/payments/date={date_query}', 'Manager\Report\PaymentController@get_payments')->name('manager.reports.payments.rest');
Route::get('/manager/reports/payments', 'Manager\Report\PaymentController@index')->name('manager.reports.payments.ui');
Route::get('/manager/absent', 'Manager\ManagerController@get_absents')->name('manager.data.absent.ui');
Route::get('/Manager/Customer/cek_absent/{id}', 'Manager\ManagerController@cek_absents')->name('manager.absent.cek');
Route::get('/Manager/information/product', 'Manager\ManagerController@report_product')->name('manager.report.product.ui');
Route::get('/Manager/Document', 'Manager\ManagerController@get_refund')->name('manager.reports.transaction.ui');
Route::get('/Manager/Document/{id}/view', 'Manager\ManagerController@get_refund_show')->name('manager.document.view');
Route::get('/Manager/Documents/{id}/view', 'Manager\ManagerController@get_change_show')->name('manager.documents.view');
Route::get('/manager/staff', 'Manager\ManagerController@get_staff')->name('manager.staff.ui');
Route::get('/manager/staff/create', 'Manager\ManagerController@get_staff_create')->name('manager.staff.create.ui');
Route::get('/manager/staff/{id}/Edit', 'Manager\ManagerController@get_staff_edit')->name('manager.staff.edit.ui');
Route::get('/manager/staff/{id}', 'manager\ManagerController@get_data_staff')->name('manager.staff.data.ui');
Route::get('/manager/customer/{id}/profile', 'manager\ManagerController@profile_customer')->name('manager.customer.profile.ui');
// Route::get('/Manager/Document', 'Manager\ManagerController@get_change_product')->name('manager.reports.transactions.ui');


// route manager, delete, create, warehouse_product
Route::delete('/manager/warehouse_products/{id}', 'Manager\DeleteProductController@delete_warehouse_product')->name('manager.warehouse.products.delete');
Route::put('/manager/warehouse_products/{id}', 'Manager\UpdateProductController@update_warehouse_product')->name('manager.warehouse.products.update');
Route::post('/manager/warehouse_products', 'Manager\CreateProductController@create_warehouse_products')->name('manager.warehouse.products.create');

// route manager delete, update, create karyawan
// Route::put('/manager/karyawan/{id}', 'Manager\DeleteKaryawanController@deactivate_karyawan')->name('manager.karyawan.deactivate');
// Route::put('/manager/karyawan/{id}', 'Manager\DeleteKaryawanController@activate_karyawan')->name('manager.karyawan.activate');
Route::put('/manager/karyawan/{id}', 'Manager\UpdateKaryawanController@update_karyawan')->name('manager.karyawan.update');
Route::post('/manager/karyawan', 'Manager\CreateKaryawanController@create_karyawan')->name('manager.karyawan.create');

// route manager delete, update, create product
Route::post('/manager/product', 'Manager\CreateProductController@create_product')->name('manager.products.create');
Route::delete('/manager/product/{id}', 'Manager\DeleteProductController@delete_product')->name('manager.products.delete');
Route::put('/manager/product/{id}', 'Manager\UpdateProductController@update_product')->name('manager.products.update');
Route::post('/api/v1/manager/stores/{store_id}/product', 'Manager\CreateProductController@create_product_rest')->name('manager.stores.products.create.rest');

// rute manager delete, update, create Anggaran
Route::post('/manager/budgeting', 'Manager\CreateBudgetingController@create_budgeting')->name('manager.budgeting.create');
Route::put('/manager/budgeting/{id}', 'Manager\UpdateBudgetingController@update_budgeting')->name('manager.budgeting.update');
Route::delete('/manager/budgeting/{id}', 'Manager\DeleteBudgetingController@delete_budgeting')->name('manager.budgeting.delete');

//rute manager delete, update, create realisasi
Route::post('/manager/budgeting/realization', 'Manager\CreateRealizationController@create_realization')->name('manager.realization.create');
Route::put('/manager/budgeting/realization/{id}', 'Manager\UpdateRealizationController@update_realization')->name('manager.realization.update');
Route::delete('/manager/budgeting/realization/{id}', 'Manager\DeleteRealizationController@delete_realization')->name('manager.realization.delete');

//rute manager delete, update, create staff
Route::post('/manager/staff', 'Manager\CreateStaffController@create_staff')->name('manager.staff.create');
Route::put('/manager/staff/{id}', 'Manager\UpdateStaffController@update_staff')->name('manager.staff.update');
Route::delete('/manager/staff/{id}', 'Manager\DeleteStaffController@delete_staff')->name('manager.staff.delete');

//Rute Delete Transaction
Route::delete('/manager/transactions/{id}', 'Manager\DeleteTransactionController@delete_transactions')->name('manager.transactions.delete');

//Rute Delete & Update
Route::put('/manager/customer/{id}', 'Manager\UpdateCustomerController@update_customer')->name('manager.customer.update');
Route::delete('/manager/customer/{id}', 'Manager\DeleteCustomerController@delete_customer')->name('manager.customer.delete');

//rute manager refund update
Route::put('/api/v1/manager/refund/validation/{id}', 'Manager\UpdateRefundController@validation_refund')->name('manager.refund.validation');

//rute manager change product update
Route::put('/api/v1/manager/changeProduct/validation/{id}', 'Manager\UpdateChangeProductController@validation_changeProduct')->name('manager.changeProduct.validation');

//rute manager staff update
Route::put('/api/v1/manager/changeStaff/{id}', 'Manager\UpdateStaffController@change_staff')->name('manager.change.staff');

// rute kasir home
Route::get('/kasir', 'Kasir\KasirController@index')->name('kasir.ui');
Route::get('/kasir/purchase', 'Kasir\KasirController@get_work_mode')->name('kasir.purchase.ui');
Route::get('/kasir/payment', 'Kasir\KasirController@payment')->name('kasir.payment.ui');
Route::get('/api/v1/kasir/transactions/{id}', 'Kasir\KasirController@get_transaction_rest')->name('kasir.search.transaction.rest');
Route::get('/api/v1/kasir/purchase/product', 'Kasir\KasirController@get_all_products_api')->name('kasir.purchase.all.products.rest');
Route::get('/api/v1/kasir/purchase/staff/search={search_query}', 'Kasir\KasirController@search_staff_api')->name('kasir.purchase.search.staff.rest');
Route::get('/api/v1/kasir/purchase/customer/search={search_query}', 'Kasir\KasirController@search_customer_api')->name('kasir.purchase.search.customer.rest');
Route::get('/api/v1/kasir/purchase/product/search={search_query}', 'Kasir\KasirController@search_product_api')->name('kasir.purchase.search.product.rest');
Route::get('/ap1/v1/kasir/reports/date={date_query}', 'Kasir\KasirController@kasir_reports_rest_by_date')->name('kasir.reports.date.rest');
// Route::get('/ap1/v1/kasir/refund', 'Kasir\KasirController@kasir_refunds_rest')->name('kasir.refunds.rest');
Route::get('/kasir/reports', 'Kasir\KasirController@kasir_reports')->name('kasir.reports.ui');
Route::get('/kasir/refund', 'Kasir\KasirController@kasir_refund')->name('kasir.refund.ui');


// rute kasir create, update purchase transaction
Route::post('/api/v1/kasir/purchase/transactions', 'Kasir\CreateTransactionController@create_transactions')->name('kasir.purchase.transactions.create.rest');

// route kasir, create payment transaction
Route::post('/api/v1/kasir/payment/transactions', 'Kasir\CreateTransactionController@create_payment_transactions')->name('kasir.payment.transactions.create.rest');

// route kasir, create refund
Route::post('/api/v1/kasir/refund/transactions', 'Kasir\CreateTransactionController@create_refund_transactions')->name('kasir.refund.transactions.create.rest');

// route kasir, create refund
Route::post('/api/v1/kasir/change_product/transactions', 'Kasir\CreateTransactionController@create_change_product_transactions')->name('kasir.change_product.transactions.create.rest');

//rute resepsionist home
Route::get('/resepsionist', 'Resepsionist\ResepsionistController@index')->name('resepsionist.ui');
Route::get('/resepsionist/customer', 'resepsionist\resepsionistController@get_customer')->name('resepsionist.customer.ui');
Route::get('/resepsionist/customer/create', 'resepsionist\resepsionistController@get_customer_create')->name('resepsionist.customer.create.ui');
Route::get('/resepsionist/customer/{id}/Edit', 'resepsionist\resepsionistController@get_customer_edit')->name('resepsionist.customer.edit.ui');
// Route::get('/resepsionist/absent', 'resepsionist\resepsionistController@get_customer')->name('resepsionist.absent.ui');
Route::get('/resepsionist/customer/cari', 'resepsionist\resepsionistController@cari_customer')->name('resepsionist.customer.cari.ui');
Route::get('/resepsionist/customer/{id}/profile', 'resepsionist\resepsionistController@profile_customer')->name('resepsionist.customer.profile.ui');
Route::get('/resepsionist/customer/print', 'resepsionist\resepsionistController@customer_print')->name('resepsionist.customer.print.ui');
Route::get('/resepsionist/staff', 'resepsionist\resepsionistController@get_staff')->name('resepsionist.staff.ui');
Route::get('/resepsionist/staff/{id}', 'resepsionist\resepsionistController@get_data_staff')->name('resepsionist.staff.data.ui');
// Route::get('/resepsionist/staff/{id}', 'resepsionist\resepsionistController@cek_data_staff')->name('resepsionist.staff.data.ui');

// route resepsionist delete, update, create customer
Route::post('/resepsionist/customer', 'Resepsionist\CreateCustomerController@create_customer')->name('resepsionist.customer.create');
Route::put('/resepsionist/customer/{id}', 'Resepsionist\UpdateCustomerController@update_customer')->name('resepsionist.customer.update');
Route::delete('/resepsionist/customer/{id}', 'Resepsionist\DeleteCustomerController@delete_customer')->name('resepsionist.customer.delete');

Route::post('resepsionist/customer/print/code',  'resepsionist\resepsionistController@print_code')->name('resepsionist.customer.barprint');

//route absent
Route::get('/resepsionist/absent/data', 'Resepsionist\ResepsionistController@get_absents')->name('resepsionist.data.absent.ui');
Route::get('/resepsionist/absent', 'Resepsionist\ResepsionistController@form_absent')->name('resepsionist.absent.ui');
Route::post('/resepsionist/absent', 'Resepsionist\CreateAbsentController@create_absent')->name('resepsionist.absent.create');

Route::get('/resepsionist/absent/data/{id}', 'Resepsionist\ResepsionistController@cek_absents')->name('resepsionist.data.absent.cek');
Route::get('/resepsionist/barcode/print/{id}', 'Resepsionist\ResepsionistController@print_barcode')->name('print.barcode.customer');

// Route::resource('/resepsionist/absent/data/datarange', 'Resepsionist\ResepsionistController@data_range')->name('resepsionist.data.absent.range');

// Route::get('/register/{id}', 'Resepsionist\ResepsionistController@register')->name('register');
// Route::post('/register/{id}', 'Resepsionist\ResepsionistController@save_register')->name('save.register');

// Route export to excel
Route::get('export', 'Manager\ManagerController@export')->name('manager.export');


Route::post('/kasir/verif/{id}', 'Kasir\PublicKasirController@verif_payment')->name('kasir.verif')
->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);








// manager center
Route::get('/manager_center', 'ManagerCenter\HomeController@index')->name('manager_center_home.ui');
Route::get('/manager_center/karyawan', 'ManagerCenter\KaryawanController@index')->name('manager_center_karyawan.ui');
// Route::get('/manager_center/transactions', 'ManagerCenter\TransactionController@index')->name('manager_center.transactions.ui');
Route::get('/manager_center/budgetings', 'ManagerCenter\BudgetingController@index')->name('manager_center.budgeting.ui');
Route::get('/manager_center/customers', 'ManagerCenter\CustomerController@index')->name('manager_center.customer.ui');
Route::get('/manager_center/customers/cek_absent/{id}', 'ManagerCenter\CustomerController@cek_absent')->name('manager_center.customer.cek.absent.ui');
Route::get('/manager_center/customers/cari', 'ManagerCenter\CustomerController@show_by_name')->name('manager_center.customer.cari.ui');
Route::get('/manager_center/budgeting/realization', 'ManagerCenter\RealizationController@index')->name('manager_center.realization.ui');
Route::get('/manager_center/reports/payments', 'ManagerCenter\PaymentController@index')->name('manager_center.reports.payments.ui');
Route::get('/api/v1/manager_center/reports/payments/date={date_query}', 'ManagerCenter\PaymentController@shows_by_date')->name('manager_center.reports.payments.rest');
Route::get('/manager_center/absent', 'ManagerCenter\CustomerController@shows_absent')->name('manager_center.data.absent.ui');
Route::get('/manager_center/transactions/is_paid_off={boolean}', 'ManagerCenter\TransactionController@shows_transactions_filter_is_paid_off')
    ->name('manager_center.transactions.is.paid.off.ui');
Route::get('/manager_center/transactions/{id}/edit', 'ManagerCenter\TransactionController@show')->name('manager_center.transactions.edit.ui');
Route::get('/api/v1/manager_center/transactions/{id}', 'ManagerCenter\TransactionController@show_by_id_api')->name('manager_center.transactions.rest');
Route::get('/manager_center/information/product', 'ManagerCenter\ReportProductController@index')->name('manager_center.report.product.ui');
Route::get('/manager_center/staffs', 'ManagerCenter\StaffController@index')->name('manager_center.staff.ui');
Route::get('/manager_center/staff/{id}', 'ManagerCenter\StaffController@show')->name('manager_center.staff.data.ui');
Route::get('/manager_center/stores', 'ManagerCenter\StoreController@index')->name('manager_center.stores.ui');
Route::get('/manager_center/stores/{store_id}', 'ManagerCenter\StoreController@show')->name('manager_center.stores.products.ui');
Route::get('/manager_center/warehouse_products', 'ManagerCenter\WarehouseController@index')->name('manager_center.warehouse.products.ui');
Route::get('/manager_center/document', 'ManagerCenter\DokumentRefundController@index')->name('manager_center.reports.transaction.ui');
Route::get('/manager_center/document/refund/{id}/view', 'ManagerCenter\DokumentRefundController@show')->name('manager_center.document.view');
Route::get('/manager_center/document/change.product/{id}/view', 'ManagerCenter\DokumentRefundController@change_show')->name('manager_center.change.document.view');

//filter
Route::get('/manager_center/transactions/search', 'ManagerCenter\TransactionController@show_search')->name('manager_center.transactions.search.ui');
Route::get('/resepsionist/customer/search', 'Resepsionist\ResepsionistController@show_search')->name('resepsionist.data.customer.search.ui');
Route::get('/resepsionist/absent/search', 'Resepsionist\ResepsionistController@show_search_absent')->name('resepsionist.data.absent.search.ui');
Route::get('/manager/customer/search', 'Manager\ManagerController@show_search')->name('manager.data.customer.search.ui');