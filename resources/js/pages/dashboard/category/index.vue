<template>
  <div>
    <div class="content">
      <br />
      <br />
      <div class="container-fuild">
        <el-row :gutter="20">
          <el-col :span="12" style="background-color: white">
            <div class="grid-content bg-purple">
              <p class="_title0">Danh mục sản phẩm</p>
              <el-form
                :inline="true"
                :model="listQuery"
                class="demo-form-inline"
              >
                <el-form-item>
                  <el-input
                    v-model="listQuery.keyword"
                    placeholder="Tìm kiếm"
                  ></el-input>
                </el-form-item>
                <el-form-item>
                  <el-button type="primary" @click="btnSearch()"
                    >Tìm kiếm</el-button
                  >
                </el-form-item>
                <el-button type="primary" @click="btnCreate()">
                  <i class="el-icon-circle-plus-outline"></i
                ></el-button>
              </el-form>

              <el-table :data="resdata.data" style="width: 100%">

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
                      @click="btnUpdate(scope.row)"
                    ></el-button>
                    <el-button
                      type="danger"
                      icon="el-icon-delete"
                      circle
                      @click="btnDelete(scope.row)"
                    ></el-button>
                    <el-button
                      type="success"
                      icon="el-icon-right"
                      circle
                      @click="btngetCategoryChild(scope.row)"
                    ></el-button>
                  </template>
                </el-table-column>
              </el-table>
            </div>
          </el-col>

          <el-col :span="12" style="background-color: #fde4e4"
            ><div class="grid-content bg-purple-light">
              <p class="_title0">Danh mục con {{ categoryname }}</p>
              <el-form
                :inline="true"
                :model="listQuery1"
                class="demo-form-inline"
              >
                <el-form-item>
                  <el-input
                    v-model="listQuery1.keyword"
                    placeholder="Tìm kiếm"
                  ></el-input>
                </el-form-item>
                <el-form-item>
                  <el-button type="primary" @click="btnSearchchild()"
                    >Tìm kiếm</el-button
                  >
                </el-form-item>
                <el-button type="primary" @click="btnCreatechild()">
                  <i class="el-icon-circle-plus-outline"></i
                ></el-button>
              </el-form>

              <el-table :data="categorychild" style="width: 100%">
                <!-- <el-table-column label="Id" width="60">
                  <template slot-scope="scope1">
                    <span style="margin-left: 10px">{{ scope1.row.id }}</span>
                  </template>
                </el-table-column> -->
                <el-table-column label="Tên">
                  <template slot-scope="scope1">
                    <span style="margin-left: 10px">{{ scope1.row.name }}</span>
                  </template>
                </el-table-column>

                <el-table-column label="Thao tác">
                  <template slot-scope="scope1">
                    <el-button
                      type="primary"
                      icon="el-icon-edit"
                      circle
                      @click="btnUpdateChild(scope1.row)"
                    ></el-button>
                    <el-button
                      type="danger"
                      icon="el-icon-delete"
                      circle
                      @click="btnDeleteChild(scope1.row)"
                    ></el-button>
                  </template>
                </el-table-column>
              </el-table></div
          ></el-col>
        </el-row>
      </div>
    </div>
    <div>
      <el-dialog :title="textMap[dialogStatus]" :visible.sync="dialogcategory">
        <el-form :model="dataCategory" :rules="rules" ref="dataform2">
          <el-form-item label="Tên" prop="name" :label-width="formLabelWidth">
            <el-input v-model="dataCategory.name" autocomplete="off"></el-input>
          </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
          <el-button @click="dialogcategory = false">hủy</el-button>
          <el-button
            type="primary"
            @click="dialogStatus === 'create' ? handleCreate() : handleUpdate()"
            >Xác nhận</el-button
          >
        </span>
      </el-dialog>
      <el-dialog
        :title="textMap1[dialogStatus1]"
        :visible.sync="dialogcategorychild"
      >
        <el-form :model="dataCategorychild" :rules="rules1" ref="dataform3">
          <el-form-item
            label="Chon danh muc"
            :label-width="formLabelWidth"
            v-if="dialogStatus1 === 'create'"
          >
            <el-select
              v-model="dataCategorychild.category_id"
              placeholder="Chọn"
              prop="category_id"
              filterable
              remote
              reserve-keyword
            >
              <el-option
                v-for="item in listcCategory"
                :key="item.id"
                :label="item.name"
                :value="item.id"
              ></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label="Tên" prop="name" :label-width="formLabelWidth">
            <el-input
              v-model="dataCategorychild.name"
              autocomplete="off"
            ></el-input>
          </el-form-item>
        </el-form>
        <span slot="footer" class="dialog-footer">
          <el-button @click="dialogcategorychild = false">hủy</el-button>
          <el-button
            type="primary"
            @click="
              dialogStatus1 === 'create' ? handleCreate1() : handleUpdate1()
            "
            >Xác nhận</el-button
          >
        </span>
      </el-dialog>
      <el-dialog title="Cảnh báo" :visible.sync="deleteDL" width="20%" center>
        <span>Xóa danh mục sản phẩm </span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="deleteDL = false">Hủy</el-button>
          <el-button type="primary" @click="handleDelete()">Đồng ý</el-button>
        </span>
      </el-dialog>
      <el-dialog title="Cảnh báo" :visible.sync="deleteDL1" width="20%" center>
        <span>Xóa danh mục sản phẩm con </span>
        <span slot="footer" class="dialog-footer">
          <el-button @click="deleteDL1 = false">Hủy</el-button>
          <el-button type="primary" @click="handleDelete1()">Đồng ý</el-button>
        </span>
      </el-dialog>
      <div></div>
    </div>
  </div>

  <!-- </div> -->
