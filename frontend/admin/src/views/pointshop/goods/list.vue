<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">
            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ t('pointshopGoodsList') }}</span>
                <el-button type="primary" @click="addEvent">
                    <icon name="icon_add" />
                    {{ t('addGoods') }}
                </el-button>
            </div>

            <el-card class="box-card !border-none table-search-wrap" shadow="never">
                <el-form :inline="true" :model="tableData.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('keyword')">
                        <el-input v-model="tableData.searchParam.keyword" :placeholder="t('keywordPlaceholder')" class="!w-[200px]" clearable @keyup.enter="search()" />
                    </el-form-item>
                    <el-form-item :label="t('category')">
                        <el-select v-model="tableData.searchParam.category_id" :placeholder="t('selectCategory')" class="!w-[200px]" clearable>
                            <el-option :label="t('selectPlaceholder')" value="" />
                            <el-option :label="item.category_name" :value="item.category_id" v-for="item in categoryList" :key="item.category_id" />
                        </el-select>
                    </el-form-item>
                    <el-form-item :label="t('status')">
                        <el-select v-model="tableData.searchParam.status" :placeholder="t('selectPlaceholder')" class="!w-[200px]" clearable>
                            <el-option :label="t('selectPlaceholder')" value="" />
                            <el-option :label="t('enable')" :value="1" />
                            <el-option :label="t('disable')" :value="0" />
                        </el-select>
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
                    <el-table-column prop="goods_id" :label="t('id')" width="80" />
                    <el-table-column :label="t('goodsInfo')" min-width="300">
                        <template #default="{ row }">
                            <div class="flex items-center">
                                <el-image class="w-[60px] h-[60px]" :src="img(row.goods_image)" fit="cover">
                                    <template #error>
                                        <div class="w-[60px] h-[60px] flex items-center justify-center bg-[#f5f5f5]">
                                            <icon name="icon_image" />
                                        </div>
                                    </template>
                                </el-image>
                                <div class="ml-[12px] flex-1">
                                    <p class="text-[14px]">{{ row.goods_name }}</p>
                                    <p class="text-[12px] text-[#999] mt-[4px]">{{ t('category') }}: {{ row.category_name || '-' }}</p>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                    <el-table-column prop="point_price" :label="t('pointPrice')" width="120" align="right">
                        <template #default="{ row }">
                            <span class="text-primary">{{ row.point_price }} {{ t('point') }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="price" :label="t('marketPrice')" width="120" align="right">
                        <template #default="{ row }">
                            ¥{{ row.price }}
                        </template>
                    </el-table-column>
                    <el-table-column prop="stock" :label="t('stock')" width="80" align="center" />
                    <el-table-column prop="sales_num" :label="t('salesNum')" width="80" align="center" />
                    <el-table-column prop="status_name" :label="t('status')" width="80" align="center">
                        <template #default="{ row }">
                            <el-tag :type="row.status == 1 ? 'success' : 'danger'">{{ row.status_name }}</el-tag>
                        </template>
                    </el-table-column>
                    <el-table-column prop="sort" :label="t('sort')" width="80" align="center" />
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="160">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
                            <el-button type="primary" link @click="deleteEvent(row)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="tableData.page" v-model:page-size="tableData.limit" layout="total, sizes, prev, pager, next, jumper" :total="tableData.total" @size-change="loadTableData()" @current-change="loadTableData" />
                </div>
            </div>
        </el-card>

        <edit-popup ref="editRef" @complete="loadTableData" />
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref, onMounted } from 'vue'
import { t } from '@/lang'
import { getPointGoodsList, deletePointGoods, getPointCategory } from '@/api/pointshop'
import { FormInstance } from 'element-plus'
import { img } from '@/utils/common'
import { ElMessageBox } from 'element-plus'
import editPopup from './components/edit.vue'

const searchFormRef = ref<FormInstance>()

const tableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        keyword: '',
        category_id: '',
        status: ''
    }
})

const categoryList = ref<any[]>([])

const loadTableData = (page: number = 1) => {
    tableData.loading = true
    tableData.page = page
    getPointGoodsList({
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

const editRef = ref()
const addEvent = () => {
    editRef.value.setData({ categoryList: categoryList.value })
    editRef.value.open()
}

const editEvent = (row: any) => {
    editRef.value.setData({ ...row, categoryList: categoryList.value })
    editRef.value.open()
}

const deleteEvent = (row: any) => {
    ElMessageBox.confirm(t('deleteGoodsTips'), t('warning'), {
        confirmButtonText: t('confirm'),
        cancelButtonText: t('cancel'),
        type: 'warning'
    }).then(() => {
        deletePointGoods(row.goods_id).then(() => {
            loadTableData()
        })
    })
}

const loadCategory = () => {
    getPointCategory().then(res => {
        categoryList.value = res.data
    })
}

onMounted(() => {
    loadCategory()
    loadTableData()
})
</script>

<style lang="scss" scoped></style>
