<template>
  <el-container :class="['w-full h-screen bg-page flex flex-col','login-wrap']">
    <template v-if="!imgLoading">
        <!-- 平台端登录-->
        <el-main class="login-main items-center justify-center flex-1 h-0">
            <div class="flex rounded-2xl shadow overflow-hidden">
                <div class="login-main-left w-[326px] flex flex-wrap justify-center">
                    <el-image v-if="loginConfig.bg" class="w-[326px] h-[449px]" :src="img(loginConfig.bg)" fit="cover" />
                    <img v-else  class="w-[326px] h-[449px]" src="@/assets/images/login/niushop_login_index_left.jpg" alt="">
                </div>
                <div class="login flex flex-col w-[394px] h-[449px] pt-[95px] px-[64px] pb-[110px]">
                    <h3 class="text-center text-[20px] font-500 mb-[4px]">{{ webSite.site_name || t('siteTitle') }}</h3>
                    <h3 class="text-center text-[14px] mb-[20px]">{{ t('platform') }}</h3>
                    <el-form :model="form" ref="formRef" :rules="formRules">
                        <el-form-item prop="username">
                            <el-input v-model.trim="form.username" :placeholder="t('userPlaceholder')" autocomplete="off" @keyup.enter="handleLogin(formRef)" class="h-[32px]">
                              <template #prefix>
                                <i class="iconfont iconwoV6xx1 !text-[13px] text-[#999]"></i>
                              </template>
                            </el-input>
                        </el-form-item>

                        <el-form-item prop="password">
                            <el-input v-model.trim="form.password" :placeholder="t('passwordPlaceholder')" type="password" autocomplete="new-password" @keyup.enter="handleLogin(formRef)" :show-password="true" class="h-[32px]">
                              <template #prefix>
                                <i class="iconfont iconmima6Vxx !text-[13px] text-[#999]"></i>
                              </template>
                            </el-input>
                        </el-form-item>

                        <el-form-item class="!mb-[0]">
                            <el-button type="primary" class="!h-[32px] !rounded-[4px] !text-[13px] w-full" @click="handleLogin(formRef)" :loading="loading">{{ loading ? t('logging') : t('login') }}</el-button>
                        </el-form-item>

                    </el-form>
                </div>
            </div>
        </el-main>

        <div class="flex items-center justify-center mt-[20px] pb-[20px] text-sm text-[#999]" v-if="copyright">
            <a :href="copyright.copyright_link" target="_blank">
                <span class="mr-3" v-if="copyright.copyright_desc">{{ copyright.copyright_desc }}</span>
                <span class="mr-3" v-if="copyright.company_name">{{ copyright.company_name }}</span>
            </a>
            <a href="https://beian.miit.gov.cn/" v-if="copyright.icp" target="_blank">
                <span class="mr-3">{{ copyright.icp }}</span>
            </a>
            <a :href="copyright.gov_url" v-if="copyright.gov_record" target="_blank">
                <span class="mr-3">{{ copyright.gov_record }}</span>
            </a>
        </div>
    </template>

    <!-- 验证组件 -->
    <verify @success="success" :mode="pop" captchaType="blockPuzzle" :imgSize="{ width: '330px', height: '155px' }" ref="verifyRef"></verify>
  </el-container>
</template>

<script lang="ts" setup>
import { inject, reactive, ref } from 'vue'
import type { FormInstance, FormRules } from 'element-plus'
import { useRoute, useRouter } from 'vue-router'
import { t } from '@/lang'
import { getLoginConfig } from '@/api/auth'
import useUserStore from '@/stores/modules/user'
import { setWindowTitle, img } from '@/utils/common'
import { getWebConfig, getWebCopyright } from '@/api/sys'

const setLayout = inject('setLayout')
setLayout('decorate')

const loading = ref(false)
const imgLoading = ref(false)
const userStore = useUserStore()
const route = useRoute()
const router = useRouter()
const copyright = ref(null)
const webSite = ref([])

getWebCopyright().then(({ data }) => {
    copyright.value = data
})

getWebConfig().then(({ data }) => {
    webSite.value = data
})

route.redirectedFrom && (route.query.redirect = route.redirectedFrom.path)

setWindowTitle(t('adminLogin'))

// 验证码 - start
const verifyRef = ref(null)
const success = (params) => {
  loginFn({ captcha_code: params.captchaVerification })
}

const form = reactive({
  username: '',
  password: ''
})

// 获取登录配置信息
const loginConfig = ref({})
const getLoginConfigFn = async () => {
  imgLoading.value = true
  const data = await (await getLoginConfig()).data
  loginConfig.value = data
  imgLoading.value = false
}
getLoginConfigFn()

const formRef = ref<FormInstance>()

const formRules = reactive<FormRules>({
  username: [
    { required: true, message: t('userPlaceholder'), trigger: 'blur' }
  ],
  password: [
    { required: true, message: t('passwordPlaceholder'), trigger: 'blur' }
  ]
})

const handleLogin = async (formEl: FormInstance | undefined) => {
  if (loading.value || !formEl) return

  await formEl.validate((valid, fields) => {
    if (valid) {
      if (parseInt(loginConfig.value.is_captcha)) { verifyRef.value.show() } else { loginFn() }
    }
  })
}

const loginFn = (data = {}) => {
  loading.value = true
  userStore.login({ username: form.username, password: form.password, ...data }).then(res => {
    const { query: { redirect } } = route
    const path = typeof redirect === 'string' ? redirect : '/'
    const url = router.resolve(path)
    location.href = url.href
  }).catch(() => {
    loading.value = false
  })
}
</script>

<style lang="scss">
.login-wrap {
  background-color: #F1F2F6;
}

.login-main {
  display: flex !important;

    .login {
        background: var(--el-bg-color);
    }
    .el-form-item {
        margin-bottom: 14px;
        .el-input__wrapper{
          border-radius: 4px !important;
        }
        .el-input{
          font-size: 13px;
        }
    }

    .el-form-item__error {
        top : 45px;
    }
}

@media only screen and (max-width: 750px) {
  .login-main-left {
    display: none;
  }
}
</style>