</template>
<script>
import { Empty, Loading } from "element-ui";
import {
  createCategory,
  getCategory,
  updateCategory,
  deleteCategory,
} from "../../../api/Category";
import {
  createCategoryChild,
  getCategoryChild,
  updateCategoryChild,
  deleteCategoryChild,
} from "../../../api/CategoryChild";
let loadingInstance;

export default {
  components: {},
  data() {
    return {
      textMap: {
        update: "Sửa Danh mục",
        create: "Thêm mới Danh mục",
      },
      textMap1: {
        update: "Sửa Danh mục con",
        create: "Thêm mới Danh mục con",
      },
      dialogStatus: "",
      dialogStatus1: "",
      listQuery: {
        page: 1,
        limit: 20,
        keyword: undefined,
      },
      listQuery1: {
        page: 1,
        limit: 20,
        keyword: undefined,
      },
      dialogcategory: false,
      dialogcategorychild: false,
      deleteDL: false,
      updateDL: false,
      deleteDL1: false,
      dataCategory: {
        name: "",
      },
      modalTitle: "",
      modal1: false,
      modal2: false,
      modaledit: false,
      modal_loading: false,
      loading: true,
      resdata: {},
      mesDelete: false,
      fullscreenLoading: false,
      updateDLLabelWidth: "130PX",
      rules: {
        name: [
          {
            required: true,
            message: "Tên không được bỏ trống",
            trigger: "change",
          },
        ],
      },
      rules1: {
        name: [
          {
            required: true,
            message: "Tên không được bỏ trống",
            trigger: "change",
          },
        ],
        category_id: [
          {
            required: true,
            message: "Danh mục không được bỏ trống",
            trigger: "change",
          },
        ],
      },
      formLabelWidth: "120px",
      search: {
        keyword: "",
      },
      dataCategorychild: {
        id: undefined,
        name: "",
        category_id: undefined,
      },
      listcCategory: [],
      categorychild: null,
      categoryname: "",
      temp: {
        id: undefined,
        name: "",
        category_id: undefined,
      },
    };
  },
  created() {
    this.getcategories();
  },
  methods: {
    Reset() {
      this.dialogcategory = false;
      this.deleteDL = false;
      this.updateDL = false;
      loadingInstance.close();
    },
    getcategories: async function () {
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await getCategory();
      if (data.data) {
        this.resdata = data.data;
        this.listcCategory = data.data.data;
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
      this.deleteDL1 = false;
      if (!data.error) {
        this.getcategories();
        this.success();
      } else {
        this.error();
      }
    },
    btnCreate() {
      this.dialogcategory = true;
      this.dialogStatus = "create";
      // this.$refs.dataform2.clearValidate()
    },
    handleCreate: async function () {
      this.$refs.dataform2.validate((valid) => {
        if (valid) {
          loadingInstance = Loading.service({ fullscreen: true });
          try {
            createCategory(this.dataCategory).then((result) => {
              if (result.data.status == true) {
                this.getcategories();
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
    btnDelete(row) {
      this.dataCategory = row;
      this.deleteDL = true;
    },
    handleDelete: async function () {
      this.deleteDL = false;
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await deleteCategory(this.dataCategory.id);
      // console.log(data);
      this.checkStatus(data.data);
    },
    btnUpdate(row) {
      this.dataCategory = Object.assign({}, row);
      this.dialogcategory = true;
      this.dialogStatus = "update";
    },
    handleUpdate: async function () {
      this.$refs.dataform2.validate((valid) => {
        if (valid) {
          loadingInstance = Loading.service({ fullscreen: true });
          try {
            updateCategory(this.dataCategory.id, this.dataCategory).then(
              (result) => {
                if (result.data.status == true) {
                  this.getcategories();
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
        const data = await getCategory(this.listQuery);
        if (data.data) {
          this.data = data.data;
          this.success();
        } else {
          this.error();
        }
      } catch (error) {
        console.log(error);
      }
    },
    async btngetCategoryChild(row) {
      this.dataCategorychild.category_id = row.id;
      this.dataCategorychild.name = "";
      this.categoryname = row.name;
      loadingInstance = Loading.service({ fullscreen: true });
      const data = await getCategoryChild(this.dataCategorychild);
      if (data.data) {
        this.categorychild = data.data.data;
        loadingInstance.close();
      }
    },
    async btngetCategoryChild1() {
      loadingInstance = Loading.service({ fullscreen: true });
      this.dataCategorychild.name = "";
      const data = await getCategoryChild(this.dataCategorychild);
      if (data.data) {
        this.categorychild = data.data.data;
        loadingInstance.close();
        this.dialogcategorychild = false;
      }
    },
    btnUpdateChild(row) {
      this.dataCategorychild = Object.assign({}, row);
      this.dialogcategorychild = true;
      this.dialogStatus1 = "update";
      // this.$refs.dataform3.clearValidate();
    },
    btnDeleteChild(row) {
      this.dataCategorychild = Object.assign({}, row);
      this.deleteDL1 = true;
    },
    btnCreatechild() {
      this.dialogcategorychild = true;
      this.dialogStatus1 = "create";
      // this.$refs.dataform3.clearValidate();
    },
    btnSearchchild() {},
    handleCreate1: async function () {
      this.$refs.dataform3.validate((valid) => {
        if (valid) {
          // loadingInstance = Loading.service({ fullscreen: true });
          try {
            createCategoryChild(this.dataCategorychild).then((result) => {
              if (result.data.status == true) {
                this.btngetCategoryChild1();
                // console.log(this.categorychild);
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
    handleUpdate1: async function () {
      this.$refs.dataform3.validate((valid) => {
        if (valid) {
          try {
            updateCategoryChild(
              this.dataCategorychild.id,
              this.dataCategorychild
            ).then((result) => {
              if (result.data.status == true) {
                this.btngetCategoryChild1();
                this.success();
              }
            });
          } catch (error) {
            this.error();
          }
        }
      });
    },
    handleDelete1: async function () {
      this.deleteDL = false;
      // loadingInstance = Loading.service({ fullscreen: true });
      const data = await deleteCategoryChild(this.dataCategorychild.id);
      this.checkStatus(data.data);
      this.btngetCategoryChild1();
    },
  },
};
</script>



			