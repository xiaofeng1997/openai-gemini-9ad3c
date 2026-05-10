<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ t('pointshopOrder') }}</span>
            </div>

            <el-card class="box-card !border-none table-search-wrap" shadow="never">
                <el-form :inline="true" :model="tableData.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('keyword')">
                        <el-input v-model="tableData.searchParam.keyword" :placeholder="t('orderKeywordPlaceholder')" class="!w-[200px]" clearable @keyup.enter="search()" />
                    </el-form-item>
                    <el-form-item :label="t('status')">
                        <el-select v-model="tableData.searchParam.status" :placeholder="t('selectPlaceholder')" class="!w-[200px]" clearable>
                            <el-option :label="t('selectPlaceholder')" value="" />
                            <el-option :label="item.name" :value="item.status" v-for="item in statusList" :key="item.status" />
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="t('createTime')">
                        <el-date-picker v-model="tableData.searchParam.create_time" type="datetimerange" value-format="YYYY-MM-DD HH:mm:ss" :start-placeholder="t('startDate')" :end-placeholder="t('endDate')" />
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="search()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[16px]">
                <el-table :data="tableData.data" size="large" v-loading="tableData.loading">
                    <template #empty>
                        <span>{{ !tableData.loading ? t('emptyData') : '' }}</span>
                    </template>
                    <el-table-column prop="order_no" :label="t('orderNo')" width="180" />
                    <el-table-column :label="t('memberInfo')" min-width="180">
                        <template #default="{ row }">
                            <div class="flex items-center" v-if="row.member">
                                <img class="w-[40px] h-[40px] rounded-full mr-[8px]" :src="img(row.member.headimg)" v-if="row.member.headimg" />
                                <img class="w-[40px] h-[40px] rounded-full mr-[8px]" src="@/assets/images/default_headimg.png" v-else />
                                <div>
                                    <p>{{ row.member.nickname || '-' }}</p>
                                    <p class="text-[12px] text-[#999]">{{ row.member.mobile || '-' }}</p>
                                </div>
                            </div>
                            <span v-else>-</span>
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('goodsInfo')" min-width="200">
                        <template #default="{ row }">
                            <div class="flex items-center" v-if="row.goods">
                                <el-image class="w-[50px] h-[50px]" :src="img(row.goods.goods_image)" fit="cover">
                                    <template #error>
                                        <div class="w-[50px] h-[50px] flex items-center justify-center bg-[#f5f5f5]">
                                            <icon name="icon_image" />
                                        </div>
                                    </template>
                                </el-image>
                                <div class="ml-[8px]">
                                    <p class="text-[14px]">{{ row.goods.goods_name }}</p>
                                    <p class="text-[12px] text-primary">{{ row.goods.point_price }} {{ t('point') }}</p>
                                </div>
                            </div>
                            <span v-else>-</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="num" :label="t('num')" width="80" align="center" />
                    <el-table-column prop="point_num" :label="t('totalPoint')" width="120" align="right">
                        <template #default="{ row }">
                            <span class="text-primary">{{ row.point_num }} {{ t('point') }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="status_name" :label="t('status')" width="100" align="center">
                        <template #default="{ row }">
                            <el-tag :type="getStatusType(row.status)">{{ row.status_name }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="create_time" :label="t('createTime')" width="160" />
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="120">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="viewEvent(row)">{{ t('info') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="tableData.page" v-model:page-size="tableData.limit" layout="total, sizes, prev, pager, next, jumper" :total="tableData.total" @size-change="loadTableData()" @current-change="loadTableData" />
                </div>
            </div>
        </el-card>

        <order-detail ref="detailRef" />
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, onMounted } from 'vue'
import { t } from '@/lang'
import { getPointOrderList, getPointOrderStatusList } from '@/api/pointshop'
import { FormInstance } from 'element-plus'
import { img } from '@/utils/common'
import orderDetail from './components/detail.vue'

const searchFormRef = ref<FormInstance>()

const tableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        keyword: '',
        status: '',
        create_time: []
    }
})

const statusList = ref<any[]>([])

const loadTableData = (page: number = 1) => {
    tableData.loading = true
    tableData.page = page
    getPointOrderList({
        page: tableData.page,
        limit: tableData.limit,
        ...tableData.searchParam
    }).then(res => {
        tableData.loading = false
        tableData.data = res.data.data
        tableData.total = res.data.total
    }).catch(() => {
        tableData.loading = false
    })
}

const search = () => {
    loadTableData(1)
}

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadTableData(1)
}

const getStatusType = (status: number) => {
    const types: Record<number, string> = {
        '-1': 'info',
        '1': 'warning',
        '2': 'primary',
        '3': 'success'
    }
    return types[status] || 'info'
}

const detailRef = ref()
const viewEvent = (row: any) => {
    detailRef.value.setData(row)
    detailRef.value.open()
}

onMounted(() => {
    getPointOrderStatusList().then(res => {
        statusList.value = res.data
    })
    loadTableData()
})
</script>

<style lang="scss" scoped></style>
