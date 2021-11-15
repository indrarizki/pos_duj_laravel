<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <input
              @change="getReport"
              class="form-control"
              type="date"
              v-model="date"
              id
            />
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Transaksi Id</th>
                  <th scope="col">Customer</th>
                  <th scope="col">Pembayaran</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(report, index) in reports" v-bind:key="index">
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ report["created_at"] | moment }}</td>
                  <td>{{ report["transaction_id"] }}</td>
                  <td>{{ report["transactions"]["customers"]["name"] }}</td>
                  <td>{{ report["cost"] | currency }}</td>
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
                <tr>
                  <td scope="row">#</td>
                  <td></td>
                  <td></td>
                  <td></td>

                  <td>{{ totalCost | currency }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <br>
        <br>
        <div class="card">
           <div class="card-header">Pembelian refund</div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Tanggal</th>
                  <th scope="col">Transaksi Id</th>
                  <th scope="col">Customer</th>
                  <!-- <th scope="col">Pembayaran</th> -->
                </tr>
              </thead>
              <tbody>
                <tr v-for="(refund, index) in refunds" v-bind:key="index">
                  <th scope="row">{{ index + 1 }}</th>
                  <td>{{ refund["created_at"] | moment }}</td>
                  <td>{{ refund["transaction_id"] }}</td>
                  <td>{{ refund['transactions']['customers']['name']}}</td>
                  <!-- <td>{{ report['cost'] | currency}}</td> -->
                  <td></td>
                  <td></td>
                  <td></td>
                  <td></td>
                </tr>
              </tbody>
            </table>
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

Vue.use(VueCurrencyFilter, {
  symbol: "Rp.",
  thousandsSeparator: ".",
  fractionCount: 0,
  fractionSeparator: ",",
  symbolPosition: "front",
});
export default {
  props: {
    token: String,
    baseUrl: String,
  },
  components: {
    // datetime: Datetime,
  },
  data() {
    return {
      date: new Date(),
      reports: [],
      refunds: [],
      config: {
        headers: { Authorization: `Bearer ${this.token}` },
      },
      totalCost: 0,
    };
  },

  methods: {
    getReport() {
      let vm = this;
      //   let date = this.$options.filters.moment(this.date);
      let date = this.date;
      axios
        .get(
          this.$props.baseUrl + "/ap1/v1/kasir/reports/date=" + date,
          this.config
        )
        .then(function (response) {
          vm.reports = response.data;
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    getRefund() {
      let vm = this;
      //   let date = this.$options.filters.moment(this.date);
      let date = this.date;
      axios
        .get(this.$props.baseUrl + "/ap1/v1/kasir/refund", this.config)
        .then(function (response) {
          vm.refunds = response.data;
          console.log(response.data);
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },

  created() {
    this.getReport();
    this.getRefund();
  },
  filters: {
    moment: function (date) {
      return moment(date).format("MM/DD/YYYY hh:mm");
    },
  },
  watch: {
    reports: function (newVal, oldValue) {
      this.totalCost = 0;
      newVal.forEach((element) => {
        this.totalCost += element["cost"];
      });
    },
  },
};
</script>
