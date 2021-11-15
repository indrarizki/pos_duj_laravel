<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Transaksi ID : {{ transaction["id"] }}</h5>
            <h6 class="card-text">
              Tanggal : {{ transaction["created_at"] | moment }}
            </h6>
          </div>
        </div>
        <div style="margin-top: 10px" class="card">
          <div class="card-body">
            <h5 class="card-title">
              Customer ID : {{ transaction["customers"]["id"] }}
            </h5>
            <h6 class="card-text">
              Nama Customer : {{ transaction["customers"]["name"] }}
            </h6>
          </div>
        </div>
        <div style="margin-top: 10px" class="card">
          <div class="card-body">
            <h5 class="card-title">
              Nama Staff: {{ transaction["staffs"]["id"] }}
            </h5>
            <h6 class="card-text">
              ID Staff: {{ transaction["staffs"]["name"] }}
            </h6>
          </div>
        </div>

        <div style="margin-top: 10px" class="card">
          <div class="card-body">
            <h5 class="card-title">Product</h5>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total Harga</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(productTransaction, index) in transaction[
                      'product_transactions'
                    ]"
                    v-bind:key="index"
                  >
                    <td scope="row">{{ index + 1 }}</td>
                    <td>
                      {{
                        productTransaction["products"]["warehouse_product"][
                          "name"
                        ]
                      }}
                    </td>
                    <td>{{ productTransaction["quantity"] }}</td>
                    <td>
                      {{ productTransaction["product_price"] | currency }}
                    </td>
                    <td>{{ productTransaction["total_price"] | currency }}</td>
                  </tr>
                  <tr>
                    <td scope="row">#</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ getTotalPrice() | currency }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div style="margin-top: 10px" class="card">
          <div class="card-body">
            <h5 class="card-title">Pembayaran</h5>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Staff</th>
                    <th scope="col">Pembayaran</th>
                  </tr>
                </thead>
                <tbody>
                  <tr
                    v-for="(productTransaction, index) in transaction[
                      'payment_transactions'
                    ]"
                    v-bind:key="index"
                  >
                    <td scope="row">{{ index + 1 }}</td>
                    <td>{{ productTransaction["created_at"] | moment }}</td>
                    <td>{{ transaction["users"]["name"] }}</td>
                    <td>{{ productTransaction["cost"] | currency }}</td>
                  </tr>

                  <tr>
                    <td scope="row">#</td>
                    <td>Kekurangan</td>
                    <td></td>
                    <td>
                      {{ getLackTotalPrice() | currency }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  
</template>

<script>
import VueCurrencyFilter from "vue-currency-filter";
import axios from "axios";
import moment from "moment";
import Autocomplete from "vuejs-auto-complete";
Vue.use(VueCurrencyFilter, {
  symbol: "Rp.",
  thousandsSeparator: ".",
  fractionCount: 0,
  fractionSeparator: ",",
  symbolPosition: "front",
});

export default {
  props: {
    transactionId: String,
    token: String,
    baseUrl: String,
  },
  components: {
    Autocomplete,
  },
  data: () => ({
    transaction: [],
    isShowModal: false,
    isShowModalChange: false,
    options: ["jj"],
    productsToChange: [],
    temp: 0,
  }),
  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    test123() {
      let temp = [];
      this.transaction["product_transactions"].forEach((element) => {
        let productName = element["products"]["warehouse_product"]["name"];
        temp.push(productName);
        console.log(productName);
      });
      this.options = temp;
      console.log(temp);

      this.isShowModalChange = true;
    },
    searchProductQuery(input) {
      console.log(input);
      console.log(this.$props.baseUrl);
      return (
        this.$props.baseUrl + "/api/v1/kasir/purchase/product/search=" + input
      );
    },
    resultsSearchProduct(result) {
      console.log(result);
      return result.warehouse_products.name;
    },
    selectedProductQuery(group) {
      // this.$refs.autocompleteProduct.clear();
      let vm = this;
      let data = group["selectedObject"];
      data["quantity"] = 1;
      vm.temp = data["price"];
      this.productsToChange = data;
      // let isExistingData = false;
      // data["max_quantity"] = data["quantity"];
      // data["quantity"] = 1;

      // if (vm.productsToSell.length > 0) {
      //   for (let index = 0; index < vm.productsToSell.length; index++) {
      //     const oldData = vm.productsToSell[index];
      //     // conditional to make sure data not duplicated
      //     if (data["id"] == oldData["id"]) {
      //       // update existing data
      //       oldData["quantity"] += data["quantity"];
      //       isExistingData = true;
      //       // vm.updateTotalPriceQuantity(vm.productsToSell);
      //       break;
      //     }
      //   }
      //   if (!isExistingData) {
      //     vm.productsToSell.push(data);
      //     //   vm.updateTotalPriceQuantity(vm.productsToSell);
      //   }
      // } else if (vm.productsToSell.length == 0) {
      //   vm.productsToSell.push(data);
      //   // vm.updateTotalPriceQuantity(vm.productsToSell);
      // }
    },

    getTotalPrice() {
      let totalCost = 0;
      for (
        let index = 0;
        index < this.transaction["product_transactions"].length;
        index++
      ) {
        const element = this.transaction["product_transactions"][index];
        const productPrice = element["product_price"];
        const quantity = element["quantity"];
        totalCost += productPrice * quantity;
      }
      return totalCost;
    },

    getLackTotalPrice() {
      const totalPrice = this.getTotalPrice();
      let lackTotalPrice = 0;
      for (
        let index = 0;
        index < this.transaction["payment_transactions"].length;
        index++
      ) {
        const element = this.transaction["payment_transactions"][index];
        const cost = element["cost"];

        lackTotalPrice += cost;
      }
      return totalPrice - lackTotalPrice;
    },
    getTransaction() {
      let vm = this;
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .get(
          this.$props.baseUrl +
            "/api/v1/manager_center/transactions/" +
            this.$props.transactionId,

          config
        )
        .then(function (response) {
          vm.transaction = response.data;
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    validation() {
      let vm = this;
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .put(
          this.$props.baseUrl +
            "/api/v1/manager/refund/validation/" +
            vm.transaction["refund_transactions"]["id"],
          { is_refund_off: 1 },
          config
        )
        .then(function (response) {
          console.log(response);
          location.reload();
        })
        .catch(function (error) {
          if (error) {
            vm.transaction = 404;
          }
          console.log(error);
        });
      this.paymentValue = 0;
      this.isInputPayActive = false;
    },
    ChangeProduct() {
      let vm = this;
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      console.log(this.product_id);
      axios
        .put(
          this.$props.baseUrl +
            "/api/v1/manager/changeProduct/validation/" +
            vm.transaction["product_transactions"][0]["id"],
          {
            product_id: vm.productsToChange["id"],
            quantity: vm.productsToChange["quantity"],
            product_price: vm.productsToChange["price"],
            total_price: vm.temp,
          },
          config
        )
        .then(function (response) {
          console.log(response);
          location.reload();
        })
        .catch(function (error) {
          if (error) {
            vm.transaction = 404;
          }
          console.log(error);
        });
    },
  },
  watch: {
    /// listener
    productsToChange: {
      handler: function (newVal, oldVal) {
        console.log(newVal["quantity"]);
        console.log(oldVal["price"]);
        if (newVal != oldVal) {
          // console.log(newVal);
          // let oldPrice = parseFloat(oldVal["price"]);
          // let newPrice = parseFloat(newVal["price"]);
          let newQuantity = parseInt(newVal["quantity"]);

          // this.productsToChange["price"] = newQuantity * 231;
          // console.log(newQuantity);
          // console.log(this.productsToChange["price"]);
          // console.log(this.productsToChange["price"]);
          // console.log(oldVal);
          // console.log(newVal);d
          // this.productsToChange["price"] = newVal["quantity"] * newVal["price"];
        }
        console.log(typeof oldVal["price"]);
        console.log(typeof newVal["quantity"]);
        this.temp = 0;
        this.temp = parseInt(newVal["quantity"]) * parseFloat(newVal["price"]);
        console.log(typeof this.productsToChange["price"]);
        // console.log(newVal);
      },
      deep: true,
    },
  },

  created() {
    this.getTransaction();
  },

  computed: {},
  filters: {
    moment: function (date) {
      return moment(date).format("MM/DD/YYYY hh:mm");
    },
  },
};
</script>

<style>
</style>
