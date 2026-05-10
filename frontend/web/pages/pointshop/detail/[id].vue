<template>
    <div class="detail-container">
        <div class="container">
            <div class="detail-content">
                <div class="goods-image">
                    <div class="image-skeleton" v-if="loading"></div>
                    <img v-else :src="goodsDetail.goods_image" :alt="goodsDetail.goods_name" />
                </div>
                <div class="goods-info">
                    <h1 class="goods-name">{{ goodsDetail.goods_name }}</h1>
                    <div class="price-box">
                        <span class="point-price">{{ goodsDetail.point_price }} 积分</span>
                        <span class="market-price">市场价 ¥{{ goodsDetail.price }}</span>
                    </div>
                    <div class="goods-stats">
                        <span>库存: {{ goodsDetail.stock }}</span>
                        <span v-if="goodsDetail.limit_num > 0">限购: {{ goodsDetail.limit_num }} 件</span>
                        <span>销量: {{ goodsDetail.sales_num }}</span>
                    </div>
                    <div class="exchange-desc" v-if="goodsDetail.exchange_desc">
                        <h3>兑换说明</h3>
                        <p>{{ goodsDetail.exchange_desc }}</p>
                    </div>
                    <div class="action-box">
                        <div class="my-point">
                            我的积分: <span>{{ memberPoint }}</span>
                        </div>
                        <el-button type="primary" size="large" @click="handleExchange" :disabled="!canExchange" :loading="exchanging">
                            {{ canExchange ? '立即兑换' : '积分不足' }}
                        </el-button>
                    </div>
                </div>
            </div>
        </div>

        <el-dialog v-model="showAddressDialog" title="选择收货地址" width="500px">
            <div class="address-list" v-if="addressList.length">
                <div class="address-item" v-for="item in addressList" :key="item.address_id" :class="{ active: selectedAddressId === item.address_id }" @click="selectedAddressId = item.address_id">
                    <div class="address-info">
                        <p class="address-name">{{ item.name }} {{ item.mobile }}</p>
                        <p class="address-detail">{{ item.full_address }} {{ item.address }}</p>
                    </div>
                    <div class="address-check" v-if="selectedAddressId === item.address_id">✓</div>
                </div>
            </div>
            <div class="no-address" v-else>
                <p>暂无收货地址</p>
                <el-button type="primary" @click="goAddressManage">去添加</el-button>
            </div>
            <template #footer>
                <el-button @click="showAddressDialog = false">取消</el-button>
                <el-button type="primary" @click="confirmExchange" :disabled="!selectedAddressId">确认兑换</el-button>
            </template>
        </el-dialog>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { ElMessage } from 'element-plus'
import { getPointGoodsDetail, pointExchange } from '@/api/pointshop'
import { getMemberAddress } from '@/api/member'
import useMemberStore from '@/stores/member'

const route = useRoute()
const router = useRouter()
const memberStore = useMemberStore()

const loading = ref(true)
const goodsDetail = ref<any>({})
const memberPoint = ref(0)
const addressList = ref<any[]>([])
const selectedAddressId = ref<number | null>(null)
const showAddressDialog = ref(false)
const exchanging = ref(false)

const canExchange = computed(() => {
    return memberPoint.value >= (goodsDetail.value.point_price || 0) && (goodsDetail.value.stock || 0) > 0
})

onMounted(async () => {
    memberPoint.value = memberStore.info?.point || 0
    const goods_id = Number(route.params.id)

    try {
        const res: any = await getPointGoodsDetail(goods_id)
        goodsDetail.value = res.data || {}
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }

    await loadAddress()
})

const loadAddress = async () => {
    try {
        const res: any = await getMemberAddress({})
        addressList.value = res.data || []
        if (addressList.value.length) {
            const defaultAddr = addressList.value.find((item: any) => item.is_default === 1)
            selectedAddressId.value = defaultAddr?.address_id || addressList.value[0].address_id
        }
    } catch (e) {
        console.error(e)
    }
}

const handleExchange = async () => {
    if (!canExchange.value) {
        ElMessage.warning('无法兑换')
        return
    }

    if (!addressList.value.length) {
        ElMessage.warning('请先添加收货地址')
        return
    }

    showAddressDialog.value = true
}

const confirmExchange = async () => {
    if (!selectedAddressId.value) {
        ElMessage.warning('请选择收货地址')
        return
    }

    exchanging.value = true
    try {
        await pointExchange({
            goods_id: goodsDetail.value.goods_id,
            address_id: selectedAddressId.value,
            num: 1
        })
        ElMessage.success('兑换成功！')
        memberPoint.value -= goodsDetail.value.point_price
        memberStore.updateInfo({ point: memberPoint.value })
        showAddressDialog.value = false

        setTimeout(() => {
            router.push('/web/member/point')
        }, 1500)
    } catch (e: any) {
        ElMessage.error(e.msg || e.message || '兑换失败')
    } finally {
        exchanging.value = false
    }
}

const goAddressManage = () => {
    router.push('/web/member/address')
}
</script>

<style scoped lang="scss">
.detail-container {
    min-height: 100vh;
    background: #f5f5f5;
    padding: 40px 0;
}

.container {
    max-width: 1200px;
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

.goods-image {
    flex: 0 0 400px;
    height: 400px;
    border-radius: 12px;
    overflow: hidden;
    background: #f5f5f5;

    @media (max-width: 768px) {
        flex: none;
        width: 100%;
        height: 300px;
    }

    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-skeleton {
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }
}

.goods-info {
    flex: 1;

    .goods-name {
        font-size: 28px;
        color: #333;
        margin: 0 0 24px;

        @media (max-width: 768px) {
            font-size: 20px;
        }
    }

    .price-box {
        display: flex;
        align-items: baseline;
        gap: 20px;
        margin-bottom: 20px;

        .point-price {
            color: #ff6b6b;
            font-size: 36px;
            font-weight: bold;

            @media (max-width: 768px) {
                font-size: 28px;
            }
        }

        .market-price {
            color: #999;
            font-size: 18px;
            text-decoration: line-through;
        }
    }

    .goods-stats {
        display: flex;
        gap: 30px;
        font-size: 14px;
        color: #666;
        margin-bottom: 30px;

        @media (max-width: 768px) {
            flex-wrap: wrap;
            gap: 15px;
        }
    }

    .exchange-desc {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 30px;

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

    .action-box {
        display: flex;
        align-items: center;
        gap: 30px;

        @media (max-width: 768px) {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .my-point {
            font-size: 16px;
            color: #666;

            span {
                color: #ff6b6b;
                font-weight: bold;
            }
        }
    }
}

.address-list {
    max-height: 400px;
    overflow-y: auto;
}

.address-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    margin-bottom: 12px;
    cursor: pointer;
    transition: all 0.3s;

    &:hover {
        border-color: #667eea;
    }

    &.active {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.05);
    }

    .address-info {
        flex: 1;

        .address-name {
            font-size: 16px;
            color: #333;
            margin: 0 0 8px;
        }

        .address-detail {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
    }

    .address-check {
        width: 24px;
        height: 24px;
        background: #667eea;
        color: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
    }
}

.no-address {
    text-align: center;
    padding: 40px;

    p {
        color: #999;
        margin-bottom: 20px;
    }
}

@keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
}
</style>
