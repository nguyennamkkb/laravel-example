<template>
  <div>
    <br />
    <h4>Phiếu nhập hàng</h4>

    <el-form ref="form" :model="temp" label-width="130px">
      <el-row :gutter="20">
        <el-col :span="10">
          <div class="grid-content bg-purple">
            <el-form-item label="Ngày nhập" style="font-weight: bold">
              <el-date-picker
                type="date"
                placeholder="(Năm-Tháng-ngày)"
                v-model="temp.date"
                style="width: auto"
              >
              </el-date-picker>
              <!-- <input type="date" v-model="temp.date" placeholder="(Năm-Tháng-ngày)"  style="width: auto"> -->
            </el-form-item>
          </div>
        </el-col>
        <el-col :span="10">
          <div class="grid-content bg-purple">
            <el-form-item label="Ng vận chuyển" style="font-weight: bold">
              <el-select
                v-model="temp.carrier_id"
                placeholder="Chọn người vận chuyển"
                style="width: auto"
                filterable
              >
                <el-option
                  v-for="item in listEmployees"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>
          </div>
        </el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="10">
          <div class="grid-content bg-purple">
            <el-form-item label="Khách hàng" style="font-weight: bold">
              <el-select
                v-model="temp.customer_id"
                placeholder="Chọn khách hàng"
                style="width: auto"
                filterable
              >
                <el-option
                  v-for="item in listCustomers"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>
          </div>
        </el-col>
        <el-col :span="10">
          <div class="grid-content bg-purple">
            <el-form-item label="Ng kiểm hàng" style="font-weight: bold">
              <el-select
                v-model="temp.importer_id"
                placeholder="Người kiểm"
                style="width: auto"
                filterable
              >
                <el-option
                  v-for="item in listEmployees"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item></div
        ></el-col>
      </el-row>
      <el-row :gutter="20">
        <el-col :span="10"
          ><div class="grid-content bg-purple">
            <el-form-item label="Mục hàng hóa" style="font-weight: bold">
              <el-select
                v-model="temp.category_id"
                placeholder="Chọn loại hàng"
                style="width: auto"
                @change="getListCatagoryChild"
                filterable
              >
                <el-option
                  v-for="item in listCategories"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                ></el-option>
              </el-select>
            </el-form-item>
          </div>
        </el-col>
        <el-col :span="10">
          <div class="grid-content bg-purple">
            <el-form-item label="Ghi chú" style="font-weight: bold">
              <el-input
                type="textarea"
                placeholder="Nhập ghi chú"
                v-model="temp.note"
              >
              </el-input>
            </el-form-item>
          </div>
        </el-col>
      </el-row>

      <!-- <el-form-item size="large">
        <el-button type="primary" @click="onSubmit">Create</el-button>
        <el-button>Xóa</el-button>
      </el-form-item> -->
    </el-form>
    <table class="table table-bordered">
      <thead class="text text-success">
        <tr>
          <th>Loại</th>
          <th>Số lượng</th>
          <th>Đơn vị</th>
          <th>Đơn giá</th>
          <th>Tổng tiền</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <!-- <tr v-for="(user, index) in users"> -->
        <tr v-for="(item, index) in inputDetails" :key="index">
          <td>
            <el-select
              v-model="item.categorychildren_id"
              placeholder="Loại"
              style="width: auto"
              @change="CalculateTotal()"
              filterable
            >
              <el-option
                v-for="item in listCategoryChilds"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </td>
          <td>
            <input
              v-model="item.weight"
              class="form-control"
              type="number"
              @change="CalculateTotal()"
            />
          </td>
          <td>
            <el-select
              v-model="item.unit"
              placeholder="Loại"
              style="width: auto"
              filterable
              @change="CalculateTotal()"
            >
              <el-option
                v-for="item in listUnits"
                :key="item.id"
                :label="item.name"
                :value="item.name"
              ></el-option>
            </el-select>
          </td>
          <td>
            <el-autocomplete
              class="inline-input"
              v-model="item.price"
              :fetch-suggestions="querySearchprice"
              placeholder="Nhập giá"
              @change="CalculateTotal"
              @select="CalculateTotal"
            ></el-autocomplete>

            <!-- <el-select
              v-model="item.price"
              placeholder="Giá"
              style="width: auto"
              filterable
              @change="CalculateTotal"
            >
              <el-option
                v-for="item in listPrices"
                :key="item.id"
                :label="item.name"
                :value="item.name"
              ></el-option>
            </el-select> -->
          </td>
          <td>
            <input type="text" v-model="item.total" disabled />
          </td>
          <td>
            <el-button
              v-if="index == lenTable - 1"
              type="danger"
              icon="el-icon-delete"
              circle
              @click="deleteRow()"
            ></el-button>
          </td>
        </tr>

        <tr>
          <td colspan="4" style="text-align: right">Tổng tiền</td>
          <td colspan="1">{{ this.temp.totalmoney }}</td>
          <td colspan="1"></td>
        </tr>
        <tr>
          <td colspan="4" style="text-align: right">Trả trước</td>
          <td colspan="1">
            <input
              v-model="temp.prepay"
              class="form-control"
              type="number"
              @change="CalculateTotal()"
            />
          </td>
          <td colspan="1">
            <el-button
              type="primary"
              icon="el-icon-plus"
              circle
              @click="addRow"
            ></el-button>
          </td>
        </tr>
      </tbody>
    </table>
    <el-button type="primary" @click="getvalueInput" style="float: right"
      >Tạo phiếu xuất</el-button
    >
  </div>
