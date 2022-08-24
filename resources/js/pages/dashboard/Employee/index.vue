<template>
  <div class="app-container">
    <el-row :gutter="20">
      <el-col :span="10">
        <h4>Loại công việc</h4>
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
                <el-button
                  type="success"
                  icon="el-icon-right"
                  circle
                  @click="btngetEmployee(scope.row)"
                ></el-button>
              </template>
            </el-table-column>
          </el-table></div
      ></el-col>
      <el-col :span="14">
        <h4>Công việc <span style="color:#ff0a0a">{{Tenloai}}</span>  </h4>
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
              @click="handleCreate2"
            ></el-button>
          </div>

          <el-table :data="list2" style="width: 100%">
            <el-table-column label="Tên">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.name }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Địa chỉ">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.address }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Số điện thoại">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.phone }}</span>
              </template>
            </el-table-column>
            <el-table-column label="Email">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.email }}</span>
              </template>
            </el-table-column>
            <!-- <el-table-column label="Tên">
              <template slot-scope="scope">
                <span style="margin-left: 10px">{{ scope.row.employeeType_id }}</span>
              </template>
            </el-table-column> -->

            <el-table-column label="Thao tác">
              <template slot-scope="scope">
                <el-button
                  type="primary"
                  icon="el-icon-edit"
                  circle
                  @click="handleUpdate2(scope.row)"
                ></el-button>
                <el-button
                  type="danger"
                  icon="el-icon-delete"
                  circle
                  @click="handleDelete2(scope.row)"
                ></el-button>
              </template>
            </el-table-column>
          </el-table></div
      ></el-col>
    </el-row>

    <!-- <pagination v-show="total>0" :total="total" :page.sync="listQuery.page" :limit.sync="listQuery.limit" @pagination="getList" /> -->
    <!-- dialog Employee type -->
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
    <!-- dialog Employee -->
    <el-dialog
      :title="textMap2[dialogStatus2]"
      :visible.sync="dialogFormVisible2"
    >
      <el-form
        ref="dataForm2"
        :rules="rules2"
        :model="temp2"
        label-position="left"
        label-width="150px"
        style="width: auto"
      >
        <el-form-item :label="'Tên'" prop="name">
          <el-input v-model="temp2.name" />
        </el-form-item>
        <el-form-item :label="'Địa chỉ'" prop="address">
          <el-input v-model="temp2.address" />
        </el-form-item>
        <el-form-item :label="'Số điện thoại'" prop="phone">
          <el-input v-model="temp2.phone" />
        </el-form-item>
        <el-form-item :label="'Email'" prop="email">
          <el-input v-model="temp2.email" />
        </el-form-item>
        <el-form-item :label="'Loại công việc'" prop="employeeType_id">
          <el-select
            v-model="temp2.employeeType_id"
            placeholder="Chọn"
            prop="employeeType_id"
          >
            <el-option
              v-for="item in list"
              :key="item.id"
              :label="item.name"
              :value="item.id"
            ></el-option>
          </el-select>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible2 = false">Huỷ bỏ</el-button>
        <el-button
          type="primary"
          @click="dialogStatus2 === 'create' ? createData2() : updateData2()"
          >Cập nhật</el-button
        >
      </div>
    </el-dialog>
  </div>
</template>

<script>
import {
  getEmployeeType,
  createEmployeeType,
  updateEmployeeType,
  deleteEmployeeType,
} from "../../../api/EmployeeType";
import {
  getEmployee,
  createEmployee,
  updateEmployee,
  deleteEmployee,
} from "../../../api/Employee";
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
      list2: null,
      total: 0,
      //   listLoading: true,
      listQuery: {
        page: 1,
        limit: 20,
        keyword: undefined,
      },
      listQueryEmployee: {
        page: 1,
        limit: 20,
        keyword: undefined,
        employee_id: undefined,
      },
      statusOptions: [
        { key: "available", display_name: "Hoạt động" },
        { key: "disable", display_name: "Không hoạt động" },
      ],
      temp: {
        id: undefined,
        name: "",
      },
      temp2: {
        id: undefined,
        name: "",
        address: "",
        phone: "",
        email: "",
        employeeType_id: "",
      },
      dialogFormVisible: false,
      dialogFormVisible2: false,
      dialogStatus: "",
      dialogStatus2: "",
      query1: {
        employeeType_id: undefined,
      },
      textMap: {
        update: "Sửa Loại công việc",
        create: "Thêm mới loại công việc",
      },
      textMap2: {
        update: "Sửa Loại công việc",
        create: "Thêm mới loại công việc",
      },
      rules: {
        name: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
            trigger: "change",
          },
        ],
      },
      rules2: {
        name: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
            trigger: "change",
          },
        ],
        address: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
            trigger: "change",
          },
        ],
        phone: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
            trigger: "change",
          },
        ],
        email: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
            trigger: "change",
          },
        ],
        employeeType_id: [
          {
            required: true,
            message: "Tên công việc không được bỏ trống",
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
      getEmployeeType(this.listQuery).then((response) => {
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
      this.temp2 = {
        id: undefined,
        name: "",
        address: "",
        phone: "",
        email: "",
        employeeType_id: "",
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
    handleCreate2() {
      this.resetTemp();
      this.dialogStatus2 = "create";
      this.dialogFormVisible2 = true;
      this.$nextTick(() => {
        this.$refs["dataForm2"].clearValidate();
      });
    },
    createData() {
      this.$refs["dataForm"].validate((valid) => {
        if (valid) {
          // console.log(this.temp);
          createEmployeeType(this.temp).then(() => {
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
    createData2() {
      this.$refs["dataForm2"].validate((valid) => {
        if (valid) {
          console.log(this.temp2);
          createEmployee(this.temp2).then(() => {
            // this.listQuery.page = 1;
            this.btngetlishEmployee();
            this.dialogFormVisible2 = false;
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
    handleUpdate2(row) {
      this.temp2 = Object.assign({}, row); // copy obj
      this.dialogStatus2 = "update";
      this.dialogFormVisible2 = true;
      this.$nextTick(() => {
        this.$refs["dataForm2"].clearValidate();
      });
    },
    updateData() {
      this.$refs["dataForm"].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updateEmployeeType(tempData.id, tempData).then(() => {
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
    updateData2() {
      this.$refs["dataForm2"].validate((valid) => {
        if (valid) {
          const tempData = Object.assign({}, this.temp);
          updateEmployee(tempData.id, tempData).then(() => {
            this.btngetlishEmployee();
            this.dialogFormVisible2 = false;
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
      deleteEmployeeType(row.id).then(() => {
        this.getList();
        this.$notify({
          title: "Thông báo",
          message: "Xoá thành công",
          type: "success",
          duration: 2000,
        });
      });
    },
    handleDelete2(row) {
      deleteEmployee(row.id).then(() => {
        this.btngetlishEmployee();
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
    btngetEmployee(row) {
      //   this.listQueryEmployee = Object.assign({}, row);
      this.Tenloai= row.name
      this.query1.employeeType_id = row.id;
      getEmployee(this.query1).then((response) => {
        this.list2 = response.data.data;
        // this.total = response.data.meta.total;
        // Just to simulate the time of the request
        setTimeout(() => {
          //   this.listLoading = false
        }, 0.5 * 1000);
      });
    },

    btngetlishEmployee() {
      getEmployee(this.query1).then((response) => {
        this.list2 = response.data.data;
        // this.total = response.data.meta.total;
        // Just to simulate the time of the request
        setTimeout(() => {
          //   this.listLoading = false
        }, 0.5 * 1000);
      });
    },
  },
};
</script>