<template>
  <div>
    <div class="content">
      <br />
      <br />
      <div class="container-fuild">
        <p class="_title0">Thông tin mã đăng ký</p>
        <el-form :inline="true" :model="listQuery" class="demo-form-inline">
          <el-form-item>
            <el-select
              v-model="listQuery.isUsed"
              placeholder="Trạng thái sử dụng"
            >
              <el-option label="Tất cả" :value="0">Tất cả</el-option>
              <el-option label="Đã sử dụng" :value="2">Đã sử dụng</el-option>
              <el-option label="Chưa sử dụng" :value="1"
                >Chưa sử dụng</el-option
              >
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="btnSearch">Tìm kiếm</el-button>
          </el-form-item>
          <el-button type="primary" @click="createCodeDL = true">
          <i class="el-icon-circle-plus-outline"></i>Thêm mới</el-button
        >
        </el-form>
        

        <el-table :data="codes.data" style="width: 100%">
          <el-table-column label="Id">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.id }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Mã đăng ký">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.name }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Trạng thái">
            <template slot-scope="scope">
              <el-tag type="danger" v-if="scope.row.isUsed == false"
                >Chưa sử dụng</el-tag
              >
              <el-tag type="success" v-if="scope.row.isUsed == true"
                >Đã sử dụng</el-tag
              >
            </template>
          </el-table-column>
          <el-table-column label="Doanh nghiệp">
            <template slot-scope="scope">

              <span style="margin-left: 10px">{{ scope.row.user ? scope.row.user.name: "" }}</span>

            </template>
          </el-table-column>
          <el-table-column label="Ngày bắt đầu">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.startTime }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Ngày kết thúc">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.endTime }}</span>
            </template>
          </el-table-column>

          <el-table-column label="Thao tác">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="danger"
                @click="confirmDelete(scope.row)"
                >Xóa</el-button
              >
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>
    <div>
      <el-dialog
        title="Thông báo"
        :visible.sync="createCodeDL"
        width="20%"
        center
      >
        <span>Thêm mới mã đăng ký</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="createCodeDL = false">Hủy</el-button>
          <el-button type="primary" @click="handleCreateCode()"
            >Đồng ý</el-button
          >
        </span>
      </el-dialog>
      <el-dialog
        title="Cảnh báo"
        :visible.sync="deleteCodeDL"
        width="20%"
        center
      >
        <span>Xóa mã đăng ký</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="deleteCodeDL = false">Hủy</el-button>
          <el-button type="primary" @click="deleteCode()">Đồng ý</el-button>
        </span>
      </el-dialog>
    </div>
  </div>

  <!-- </div> -->
</template>
<script>
import {getCode, createCode, updateCode, deleteCode, filterCode } from "../../../api/CodeRepository"
import { Loading } from "element-ui";
let loadingInstance;

export default {
  middleware: "auth",
  components: {},
  data() {
    return {
      createCodeDL: false,
      deleteCodeDL: false,
      codes: {
        message: null,
        error: false,
        code: 0,
        results: [
          {
            id: 0,
            name: null,
            isUsed: null,
            enterprise: null,
            startTime: null,
            endTime: null,
          },
        ],
      },
      modalTitle: "",
      modaledit: false,
      modal_loading: false,
      loading: true,
      tableData: {
        id: 0,
        name: "Nguyennasdasdam",
        isUsed: null,
        idEnterprise: null,
        startTime: null,
        endTime: null,
      },
      resData: {
        message: null,
        error: null,
        code: null,
        results: null,
      },
      mesDelete: false,
      fullscreenLoading: false,
      listQuery: {
        page: 1,
        limit: 20,
        keyword: '',
        isUsed:undefined,
      },
    };
  },

  created() {
    loadingInstance = Loading.service({ fullscreen: true });
    this.getCodes();
    loadingInstance.close();
  },
  methods: {
    getCodes: async function () {
      const data = await getCode();
      if (data.data) {
        this.codes = data.data;
      }
    },
    success() {
      this.createCodeDL = false;
      loadingInstance.close();
      this.$message({
        type: "success",
        message: "Thành công",
      });
    },
    error() {
      this.createCodeDL = false;
      loadingInstance.close();
      this.$message({
        type: "error",
        message: "Không thành công",
      });
    },
    checkStatus: function (data) {
      if (!data.error) {
        this.getCodes();
        this.success();
      } else {
        this.error();
      }
    },
    handleCreateCode: async function () {
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await createCode();
      this.checkStatus(data.data);
    },
    confirmDelete(row) {
      this.dataCode = row;
      this.deleteCodeDL = true;
    },
    deleteCode: async function () {
      this.deleteCodeDL = false;
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await deleteCode(this.dataCode.id);
      // console.log(data);
      this.checkStatus(data.data);
    },
    btnSearch: async function () {
      this.listQuery.isUsed = parseInt(this.listQuery.isUsed);
      // console.log(this.listQuery);
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await filterCode(this.listQuery);

      if (data.data) {
        this.codes = data.data;
        this.success();
      }else{
        this.error()
      }
    },
  },
};
</script>



			