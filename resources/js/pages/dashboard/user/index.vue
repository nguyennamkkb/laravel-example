<template>
  <div>
    <div class="content">
      <br />
      <br />
      <div class="container-fuild">
        <p class="_title0">Thông tin tài khoản</p>
        <el-form :inline="true" :model="listQuery" class="demo-form-inline">
          <el-form-item>
            <el-input
              v-model="listQuery.keyword"
              placeholder="Tìm kiếm"
            ></el-input>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="btnSearch">Tìm kiếm</el-button>
          </el-form-item>
          <el-button type="primary" @click="btnCreateUser()">
            <i class="el-icon-circle-plus-outline"></i>Thêm mới</el-button
          >
        </el-form>

        <el-table :data="users.data" style="width: 100%">
          <el-table-column label="Id">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.id }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Tên">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.name }}</span>
            </template>
          </el-table-column>
          <el-table-column label="Email">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.email }}</span>
            </template>
          </el-table-column>

          <el-table-column label="Mã đăng ký">
            <template slot-scope="scope">
              <span style="margin-left: 10px">{{ scope.row.code }}</span>
            </template>
          </el-table-column>

          <el-table-column label="Thao tác">
            <template slot-scope="scope">
              <el-button
                size="mini"
                type="warning"
                @click="btnUpdate(scope.row)"
                >Sửa</el-button
              >
              <el-button size="mini" type="danger" @click="bntDelete(scope.row)"
                >Xóa</el-button
              >
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>
    <div>
      <el-dialog title="Thêm mới tài khoản" :visible.sync="createUserDL">
        <el-form :model="dataCreate" :rules="createRules" ref="dataform2">
          <el-form-item label="Tên" prop="name" :label-width="formLabelWidth">
            <el-input v-model="dataCreate.name" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item
            label="Email"
            prop="email"
            :label-width="formLabelWidth"
          >
            <el-input v-model="dataCreate.email" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item
            label="Mã đăng ký"
            prop="code"
            :label-width="formLabelWidth"
          >
            <el-input v-model="dataCreate.code" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item
            label="Mật khẩu"
            prop="password"
            :label-width="formLabelWidth"
          >
            <el-input
              v-model="dataCreate.password"
              autocomplete="off"
            ></el-input>
          </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
          <el-button @click="createUserDL = false">hủy</el-button>
          <el-button type="primary" @click="handleCreateUser()"
            >Xác nhận</el-button
          >
        </span>
      </el-dialog>
      <el-dialog
        title="Cảnh báo"
        :visible.sync="deleteUserDL"
        width="20%"
        center
      >
        <span>Xóa tài khoản người đăng ký</span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="deleteUserDL = false">Hủy</el-button>
          <el-button type="primary" @click="handleDeleteUser()"
            >Đồng ý</el-button
          >
        </span>
      </el-dialog>
      <div></div>
      <el-dialog title="Sửa thông tin tài khoản" :visible.sync="updateUserDL">
        <el-form :model="userData" :rules="rules" ref="ruleForm">
          <el-form-item
            label="Tên"
            :label-width="updateUserDLLabelWidth"
            prop="name"
          >
            <el-input
              v-model="userData.name"
              type="text"
              autocomplete="off"
            ></el-input>
          </el-form-item>
          <el-form-item
            label="Địa chỉ Email"
            :label-width="updateUserDLLabelWidth"
            prop="email"
          >
            <el-input
              type="email"
              v-model="userData.email"
              autocomplete="off"
            ></el-input>
          </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
          <el-button @click="updateUserDL = false">Hủy</el-button>
          <el-button type="primary" @click="handleUpdateCode()"
            >Xác nhận</el-button
          >
        </span>
      </el-dialog>
    </div>
  </div>

  <!-- </div> -->
</template>
<script>
import { Empty, Loading } from "element-ui";
import { createUser, getUser,updateUser,deleteUser,filterUser} from "../../../api/UserRepository";
let loadingInstance;

