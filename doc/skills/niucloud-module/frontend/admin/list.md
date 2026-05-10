# 模块列表页面

## 概述

模块列表页面用于展示和管理系统中所有的模块，支持搜索、筛选、添加、编辑、删除等功能。

## 代码结构

```vue
<template>
  <div class="main-container">
    <el-card class="box-card !border-none" shadow="never">
      <div class="flex justify-between items-center">
        <span class="text-page-title">{{ pageName }}</span>
        <el-button type="primary" class="w-[100px]" @click="dialogVisible = true">{{ t('addModule') }}</el-button>
      </div>
      
      <el-card class="box-card !border-none my-[10px] table-search-wrap" shadow="never">
        <el-form :inline="true" :model="moduleTableData.searchParam" ref="searchFormModuleRef">
          <el-form-item :label="t('title')" prop="title">
            <el-input v-model.trim="moduleTableData.searchParam.title" :placeholder="t('titlePlaceholder')" />
          </el-form-item>
          <el-form-item :label="t('typeName')" prop="type">
            <el-select v-model="moduleTableData.searchParam.type" :placeholder="t('moduleTypePlaceholder')">
              <el-option :label="t('all')" value="" />
              <el-option v-for="(item, key) in moduleType" :label="item.title" :value="key" :key="key"/>
            </el-select>
          </el-form-item>
          <el-form-item>
            <el-button type="primary" @click="loadModuleList()">{{ t('search') }}</el-button>
            <el-button @click="resetForm(searchFormModuleRef)">{{ t('reset') }}</el-button>
          </el-form-item>
        </el-form>
      </div>
      
      <div class="mb-[10px] flex items-center">
        <el-checkbox v-model="toggleCheckbox" size="large" class="px-[14px]" @change="toggleChange" :indeterminate="isIndeterminate" />
        <el-button @click="batchDeleteModules" size="small">{{t("batchDeletion")}}</el-button>
      </div>
      
      <el-table :data="moduleTableData.data" size="large" ref="moduleListTableRef" v-loading="moduleTableData.loading" @selection-change="handleSelectionChange">
        <template #empty>
          <span>{{ !moduleTableData.loading ? t('emptyData') : '' }}</span>
        </template>
        <el-table-column type="selection" width="55" />
        <el-table-column prop="page_title" :label="t('title')" min-width="120" />
        <el-table-column prop="type_name" :label="t('typeName')" min-width="80" />
        <el-table-column :label="t('status')" min-width="80">
          <template #default="{ row }">
            <el-tag type="success" v-if="row.status == 1" class="cursor-pointer" @click="showClick(row)">{{ t('statusOn') }}</el-tag>
            <el-tag type="info" v-else class="cursor-pointer" @click="showClick(row)">{{ t('statusOff') }}</el-tag>
          </template>
        </el-table-column>
        <el-table-column prop="update_time" :label="t('updateTime')" min-width="120" />
        
        <el-table-column :label="t('operation')" fixed="right" align="right" min-width="130">
          <template #default="{ row }">
            <div class="flex items-center justify-end">
              <el-button type="primary" v-if="row.status == 1 && row.type=='MODULE'" link @click="spreadEvent(row)">{{ t('promotion') }}</el-button>
              <el-button type="primary" link @click="editEvent(row)">{{ t('edit') }}</el-button>
              <el-button v-if="row.status == 0" type="primary" link @click="deleteEvent(row.module_id)">{{ t('delete') }}</el-button>
              <el-button type="primary" link @click="detailEvent(row)">{{ t('detail') }}</el-button>
              <el-dropdown placement="bottom" trigger="click" class="ml-[12px]">
                <el-button type="primary" link>{{ t('more') }}</el-button>
                <template #dropdown>
                  <el-dropdown-menu>
                    <el-dropdown-item v-if="row.type=='MODULE'">
                      <el-button type="primary" class="w-full" link @click="submitConfigEvent(row)">{{ t('submitSuccess') }}</el-button>
                    </el-dropdown-item>
                    <el-dropdown-item>
                      <el-button type="primary" class="w-full" link @click="writeConfigEvent(row)">{{ t('writeSet') }}</el-button>
                    </el-dropdown-item>
                    <el-dropdown-item v-if="row.type=='MODULE'">
                      <el-button type="primary" class="w-full" link @click="openShare(row)">{{ t('shareSet') }}</el-button>
                    </el-dropdown-item>
                    <el-dropdown-item>
                      <el-button type="primary" class="w-full" link @click="exportEvent(row)">{{ t('export') }}</el-button>
                    </el-dropdown-item>
                    <el-dropdown-item>
                      <el-button type="primary" class="w-full" link @click="copyEvent(row.module_id)">{{ t('copy') }}</el-button>
                    </el-dropdown-item>
                  </el-dropdown-menu>
                </template>
              </el-dropdown>
            </div>
          </template>
        </el-table-column>
      </el-table>
      
      <div class="mt-[16px] flex justify-end">
        <el-pagination v-model:current-page="moduleTableData.page" v-model:page-size="moduleTableData.limit"
          layout="total, sizes, prev, pager, next, jumper" :total="moduleTableData.total"
          @size-change="loadModuleList()" @current-change="loadModuleList" />
      </div>
    </el-card>
    
    <!--添加模块-->
    <el-dialog v-model="dialogVisible" :title="t('addModuleTips')" width="980px">
      <el-form :model="formData" ref="formRef" :rules="formRules">
        <el-form-item  prop="type">
          <div class="image-selection-container">
            <div
              v-for="(item, key) in moduleType"
              :key="key"
              class="image-option"
              :class="{ selected: formData.type === key }"
              @click="selectType(key)"
            >
              <img :src="img(item.preview)" class="option-image" />
              <div class="option-title">{{ item.title }}</div>
            </div>
          </div>
        </el-form-item>
      </el-form>
      
      <template #footer>
        <span class="dialog-footer">
          <el-button @click="dialogVisible = false">{{ t('cancel') }}</el-button>
          <el-button type="primary" @click="addEvent(formRef)">{{ t('confirm') }}</el-button>
        </span>
      </template>
    </el-dialog>
  </div>
</template>

<script lang="ts" setup>
import { reactive, ref, computed } from 'vue'
import { t } from '@/lang'
import { getModuleType, getApps, getModulePageList, deleteModule, editModuleShare, editModuleStatus, copyModule } from '@/api/module'
import { FormInstance, ElMessage, ElMessageBox } from 'element-plus'
import { useRoute, useRouter } from 'vue-router'
import { setTablePageStorage, getTablePageStorage, img } from '@/utils/common'

const route = useRoute()
const router = useRouter()
const pageName = route.meta.title

const moduleType: any = reactive({}) // 模块类型

// 添加自定义模块
const formData = reactive({
    title: '',
    type: ''
})
</script>
```