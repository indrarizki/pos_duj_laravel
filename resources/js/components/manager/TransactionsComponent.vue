<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Products</div>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">ID</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Role</th>
                <th scope="col">Dibuat</th>
                <th scope="col">Diperbarui</th>
                <!-- <th scope="col">
                  <a href="{{ route('manager.products.create.ui')}}">Buat Baru</a>
                </th>-->
              </tr>
            </thead>
            <tbody>
              @foreach ($products as $product)
              <tr>
                <th scope="row"></th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>
                  <a href>Edit</a>
                </td>

                <td>
                  <form action method="post">
                    <button type="submit" class="btn btn-primary btn-sm">Hapus</button>
                  </form>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {};
</script>
