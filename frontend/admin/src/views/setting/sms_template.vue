<template>
  <!-- 短信模板管理 -->
  <div class="main-container" v-loading="smsTemplateData.loading">
    <el-card class="box-card !border-none" shadow="never">
      <h3 class="panel-title !text-sm">全部消息</h3>

      <div class="flex flex-row flex-wrap">
        <el-table :data="smsTemplateData.all" size="large">
          <el-table-column prop="name" label="消息类型" min-width="120" />
          <el-table-column label="模板id" min-width="120">
            <template #default="{ row }">
              <span>{{ row.sms_id || '-' }}</span>
            </template>
          </el-table-column>
          <el-table-column label="短信内容" min-width="300">
            <template #default="{ row }">
              <span class="text-sm">{{ row.sms_content || '-' }}</span>
            </template>
          </el-table-column>
          <el-table-column label="是否启用" min-width="100">
            <template #default="{ row }">
              <el-switch v-model="row.is_sms" :active-value="1" :inactive-value="0" @change="handleSwitchChange(row)" />
            </template>
          </el-table-column>
          <el-table-column label="操作" align="right" fixed="right" min-width="100">
            <template #default="{ row }">
              <el-button type="primary" link @click="setNotice(row, 'sms')">设置</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </el-card>

    <el-card class="box-card mt-[15px] !border-none" shadow="never">
      <h3 class="panel-title !text-sm">用户消息</h3>

      <div class="flex flex-row flex-wrap">
        <el-table :data="smsTemplateData.buyer" size="large">
          <el-table-column prop="name" label="消息类型" min-width="120" />
          <el-table-column label="模板id" min-width="120">
            <template #default="{ row }">
              <span>{{ row.sms_id || '-' }}</span>
            </template>
          </el-table-column>
          <el-table-column label="短信内容" min-width="300">
            <template #default="{ row }">
              <span class="text-sm">{{ row.sms_content || '-' }}</span>
            </template>
          </el-table-column>
          <el-table-column label="是否启用" min-width="100">
            <template #default="{ row }">
              <el-switch v-model="row.is_sms" :active-value="1" :inactive-value="0" @change="handleSwitchChange(row)" />
            </template>
          </el-table-column>
          <el-table-column label="操作" align="right" fixed="right" min-width="100">
            <template #default="{ row }">
              <el-button type="primary" link @click="setNotice(row, 'sms')">设置</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </el-card>

    <sms ref="smsDialog" @complete="loadSmsTemplateList()" />
  </div>
</template>

<script setup lang="ts">
import { reactive, ref } from 'vue'
import { t } from '@/lang'
import { SuccessFilled } from '@element-plus/icons-vue'
import { getSmsNoticeList } from '@/api/sms'
import Sms from '@/views/setting/components/notice-sms.vue'

const smsDialog: Record<string, any> | null = ref(null)

const smsTemplateData = reactive({
  loading: true,
  all: [],
  buyer: [],
  seller: []
})

/**
 * 获取短信模板列表
 */
const loadSmsTemplateList = () => {
  smsTemplateData.loading = true

  getSmsNoticeList().then(res => {
    smsTemplateData.all = []
    smsTemplateData.buyer = []
    smsTemplateData.seller = []
    if (res.code === 1) {
      res.data.forEach(item => {
        if (item.notice && Object.keys(item.notice).length) {
          Object.keys(item.notice).forEach((key, index) => {
            const notice = item.notice[key]
            smsTemplateData.all.push(notice)
            notice.receiver_type == 1 ? smsTemplateData.buyer.push(notice) : smsTemplateData.seller.push(notice)
          })
        } else {
          smsTemplateData.all.push(item)
          item.receiver_type == 1 ? smsTemplateData.buyer.push(item) : smsTemplateData.seller.push(item)
        }
      })
    }
    smsTemplateData.loading = false
  }).catch((e) => {
    smsTemplateData.loading = false
  })
}

loadSmsTemplateList()

const setNotice = (data: any, type: string) => {
  data.type = type
  data.status = data['is_' + type]
  if (type === 'sms') {
    smsDialog.value.setFormData(data)
    smsDialog.value.showDialog = true
  }
}

const handleSwitchChange = (row: any) => {
  // 这里可以添加保存状态的逻辑
  console.log('开关状态变更:', row)
}
</script>

<style lang="scss" scoped>
.open {
  color: var(--el-color-primary);
}

.notice-type {
  >div:nth-last-child(1):first-child {
    width: 100%;
  }
}
</style>
