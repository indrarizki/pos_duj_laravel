<template>
  <div class="container-fluid">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Pembelian</div>
          </div>
          <div class="card-body">
            <div ref="content">
              <table id="table" class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">No</th>
                    <th scope="col">Id</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col">Harga</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>

                <tbody class>
                  <tr
                    v-for="(product, index) in productsToSell"
                    v-bind:key="index"
                  >
                    <td scope="row">{{ index + 1 }}</td>
                    <td>{{ product["id"] }}</td>
                    <td>{{ product["warehouse_products"]["name"] }}</td>
                    <td>
                      <input
                        v-model="product['quantity']"
                        type="number"
                        class="form-control form-control-sm"
                      />
                    </td>
                    <td>
                      <input
                        style="background: transparent"
                        disabled
                        class="form-control form-control-sm"
                        type="text"
                        :value="product['price'] | currency"
                      />
                    </td>
                    <td>
                      <input
                        style="background: transparent"
                        disabled
                        class="form-control form-control-sm"
                        type="text"
                        :value="
                          (product['price'] * product['quantity']) | currency
                        "
                      />
                    </td>
                  </tr>
                </tbody>
                <tr>
                  <td scope="row">#</td>
                  <td></td>
                  <td></td>
                  <td>
                    <input
                      style="background: transparent"
                      disabled
                      class="form-control form-control-sm"
                      type="text"
                      :value="totalQuantity"
                    />
                  </td>
                  <td></td>
                  <td>
                    <input
                      style="background: transparent"
                      disabled
                      class="form-control form-control-sm"
                      type="text"
                      :value="totalPrice | currency"
                    />
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>Pembayaran</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <input
                      type="text"
                      style="background: transparent"
                      class="form-control form-control-sm"
                      v-model="displayPayValue"
                      @blur="isInputPayActive = false"
                      @focus="isInputPayActive = true"
                    />
                  </td>
                </tr>
                <tr>
                  <td></td>
                  <td>Kekurangan</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td>
                    <input
                      type="text"
                      style="background: transparent"
                      class="form-control form-control-sm"
                      :value="installmentPayment | currency"
                      @blur="isInputPayActive = false"
                      @focus="isInputPayActive = true"
                    />
                  </td>
                </tr>
              </table>
            </div>
            <div class="form-group">
              <label for>Staff</label>
              <autocomplete
                ref="autocompleteStaff"
                placeholder="Kamila"
                :source="searchStaffQuery"
                input-class="form-control form-control-sm"
                results-property="data"
                :results-display="resultsSearchStaff"
                @selected="selectedStaffQuery"
              ></autocomplete>
            </div>
            <div class="form-group">
              <label for>Customer</label>
              <autocomplete
                ref="autocompleteCustomer"
                placeholder="Budi"
                :source="searchCustomerQuery"
                input-class="form-control form-control-sm"
                results-property="data"
                :results-display="resultsSearchCustomer"
                @selected="selectedCustomerQuery"
              ></autocomplete>
            </div>
            <div class="form-group">
              <div class>
                <label for>Barang</label>
                <autocomplete
                  ref="autocompleteProduct"
                  placeholder="Redmi"
                  :source="searchProductQuery"
                  input-class="form-control form-control-sm"
                  :results-display="resultsSearchProduct"
                  @selected="selectedProductQuery"
                ></autocomplete>
              </div>
            </div>
            <div class="form-group">
              <button
                @click="isShowModal = true"
                class="form-control form-control-sm"
              >
                Print
              </button>
            </div>

            <div class="form-group">
              <button @click="reset()" class="form-control form-control-sm">
                Reset
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal -->
    <div v-if="isShowModal">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Masukan Nilai</h5>
                  <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                  >
                    <span aria-hidden="true" @click="isShowModal = false"
                      >&times;</span
                    >
                  </button>
                </div>

                <div class="modal-body">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="isShowModal = false"
                  >
                    Batal
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="
                      verificationBUyer();
                      isShowModal = false;
                    "
                  >
                    Verifikasi
                  </button>
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="
                      print();
                      isShowModal = false;
                    "
                  >
                    Print
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import VueCurrencyFilter from "vue-currency-filter";
import jsPDF from "jspdf";
import "jspdf-autotable";
import domtoimage from "dom-to-image";
import Autocomplete from "vuejs-auto-complete";
import html2canvas from "html2canvas";
Vue.use(VueCurrencyFilter, {
  symbol: "Rp.",
  thousandsSeparator: ".",
  fractionCount: 0,
  fractionSeparator: ",",
  symbolPosition: "front",
});

