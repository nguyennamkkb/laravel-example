<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="10">
        <h4>Dặc tính hàng hóa</h4>
        <div class="grid-content bg-purple">
          <div class="filter-container">
            <el-input
              :placeholder="'Tên'"
              v-model="listQuery.keyword"
              style="width: 200px"
              class="filter-item"
              @keyup.enter.native="handleFilter"
            />
            <!-- <el-select
        v-model="listQuery.status"
        :placeholder="'Trạng thái'"
        clearable
        class="filter-item"
        style="width: 160px"
        @change="handleFilter"
      >
        <el-option
          v-for="item in statusOptions"
          :key="item.key"
          :label="item.display_name"
          :value="item.key"
        />
      </el-select> -->
            <el-button
              class="filter-item"
              type="primary"
              icon="el-icon-search"
              @click="handleFilter"
              >Tìm kiếm</el-button
            >
            <el-button
              class="filter-item"
              style="margin-left: 10px"
              type="primary"
              icon="el-icon-circle-plus-outline"
              @click="handleCreate"
            ></el-button>
          </div>

          <el-table :data="list" style="width: 100%">
            <el-table-column label="Tên">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.name }}</span>
              </template>
            </el-table-column>

            <el-table-column label="Thao tác">
              <template slot-scope="scope">
                <el-button
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
                ></el-button>
               
              </template>
            </el-table-column>
          </el-table></div
      ></el-col>

    </el-row>

    <!-- <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" /> -->
    <!-- dialog customer type -->
    <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogFormVisible">
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
    </el-dialog>
    <!-- dialog customer -->

  </div>
</template>

<script>
import {
  getPrice,
  createPrice,
  updatePrice,
  deletePrice,
} from "../../../api/Price";

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
      Tenloai: "",
      tableKey: 0,
      list: null,
      total: 0,
      //   listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        keyword: undefined,
      },
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
    }; 
  },
  created() {
    this.getList();
  },
  methods: {
    getList() {
      //   this.listLoading = true
      getPrice(this.listQuery).then((response) => {
        this.list = response.data.data;
        this.total = response.data.meta.total;
        // Just to simulate the time of the request
        setTimeout(() => {
          //   this.listLoading = false
        }, 0.5 * 1000);
      });
    },
    handleFilter() {
      this.listQuery.page = 1;
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
  },
};
</script>