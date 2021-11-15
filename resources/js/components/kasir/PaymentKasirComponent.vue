<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <div class="form-row">
              <div class="col-md-8 mb-2">
                <input
                  type="text"
                  v-model="transactionIdOrNik"
                  class="form-control"
                  placeholder="Transaction Id atau NIK"
                  :disabled="transaction != null"
                />
              </div>
              <div class="col-md-2 mb-2">
                <button @click="reset()" class="btn btn-primary btn-block">
                  Reset
                </button>
              </div>
              <div class="col-md-2 mb-2">
                <button
                  @click="getTransactionOrCustomer()"
                  class="btn btn-primary btn-block"
                >
                  Cari
                </button>
              </div>
            </div>
          </div>
        </div>

        <div v-if="transaction != null && transaction['is_paid_off'] == null">
          <div
            @click="getTransactionDetail(transaction['id'])"
            style="margin-top: 10px"
            v-for="(transaction, index) in transaction['transactions']"
            v-bind:key="index"
            class="card"
          >
            <div class="card-body">
              <h5 class="card-title">Transaksi ID : {{ transaction["id"] }}</h5>
              <h6 class="card-text">
                Tanggal : {{ transaction["created_at"] | moment }}
              </h6>
            </div>
          </div>
        </div>
        <div
          style="margin-top: 10px"
          v-else-if="transaction != null && transaction['is_paid_off'] != null"
        >
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
                Nama Customer : {{ transaction["customers"]["name"] }}
              </h5>
              <h6 class="card-text">
                Customer ID : {{ transaction["customers"]["id"] }}
              </h6>
            </div>
          </div>
          <div style="margin-top: 10px" class="card">
            <div class="card-body">
              <h5 class="card-title">
                Nama Staff: {{ transaction["staffs"]["name"] }}
              </h5>
              <h6 class="card-text">
                ID Staff: {{ transaction["staffs"]["id"] }}
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
                      <td>
                        {{ productTransaction["total_price"] | currency }}
                      </td>
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
                      <td>{{ productTransaction["cost"] | currency }}</td>
                    </tr>
                    <tr>
                      <td scope="row">#</td>
                      <td>Kekurangan</td>
                      <td>
                        {{ getLackTotalPrice() | currency }}
                      </td>
                    </tr>
                    <tr
                      v-if="
                        transaction['refund_transactions'] != null &&
                        transaction['refund_transactions']['is_refund_off'] == 1
                      "
                    >
                      <td>Refund</td>
                      <td>
                        {{
                          transaction["refund_transactions"]["created_at"]
                            | moment
                        }}
                      </td>
                      <td>
                        Refund dikembalikan:
                        {{ getTotalPayment() * 0.9 }}
                      </td>
                    </tr>
                  </tbody>
                </table>

                <div v-if="transaction['refund_transactions'] != null">
                  <button
                    type="button"
                    v-if="
                      transaction['is_paid_off'] == 0 &&
                      transaction['refund_transactions']['is_refund_off'] == 0
                    "
                    class="btn btn-primary btn-block"
                    @click="isShowModal = true"
                  >
                    Bayar
                  </button>
                  <button
                    v-if="
                      transaction['is_paid_off'] == 0 &&
                      transaction['refund_transactions']['is_refund_off'] == 0
                    "
                    @click="isSHowModalRefund = true"
                    type="button"
                    class="btn btn-primary btn-block"
                  >
                    Refund
                  </button>
                  <button
                    v-if="
                      transaction['is_paid_off'] == 0 &&
                      transaction['refund_transactions']['is_refund_off'] == 0
                    "
                    @click="isSHowModalMove = true"
                    type="button"
                    class="btn btn-primary btn-block"
                  >
                    Pindah
                  </button>
                </div>
                <div v-else>
                  <button
                    type="button"
                    v-if="transaction['is_paid_off'] == 0"
                    class="btn btn-primary btn-block"
                    @click="isShowModal = true"
                  >
                    Bayar
                  </button>
                  <button
                    v-if="transaction['is_paid_off'] == 0"
                    @click="isSHowModalRefund = true"
                    type="button"
                    class="btn btn-primary btn-block"
                  >
                    Refund
                  </button>
                  <button
                    v-if="transaction['is_paid_off'] == 0"
                    @click="isSHowModalMove = true"
                    type="button"
                    class="btn btn-primary btn-block"
                  >
                    Pindah
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-else-if="transaction == 404">
          <div class="card">
            <div class="card-body">
              <div class="card-title">Data tidak ditemukan</div>
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
                  <div class="form-row">
                    <div class="col">
                      <div class="form-control">
                        Total pembayaran yang harus dibayar :
                        {{ getLackTotalPrice() | currency }}
                      </div>
                    </div>
                  </div>

                  <input
                    type="text"
                    style="background: transparent"
                    class="form-control"
                    v-model="displayPayValue"
                    @blur="isInputPayActive = false"
                    @focus="isInputPayActive = true"
                  />
                </div>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="isShowModal = false"
                  >
                    Tutup
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
                  <button @click="pay()" type="button" class="btn btn-primary">
                    Simpan
                  </button>
                  <!-- <button @click="pay()" type="button" class="btn btn-primary">
                    Simpan
                  </button> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>

    <!-- Modal refund -->
    <div v-if="isSHowModalRefund">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Refund transaksi ini</h5>
                </div>
                <label class="btn btn-default">
                  <input type="file" ref="file" @change="selectFile" />
                </label>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="isSHowModalRefund = false"
                  >
                    Tutup
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
                    @click="refund()"
                    type="button"
                    class="btn btn-primary"
                  >
                    Ya
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </transition>
    </div>
    <!-- Modal change product -->
    <div v-if="isSHowModalMove">
      <transition name="modal">
        <div class="modal-mask">
          <div class="modal-wrapper">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Pindah product transaksi ini</h5>
                </div>
                <label> </label>
                <label class="btn btn-default">
                  <input type="file" ref="file" @change="selectFile" />
                </label>
                <div class="modal-footer">
                  <button
                    type="button"
                    class="btn btn-secondary"
                    @click="isSHowModalMove = false"
                  >
                    Tutup
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
                    @click="change_product()"
                    type="button"
                    class="btn btn-primary"
                  >
                    Ya
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
import VueCurrencyFilter from "vue-currency-filter";
import axios from "axios";
import moment from "moment";
import jsPDF from "jspdf";
import "jspdf-autotable";

