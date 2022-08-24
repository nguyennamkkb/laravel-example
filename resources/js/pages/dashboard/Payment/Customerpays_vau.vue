<template>
  <div>
    <div>
      <el-row :gutter="20">
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Chủ tăm</div>
            <div>
              <el-select
                v-model="listQuery.customer_id"
                filterable
                placeholder="Chọn"
              >
                <el-option
                  v-for="item in listCustomer"
                  :key="item.id"
                  :label="item.name"
                  :value="item.id"
                >
                </el-option>
              </el-select>
            </div>
          </div>
        </el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Từ ngày</div>
            <div>
              <el-date-picker
                v-model="listQuery.dateFrom"
                type="date"
                placeholder="Pick a day"
              >
              </el-date-picker>
            </div></div
        ></el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>Đến ngày</div>
            <div>
              <el-date-picker
                v-model="listQuery.dateTo"
                type="date"
                placeholder="Pick a day"
              >
              </el-date-picker>
            </div></div
        ></el-col>
        <el-col :span="6">
          <div class="grid-content bg-purple">
            <div>-----</div>
            <div>
              <el-button type="primary" @click="getListThanhToanVau()"
                >Tìm kiếm</el-button
              >
            </div>
          </div>
        </el-col>
      </el-row>
    </div>
    <div style="padding-top: 20px">
      <div>Khách hàng: {{ this.list.customer }}</div>
      <div>Tổng tiền: {{ this.list.totalmoney }}</div>
      <div>Đã trả trước: {{ this.list.prepay }}</div>
    </div>
    <div>
      <el-table :data="this.list.data" border style="width: 100%">
        <el-table-column prop="date" label="Ngày" width="180">
        </el-table-column>
        <el-table-column prop="weight" label="Số KG" width="180">
        </el-table-column>
        <el-table-column prop="price" label="Giá"> </el-table-column>
        <el-table-column prop="total" label="Tổng tiền"> </el-table-column>
      </el-table>
    </div>
  </div>
</template>

<script>
import { convertToDate } from "../../../handle/handleDate";
import { getCustomer } from "../../../api/Customer";
import { getListVau } from "../../../api/Payment";
export default {
  data() {
    return {
      listQuery: {
        dateFrom: "",
        dateTo: "",
        customer_id: undefined,
        status: 1,
      },
      query1: {
        customerType_id: 1,
        limit: 200,
      },
      listCustomer: null,
      list: {
        customer: undefined,
        prepay: undefined,
        customer: undefined,
        data: [],
      },
    };
  },
  created() {
    this.getListCustomer();
  },
  methods: {
    getListCustomer() {
      getCustomer(this.query1).then((response) => {
        this.listCustomer = response.data.data;
      });
    },
    getListThanhToanVau() {
      this.listQuery.dateFrom = convertToDate(this.listQuery.dateFrom);
      this.listQuery.dateTo = convertToDate(this.listQuery.dateTo);
      getListVau(this.listQuery).then((response) => {
        this.list = response.data;
        console.log(this.list);
      });
    },
  },
};
</script>