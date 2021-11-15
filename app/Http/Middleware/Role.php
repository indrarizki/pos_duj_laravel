<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (!Auth::check()) // I included this check because you have it, but it really should be part of your 'auth' middleware, most likely added as part of a route group.
            return redirect('login');
        $user = Auth::user();
        $role = $user->role;
        $route = $request->route();
        if ($role == 'kasir') {
            // return $next($request);
            if ($route->named('kasir.ui')) return $next($request);
            if ($route->named('kasir.purchase.ui')) return $next($request);
            if ($route->named('kasir.purchase.products.rest')) return $next($request);
            if ($route->named('kasir.purchase.all.products.rest')) return $next($request);
            if ($route->named('kasir.purchase.transactions.create.rest')) return $next($request);
            if ($route->named('kasir.purchase.search.customer.rest')) return $next($request);
            if ($route->named('kasir.purchase.search.staff.rest')) return $next($request);
            if ($route->named('kasir.purchase.search.product.rest')) return $next($request);
            if ($route->named('kasir.payment.ui')) return $next($request);
            if ($route->named('kasir.search.transaction.rest')) return $next($request);
            if ($route->named('kasir.payment.transactions.create.rest')) return $next($request);
            if ($route->named('kasir.reports.product.ui')) return $next($request);
            if ($route->named('kasir.reports.ui')) return $next($request);
            if ($route->named('kasir.reports.date.rest')) return $next($request);
            if ($route->named('kasir.refund.ui')) return $next($request);
            if ($route->named('kasir.refund.transactions.create.rest')) return $next($request);
            if ($route->named('kasir.change_product.transactions.create.rest')) return $next($request);
        } elseif ($role == 'manager') {
            if ($route->named('manager.ui')) return $next($request);
            if ($route->named('manager.karyawan.ui'))  return $next($request);
            if ($route->named('manager.karyawan.edit.ui')) return $next($request);
            if ($route->named('manager.karyawan.create.ui'))  return $next($request);
            if ($route->named('manager.karyawan.activate')) return $next($request);
            if ($route->named('manager.karyawan.deactivate')) return $next($request);
            if ($route->named('manager.karyawan.update')) return $next($request);
            if ($route->named('manager.karyawan.create')) return $next($request);
            if ($route->named('manager.products.ui')) return $next($request);
            if ($route->named('manager.products.create.ui')) return $next($request);
            if ($route->named('manager.products.create')) return $next($request);
            if ($route->named('manager.products.delete')) return $next($request);
            if ($route->named('manager.products.delete.ui')) return $next($request);
            if ($route->named('manager.products.edit.ui')) return $next($request);
            if ($route->named('manager.products.update')) return $next($request);
            if ($route->named('manager.transactions.ui')) return $next($request);
            if ($route->named('manager.transactions.is.paid.off.ui')) return $next($request);
            if ($route->named('manager.transactions.edit.ui')) return $next($request);
            if ($route->named('manager.transactions.rest')) return $next($request);
            if ($route->named('manager.budgeting.ui')) return $next($request);
            if ($route->named('manager.budgeting.create.ui')) return $next($request);
            if ($route->named('manager.budgeting.create')) return $next($request);
            if ($route->named('manager.budgeting.edit.ui')) return $next($request);
            if ($route->named('manager.budgeting.update')) return $next($request);
            if ($route->named('manager.budgeting.delete')) return $next($request);
            if ($route->named('manager.realization.ui')) return $next($request);
            if ($route->named('manager.realization.create.ui')) return $next($request);
            if ($route->named('manager.realization.create')) return $next($request);
            if ($route->named('manager.realization.edit.ui')) return $next($request);
            if ($route->named('manager.realization.update')) return $next($request);
            if ($route->named('manager.realization.delete')) return $next($request);
            if ($route->named('manager.customer.ui')) return $next($request);
            if ($route->named('manager.customer.edit.ui'))  return $next($request);
            if ($route->named('manager.customer.update'))  return $next($request);
            if ($route->named('manager.customer.delete')) return $next($request);
            if ($route->named('manager.customer.cari.ui'))  return $next($request);
            if ($route->named('manager.warehouse.products.ui')) return $next($request);
            if ($route->named('manager.warehouse.products.delete')) return $next($request);
            if ($route->named('manager.warehouse.products.edit.ui')) return $next($request);
            if ($route->named('manager.warehouse.products.update')) return $next($request);
            if ($route->named('manager.warehouse.products.create.ui')) return $next($request);
            if ($route->named('manager.warehouse.products.create')) return $next($request);
            if ($route->named('manager.stores.ui')) return $next($request);
            if ($route->named('manager.stores.products.ui')) return $next($request);
            if ($route->named('manager.stores.products.create.ui')) return $next($request);
            if ($route->named('manager.stores.products.rest')) return $next($request);
            if ($route->named('manager.store.warehouse.products.rest')) return $next($request);
            if ($route->named('manager.stores.products.create.rest')) return $next($request);
            if ($route->named('manager.reports.payments.ui')) return $next($request);
            if ($route->named('manager.reports.payments.rest')) return $next($request);
            if ($route->named('manager.data.absent.ui')) return $next($request);
            if ($route->named('manager.absent.cek')) return $next($request);
            if ($route->named('manager.reports.transaction.ui')) return $next($request);
            if ($route->named('manager.document.view')) return $next($request);
            if ($route->named('manager.documents.view')) return $next($request);
            if ($route->named('manager.report.product.ui')) return $next($request);
            // if ($route->named('manager.reports.transactions.ui')) return $next($request);
            if ($route->named('kasir.purchase.search.product.rest')) return $next($request);
            if ($route->named('kasir.purchase.search.staff.rest')) return $next($request);
            if ($route->named('manager.refund.validation')) return $next($request);
            if ($route->named('manager.changeProduct.validation')) return $next($request);
            if ($route->named('manager.staff.ui')) return $next($request);
            if ($route->named('manager.staff.create.ui')) return $next($request);
            if ($route->named('manager.staff.create')) return $next($request);
            if ($route->named('manager.staff.edit.ui'))  return $next($request);
            if ($route->named('manager.staff.delete')) return $next($request);
            if ($route->named('manager.staff.update'))  return $next($request);
            if ($route->named('manager.staff.data.ui'))  return $next($request);
            if ($route->named('manager.change.staff'))  return $next($request);
            if ($route->named('manager.transactions.search.customer.id.ui')) return $next($request);
            if ($route->named('manager.data.customer.search.ui')) return $next($request);
            if ($route->named('manager.customer.profile.ui')) return $next($request);
        } elseif ($role == 'resepsionist') {
            if ($route->named('resepsionist.ui')) return $next($request);
            if ($route->named('resepsionist.customer.ui'))  return $next($request);
            if ($route->named('resepsionist.customer.cari.ui'))  return $next($request);
            if ($route->named('resepsionist.customer.create.ui'))  return $next($request);
            if ($route->named('resepsionist.customer.create'))  return $next($request);
            if ($route->named('resepsionist.customer.edit.ui'))  return $next($request);
            if ($route->named('resepsionist.customer.update'))  return $next($request);
            if ($route->named('resepsionist.Absent.ui')) return $next($request);
            if ($route->named('resepsionist.customer.delete')) return $next($request);
            if ($route->named('resepsionist.customer.profile.ui')) return $next($request);
            if ($route->named('resepsionist.customer.print.ui')) return $next($request);
            if ($route->named('resepsionist.absent.ui')) return $next($request);
            if ($route->named('resepsionist.absent.create')) return $next($request);
            if ($route->named('resepsionist.data.absent.ui')) return $next($request);
            if ($route->named('resepsionist.data.absent.cek')) return $next($request);
            if ($route->named('resepsionist.staff.ui'))  return $next($request);
            if ($route->named('resepsionist.staff.data.ui'))  return $next($request);
            if ($route->named('resepsionist.data.customer.search.ui'))  return $next($request);
            if ($route->named('resepsionist.data.absent.search.ui')) return $next($request);
            if ($route->named('print.barcode.customer')) return $next($request); 
            // return $next($request);
        } 
        elseif ($role == 'manager_center') {
            if ($route->named('manager_center_home.ui'))  return $next($request);
            if ($route->named('manager_center_karyawan.ui'))  return $next($request);
            if ($route->named('manager_center.transactions.ui'))  return $next($request);
            if ($route->named('manager_center.budgeting.ui')) return $next($request);
            if ($route->named('manager_center.realization.ui')) return $next($request);
            if ($route->named('manager_center.customer.ui')) return $next($request);
            if ($route->named('manager_center.customer.cek.absent.ui')) return $next($request);
            if ($route->named('manager_center.customer.cari.ui')) return $next($request);
            if ($route->named('manager_center.reports.payments.ui')) return $next($request);
            if ($route->named('manager_center.reports.payments.rest')) return $next($request);
            if ($route->named('manager_center.data.absent.ui')) return $next($request);
            if ($route->named('manager_center.transactions.is.paid.off.ui')) return $next($request);
            if ($route->named('manager_center.transactions.edit.ui')) return $next($request);
            if ($route->named('manager_center.transactions.rest')) return $next($request);
            if ($route->named('manager_center.report.product.ui')) return $next($request);
            if ($route->named('manager_center.staff.ui')) return $next($request);
            if ($route->named('manager_center.staff.data.ui')) return $next($request);
            if ($route->named('manager_center.stores.ui')) return $next($request);
            if ($route->named('manager_center.stores.products.ui')) return $next($request);
            if ($route->named('manager_center.warehouse.products.ui')) return $next($request);
            if ($route->named('manager_center.reports.transaction.ui')) return $next($request);
            if ($route->named('manager_center.document.view')) return $next($request);
            if ($route->named('manager_center.change.document.view')) return $next($request);
            if ($route->named('manager_center.transactions.search.ui')) return $next($request);
            if ($route->named('manager_center.data.staff.search.ui')) return $next($request);
        }

        // else {
        //     return $next($request);
        // }
        return redirect('/');
    }
}
