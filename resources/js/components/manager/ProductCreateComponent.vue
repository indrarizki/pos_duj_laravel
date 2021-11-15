<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Product</h5>
            <div class="form-group">
              <label>Nama</label>
              <select v-model="selectedProduct" class="form-control">
                <option
                  v-for="(warehouseProduct, index) in filteredWarehouseProducts"
                  v-bind:key="index"
                  :value="warehouseProduct"
                >{{warehouseProduct['name']}}</option>
              </select>
              <div v-if="selectedProduct != null">
                <label>Harga</label>
                <input
                  class="form-control"
                  v-model="displayPriceValue"
                  @blur="isInputPriceActive = false"
                  @focus="isInputPriceActive = true"
                />
              </div>

              <label>Jumlah</label>
              <input v-model="quantity" type="number" class="form-control" />
              <label
                v-if="selectedProduct != null"
              >Max jumlah yang dapat dikirim ke toko : {{selectedProduct['quantity']}}</label>
            </div>
            <button @click="saveProductToStore" class="form-control">Ok</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import VueCurrencyFilter from "vue-currency-filter";
import axios from "axios";

Vue.use(VueCurrencyFilter, {
  symbol: "Rp.",
  thousandsSeparator: ".",
  fractionCount: 0,
  fractionSeparator: ",",
  symbolPosition: "front",
});
Vue.filter("formatDate", function (value) {
  if (value) {
    return moment(String(value)).format("MM/DD/YYYY hh:mm");
  }
});
export default {
  props: {
    storeId: String,
    token: String,
    baseUrl: String,
  },
  data() {
    return {
      products: [],
      warehouseProducts: [],
      filteredWarehouseProducts: [],
      selectedProduct: null,
      quantity: 0,
      config: {
        headers: { Authorization: `Bearer ${this.token}` },
      },
      isInputPriceActive: false,
    };
  },

  created() {
    this.getProducts();
    this.getWarehouseProducts();
  },

  methods: {
    saveProductToStore() {
      let vm = this;
      axios
        .post(
          this.$props.baseUrl +
            "/api/v1/manager/stores/" +
            this.storeId +
            "/product",
          {
            warehouse_product_id: vm.selectedProduct["id"],
            quantity: vm.quantity,
            price: vm.selectedProduct["price"],
          },

          this.config
        )
        .then(function (response) {
          alert("berhasil insert data");
          vm.products = [];
          vm.warehouseProducts = [];
          vm.filteredWarehouseProducts = [];
          vm.selectedProduct = [];
          vm.quantity = 0;
          vm.getProducts();
          vm.getWarehouseProducts();
          window.location.href = vm.baseUrl + "/manager/stores/" + vm.storeId;
        })
        .catch(function (error) {
          alert(error.response.data.error);
          console.log(error.response);
        });
    },

    getProducts() {
      let vm = this;
      axios
        .get(
          this.$props.baseUrl + "/api/v1/manager/stores/" + this.$props.storeId,
          this.config
        )
        .then(function (response) {
          vm.products = response.data;
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getWarehouseProducts() {
      let vm = this;
      axios
        .get(
          this.$props.baseUrl + "/api/v1/manager/warehouse_products",
          this.config
        )
        .then(function (response) {
          vm.warehouseProducts = response.data;
          console.log(response.data);
          vm.filterProducts();
        })
        .catch(function (error) {
          console.log(error);
        });
    },

    filterProducts() {
      //   this.filteredWarehouseProducts = this.warehouseProducts.filter(
      //     (warehouseProductsElement) => {
      //       let updateFiltered = true;
      //       this.products.forEach((productsElement) => {
      //         warehouseProductsElement["id"] !=
      //           productsElement["warehouse_product_id"];
      //       });
      //     }
      //   );

      for (let i = 0; i < this.warehouseProducts.length; i++) {
        const warehouseElement = this.warehouseProducts[i];
        let updateWarehouseProducts = true;
        for (let j = 0; j < this.products.length; j++) {
          const productElement = this.products[j];
          if (
            warehouseElement["id"] == productElement["warehouse_product_id"]
          ) {
            updateWarehouseProducts = false;
            break;
          }
        }
        console.log(updateWarehouseProducts);
        if (updateWarehouseProducts) {
          let obj = {};
          obj["name"] = warehouseElement["name"];
          obj["id"] = warehouseElement["id"];
          obj["price"] = warehouseElement["price"];
          obj["quantity"] = warehouseElement["quantity"];
          this.filteredWarehouseProducts.push(obj);
          // this.filteredWarehouseProducts[i]= warehouseElement["id"];
          // this.filteredWarehouseProducts[i]["name"] = warehouseElement["name"];
          // this.filteredWarehouseProducts[i]["quantity"] =
          //   warehouseElement["quantity"];
        }
      }
      console.log("filtered");
      console.log(this.filteredWarehouseProducts);
    },
  },

  computed: {
    displayPriceValue: {
      get: function () {
        if (this.isInputPriceActive) {
          return this.selectedProduct["price"].toString();
        } else {
          return (
            "Rp. " +
            this.selectedProduct["price"]
              .toFixed(0)
              .replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1.")
          );
        }
      },
      set: function (modifiedValue) {
        let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ""));

        if (isNaN(newValue)) {
          newValue = 0;
        }
        this.selectedProduct["price"] = newValue;
        // this.$emit('input', newValue)
      },
    },
  },
};
</script>