</template>
<script>
import { getValueInput, createInput } from "../../../api/Input";
import { getCategoryChildbyCategoryId } from "../../../api/CategoryChild";
import { convertToDate } from "../../../handle/handleDate";
import { convertnametovalue } from "../../../handle/cmd";

export default {
  data() {
    return {
      listCustomers: null,
      listEmployees: null,
      listCategories: null,
      listUnits: null,
      listPrices: null,
      listCategoryChilds: null,
      inputDetails: [
        {
          categorychildren_id: undefined,
          weight: undefined,
          unit: "kg",
          price: "",
          total: 0,
        },
      ],
      totalmoney: undefined,
      temp: {
        date: Date(),
        customer_id: undefined,
        importer_id: undefined,
        carrier_id: undefined,
        note: "",
        totalmoney: undefined,
        category_id: undefined,
        prepay: 0,

        item: [
          {
            categorychildren_id: undefined,
            weight: 0,
            unit: undefined,
            price: "",
            total: 0,
          },
        ],
      },
      totalAmount: 0,
      lenTable: 0,
      total1: 0,
    };
  },
  created() {
    this.getList();
    // var a =convertToDate(Date());
    // console.log(a)
  },
  methods: {
    querySearchprice(queryString, cb) {
      var prices = this.listPrices;
      var results = queryString
        ? prices.filter(this.createFilterPrice(queryString))
        : prices;
      // call callback function to return suggestions
      cb(results);
    },
    createFilterPrice(queryString) {
      return (price) => {
        // console.log(link.value.toLowerCase().indexOf(queryString.toLowerCase()) === 0)
        return (
          price.value
            .toString()
            .toLowerCase()
            .indexOf(queryString.toLowerCase()) === 0
        );
      };
    },
    notifyMes(mes, type) {
      this.$notify({
        title: "Thông báo",
        message: mes,
        type: type == 1 ? "success" : "error",
        duration: 2000,
      });
    },
    getList: async function () {
      const data = await getValueInput();
      this.listCustomers = data.data.customer;
      this.listCategories = data.data.category;
      this.listEmployees = data.data.employee;
      this.listUnits = data.data.unit;
      this.listPrices = data.data.price;
      this.listPrices = convertnametovalue(this.listPrices);
    },
    addRow: function () {
      this.inputDetails.push({
        categorychildren_id: undefined,
        weight: undefined,
        unit: "kg",
        price: "",
        total: 0,
      });
      this.CalculateTotal();
    },
    deleteRow() {
      this.inputDetails.pop();
      this.CalculateTotal();
    },
    getvalueInput() {
      this.temp.date = convertToDate(this.temp.date);
      this.temp.item = Object.assign({}, this.inputDetails);
      // console.log(this.temp);
      createInput(this.temp)
        .then((result) => {
          if (result.data.status == true) {
            this.notifyMes("Tạo phiếu nhập thành công", 1);
          }
        })
        .catch((err) => {
          this.notifyMes("Lỗi tạo phiếu nhập", 0);
        });
    },
    getData: async function () {
      // const data1 = await getCategoryChild(this.temp)
    },
    getListCatagoryChild() {
      const dt = {
        category_id: this.temp.category_id,
      };
      getCategoryChildbyCategoryId(dt)
        .then((result) => {
          // console.log(result.data.data);
          this.listCategoryChilds = result.data.data;
        })
        .catch((err) => {});
    },
    CalculateTotal() {
      // console.log(this.inputDetails);
      // console.log(this.inputDetails[0].price);
      this.total1 = 0;
      let datatable = this.inputDetails;
      let index = 0;
      this.lenTable = datatable.length;
      datatable.forEach((element) => {
        let dongia = Number(element.price);
        // console.log(element);
        index++;
        let soluong = element.weight;
        let donvi =
          element.unit != undefined ? parseInt(element.unit.split(" ")[1]) : "";

        let thanhtien;
        if (isNaN(donvi)) donvi = 1;
        thanhtien = soluong * donvi * dongia;
        if (isNaN(thanhtien)) thanhtien = 0;
        // console.log('tong tien'+ thanhtien);
        datatable[index - 1].total = thanhtien;
        this.total1 += thanhtien;
        element.customer_id = this.temp.customer_id;
      });
      this.temp.totalmoney = this.total1;
    },
    convertnametovalue(str) {
      return str;
    },
  },
};
</script>