export default {
  props: {
    baseUrl: String,
    token: String,
  },
  components: {
    Autocomplete,
  },
  data: () => ({
    isInputPayActive: false,
    paymentValue: 0,
    message: "",
    products: [],
    customer: null,
    staff: null,
    selectedProduct: "",
    selectedCustomer: "",
    productsToSell: [],
    totalQuantity: 0,
    totalPrice: 0,
    isPrint: false,
    installmentPayment: 0,
    transactionId: "Auto generated",
    isShowModal: false,
  }),
  mounted() {
    console.log("Component mounted.");
  },

  methods: {
    verificationBUyer() {
      window.open("http://localhost/flexcode/payment.php?id=" + this.customer);
      // axios
      //   .get("http://localhost/flexcode/payment.php?id=" + this.customer, {})
      //   .then(function (response) {
      //     alert(response);
      //   })
      //   .catch(function (error) {});
    },
    searchStaffQuery(input) {
      return (
        this.$props.baseUrl + "/api/v1/kasir/purchase/staff/search=" + input
      );
    },
    searchCustomerQuery(input) {
      return (
        this.$props.baseUrl + "/api/v1/kasir/purchase/customer/search=" + input
      );
    },

    searchProductQuery(input) {
      return (
        this.$props.baseUrl + "/api/v1/kasir/purchase/product/search=" + input
      );
    },
    selectedStaffQuery(group) {
      console.log(group["selectedObject"]);
      this.staff = group["selectedObject"]["id"];
    },
    selectedCustomerQuery(group) {
      console.log(group["selectedObject"]);
      this.customer = group["selectedObject"]["id"];
    },
    selectedProductQuery(group) {
      this.$refs.autocompleteProduct.clear();
      let vm = this;
      let data = group["selectedObject"];
      let isExistingData = false;
      data["max_quantity"] = data["quantity"];
      data["quantity"] = 1;

      if (vm.productsToSell.length > 0) {
        for (let index = 0; index < vm.productsToSell.length; index++) {
          const oldData = vm.productsToSell[index];
          // conditional to make sure data not duplicated
          if (data["id"] == oldData["id"]) {
            // update existing data
            oldData["quantity"] += data["quantity"];
            isExistingData = true;
            // vm.updateTotalPriceQuantity(vm.productsToSell);
            break;
          }
        }
        if (!isExistingData) {
          vm.productsToSell.push(data);
          //   vm.updateTotalPriceQuantity(vm.productsToSell);
        }
      } else if (vm.productsToSell.length == 0) {
        vm.productsToSell.push(data);
        // vm.updateTotalPriceQuantity(vm.productsToSell);
      }
    },
    authHeaders() {
      return {
        Authorization: `Bearer ${this.$props.token}`,
      };
    },

    resultsSearchStaff(result) {
      return result.name + " | " + result.id;
    },

    resultsSearchCustomer(result) {
      // console.log(result);
      return result.name + " | " + result.id;
    },

    resultsSearchProduct(result) {
      console.log(result);
      return result.warehouse_products.name;
    },

    saveToDb() {
      let vm = this;
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .post(
          this.$props.baseUrl + "/api/v1/kasir/purchase/transactions",
          {
            customer: this.customer,
            staff: this.staff,
            total_quantity: this.totalQuantity,
            total_price: this.totalPrice,
            products_to_sell: this.productsToSell,
            payment: this.paymentValue,
          },
          config
        )
        .then(function (response) {
          if (response.status == 201) {
            vm.transactionId = response.data.id;
            vm.generatePdf();
            setTimeout(() => {
              
              vm.reset(response);
            }, 1000);
          }
          console.log(response.data);
        })
        .catch(function (error) {
          alert(error.response.data.error);
          console.log(error.response);
        });
    },

    reset(id) {
      this.productsToSell = [];
      this.totalPrice = 0;
      this.totalQuantity = 0;
      this.customer = null;
      this.staff = null;
      this.paymentValue = 0;
      this.$refs.autocompleteCustomer.clear();
      this.$refs.autocompleteStaff.clear();
    },

    print() {
      // this.isShowModal = true;
      let isReadyStock = true;
      if (!isReadyStock) {
        return;
      }else if (this.staff == null) {
        alert("tidak memilih staff"); 
      } else if (this.customer == null) {
        alert("tidak memilih customer");
      } else if (
        this.productsToSell.length <= 0 ||
        this.productsToSell == null
      ) {
        alert("tidak ada produk yang dipilih");
      } else if (this.paymentValue > this.totalPrice) {
        alert("pembayaran terlalu besar ");
      } else if (this.totalQuantity == null || this.totalQuantity <= 0) {
        alert("total quantity null");
      } else if (this.totalPrice == null || this.totalPrice <= 0) {
        alert("total price is null");
      } else if (this.paymentValue == null || this.paymentValue <= 0) {
        alert("pembayaran tidak mempunyai nilai");
      } else {
        let isPrint = true;
        this.productsToSell.forEach((element) => {
          if (element.quantity <= 0) {
            isPrint = false;
          }
        });
        if (isPrint) {
          this.saveToDb();
          //   this.generatePdf();
        } else {
          alert("terdapat barang berjumlah 0");
        }
      }
    },
    generatePdf() {
      let vm = this;
      const doc = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [100, 75],
      });
      // const titleCompany = "PT DIRA UTAMA JAYA";
      // const customer = vm.customer;
      var tanggal = new Date();

      doc.setFontSize(6); 
      doc.setFont("instruction", "bold");
      doc.text("PT DIRA UTAMA JAYA", 37.5, 6, 'center');

      doc.setFont("instruction", "bold");
      doc.text("JL PAPANDAYAN NO.1 BANYUWANGI", 37.5, 9, 'center');

      doc.setFont("instruction", "bold");
      doc.text("----------------------------------------------------", 37.5, 12, 'center');

      doc.setFont("instruction", "bold");
      doc.text("TANGGAL      :", 10, 15);

      doc.setFont("instruction", "bold");
      doc.text(tanggal.getFullYear() +
        ("." + (tanggal.getMonth()+ 1)) +
        ("." + tanggal.getDate()) , 28, 15);

      doc.setFont("instruction", "bold");
      doc.text("TRANSAKSI ID :", 10, 18);

      doc.setFont("instruction", "bold");
      doc.text(vm.transactionId, 28, 18);

      doc.setFont("instruction", "bold");
      doc.text("----------------------------------------------------", 37.5, 21, 'center');

      let head = [];
      let body = [];
      console.log(vm.productsToSell);
      vm.productsToSell.forEach((element, index) => {
        let newArray = [];
        newArray.push(element.warehouse_products.name);
        newArray.push(element.quantity + "x");
        newArray.push(vm.formatRupiah(element.price));
        newArray.push(vm.formatRupiah(element.price * element.quantity));
        head.push(newArray);
      });
      doc.setFont("instruction", "bold");
      doc.text("----------------------------------------------------", 37.5, 28, 'center');

      let newArray = [];
      newArray.push("");
      newArray.push("");
      newArray.push("Subtotal");
      newArray.push(vm.formatRupiah(vm.totalPrice));
      body.push(newArray);

      let cash = [];
      cash.push("");
      cash.push("");
      cash.push("Cash");
      cash.push(vm.formatRupiah(vm.paymentValue));
      body.push(cash);

      let lack = [];
      lack.push("");
      lack.push("");
      lack.push("Kekurangan");
      lack.push(vm.formatRupiah(vm.totalPrice - vm.paymentValue));
      body.push(lack);

      doc.setFont("instruction", "bold");
      doc.text("----------------------------------------------------", 37.5, 46, 'center');
      
      let foot = [
        ["CUSTOMER ID :", vm.customer, "", "" ],
        ["STAFF ID   :", vm.staff, "", "" ],
      ];

      doc.setFont("instruction", "bold");
      doc.text("----------------------------------------------------", 37.5, 56, 'center');

      doc.setFont("instruction", "bold");
      doc.text("TERIMA KASIH", 37.5, 60, 'center');
      // console.log(body);
      doc.autoTable({
        margin: { top: 23, right: 6, bottom: 0, left: 6 },
        theme: "plain",
        head: head,
        body: body,
        foot: foot,
        styles: {
          fontSize: 5,
          cellWidth: "wrap",
          lineWidth: 0.0,
          lineColor: "black",
        },
        fillColor: null,

        columnStyles: {
          1: { cellWidth: "auto" },
        },
      });

      const date = new Date();
      const filename =
        "DO:" +
        date.getFullYear() +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        ("0" + date.getDate()).slice(-2) + "." +
        vm.customer +
        ".pdf";
      doc.autoPrint({variant: 'non-conform'});  
      doc.save(filename);
    },
    formatRupiah(value) {
      const parse = parseFloat(value);
      return (
        "Rp. " + parse.toFixed(0).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1.")
      );
    },
  },
  watch: {
    /**
     * watch productsToSell to update total Quantity and total price
     * @param {array} val newValue
     */

    productsToSell: {
      handler: function (newVal, oldVal) {
        let totalQuantity = 0;
        let totalPrice = 0;
        for (let index = 0; index < newVal.length; index++) {
          const element = newVal[index];
          const quantity = element["quantity"];
          const price = element["price"];
          if (quantity != null && price != null) {
            totalQuantity += parseInt(quantity);
            // console.log(quantity);
            totalPrice += parseFloat(price) * quantity;

            // console.log(totalPrice);
          }
        }

        if (totalQuantity != 0 && totalPrice != 0) {
          this.installmentPayment = totalPrice - this.paymentValue;
          this.totalQuantity = totalQuantity;

          this.totalPrice = totalPrice;
          console.log(totalQuantity);
        }
      },
      deep: true,
    },

    paymentValue: function (newVal, oldVal) {
      this.installmentPayment = parseFloat(this.totalPrice) - newVal;
      // this.displayPayValue = this.installmentPayment.toString()
      console.log("totalprice: " + parseFloat(this.totalPrice));
      console.log("paymentValue: " + newVal);
    },
  },

  // created() {
  //   this.getAllProduct();
  // },

  computed: {
    displayPayValue: {
      get: function () {
        if (this.isInputPayActive) {
          return this.paymentValue.toString();
        } else {
          return (
            "Rp. " +
            this.paymentValue
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
        this.paymentValue = newValue;
        // this.$emit('input', newValue)
      },
    },
  },
  filters: {},
};
</script>

<style>
table {
  font-size: 0.8rem;
}

/* .form-control {
    border: 0;
} */
</style>
