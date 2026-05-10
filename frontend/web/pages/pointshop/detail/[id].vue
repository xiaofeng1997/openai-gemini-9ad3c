<template>
    <div class="detail-container">
        <div class="container">
            <div class="detail-content">
                <div class="goods-image">
                    <img :src="goodsDetail.goods_image" :alt="goodsDetail.goods_name" />
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
                        <button class="exchange-btn" @click="handleExchange" :disabled="!canExchange">
                            {{ canExchange ? '立即兑换' : '积分不足' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { getPointGoodsDetail, pointExchange } from '@/api/pointshop'
import { getMemberAddress } from '@/api/member'
import { useMemberStore } from '@/stores/member'

const route = useRoute()
const router = useRouter()
const memberStore = useMemberStore()

const goodsDetail = ref<any>({})
const memberPoint = ref(0)
const addressList = ref<any[]>([])

const canExchange = computed(() => {
    return memberPoint.value >= (goodsDetail.value.point_price || 0) && (goodsDetail.value.stock || 0) > 0
})

onMounted(async () => {
    memberPoint.value = memberStore.info.point || 0
    const goods_id = Number(route.params.id)
    await loadGoodsDetail(goods_id)
    await loadAddress()
})

const loadGoodsDetail = async (goods_id: number) => {
    try {
        const res = await getPointGoodsDetail(goods_id)
        goodsDetail.value = res.data
    } catch (e) {
        console.error(e)
    }
}

const loadAddress = async () => {
    try {
        const res = await getMemberAddress({})
        addressList.value = res.data || []
    } catch (e) {
        console.error(e)
    }
}

const handleExchange = async () => {
    if (!canExchange.value) return

    if (!addressList.value.length) {
        alert('请先添加收货地址')
        return
    }

    const defaultAddress = addressList.value.find((item: any) => item.is_default === 1) || addressList.value[0]

    if (confirm(`确认使用 ${goodsDetail.value.point_price} 积分兑换此商品？`)) {
        try {
            await pointExchange({
                goods_id: goodsDetail.value.goods_id,
                address_id: defaultAddress.address_id,
                num: 1
            })
            alert('兑换成功！')
            router.push('/member/point')
        } catch (e: any) {
            alert(e.message || '兑换失败')
        }
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
    }
}

.goods-image {
    flex: 0 0 400px;
    height: 400px;
    border-radius: 12px;
    overflow: hidden;

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
}

.goods-info {
    flex: 1;

    .goods-name {
        font-size: 28px;
        color: #333;
        margin: 0 0 24px;
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

        .my-point {
            font-size: 16px;
            color: #666;

            span {
                color: #ff6b6b;
                font-weight: bold;
            }
        }

        .exchange-btn {
            padding: 14px 48px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            border-radius: 30px;
            font-size: 16px;
            cursor: pointer;
            transition: opacity 0.3s;

            &:hover:not(:disabled) {
                opacity: 0.9;
            }

            &:disabled {
                background: #ccc;
                cursor: not-allowed;
            }
        }
    }
}
</style>
