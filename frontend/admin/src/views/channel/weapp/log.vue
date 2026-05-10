<template>
    <!-- 微信小程序模板消息记录 -->
    <div class="main-container">
        <el-card class="box-card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
            </div>
            <el-tabs v-model="activeName" class="my-[20px]" @tab-change="handleClick">
                <el-tab-pane :label="t('weappAccessFlow')" name="/channel/weapp" />
                <el-tab-pane :label="t('subscribeMessage')" name="/channel/weapp/message" />
                <el-tab-pane :label="t('messageRecord')" name="/channel/weapp/log" />
            </el-tabs>
            <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
                <el-form :inline="true" :model="recordsTableData.searchParam" ref="searchFormRef">
                    <el-form-item :label="t('searchReceiver')" prop="receiver">
                        <el-input v-model.trim="recordsTableData.searchParam.receiver" :placeholder="t('receiverPlaceholder')" />
                    </el-form-item>

                    <el-form-item :label="t('noticeKey')" prop="key">
                        <el-select v-model="recordsTableData.searchParam.key" clearable :placeholder="t('noticeKeyPlaceholder')" class="input-width">
                            <el-option :label="item.name" :value="item.value" :disabled="item.disabled ?? false" v-for="(item, index) in templateList" :key="index" />
                        </el-select>
                    </el-form-item>

                    <el-form-item :label="t('createTime')" prop="create_time">
                        <el-date-picker v-model="recordsTableData.searchParam.create_time" type="datetimerange" value-format="YYYY-MM-DD HH:mm:ss" :start-placeholder="t('startDate')" :end-placeholder="t('endDate')" />
                    </el-form-item>

                    <el-form-item>
                        <el-button type="primary" @click="loadNoticeLogList()">{{ t('search') }}</el-button>
                        <el-button @click="resetForm(searchFormRef)">{{ t('reset') }}</el-button>
                    </el-form-item>
                </el-form>
            </el-card>

            <div class="mt-[10px]">
                <el-table :data="recordsTableData.data" size="large" v-loading="recordsTableData.loading">

                    <template #empty>
                        <span>{{ !recordsTableData.loading ? t('emptyData') : '' }}</span>
                    </template>

                    <el-table-column prop="name" :label="t('noticeKey')" min-width="120" />
                    <el-table-column prop="receiver" :label="t('receiver')" min-width="120" />
                    <el-table-column prop="create_time" :label="t('createTime')" min-width="140" />
                    <el-table-column prop="status" :label="t('status')" min-width="100">
                        <template #default="{ row }">
                            <el-tag v-if="row.status === 0" type="warning">{{ t('sending') }}</el-tag>
                            <el-tag v-else-if="row.status === 1" type="success">{{ t('success') }}</el-tag>
                            <el-tag v-else-if="row.status === 2" type="danger">{{ t('failed') }}</el-tag>
                        </template>
                    </el-table-column>

                    <el-table-column :label="t('operation')" align="right" fixed="right" width="100">
                        <template #default="{ row }">
                            <el-button type="primary" link @click="infoEvent(row)">{{ t('info') }}</el-button>
                        </template>
                    </el-table-column>

                </el-table>

                <div class="mt-[16px] flex justify-end">
                    <el-pagination v-model:current-page="recordsTableData.page" v-model:page-size="recordsTableData.limit"
                        layout="total, sizes, prev, pager, next, jumper" :total="recordsTableData.total"
                        @size-change="loadNoticeLogList()" @current-change="loadNoticeLogList" />
                </div>
            </div>

            <records-info ref="recordsDialog" @complete="loadNoticeLogList" />
        </el-card>
    </div>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { getWeappLogList, getWeappLogInfo, getTemplateList } from '@/api/weapp'
import RecordsInfo from './components/weapp-log-info.vue'
import { FormInstance } from 'element-plus'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title
const activeName = ref('/channel/weapp/log')

const handleClick = (val: any) => {
    activeName.value = val
    router.push({ path: val })
}

const recordsTableData = reactive({
    page: 1,
    limit: 10,
    total: 0,
    loading: true,
    data: [],
    searchParam: {
        key: '',
        receiver: '',
        create_time: []
    }
})

const templateList = reactive<Array<any>>([])

const setTemplateList = async () => {
    getTemplateList().then(res => {
        templateList.length = 0
        res.data.forEach(item => {
            templateList.push({ name: item.name, value: item.key })
        })
    }).catch((e) => {
    })
}

setTemplateList()

const searchFormRef = ref<FormInstance>()

/**
 * 获取通知记录列表
 */
const loadNoticeLogList = (page: number = 1) => {
    recordsTableData.loading = true
    recordsTableData.page = page

    getWeappLogList({
        page: recordsTableData.page,
        limit: recordsTableData.limit,
        ...recordsTableData.searchParam
    }).then(res => {
        recordsTableData.loading = false
        recordsTableData.data = res.data.data
        recordsTableData.total = res.data.total
    }).catch(() => {
        recordsTableData.loading = false
    })
}
loadNoticeLogList()

const resetForm = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.resetFields()
    loadNoticeLogList()
}

const recordsDialog: Record<string, any> | null = ref(null)

/**
 * 查看通知记录
 * @param data
 */
const infoEvent = (data: any) => {
    recordsDialog.value.setFormData(data)
    recordsDialog.value.showDialog = true
}

</script>

<style lang="scss" scoped></style>