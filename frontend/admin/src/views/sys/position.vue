<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
            </div>

            <div class="flex justify-between items-center mt-[20px]">
                <el-form :inline="true" :model="positionTableData.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('positionName')">
                        <el-input v-model="positionTableData.searchParam.name" class="input-width" :placeholder="t('positionNamePlaceholder')" />
                    </el-form-item>
                    <el-form-item :label="t('deptName')">
                        <el-tree-select
                            v-model="positionTableData.searchParam.dept_id"
                            :data="deptList"
                            :props="{ label: 'name', value: 'id', children: 'children' }"
                            :placeholder="t('deptNamePlaceholder')"
                            clearable
                            check-strictly
                            :render-after-expand="false"
                            class="input-width"
                        >
                            <template #default="{ data }">
                                <span>{{ data.name }}</span>
                            </template>
                        </el-tree-select>
                    </el-form-item>
                    <el-form-item :label="t('status')">
                        <el-select v-model="positionTableData.searchParam.status" :placeholder="t('statusPlaceholder')" clearable>
                            <el-option :label="t('statusUnlock')" :value="1" />
                            <el-option :label="t('lock')" :value="0" />
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="loadPositionList()">{{ t('search') }}</el-button>
                        <el-button @click="resetSearch()">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
                <el-button type="primary" class="w-[100px] self-start" @click="addEvent">{{ t('addPosition') }}</el-button>
            </div>

            <div>
                <el-table :data="positionTableData.data" size="large" v-loading="positionTableData.loading">
                    <template #empty>
                        <span>{{ !positionTableData.loading ? t('emptyData') : '' }}</span>
                    </template>

                    <el-table-column prop="name" :label="t('positionName')" min-width="150" show-overflow-tooltip />
                    <el-table-column prop="dept_name" :label="t('deptName')" min-width="150" show-overflow-tooltip>
                        <template #default="{ row }">
                            <span>{{ row.dept_name || '--' }}</span>
                        </template>
                    </el-table-column>
                    <el-table-column prop="sort" :label="t('sort')" min-width="100" />
                    <el-table-column prop="create_time" :label="t('createTime')" min-width="150" />
                    <el-table-column :label="t('status')" min-width="80" align="center">
                        <template #default="scope">
                            <el-switch v-model="scope.row.status" :active-value="1" :inactive-value="0" @change="toggleStatus(scope.row)" />
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="130">
                        <template #default="scope">
                            <el-button link type="primary" @click="editPosition(scope.row)">{{ t('edit') }}</el-button>
                            <el-button link type="danger" @click="deletePositionFn(scope.row)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="positionTableData.page" v-model:page-size="positionTableData.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="positionTableData.total"
                        @size-change="loadPositionList()" @current-change="loadPositionList" />
                </div>
            </div>

            <EditPosition ref="editPositionDialog" @complete="loadPositionList()" />
        </el-card>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, nextTick } from 'vue'
import { ElMessageBox, ElMessage } from 'element-plus'
import { getPositionList, deleteDept,deletePosition, editPosition as editPositionApi, getDeptTree } from '@/api/sys'
import EditPosition from './components/edit-position.vue'
import { t } from '@/lang'
import { useRoute } from 'vue-router'
import type { FormInstance } from 'element-plus'

const route = useRoute()
const pageName = route.meta.title

const positionTableData = reactive({
    page: 1,
    limit: 20,
    total: 0,
    data: [],
    loading: false,
    searchParam: {
        name: '',
        dept_id: '',
        status: ''
    }
})

const editPositionDialog = ref<InstanceType<typeof EditPosition> | null>(null)
const deptList = ref([])
const searchFormRef = ref<FormInstance>()
const isLoading = ref(false)

onMounted(() => {
    loadDeptList()
    loadPositionList()
})

const loadDeptList = async () => {
    getDeptTree().then(res => {
        deptList.value = res.data
    }).catch(() => {
    })
}

const loadPositionList = async (page = 1, limit = positionTableData.limit) => {
    isLoading.value = true
    positionTableData.loading = true
    positionTableData.page = page
    positionTableData.limit = limit
    getPositionList({
        page: positionTableData.page,
        limit: positionTableData.limit,
        name: positionTableData.searchParam.name,
        dept_id: positionTableData.searchParam.dept_id,
        status: positionTableData.searchParam.status
    }).then(res => {
        positionTableData.loading = false
        positionTableData.data = res.data.data
        positionTableData.total = res.data.total
    }).catch(() => {
        positionTableData.loading = false
    }).finally(() => {
        setTimeout(() => {
            isLoading.value = false
        }, 100)
    })
}

const editPosition = (row: any) => {
    nextTick(() => {
        if (!editPositionDialog.value) {
            return
        }
        editPositionDialog.value.setFormData(row)
        editPositionDialog.value.showDialog = true
    })
}

const addEvent = () => {
    nextTick(() => {
        if (!editPositionDialog.value) {
            return
        }
        editPositionDialog.value.setFormData()
        editPositionDialog.value.showDialog = true
    })
}

const deletePositionFn = (row: any) => {
    ElMessageBox.confirm(t('positionDeleteTips'), t('warning'), {
        confirmButtonText: t('confirm'),
        cancelButtonText: t('cancel'),
        type: 'warning'
    }).then(() => {
        deletePosition(row.id).then(() => {
            loadPositionList()
        }).catch(() => {
        })
    }).catch(() => {
    })
}

const toggleStatus = async (row: any) => {
    if (isLoading.value) {
        return
    }
    editPositionApi({ id: row.id, status: row.status }).then(() => {
    }).catch(() => {
    })
}

const resetSearch = () => {
    if (searchFormRef.value) {
        searchFormRef.value.resetFields()
    }
    loadPositionList()
}
</script>

<style lang="scss" scoped></style>