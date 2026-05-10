<template>
    <div>
        <el-dropdown @command="clickEvent" :tabindex="1" trigger="click">
            <div class="userinfo">
                <el-avatar v-if="userStore.userInfo.head_img" :size="28" :icon="UserFilled" :src="img(userStore.userInfo.head_img)"/>
                <el-avatar v-else :size="28" :icon="UserFilled" />
                <span class="user-name">{{ userStore.userInfo.username }}</span>
                <el-icon class="arrow-icon"><ArrowDown /></el-icon>
            </div>
            <template #dropdown>
                <el-dropdown-menu class="user-dropdown">
                    <div class="user-dropdown-header">
                        <el-avatar v-if="userStore.userInfo.head_img" :size="40" :icon="UserFilled" :src="img(userStore.userInfo.head_img)"/>
                        <el-avatar v-else :size="40" :icon="UserFilled" />
                        <div class="user-info">
                            <div class="username">{{ userStore.userInfo.username }}</div>
                            <div class="role">个人中心</div>
                        </div>
                    </div>
                    <el-dropdown-item @click="getUserInfoFn">
                        <el-icon><Setting /></el-icon>
                        <span>账号设置</span>
                    </el-dropdown-item>
                    <el-dropdown-item @click="changePasswordDialog=true">
                        <el-icon><Lock /></el-icon>
                        <span>修改密码</span>
                    </el-dropdown-item>
                    <el-dropdown-item divided @click="logout">
                        <el-icon><SwitchButton /></el-icon>
                        <span>退出登录</span>
                    </el-dropdown-item>
                </el-dropdown-menu>
            </template>
        </el-dropdown>
        <el-dialog v-model="changePasswordDialog" width="450px" title="修改密码">
            <div>
                <el-form :model="saveInfo" label-width="90px" ref="formRef" :rules="formRules" class="page-form">
                    <el-form-item :label="t('originalPassword')" prop="original_password">
                        <el-input v-model="saveInfo.original_password" type="password" :placeholder="t('originalPasswordPlaceholder')" clearable class="input-width" maxlength="40" />
                    </el-form-item>
                    <el-form-item :label="t('newPassword')" prop="password">
                        <el-input v-model="saveInfo.password" type="password" :placeholder="t('passwordPlaceholder')" clearable class="input-width" maxlength="40" />
                        <div class="form-tip">{{t('passwordTip')}}</div>
                    </el-form-item>
                    <el-form-item :label="t('passwordCopy')" prop="password_copy">
                        <el-input v-model="saveInfo.password_copy" type="password" :placeholder="t('passwordPlaceholder')" clearable class="input-width" maxlength="40" />
                    </el-form-item>
                </el-form>
            </div>
            <template #footer>
                <span class="dialog-footer">
                    <el-button @click="changePasswordDialog = false">{{t('cancel')}}</el-button>
                    <el-button type="primary" @click="submitForm(formRef)">{{t('save')}}</el-button>
                </span>
            </template>
        </el-dialog>
        <user-info-edit ref="userInfoEditRef" />
    </div>
</template>

<script lang="ts" setup>
import { UserFilled, ArrowDown, Setting, Lock, SwitchButton } from '@element-plus/icons-vue'
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import type { FormInstance, FormRules } from 'element-plus'
import useUserStore from '@/stores/modules/user'
import { setUserInfo } from '@/api/personal'
import { t } from '@/lang'
import userInfoEdit from '@/components/user-info-edit/index.vue'
import { img } from "@/utils/common";

const userStore = useUserStore()
const router = useRouter()
const clickEvent = (command: string) => {
    switch (command) {
        case 'logout':
            userStore.logout()
            break
    }
}

const logout = () => {
    userStore.logout();
}
const toLink = (link) => {
    router.push(link)
}
const userInfoEditRef = ref(null)
const getUserInfoFn = ()=>{
    userInfoEditRef.value?.open()
}
const changePasswordDialog = ref(false)
const formRef = ref<FormInstance>();
const saveInfo = reactive({
    original_password: '',
    password: '',
    password_copy: ''
});
const formRules = reactive<FormRules>({
    original_password: [
        { required: true, message: '请输入原密码', trigger: 'blur' }
    ],
    password: [
        { required: true, message: '请输入新密码', trigger: 'blur' },
        { min: 6, message: '密码不能少于6位', trigger: 'blur' }
    ],
    password_copy: [
        { required: true, message: '请再次输入新密码', trigger: 'blur' },
        {
            validator: (rule, value, callback) => {
                if (value !== saveInfo.password) {
                    callback(new Error('两次输入的密码不一致'))
                } else {
                    callback()
                }
            },
            trigger: 'blur'
        }
    ]
});
const submitForm = async (formEl: FormInstance | undefined) => {
    if (!formEl) return
    await formEl.validate((valid) => {
        if (valid) {
            setUserInfo(saveInfo).then(() => {
                changePasswordDialog.value = false
                userStore.logout()
            })
        }
    })
}
</script>

<style lang="scss" scoped>
.userinfo {
    display: flex;
    align-items: center;
    height: 50px;
    padding: 0 2px;
    cursor: pointer;
    transition: all 0.3s;

    &:hover {
        background-color: var(--el-fill-color-light);
    }

    .user-name {
        margin-left: 8px;
        font-size: 14px;
        color: var(--el-text-color-primary);
        white-space: nowrap;
    }

    .arrow-icon {
        margin-left: 4px;
        font-size: 12px;
        color: var(--el-text-color-secondary);
    }
}

.user-dropdown {
    min-width: 180px;

    .user-dropdown-header {
        display: flex;
        align-items: center;
        padding: 12px 2px;
        border-bottom: 1px solid var(--el-border-color-lighter);

        .user-info {
            margin-left: 12px;

            .username {
                font-size: 14px;
                font-weight: 500;
                color: var(--el-text-color-primary);
            }

            .role {
                font-size: 12px;
                color: var(--el-text-color-secondary);
                margin-top: 2px;
            }
        }
    }

    .el-dropdown-menu__item {
        padding: 10px 16px;

        .el-icon {
            margin-right: 8px;
            font-size: 16px;
        }
    }
}
</style>
