<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Product;
use App\Transaction;
use App\User;
use App\Budgeting;
use App\Realization;
use App\Customer;
use App\Store;
use App\WarehouseProduct;
use App\AbsentCust;
use App\ReportProduct;
use App\Refund;
use App\ChangeProductTransaction;
use App\Staff;
use App\Exports\CustomerExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use stdClass;

class ManagerController extends Controller
{

    public function __construct()
    {
        $this->middleware('role');
    }

    public function index()
    {

        return view('manager.home');
    }

    public function get_karyawan()
    {
        $data = User::wherein('role', ['kasir', 'resepsionist', 'manager', 'manager_center'])
            ->where('id', '!=', Auth()->user()->id)
            ->orderBy('is_active', 'desc')
            ->get();
        $roles = User::getRules();
        return view('manager.karyawan', ['data' => $data, 'roles' => $roles]);
    }

    public function get_karyawan_edit($id)
    {
        $data = User::where('id', '=', $id)->first();
        $roles = User::getRules();
        unset($roles['manager']);
        return view('manager.karyawan_edit', ['user' => $data, 'roles' => $roles]);
    }

    public function get_karyawan_create()
    {

        $roles = User::getRules();
        unset($roles['manager']);
        return view('manager.karyawan_create', ['roles' => $roles]);
    }

    public function get_products($store_id)
    {
        //wherein('role', ['sale', 'asset'])->get()
        $data = Product::get_products($store_id);
        return view('manager.products', ['products' => $data]);
    }

    public function get_products_create($store_id)
    {
        $products = Product::get_products($store_id, null);
        // $warehouse_products = WarehouseProduct::all();

        // $products_to_input = array();
        // for ($i = 0; $i < count($warehouse_products); $i++) {
        //     $object = array();
        //     $update_item = true;
        //     for ($j = 0; $j < count($products); $j++) {
        //         if ($products[$j]['warehouse_product_id'] == $warehouse_products[$i]['id']) {
        //             $update_item = false;
        //             break;
        //         }
        //     }
        //     if ($update_item) {
        //         $object[] = $warehouse_products[$i]['name'];
        //         $object[] = $warehouse_products[$i]['price'];
        //         $products_to_input[] = $object;
        //     }
        // };

        $access_token = User::get_access_token("Manager");
        $base_url = url('/');
        $payload = [
            'store_id' => $store_id,
            'token' => $access_token,
            'base_url' => $base_url,
        ];

        return view('manager.product_create', $payload);
    }

    public function get_all_products_rest($store_id)
    {
        $products = Product::get_products($store_id, null);
        return response()->json($products, 200);
    }

    public function get_all_warehouse_products_rest()
    {
        $warehouse_products = WarehouseProduct::where('is_deleted', '=', false)->get();
        return response()->json($warehouse_products, 200);
    }

    public function get_products_edit($id)
    {
        $data = Product::get_products(null, $id);
        return view('manager.product_edit', ['product' => $data]);
    }

    public function get_budgeting()
    {
        $data = Budgeting::all();
        return view('manager.budgeting', ['budgeting' => $data]);
    }
    public function get_budgeting_create()
    {
        return view('manager.budgeting_create');
    }
    public function get_budgeting_edit($id)
    {
        $data = Budgeting::where('id', '=', $id)->first();
        return view('manager.budgeting_edit', ['budgeting' => $data]);
    }
    public function get_realization()
    {
        $data = Realization::all();
        return view('manager.realization', ['realization' => $data]);
    }
    public function get_realization_create()
    {
        return view('manager.realization_create');
    }
    public function get_realization_edit($id)
    {
        $data = Realization::where('id', '=', $id)->first();
        return view('manager.realization_edit', ['realization' => $data]);
    }

    public function get_transactions()
    {
        $data = Transaction::get_all_transactions();
        return view('manager.transactions', ['transactions' => $data]);
    }

    public function get_transactions_filter_is_paid_off($boolean)
    {
        $data = Transaction::get_all_transactions_filter_is_paid_off($boolean);
        return view('manager.transactions', ['transactions' => $data]);
    }

    public function get_transactions_edit($id)
    {
        $access_token = User::get_access_token("Manager");
        $base_url = url('');
        $payload = [
            'id' => $id,
            'token' => $access_token,
            'base_url' => $base_url,
        ];
        return view('manager.transaction_edit', $payload);
    }

