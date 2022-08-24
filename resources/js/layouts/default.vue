<template>
  <div>
    <div>
      <div class="" style="background-color: white">
        <header
          class="
            navbar navbar-dark
            sticky-top
            bg-dark
            flex-md-nowrap
            p-0
            shadow
          "
        >
          <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#"
            >QUYETNHANH</a
          >

          <div class="navbar-nav">
            <div class="nav-item text-nowrap">
              <el-row>
                <!-- <el-button disabled>{{ user.name? user.name: "" }}</el-button> -->
                <el-button @click.prevent="logout" type="danger"
                  >Đăng xuất</el-button
                >
              </el-row>
            </div>
          </div>
        </header>

        <div class="row">
          <nav
            id="sidebarMenu"
            class="col-md-3 col-lg-2 d-md-block sidebar collapse"
          >
            <el-menu
              class="el-menu-vertical-demo"
              background-color="#545c64"
              text-color="#fff"
              active-text-color="#ffd04b"
            >
              <router-link to="index" aria-current="page">
                <el-menu-item index="1">
                  <i class="el-icon-setting"></i>
                  <span> Overview</span>
                </el-menu-item>
              </router-link>
              <router-link aria-current="page" :to="{ name: 'dashboard.user' }">
                <el-menu-item index="2">
                  <i class="el-icon-setting"></i>
                  <span> Tài khoản</span>
                </el-menu-item>
              </router-link>
              <router-link aria-current="page" :to="{ name: 'dashboard.code' }">
                <el-menu-item index="3">
                  <i class="el-icon-setting"></i>
                  <span>Mã đăng ký</span>
                </el-menu-item>
              </router-link>
              <el-submenu index="4">
                <template slot="title">
                  <i class="el-icon-location"></i>
                  <span>Danh mục chung</span>
                </template>

                <router-link :to="{ name: 'dashboard.category' }"
                  ><el-menu-item index="4-1"
                    >Loại hàng hóa</el-menu-item
                  ></router-link
                >
                <router-link :to="{ name: 'dashboard.specificities' }"
                  ><el-menu-item index="4-2"
                    >Đặc tính</el-menu-item
                  ></router-link
                >
                <router-link :to="{ name: 'dashboard.price' }"
                  ><el-menu-item index="4-3">Giá</el-menu-item></router-link
                >
                <router-link :to="{ name: 'dashboard.unit' }"
                  ><el-menu-item index="4-4"
                    >Đơn vị tính</el-menu-item
                  ></router-link
                >
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.customer' }"
                >
                  <el-menu-item index="4-5">
                    <i class="el-icon-setting"></i>
                    <span>Khách hàng</span>
                  </el-menu-item>
                </router-link>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.employee' }"
                >
                  <el-menu-item index="4-6">
                    <i class="el-icon-setting"></i>
                    <span>Nhân viên</span>
                  </el-menu-item>
                </router-link>
              </el-submenu>

              <el-submenu index="8">
                <template slot="title">
                  <i class="el-icon-location"></i>
                  <span>Nhập hàng</span>
                </template>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.input' }"
                >
                  <el-menu-item index="8-1">
                    Lập phiếu nhập</el-menu-item
                  ></router-link
                >
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.inputlist' }"
                  ><el-menu-item index="8-3"
                    >Danh sách phiếu nhập</el-menu-item
                  ></router-link
                >
                <!-- <el-menu-item index="8-2"></el-menu-item> -->
              </el-submenu>
              <el-submenu index="9">
                <template slot="title">
                  <i class="el-icon-location"></i>
                  <span>Xuất hàng</span>
                </template>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.export' }"
                  ><el-menu-item index="9-1"
                    >Lập phiếu xuất</el-menu-item
                  ></router-link
                >
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.exportlist' }"
                  ><el-menu-item index="9-2"
                    >Danh sách phiếu xuất</el-menu-item
                  ></router-link
                >
              </el-submenu>
              <el-submenu index="10">
                <template slot="title">
                  <i class="el-icon-location"></i>
                  <span>Thanh toán</span>
                </template>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.thanhtoantam' }"
                >
                  <el-menu-item index="10-1">Thanh toán chủ Tăm</el-menu-item>
                </router-link>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.thanhtoanvau' }"
                >
                  <el-menu-item index="10-2"> Thanh toán chủ vầu </el-menu-item>
                </router-link>
                <router-link
                  aria-current="page"
                  :to="{ name: 'dashboard.thanhtoanluong' }"
                >
                  <el-menu-item index="10-3">
                    Thanh toán Công nhân
                  </el-menu-item>
                </router-link>
              </el-submenu>
            </el-menu>
          </nav>
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <child />
          </main>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="main-layout">
    <navbar />

    <div class="container mt-4">
      <child />
    </div>
  </div> -->
</template>

<script>
import Navbar from "~/components/Navbar";
import { mapGetters } from "vuex";
export default {
  name: "MainLayout",

  components: {
    Navbar,
  },
  computed: mapGetters({
    user: "auth/user",
  }),
  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    },
  },
};
</script>
