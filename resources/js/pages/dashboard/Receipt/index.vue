<template>
  <div class="app-container">
    <h4>Nhập hàng, mua hàng</h4>
    <div class="grid-content bg-purple">
      <el-row :gutter="20">
        <el-col :span="4" style="background-color: #d4ffbf">
          <div>Từ ngày</div>
          <div>
            <el-date-picker
              v-model="listQuery.from"
              type="date"
              placeholder="Từ ngày"
              style="width: 100%"
              @change="handleFilter"
            >
            </el-date-picker>
          </div>
        </el-col>
        <el-col :span="4" style="background-color: #e7e1ff">
          <div>Đến ngày</div>
          <div>
            <el-date-picker
              v-model="listQuery.to"
              type="date"
              placeholder="Dến ngày"
              style="width: 100%"
              @change="handleFilter"
            ></el-date-picker>
          </div>
        </el-col>
        <el-col :span="4" style="background-color: #d4ffbf">
          <div>Loại</div>
          <div>
            <el-select
              v-model="listQuery.category_id"
              :placeholder="'Loại'"
              class="filter-item"
              style="width: 100%"
              @change="handleFilter"
            >
              <el-option :label="'Tất cả'" :value="undefined" />
              <el-option
                v-for="item in listcategory"
                :key="item.key"
                :label="item.name"
                :value="item.id"
              />
            </el-select>
          </div>
        </el-col>
        <el-col :span="4" style="background-color: #e7e1ff">
          <div>Trạng thái</div>
          <div>
            <el-select
              :placeholder="'Loại'"
              class="filter-item"
              @change="handleFilter"
              v-model="listQuery.status"
              style="width: 100%"
            >
              <el-option :label="'Tất cả'" :value="0" />
              <el-option :label="'Đã TT'" :value="2" />
              <el-option :label="'Chưa TT'" :value="1" />
            </el-select>
          </div>
        </el-col>
        <el-col :span="4" style="background-color: #d4ffbf">
          <div>xuất</div>
          <div>
            <el-select
              :placeholder="'Loại'"
              class="filter-item"
              @change="handleFilter"
              v-model="listQuery.status_export"
              style="width: 100%"
            >
              <el-option :label="'Tất cả'" :value="0" />
              <el-option :label="'Đã Xuất'" :value="2" />
              <el-option :label="'Chưa Xuất'" :value="1" />
            </el-select>
          </div>
        </el-col>
        <el-col :span="2">
          <div>--</div>
          <div class="grid-content bg-purple">
            <el-button
              class="filter-item"
              type="primary"
              icon="el-icon-search"
              @click="handleFilter"
              >Tìm kiếm</el-button
            >
          </div></el-col
        >
      </el-row>
      <div class="filter-container"></div>

      <el-table :data="list" style="width: 100%; margin-top: 20px" border>
        <el-table-column label="Ngày">
          <template slot-scope="scope">
            <span style="margin-left: 10px" class="text-primary">{{
              scope.row.date
            }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Khách hàng">
          <template slot-scope="scope">
            <span style="margin-left: 10px" class="text-success">{{
              scope.row.customer
            }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Loại hàng">
          <template slot-scope="scope">
            <span style="margin-left: 10px">{{ scope.row.category }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Người nhập">
          <template slot-scope="scope">
            <span style="margin-left: 10px">{{ scope.row.importer }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Người chở">
          <template slot-scope="scope">
            <span style="margin-left: 10px">{{ scope.row.carrier }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Đã trả trước">
          <template slot-scope="scope">
            <span style="margin-left: 10px">{{ scope.row.prepay }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Tổng tiền">
          <template slot-scope="scope">
            <span style="margin-left: 10px">{{ scope.row.totalmoney }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Trạng thái">
          <template slot-scope="scope">
            <!-- <span v-if="scope.row.status == 1" style="margin-left: 10px"
              ><el-tag type="danger">Chưa TT</el-tag></span
            >
            <span v-if="scope.row.status != 2" style="margin-left: 10px"
              ><el-tag type="success">Đã TT</el-tag></span
            > -->
            <el-tag
              style="font-weight: bold"
              size="mini"
              :type="scope.row.status != '1' ? 'success' : 'danger'"
              >{{ scope.row.status != "1" ? "Đã TT" : "Chưa TT" }}</el-tag
            >
            <el-tag
              style="font-weight: bold"
              size="mini"
              :type="scope.row.status_export != '1' ? 'success' : 'warning'"
              v-if="scope.row.category === 'Vầu'"
              >{{
                scope.row.status_export != "1" ? "Đã xuất" : "Chưa xuất"
              }}</el-tag
            >
          </template>
        </el-table-column>

        <el-table-column label="Thao tác">
          <template slot-scope="scope">
            <el-button
              type="success"
              icon="el-icon-view"
              circle
              @click="viewInputDetail(scope.row)"
            ></el-button>
            <el-button
              v-if="
                scope.row.category === 'Vầu' && scope.row.status_export == '1'
              "
              type="primary"
              @click="exportDetail(scope.row)"
              >Xuất</el-button
            >
            <!-- <el-button
              type="primary"
              icon="el-icon-edit"
              circle
              @click="handleUpdate(scope.row)"
            ></el-button>
            <el-button
              type="danger"
              icon="el-icon-delete"
              circle
              @click="handleDelete(scope.row)"
            ></el-button> -->
          </template>
        </el-table-column>
      </el-table>
    </div>

    <el-drawer
      :title="inputDetailDltitle"
      :visible.sync="inputDetailDl"
      direction="rtl"
      size="70%"
    >
      <!-- <h5>Thông tin nhập hàng {{temp.category}}</h5> -->
      <el-row style="padding: 10px">
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Ngày: </span> {{ temp.date }}
          </div>
        </el-col>
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Khách hàng: </span>
            {{ temp.customer }}
          </div>
        </el-col>
      </el-row>
      <el-row style="padding: 10px">
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Người kiểm tra: </span
            >{{ temp.importer }}
          </div>
        </el-col>
        <el-col :span="12">
          <div class="grid-content">
            <span style="font-weight: bold">Người chở: </span>{{ temp.carrier }}
          </div>
        </el-col>
      </el-row>
      <el-row style="padding: 10px">
        <el-col :span="6">
          <div class="grid-content">
            <span style="font-weight: bold">Tổng tiền: </span>
            {{ temp.totalmoney }}
          </div>
        </el-col>
        <el-col :span="6">
          <div class="grid-content">
            <span style="font-weight: bold">Đã trả: </span>{{ temp.prepay }}
          </div>
        </el-col>
        <el-col :span="6">
          <div class="grid-content">
            <span style="font-weight: bold">Trạng thái: </span>
            <el-tag :type="temp.status != '1' ? 'success' : 'danger'">{{
              temp.status != "1" ? "Đã TT" : "Chưa TT"
            }}</el-tag>
            <!-- <span v-if='temp.status == "1" ' style="color: red">Chưa TT</span>
            <span  v-if='temp.status != "1" ' style="color: green">Đã TT</span>  -->
          </div>
        </el-col>
        <el-col :span="6">
          <div class="grid-content">
            <span style="font-weight: bold">Ghi chú: </span> {{ temp.note }}
          </div>
        </el-col>
      </el-row>
      <el-table
        :data="temp.item"
        class="table table-striped"
        width="100%"
        border
      >
        <el-table-column label="Loại">
          <template slot-scope="scope">
            <span>{{ scope.row.categorychildren }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Số lượng">
          <template slot-scope="scope">
            <span style="float: center">{{ scope.row.weight }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Đơn vị tính">
          <template slot-scope="scope">
            <span>{{ scope.row.unit }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Giá">
          <template slot-scope="scope">
            <span style="float: right">{{ scope.row.price }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Thành tiền">
          <template slot-scope="scope">
            <span style="float: right" class="text-primary">{{
              scope.row.total
            }}</span>
          </template>
        </el-table-column>
      </el-table>
    </el-drawer>

    <!-- dialog nhap hang-->
    <el-dialog title="Xuất hàng" :visible.sync="exportDetailDL" width="70%">
      <el-row style="padding: 10px">
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Ngày: </span> {{ tempexport.date }}
          </div>
        </el-col>
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Khách hàng: </span>

            <el-select
              v-model="tempexport.customer_id"
              filterable
              placeholder="Chọn"
            >
              <el-option
                v-for="item in listcustomers"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              >
              </el-option>
            </el-select>
          </div>
        </el-col>
      </el-row>
      <el-row style="padding: 10px">
        <el-col :span="12">
          <div class="grid-content Compact">
            <span style="font-weight: bold">Người kiểm tra: </span
            >{{ tempexport.importer }}
          </div>
        </el-col>
        <el-col :span="10">
          <div class="grid-content">
            <span style="font-weight: bold">Tổng tiền: </span>
            {{ tempexport.totalmoney }}
          </div>
        </el-col>
      </el-row>
      <el-row style="padding: 10px">
        <el-col :span="10">
          <div class="grid-content">
            <span style="font-weight: bold">Ghi chú: </span>
            <el-input
              type="textarea"
              :rows="2"
              :cols="20"
              placeholder="nhập ghi chú"
              v-model="tempexport.note"
            >
            </el-input>
          </div>
        </el-col>
      </el-row>
      <el-table
        :data="tempexport.item"
        class="table table-striped"
        width="100%"
        border
      >
        <el-table-column label="Loại">
          <template slot-scope="scope">
            <span>{{ scope.row.categorychildren }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Số lượng">
          <template slot-scope="scope">
            <span style="float: center">{{ scope.row.weight }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Đơn vị tính">
          <template slot-scope="scope">
            <span>{{ scope.row.unit }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Giá">
          <template slot-scope="scope">
            <!-- <input type="number" v-model="tempexport.price" /> -->
            <input
              type="number"
              v-model="scope.row.price"
              class="form-control form-control-sm"
              @change="CalculateTotalexport"
            />

            <!-- <el-input type="number" v-model="tempexport.price"></el-input> -->
          </template>
        </el-table-column>

        <el-table-column label="Thành tiền">
          <template slot-scope="scope">
            <span style="float: right" class="text-primary">{{
              scope.row.total
            }}</span>
          </template>
        </el-table-column>
      </el-table>
      <div style="text-align: center">
        <el-button type="primary" @click="handleCreateExport"
          >Tạo phiếu xuất</el-button
        >
      </div>
    </el-dialog>
  </div>
</template>

<script>
import { exportFromInput } from "../../../api/Input";
import { getWarehouse } from "../../../api/Warehouse";
import { getCategory } from "../../../api/Category";
import { getCustomer } from "../../../api/Customer";
import { convertToDate } from "../../../handle/handleDate";
import { formatcurrency, removeDot } from "../../../handle/cmd";

export default {
  filters: {
    statusFilter(status) {
      const statusMap = {
        available: "success",
        disable: "danger",
      };
      return statusMap[status];
    },
  },
  data() {
    return {
      inputDetailDltitle: "",
      inputDetailDl: false,
      exportDetailDL: false,
      Tenloai: "",
      tableKey: 0,
      list: null,
      total: 0,
      //   listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        from: undefined,
        to: undefined,
        category_id: undefined,
        status: undefined,
        status_export: undefined,
      },
      listcategory: null,
      listcustomers: null,
      statusOptions: [
        { key: "available", display_name: "Hoạt động" },
        { key: "disable", display_name: "Không hoạt động" },
      ],
      temp: {
        id: undefined,
        name: "",
      },
      dialogFormVisible: false,
      dialogStatus: "",
      textMap: {
        update: "Sửa Loại hàng hóa",
        create: "Thêm mới loại hàng hóa",
      },
      rules: {
        name: [
          {
            required: true,
            message: "Tên hàng hóa không được bỏ trống",
            trigger: "change",
          },
        ],
      },

      temp: {
        date: undefined,
        customer_id: undefined,
        importer_id: undefined,
        carrier_id: undefined,
        note: "",
        totalmoney: undefined,
        prepay: 0,
        status: 0,
        status_export: 0,
        item: [
          {
            categorychildren_id: undefined,
            weight: 0,
            unit: undefined,
            price: undefined,
            total: 0,
          },
        ],
      },
      tempexport: {
        id: undefined,
        date: undefined,
        customer_id: undefined,
        importer_id: undefined,
        carrier_id: undefined,
        note: "",
        totalmoney: undefined,
        prepay: 0,
        status: 0,
        status_export: 0,
        item: [
          {
            categorychildren_id: undefined,
            weight: 0,
            unit: undefined,
            price: undefined,
            total: 0,
          },
        ],
      },
    };
  },
  created() {
    this.getList();
    this.getListCategory();
    this.getListCustomers();
    // this.aaaaa();
  },
  methods: {
    aaaaa() {
      console.log(formatcurrency(2222));
    },
    statusFilter(status) {
      const statusMap = {
        available: "success",
        disable: "danger",
      };
      return statusMap[status];
    },
    getList() {
      //   this.listLoading = true
      // console.log(this.listQuery);
      getWarehouse(this.listQuery).then((response) => {
        this.list = response.data.data;
        setTimeout(() => {}, 0.5 * 1000);
      });
    },
    getListCategory() {
      getCategory().then((response) => {
        this.listcategory = response.data.data;
      });
    },
    getListCustomers() {
      getCustomer().then((response) => {
        this.listcustomers = response.data.data;
      });
    },
    getListWarehouse() {},
    handleFilter() {
      this.listQuery.page = 1;
      this.listQuery.from = convertToDate(this.listQuery.from);
      this.listQuery.to = convertToDate(this.listQuery.to);
      this.getList();
    },
    resetTemp() {
      this.temp = {
        id: undefined,
        name: "",
      };
    },
    handleCreate() {
      this.resetTemp();
      this.dialogStatus = "create";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    createData() {
      this.$refs["dataForm"].validate((valid) => {
        if (valid) {
          console.log(this.temp);
          createPrice(this.temp).then(() => {
            this.listQuery.page = 1;
            this.getList();
            this.dialogFormVisible = false;
            this.$notify({
              title: "Thông báo",
              message: "Tạo thành công",
              type: "success",
              duration: 2000,
            });
          });
        }
      });
    },
    handleUpdate(row) {
      this.temp = Object.assign({}, row); // copy obj
      this.dialogStatus = "update";
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs["dataForm"].clearValidate();
      });
    },
    updateData() {
      this.$refs["dataForm"].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updatePrice(tempData.id, tempData).then(() => {
            this.getList();
            this.dialogFormVisible = false;
            this.$notify({
              title: "Thông báo",
              message: "Cập nhật thành công",
              type: "success",
              duration: 2000,
            });
          });
        }
      });
    },
    handleDelete(row) {
      deletePrice(row.id).then(() => {
        this.getList();
        this.$notify({
          title: "Thông báo",
          message: "Xoá thành công",
          type: "success",
          duration: 2000,
        });
      });
    },
    handleSelectionChange(val) {
      this.multipleSelection = val;
    },
    viewInputDetail(row) {
      this.temp = Object.assign({}, row);
      this.inputDetailDltitle = "Thông tin nhập " + row.category;
      this.inputDetailDl = true;
    },
    exportDetail(row) {
      this.tempexport = Object.assign({}, row);
      this.tempexport.totalmoney = 0;
      this.tempexport.item.price = 0;
      this.exportDetailDL = true;
    },
    handleCreateExport() {
      console.log(this.tempexport);
      exportFromInput(this.tempexport)
        .then((result) => {
          console.log(result.data);
        })
        .catch((err) => {});
    },

    CalculateTotalexport() {
      let datatable = this.tempexport.item;
      // console.log(datatable);
      let index = 0;
      let thanhtien;
      let tongtien = 0;
      datatable.forEach((element) => {
        index++;
        let dongia = Number(removeDot(element.price));
        let soluong = removeDot(element.weight);
        let donvi =
          element.unit != undefined ? parseInt(element.unit.split(" ")[1]) : "";
        if (isNaN(donvi)) donvi = 1;
        thanhtien = soluong * donvi * dongia;
        if (isNaN(thanhtien)) thanhtien = 0;
        datatable[index - 1].total = formatcurrency(thanhtien);
        tongtien += thanhtien;
      });
      this.tempexport.totalmoney = formatcurrency(tongtien);
    },
  },
};
</script>