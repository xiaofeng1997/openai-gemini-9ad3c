<template>
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
            </div>

            <div class="flex justify-between items-center mt-[20px]">
                <el-form :inline="true" :model="deptTableData.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('deptName')">
                        <el-input v-model="deptTableData.searchParam.name" class="input-width" :placeholder="t('deptNamePlaceholder')" />
                    </el-form-item>
                    <el-form-item :label="t('status')">
                        <el-select v-model="deptTableData.searchParam.status" :placeholder="t('statusPlaceholder')" clearable>
                            <el-option :label="t('statusUnlock')" :value="1" />
                            <el-option :label="t('lock')" :value="0" />
                        </el-select>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="loadDeptList()">{{ t('search') }}</el-button>
                        <el-button @click="resetSearch()">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
                <el-button type="primary" class="w-[100px] self-start" @click="addEvent">{{ t('addDept') }}</el-button>
            </div>

            <div>
                <el-table :data="deptTableData.data" size="large" v-loading="deptTableData.loading" row-key="id" :tree-props="{ children: 'children', hasChildren: 'hasChildren' }">
                    <template #empty>
                        <span>{{ !deptTableData.loading ? t('emptyData') : '' }}</span>
                    </template>

                    <el-table-column prop="name" :label="t('deptName')" min-width="200" show-overflow-tooltip />
                    <el-table-column prop="sort" :label="t('sort')" min-width="100" />
                    <el-table-column prop="create_time" :label="t('createTime')" min-width="150" />
                    <el-table-column :label="t('status')" min-width="80" align="center">
                        <template #default="scope">
                            <el-switch v-model="scope.row.status" :active-value="1" :inactive-value="0" @change="toggleStatus(scope.row)" />
                        </template>
                    </el-table-column>
                    <el-table-column :label="t('operation')" align="right" fixed="right" width="130">
                        <template #default="scope">
                            <el-button link type="primary" @click="editDept(scope.row)">{{ t('edit') }}</el-button>
                            <el-button link type="danger" @click="deleteDeptFn(scope.row)">{{ t('delete') }}</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </div>

            <EditDept ref="editDeptDialog" @complete="loadDeptList()" />
        </el-card>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, nextTick } from 'vue'
import { ElMessageBox, ElMessage } from 'element-plus'
import { getDeptList, deleteDept, editDept as editDeptApi } from '@/api/sys'
import EditDept from './components/edit-dept.vue'
import { t } from '@/lang'
import { useRoute } from 'vue-router'
import type { FormInstance } from 'element-plus'

const route = useRoute()
const pageName = route.meta.title

const deptTableData = reactive({
    page: 1,
    limit: 20,
    total: 0,
    data: [],
    loading: false,
    searchParam: {
        name: '',
        status: ''
    }
})

const editDeptDialog = ref<InstanceType<typeof EditDept> | null>(null)
const searchFormRef = ref<FormInstance>()
const isLoading = ref(false)

onMounted(() => {
    loadDeptList()
})

const loadDeptList = async () => {
    isLoading.value = true
    deptTableData.loading = true
    getDeptList({
        name: deptTableData.searchParam.name,
        status: deptTableData.searchParam.status
    }).then(res => {
        deptTableData.loading = false
        deptTableData.data = res.data
    }).catch(() => {
        deptTableData.loading = false
    }).finally(() => {
        setTimeout(() => {
            isLoading.value = false
        }, 100)
    })
}

const editDept = (row: any) => {
    nextTick(() => {
        if (!editDeptDialog.value) {
            return
        }
        editDeptDialog.value.setFormData(row)
        editDeptDialog.value.showDialog = true
    })
}

const addEvent = () => {
    nextTick(() => {
        if (!editDeptDialog.value) {
            return
        }
        editDeptDialog.value.setFormData()
        editDeptDialog.value.showDialog = true
    })
}

const deleteDeptFn = (row: any) => {
    ElMessageBox.confirm(t('deptDeleteTips'), t('warning'), {
        confirmButtonText: t('confirm'),
        cancelButtonText: t('cancel'),
        type: 'warning'
    }).then(() => {
        deleteDept(row.id).then(() => {
            loadDeptList()
        }).catch(() => {
        })
    }).catch(() => {
    })
}

const toggleStatus = async (row: any) => {
    if (isLoading.value) {
        return
    }
    editDeptApi({ id: row.id, status: row.status }).then(() => {
    }).catch(() => {
    })
}

const resetSearch = () => {
    if (searchFormRef.value) {
        searchFormRef.value.resetFields()
    }
    loadDeptList()
}
</script>

<style lang="scss" scoped></style>