Vue.use(VueCurrencyFilter, {
  symbol: "Rp.",
  thousandsSeparator: ".",
  fractionCount: 0,
  fractionSeparator: ",",
  symbolPosition: "front",
});
// Vue.filter("formatDate", function (value) {
//   if (value) {
//     return moment(String(value)).format("MM/DD/YYYY hh:mm");
//   }
// });
export default {
  props: {
    token: String,
    baseUrl: String,
  },
  components: {},
  data: () => ({
    paymentValue: 0,
    isInputPayActive: false,
    transactionIdOrNik: null,
    transaction: null,
    // customer: customer_id,
    isShowModal: false,
    isSHowModalRefund: false,
    isSHowModalMove: false,
    isPrint: false,
    transactionId: "Auto generated",
    image: null,
  }),
  mounted() {
    console.log(this.token);
    console.log("Component mounted.");
  },

  methods: {
    getTotalPayment() {
      let totalPayment = 0;
      for (
        let index = 0;
        index < this.transaction["payment_transactions"].length;
        index++
      ) {
        const element = this.transaction["payment_transactions"][index];
        const cost = element["cost"];
        totalPayment += cost;
      }
      return totalPayment;
    },
    verificationBUyer() {
      let vm = this;
      window.open(
        "http://localhost/flexcode/payment.php?id=" +
          this.transaction["customer_id"]
      );
      // axios
      //   .get("http://localhost/flexcode/payment.php?id=" + this.customer, {})
      //   .then(function (response) {
      //     alert(response);
      //   })
      //   .catch(function (error) {});
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
    getLackNow(){
      let lackNow = 0;
      const lack = this.getLackTotalPrice();
      const payment = this.paymentValue;

      lackNow += lack - payment;

      return lackNow;
    },

    getTransactionDetail(data) {
      this.getTransactionOrCustomer(data);
    },

    getTransactionOrCustomer(data) {
      let transactionId = data;
      if (transactionId == null) transactionId = this.transactionIdOrNik;
      let vm = this;
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .get(
          this.$props.baseUrl + "/api/v1/kasir/transactions/" + transactionId,
          config
        )
        .then(function (response) {
          if (response.status == 200) {
            vm.transaction = response.data;
            console.log(response.data);
          }

          console.log(response);
        })
        .catch(function (error) {
          if (error) {
            vm.transaction = 404;
          }
          console.log(error);
        });
    },

    pay() {
      let vm = this;
      // if (this.paymentValue > this.getLackTotalPrice()) {
      //   alert("pembayaran terlalu besar");
      //   return;
    // }
       if (this.paymentValue <= 0 || this.paymentValue == null) {
        alert("masukkan nilai pembayaran");
        return;
      }

      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .post(
          this.$props.baseUrl + "/api/v1/kasir/payment/transactions",
          {
            id: vm.transaction["id"],
            payment: vm.paymentValue,
            total_cost: vm.getLackTotalPrice(),
            customer_id: vm.transaction["customers"]["id"],
          },

          config
        )
        .then(function (response) {
          if (response.status == 201) {
            alert("Berhasil melakukan pembayaran");
            vm.generatePdf();
            // refresh transaction data
            vm.getTransactionOrCustomer(vm.transaction["id"]);
          }

          console.log(response);
        })
        .catch(function (error) {
          alert(error.response.data.error);
          console.log(error.response);
        });
      // this.paymentValue = 0;
      this.isInputPayActive = false;
      this.isShowModal = false;
    },
    selectFile(e) {
      console.log(e.target.files[0]);
      this.image = e.target.files[0];
    },
    refund() {
      console.log("refund");
      let data = new FormData();
      data.append("customer_id", this.transaction["customer_id"]);
      data.append("transaction_id", this.transaction["id"]);
      data.append("scanner", this.image);
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .post("/api/v1/kasir/refund/transactions", data, config)
        .then(function (response) {
          if (response.status == 201) {
            alert("Dokumen refund berhasil terkirim");
            // refresh transaction data
            vm.getTransactionOrCustomer(vm.transaction["id"]);
          }
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
      this.isSHowModalRefund = false;
    },
    change_product() {
      console.log("change_product");
      let data = new FormData();
      data.append("customer_id", this.transaction["customer_id"]);
      data.append("transaction_id", this.transaction["id"]);
      data.append("scanner", this.image);
      const config = {
        headers: { Authorization: `Bearer ${this.$props.token}` },
      };
      axios
        .post("/api/v1/kasir/change_product/transactions", data, config)
        .then(function (response) {
          if (response.status == 201) {
            alert("Dokumen berhasil terkirim");
            // refresh transaction data
            vm.getTransactionOrCustomer(vm.transaction["id"]);
          }
          console.log(response);
        })
        .catch(function (error) {
          console.log(error);
        });
      this.isSHowModalMove = false;
    },
    reset() {
      this.paymentValue = 0;
      this.isInputPayActive = false;
      this.transactionIdOrNik = null;
      this.transaction = null;
      this.isShowModal = false;
      this.isSHowModalRefund = false;
      this.isSHowModalMove = false;
    },
    generatePdf() {
      let vm = this;
      const doc = new jsPDF({
        orientation: "portrait",
        unit: "mm",
        format: [100, 75],
      });

      var tanggal = new Date();

      doc.setFontSize(6); 
      doc.setFont("courier", "bold");
      doc.text("PT DIRA UTAMA JAYA", 37.5, 6, 'center');

      doc.setFont("courier", "normal");
      doc.text("JL PAPANDAYAN NO.1 BANYUWANGI", 37.5, 9, 'center');

      doc.setFont("courier", "normal");
      doc.text("----------------------------------------------------", 37.5, 12, 'center');

      doc.setFont("courier", "normal");
      doc.text("TANGGAL      :", 10, 15);

      doc.setFont("courier", "normal");
      doc.text(tanggal.getFullYear() +
        ("." + (tanggal.getMonth()+ 1)) +
        ("." + tanggal.getDate()) , 28, 15);

      doc.setFont("courier", "normal");
      doc.text("TRANSAKSI ID :", 10, 18);

      doc.setFont("courier", "normal");
      doc.text(vm.transaction['id'], 28, 18);

      doc.setFont("courier", "normal");
      doc.text("----------------------------------------------------", 37.5, 21, 'center');

      let head = [];
      let body = [];
      console.log(2);
      vm.transaction["product_transactions"].forEach((element, index) => {
        let newArray = [];

        newArray.push(element.products.warehouse_product.name);
        newArray.push(element.quantity);
        newArray.push(vm.formatRupiah(element.products.price));
        newArray.push(vm.formatRupiah(element.products.price * element.quantity));
        head.push(newArray);
      });

      doc.setFont("courier", "bold");
      doc.text("----------------------------------------------------", 37.5, 29, 'center');

      let lack = [];
      lack.push("");
      lack.push("Kekurangan");
      lack.push(vm.formatRupiah(vm.getLackTotalPrice()));
      body.push(lack);

      let newArray = [];
      newArray.push("");
      newArray.push("cash");
      newArray.push(this.paymentValue);
      body.push(newArray);
      console.log(9999);

      doc.setFont("courier", "normal");
      doc.text("----------------------------------------------------", 37.5, 41, 'center');

      let lackNow = [];
      lackNow.push("");
      lackNow.push("Kekurangan Sekarang");
      lackNow.push(vm.formatRupiah(vm.getLackNow()));
      body.push(lackNow);
      console.log(99);

      let foot = [
        ["CUSTOMER ID :", vm.transaction['customers']['name'], "", "" ],
        ["STAFF ID   :", vm.transaction['staffs']['name'], "", "" ],
      ];

      doc.setFont("courier", "normal");
      doc.text("----------------------------------------------------", 37.5, 59, 'center');

      doc.setFont("courier", "bold");
      doc.text("TERIMA KASIH", 37.5, 61 , 'center');

      doc.autoTable({
        margin: { top: 23, right: 6, bottom: 0, left: 3 },
        // tableLineColor: "black",
        // tableLineWidth: 0.1,
        theme: "plain",
        head: head,
        body: body,
        foot: foot,
        styles: {
          // overflow: "hidden",
          halign: 'center',
          fontSize: 6,
          cellWidth: "wrap",
          lineWidth: 0.0,
          lineColor: "black",
        },
        fillColor: null,
        // pageBreak: "auto",
        showHead: "firstPage",
        showFoot: "lastPage",
      });
      console.log(6);
      const date = new Date();
      const filename =
        vm.transaction['customers']['name'] +
        date.getFullYear() +
        ("0" + (date.getMonth() + 1)).slice(-2) +
        ("0" + date.getDate()).slice(-2) +
        ("0" + date.getHours()).slice(-2) +
        ("0" + date.getMinutes()).slice(-2) +
        ("0" + date.getSeconds()).slice(-2) +
        vm.transaction['id'] +
        ".pdf";
      doc.save(filename);
      doc.autoPrint();
      console.log(7);
    },

    formatRupiah(value) {
      const parse = parseFloat(value);
      return (
        "Rp. " + parse.toFixed(0).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, "$1.")
      );
    },
  },
  watch: {},

  //   created() {
  //     this.getTransaction();
  //   },

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
  filters: {
    moment: function (date) {
      return moment(date).format("MM/DD/YYYY hh:mm");
    },
  },
};
</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}
</style>
