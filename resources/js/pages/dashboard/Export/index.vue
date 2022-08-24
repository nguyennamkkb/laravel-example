<template>
  <div class="app-container">
    <h4>Xuất hàng, bán hàng</h4>
    <div class="grid-content bg-purple">
      <div class="filter-container">
        Từ:
        <el-date-picker
          v-model="listQuery.from"
          type="date"
          placeholder="Từ ngày"
          @change="handleFilter"
        >
        </el-date-picker>
        Đến:
        <el-date-picker
          v-model="listQuery.to"
          type="date"
          placeholder="Dến ngày"
          @change="handleFilter"
        >
        </el-date-picker>
        Loại
        <el-select
          v-model="listQuery.category_id"
          :placeholder="'Loại'"
          class="filter-item"
          style="width: 160px"
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
        Trạng thái
        <el-select
          :placeholder="'Loại'"
          class="filter-item"
          style="width: 160px"
          @change="handleFilter"
          v-model="listQuery.status"
        >
          <el-option :label="'Tất cả'" :value="0" />
          <el-option :label="'Đã đủ'" :value="2" />
          <el-option :label="' Chưa dủ'" :value="1" />
        </el-select>

        <el-button
          class="filter-item"
          type="primary"
          icon="el-icon-search"
          @click="handleFilter"
          >Tìm kiếm</el-button
        >
      </div>

      <el-table
        :data="list"
        class="table table-striped"
        style="width: auto%; margin-top: 20px"
        border
      >
        <el-table-column label="Ngày" :width="95">
          <template slot-scope="scope">
            <span style="text-align: center" class="text-primary">{{
              scope.row.date
            }}</span>
          </template>
        </el-table-column>

        <el-table-column label="Khách hàng" width="auto">
          <template slot-scope="scope">
            <span style="color: red !important"> {{ scope.row.customer }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Loại hàng" :width="95">
          <template slot-scope="scope">
            <el-tag style="text-align: center" type="success">{{
              scope.row.category
            }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column label="Người nhập">
          <template slot-scope="scope">
            <span style="float: left" class="text-info">{{
              scope.row.importer
            }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Người chở">
          <template slot-scope="scope">
            <span style="float: left">{{ scope.row.carrier }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Đã trả" :width="95">
          <template slot-scope="scope">
            <span style="float: right" class="text-primary">{{
              scope.row.prepay
            }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Cước" :width="95">
          <template slot-scope="scope">
            <span style="float: right">{{ scope.row.freight }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Tổng tiền" :width="95">
          <template slot-scope="scope">
            <span style="float: right" class="text-success">{{
              scope.row.totalmoney
            }}</span>
          </template>
        </el-table-column>
        <el-table-column label="Trạng thái" :width="95">
          <template slot-scope="scope">
            <!-- <span v-if="scope.row.status == 1"  
              ><el-tag type="danger"> Chưa dủ</el-tag></span
            >
            <span v-if="scope.row.status != 2"  
              ><el-tag type="success">Đã đủ</el-tag></span
            > -->
            <el-tag :type="scope.row.status != '1' ? 'success' : 'danger'">{{
              scope.row.status != "1" ? "Đã đủ" : " Chưa dủ"
            }}</el-tag>
          </template>
        </el-table-column>

        <el-table-column label="Thao tác" :width="95" align="center">
          <template slot-scope="scope">
            <el-button
              type="success"
              icon="el-icon-view"
              circle
              @click="viewInputDetail(scope.row)"
            ></el-button>
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

    <!-- <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" /> -->
    <!-- dialog customer type -->
    <!-- <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
      <el-form
        ref="dataForm"
        :rules="rules"
        :model="temp"
        label-position="left"
        label-width="150px"
        style="width: 400px; margin-left: 50px"
      >
        <el-form-item :label="'Tên'" prop="name">
          <el-input v-model="temp.name" />
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible = false">Huỷ bỏ</el-button>
        <el-button
          type="primary"
          @click="dialogStatus === 'create' ? createData() : updateData()"
          >Cập nhật</el-button
        >
      </div>
    </el-dialog> -->
    <!-- dialog customer -->
    <el-drawer
      :title="inputDetailDrtitle"
      :visible.sync="inputDetailDr"
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
              temp.status != "1" ? "Đã đủ" : " Chưa dủ"
            }}</el-tag>
            <!-- <span v-if='temp.status == "1" ' style="color: red"> Chưa dủ</span>
            <span  v-if='temp.status != "1" ' style="color: green">Đã đủ</span>  -->
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
  </div>
</template>

<script>
// import { getWarehouse } from "../../../api/Input";
import { getExport } from "../../../api/Export";
import { getCategory } from "../../../api/Category";
import { convertToDate } from "../../../handle/handleDate";

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
      inputDetailDrtitle: "",
      inputDetailDr: false,
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
        status: 1,
      },
      listcategory: null,
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
        freight: undefined,
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
  },
  methods: {
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
      getExport(this.listQuery).then((response) => {
        this.list = response.data.data;
        setTimeout(() => {}, 0.5 * 1000);
      });
    },
    getListCategory() {
      getCategory().then((response) => {
        this.listcategory = response.data.data;
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
      // console.log(row);
      this.inputDetailDrtitle = "Thông tin nhập " + row.category;
      this.inputDetailDr = true;
    },
  },
};
</script>