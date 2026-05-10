<template>
    <!--模板消息-->
    <div class="main-container">
        <el-card class="card !border-none" shadow="never">

            <div class="flex justify-between items-center">
                <span class="text-page-title">{{ pageName }}</span>
            </div>

            <el-tabs v-model="activeName" class="my-[20px]" @tab-change="handleClick">
                <el-tab-pane :label="t('wechatAccessFlow')" name="/channel/wechat" />
                <el-tab-pane :label="t('customMenu')" name="/channel/wechat/menu" />
                <el-tab-pane :label="t('wechatTemplate')" name="/channel/wechat/message" />
                <el-tab-pane :label="t('reply')" name="/channel/wechat/reply" />
                <el-tab-pane :label="t('messageRecord')" name="/channel/wechat/log" />
            </el-tabs>

            <el-table :data="cronTableData.data" :span-method="templateSpan" size="large" v-loading="cronTableData.loading">
                <template #empty>
                    <span>{{ !cronTableData.loading ? t('emptyData') : '' }}</span>
                </template>


                <el-table-column prop="name" :show-overflow-tooltip="true" :label="t('name')" min-width="150" >
                    <template #default="{ row }">
                        <div class="flex items-center">
                            <span class="mr-[5px]">{{row.name ? row.name : '商城订单支付通知' }}</span>
                            <el-tooltip :content="row.tips" v-if="row.tips" placement="top">
                                <icon name="element WarningFilled" />
                            </el-tooltip>
                        </div>
                    </template>
                </el-table-column>

                <el-table-column :label="t('messageType')" min-width="100" align="center">
                    <template #default="{ row }">
                        <span>{{ 1 == 1 ? t('buyerNews') : t('sellerMessage') }}</span>
                    </template>
                </el-table-column>

                <el-table-column :label="t('isStart')" min-width="100" align="center">
                    <template #default="{ row }">
                        {{ (row.is_wechat || 0) == 1 ? t('startUsing') : t('statusDeactivate') }}
                    </template>
                </el-table-column>

                <el-table-column :label="t('response')" min-width="180">
                    <template #default="{ row }">
                        <div v-for="(item, index) in row.content" :key="'a' + index" class="text-left">{{ item.join(":") }}</div>
                    </template>
                </el-table-column>

                <el-table-column prop="wechat_template_id" :label="t('serialNumber')" min-width="140" />

                <el-table-column :label="t('operation')" fixed="right" align="right" width="200">
                    <template #default="{ row }">
                        <el-button type="primary" link @click="infoSwitch(row)">{{ (row.is_weapp || 0) == 1 ? t('close') : t('open') }}</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </el-card>
    </div>

    <!-- 微信模板设置弹窗 -->
    <el-dialog v-model="dialogVisible" :title="dialogTitle" width="500px">
        <el-form :model="formData" label-width="120px">
            <el-form-item label="状态">
                <el-radio-group v-model="formData.status">
                    <el-radio :label="1">启用</el-radio>
                    <el-radio :label="0">停用</el-radio>
                </el-radio-group>
            </el-form-item>
            <el-form-item label="模板名称">
                <span>{{ formData.name }}</span>
            </el-form-item>
            <el-form-item label="模板ID" required>
                <el-input v-model="formData.wechat_template_id" placeholder="请输入微信模板ID" />
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogVisible = false">{{ t('cancel') }}</el-button>
                <el-button type="primary" @click="confirmDialog">{{ t('confirm') }}</el-button>
            </span>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { getTemplateList, setTemplate } from '@/api/wechat'
import { AnyObject } from '@/types/global'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title
const cronTableData = reactive({
    loading: true,
    data: []
})
const activeName = ref('/channel/wechat/message')
const handleClick = (val: any) => {
    activeName.value = val
    router.push({ path: val })
}

// 弹窗相关
const dialogVisible = ref(false)
const dialogTitle = ref('微信模板设置')
const formData = reactive({
    key: '',
    status: 0,
    name: '',
    content: '',
    wechat_template_id: ''
})
/**
 * 获取消息模板列表
 */
const loadCronList = (page: number = 1) => {
    cronTableData.loading = true

    getTemplateList().then(res => {
        cronTableData.loading = false
        cronTableData.data = res.data
    }).catch((e) => {
        cronTableData.loading = false
    })
}
loadCronList()



/**
 * 开启或关闭模版消息
 */
interface Switch {
    key: string;
    type: string;
    status: number;
    wechat_template_id?: string;
}

const infoSwitch = (res: AnyObject) => {
    // 填充表单数据
    formData.key = res.key
    // 显示当前状态：停用状态打开弹窗时显示"停用"，启用状态打开弹窗时显示"启用"
    const currentStatus = res.is_wechat || res.is_weapp || 0
    formData.status = currentStatus
    formData.name = res.name ? res.name : '商城订单支付通知'
    formData.content = res.content ? res.content.toString() : ''
    formData.wechat_template_id = res.wechat_template_id || ''
    
    // 显示弹窗
    dialogVisible.value = true
}

/**
 * 确认弹窗
 */
const confirmDialog = () => {
    cronTableData.loading = true
    // 调用新的接口保存微信模板设置
    // 这里需要添加新的API调用
    const data = {
        key: formData.key,
        status: formData.status,
        wechat_template_id: formData.wechat_template_id
    }
    
    // 使用新的微信模板设置接口
    setTemplate(data).then(res => {
        dialogVisible.value = false
        loadCronList()
    }).catch(() => {
        cronTableData.loading = false
        dialogVisible.value = false
    })
}
</script>
<style lang="scss" scoped>
:deep(.el-tabs__item:hover) {
    border-bottom: 2px solid var(--el-color-primary);
}

:deep(.el-tabs__item) {
    padding: 0;
}

:deep(.el-tabs__item+.el-tabs__item) {
    margin-right: 20px;
    margin-left: 20px;
    // border-bottom: 2px solid var(--el-color-primary);
}

:deep(.el-tabs--top) {
    .el-tabs__active-bar {
        display: none;
    }

    .el-tabs__item.is-active {
        border-bottom: 2px solid var(--el-color-primary);
    }

    .el-tabs__item.is-top:nth-child(2) {
        margin-right: 20px;
    }

}</style>

