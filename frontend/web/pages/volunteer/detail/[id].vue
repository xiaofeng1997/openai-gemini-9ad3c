<template>
    <div class="detail-container">
        <div class="container">
            <div class="detail-content" v-if="!loading">
                <div class="service-cover">
                    <img :src="serviceDetail.service_cover" :alt="serviceDetail.service_name" />
                </div>
                <div class="service-info">
                    <h1 class="service-name">{{ serviceDetail.service_name }}</h1>
                    <div class="price-row">
                        <span class="point-price">{{ serviceDetail.point_price }} 积分</span>
                        <span class="unit">/{{ serviceDetail.service_unit }}</span>
                    </div>
                    <div class="meta-row">
                        <span>预计时长: {{ serviceDetail.service_duration }}分钟</span>
                        <span>服务范围: {{ serviceDetail.service_area || '不限' }}</span>
                    </div>
                    <div class="category-tag">{{ serviceDetail.category_name }}</div>

                    <div class="service-desc" v-if="serviceDetail.service_desc">
                        <h3>服务描述</h3>
                        <p>{{ serviceDetail.service_desc }}</p>
                    </div>

                    <div class="volunteer-info" v-if="serviceDetail.volunteer_id > 0">
                        <img :src="serviceDetail.volunteer_avatar || '/static/images/default_avatar.png'" class="avatar" />
                        <div class="info">
                            <p class="name">{{ serviceDetail.volunteer_name }}</p>
                            <p class="intro" v-if="serviceDetail.volunteer_intro">{{ serviceDetail.volunteer_intro }}</p>
                        </div>
                    </div>

                    <div class="action-box">
                        <div class="my-point">
                            我的积分: <span>{{ memberPoint }}</span>
                        </div>
                        <el-button type="primary" size="large" @click="handleBook" :disabled="!canBook">
                            {{ canBook ? '立即预约' : '积分不足' }}
                        </el-button>
                    </div>
                </div>
            </div>
        </div>

        <el-dialog v-model="showBookDialog" title="预约服务" width="500px">
            <el-form :model="bookForm" label-width="100px">
                <el-form-item label="预约时间">
                    <el-date-picker v-model="bookForm.service_time" type="datetime" placeholder="选择预约时间" value-format="x" />
                </el-form-item>
                <el-form-item label="服务地址">
                    <el-input v-model="bookForm.service_address" placeholder="请输入服务地址" />
                </el-form-item>
                <el-form-item label="备注">
                    <el-input v-model="bookForm.service_remark" type="textarea" :rows="3" placeholder="如有特殊要求请备注" />
                </el-form-item>
            </el-form>
            <template #footer>
                <el-button @click="showBookDialog = false">取消</el-button>
                <el-button type="primary" @click="confirmBook" :loading="booking">确认预约</el-button>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import { getServiceDetail, createServiceOrder, checkIsVolunteer } from '@/api/volunteer'
import useMemberStore from '@/stores/member'

const route = useRoute()
const router = useRouter()
const memberStore = useMemberStore()

const loading = ref(true)
const serviceDetail = ref<any>({})
const memberPoint = ref(0)
const showBookDialog = ref(false)
const booking = ref(false)
const bookForm = ref({
    service_time: '',
    service_address: '',
    service_remark: ''
})

const canBook = computed(() => {
    return memberPoint.value >= (serviceDetail.value.point_price || 0)
})

onMounted(async () => {
    memberPoint.value = memberStore.info?.point || 0
    const service_id = Number(route.params.id)

    try {
        const res: any = await getServiceDetail(service_id)
        serviceDetail.value = res.data || {}
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
})

const handleBook = () => {
    if (!canBook.value) {
        ElMessage.warning('积分不足')
        return
    }
    showBookDialog.value = true
}

const confirmBook = async () => {
    if (!bookForm.value.service_time) {
        ElMessage.warning('请选择预约时间')
        return
    }
    if (!bookForm.value.service_address) {
        ElMessage.warning('请输入服务地址')
        return
    }

    booking.value = true
    try {
        await createServiceOrder({
            service_id: serviceDetail.value.service_id,
            service_time: bookForm.value.service_time,
            service_address: bookForm.value.service_address,
            service_remark: bookForm.value.service_remark
        })
        ElMessage.success('预约成功！')
        memberPoint.value -= serviceDetail.value.point_price
        memberStore.updateInfo({ point: memberPoint.value })
        showBookDialog.value = false

        setTimeout(() => {
            router.push('/web/volunteer/my')
        }, 1500)
    } catch (e: any) {
        ElMessage.error(e.msg || e.message || '预约失败')
    } finally {
        booking.value = false
    }
}
</script>

<style scoped lang="scss">
.detail-container {
    min-height: 100vh;
    background: #f5f5f5;
    padding: 40px 0;
}

.container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 0 20px;
}

.detail-content {
    display: flex;
    gap: 40px;
    background: #fff;
    padding: 40px;
    border-radius: 16px;

    @media (max-width: 768px) {
        flex-direction: column;
        padding: 20px;
    }
}

.service-cover {
    flex: 0 0 400px;
    height: 400px;
    border-radius: 12px;
    overflow: hidden;
    background: #f5f5f5;

    @media (max-width: 768px) {
        flex: none;
        width: 100%;
        height: 250px;
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
}

.service-info {
    flex: 1;

    .service-name {
        font-size: 28px;
        color: #333;
        margin: 0 0 20px;
    }

    .price-row {
        margin-bottom: 20px;

        .point-price {
            color: #11998e;
            font-size: 36px;
            font-weight: bold;
        }

        .unit {
            color: #999;
            font-size: 16px;
        }
    }

    .meta-row {
        display: flex;
        gap: 30px;
        font-size: 14px;
        color: #666;
        margin-bottom: 16px;
    }

    .category-tag {
        display: inline-block;
        background: #f0f9f7;
        color: #11998e;
        padding: 6px 16px;
        border-radius: 20px;
        font-size: 12px;
        margin-bottom: 24px;
    }

    .service-desc {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 24px;

        h3 {
            font-size: 16px;
            margin: 0 0 12px;
        }

        p {
            font-size: 14px;
            color: #666;
            line-height: 1.8;
            margin: 0;
        }
    }

    .volunteer-info {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px;
        background: #f9f9f9;
        border-radius: 8px;
        margin-bottom: 30px;

        .avatar {
            width: 60px;
            height: 60px;
            border-radius: 50%;
        }

        .info {
            .name {
                font-size: 16px;
                color: #333;
                margin: 0 0 4px;
            }

            .intro {
                font-size: 12px;
                color: #999;
                margin: 0;
            }
        }
    }

    .action-box {
        display: flex;
        align-items: center;
        gap: 30px;

        .my-point {
            font-size: 16px;
            color: #666;

            span {
                color: #11998e;
                font-weight: bold;
            }
        }
    }
}
</style>