    public function get_transactions_api($id)
    {
        $data = Transaction::get_transaction($id);
        $response = response()->json($data, 200);
        return $response;
    }
    public function get_customer()
    {

        $data = Customer::getAllCustomers();
        $context = [
            'customers' => $data,
            'date_time' => $data,
            'sort_type' => $data,
            'id' => ""
        ];
        return view('manager.customer', $context);
    }
    public function show_search(Request $request)
    {
        $data =  Customer::search($request);
        $context = [
            'customers' => $data["customers"],
            // 'is_paid_off' => $data["where_query"]['is_paid_off'] ?? "all",
            'id' => $data["where_query"]['id'] ?? "",
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('resepsionist.customer', $context);
    }
    public function get_customer_edit($id)
    {
        $data = Customer::where('id', '=', $id)->first();
        return view('manager.customer_edit', ['customer' => $data]);
    }
    public function profile_customer($id)
    {
        $data = Customer::where('id', '=', $id)->first();
        $customers = Customer::find($id);
        $absent = $customers->absents()->get();
        return view('manager.customer_profil', ['customer' => $data, 'absent' => $absent]);
    }
    public function cari_customer(Request $request)
    {
        $cari = $request->cari;
        $data = Customer::where('name', 'like', "%" . $cari . "%")->paginate();

        return view('manager.customer', ['customer' => $data]);
    }

    public function get_all_warehuse_products()
    {
        $data = WarehouseProduct::where('is_deleted', '=', false)->get();
        return view('manager.warehouse_products', ['products' => $data]);
    }

    public function get_warehouse_edit($id)
    {
        $data = WarehouseProduct::where('id', '=', $id)->first();
        return view('manager.warehouse_product_edit', ['product' => $data]);
    }

    public function get_warehouse_create()
    {
        return view('manager.warehouse_product_create');
    }

    public function get_stores()
    {
        $data = Store::all();
        return view('manager.stores', ['stores' => $data]);
    }
    public function get_absents()
    {
        $data = AbsentCust::paginate(100);
        $context = [
            'absentcusts' => $data,
            'date_time' => $data,
            'sort_type' => $data,
        ];
        return view('manager.customer_absent', $context);
    }
    public function show_search_absent(Request $request)
    {
        $data =  AbsentCust::search($request);
        $context = [
            'absentcusts' => $data["absentcusts"],
            'sort_type' => $data["sort_type"] ?? "desc",
            'date_time' => $data['where_query']['date_time'] ?? null
        ];
        return view('resepsionist.customer_absent', $context);
    }
    public function cek_absents($id)
    {
        $customers = Customer::find($id);
        $absent = $customers->absents()->get();
        return view('manager.customer_cek_absent', compact('absent'));
    }
    public function report_product()
    {
        $data = ReportProduct::all();
        return view('manager.report_product', ['report' => $data]);
    }
    public function get_refund()
    {
        $refund_validation = Refund::where('is_refund_off', '=', true)->get();
        $refund = Refund::where('is_refund_off', '=', false)->get();
        $change_validation = ChangeProductTransaction::where('is_change_off', '=', true)->get();
        $change = ChangeProductTransaction::where('is_change_off', '=', false)->get();
        return view('manager.refund_pindah', compact("refund_validation","refund", "change", "change_validation"));
    }
    public function get_refund_show($id)
    {
        $data = Refund::find($id);
        return view('manager.refund_show', compact('data'));
    }
    public function get_change_show($id)
    {
        $data = ChangeProductTransaction::find($id);
        return view('manager.change_show', compact('data'));
    }
    public function get_staff()
    {
        $data = Staff::all();
        return view('manager.staff', ['staff' => $data]);
    }
    public function get_staff_create()
    {
        return view('manager.staff_create');
    }
    public function get_staff_edit($id)
    {
        $data = Staff::where('id', '=', $id)->first();
        return view('manager.staff_edit', ['staff' => $data]);
    }
    public function get_data_staff($id)
    {
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $data = Staff::where('id', '=', $id)->first();
        // return view('resepsionist.staff_data', ['staff' => $data]);
        $staff = Staff::find($id);
        $transactions = $staff->transactions()->get();
        

        // $out->writeln($transactions);
        foreach ($transactions as $transaction) {
            // $out->writeln($value->id);
            $products = Staff::get_product_transaction($transaction->id);
            $transaction->products = $products;

            foreach ($transaction->products as $product) {
                // $out->writeln($product);
                $products = Staff::get_product($product->product_id);

                // $out->writeln($products);

                $warehouse = Staff::get_warehouse($products->warehouse_product_id);

                    // $out->writeln($warehouse->name);
                $name = $warehouse->name;

                $product->name = $name;
            }
        }
        // $out->writeln($transactions);
        return view('manager.staff_data', ['data' => $data , 'transactions' => $transactions]);
        
    }
}