export default {
  components: {},
  data() {
    return {
      listQuery: {
        page: 1,
        limit: 20,
        keyword: undefined,
      },
      creatUserDL: false,
      createUserDL: false,
      deleteUserDL: false,
      updateUserDL: false,
      users: {
        message: null,
        error: false,
        User: 0,
        results: [
          {
            id: null,
            name: null,
            email: null,
            code: null,
          },
        ],
      },
      userData: {
        id: undefined,
        name: "",
        email: "",
        code: "",
      },
      dataCreate: {
        id: undefined,
        name: "",
        email: "",
        code: "",
      },
      modalTitle: "",
      modal1: false,
      modal2: false,
      modaledit: false,
      modal_loading: false,
      loading: true,

      mesDelete: false,
      fullscreenLoading: false,
      updateUserDLLabelWidth: "130PX",
      rules: {
        name: [
          {
            required: true,
            message: "Tên không được bỏ trống",
            trigger: "change",
          },
        ],
        email: [
          {
            required: true,
            message: "Email không được bỏ trống",
            trigger: "change",
          },
        ],
      },
      createRules: {
        name: [
          {
            required: true,
            message: "Tên không được bỏ trống",
            trigger: "change",
          },
        ],
        email: [
          {
            required: true,
            message: "Email không được bỏ trống",
            trigger: "change",
          },
        ],
        code: [
          {
            required: true,
            message: "Mã đăng ký không được bỏ trống",
            trigger: "change",
          },
        ],
        password: [
          {
            required: true,
            message: "Mật khẩu không được bỏ trống",
            trigger: "change",
          },
        ],
      },
      formLabelWidth: "120px",
      search: {
        keyword: "",
        isUsed: undefined,
      },
    };
  },

  created() {
    this.getusers();
  },
  methods: {
    Reset() {
      this.createUserDL = false;
      this.deleteUserDL = false;
      this.updateUserDL = false;
      loadingInstance.close();
    },
    getusers: async function () {
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await getUser();
      // console.log(data.data);
      if (data.data) {
        this.users = data.data;
        loadingInstance.close();
      }
    },
    success() {
      this.$message({
        type: "success",
        message: "Thành công",
      });
      this.Reset();
    },
    error(data) {
      loadingInstance.close();
      this.$message({
        type: "error",
        message: data == "" ? "Không thành công" : data,
      });
    },
    checkStatus: function (data) {
      this.Reset();
      if (!data.error) {
        this.getusers();
        this.success();
      } else {
        this.error();
      }
    },
    btnCreateUser() {
      this.createUserDL = true;
    },
    handleCreateUser: async function () {
      this.$refs.dataform2.validate((valid) => {
        if (valid) {
          loadingInstance = Loading.service({ fullscreen: true });
          try {
            createUser(this.dataCreate).then((result) => {
              if (result.data.status == true) {
                this.getusers();
                this.success();
              } else {
                this.error(result.data.message);
              }
            });
          } catch (error) {
            console.log(error);
            this.error();
          }
        }
      });
    },
    bntDelete(row) {
      this.dataUser = row;
      this.deleteUserDL = true;
    },
    handleDeleteUser: async function () {
      this.deleteUserDL = false;
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await deleteUser(this.dataUser.id);
      // console.log(data);
      this.checkStatus(data.data);
    },
    btnUpdate(row) {
      this.userData = Object.assign({}, row);
      // console.log(this.userData);
      this.updateUserDL = true;
    },
    handleUpdateCode: async function () {
      this.$refs["ruleForm"].validate((valid) => {
        if (valid) {
          loadingInstance = Loading.service({ fullscreen: true });
          try {
            updateUser(this.userData.id, this.userData).then(
              (result) => {
                if (result.data.status == true) {
                  this.getusers();
                  this.success();
                }
              }
            );
          } catch (error) {
            this.error();
          }
        }
      });
    },
    btnSearch: async function () {
      loadingInstance = Loading.service({ fullscreen: true });
      try {
        const data = await filterUser(this.listQuery);
        if (data.data) {
          this.users = data.data;
          this.success();
        } else {
          this.error();
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>



			