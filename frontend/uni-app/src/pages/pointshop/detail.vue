<template>
    <view class="page-container">
        <view class="goods-banner">
            <image class="banner-image" :src="goodsDetail.goods_image" mode="aspectFill"></image>
        </view>

        <view class="goods-info">
            <view class="price-row">
                <text class="point-price">{{ goodsDetail.point_price }} 积分</text>
                <text class="market-price">¥{{ goodsDetail.price }}</text>
            </view>
            <view class="goods-name">{{ goodsDetail.goods_name }}</view>
            <view class="stock-row">
                <text>库存: {{ goodsDetail.stock }}</text>
                <text v-if="goodsDetail.limit_num > 0">限购: {{ goodsDetail.limit_num }} 件</text>
            </view>
        </view>

        <view class="exchange-desc" v-if="goodsDetail.exchange_desc">
            <view class="section-title">兑换说明</view>
            <view class="desc-content">{{ goodsDetail.exchange_desc }}</view>
        </view>

        <view class="bottom-bar">
            <view class="my-point">
                <text>可用积分: </text>
                <text class="point-num">{{ memberInfo.point || 0 }}</text>
            </view>
            <view class="exchange-btn" @click="handleExchange" :class="{ disabled: !canExchange }">
                {{ canExchange ? '立即兑换' : '积分不足' }}
            </view>
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, reactive } from 'vue'
import { getPointGoodsDetail, pointExchange } from '@/api/pointshop'
import { getMemberAddress, addMemberAddress } from '@/api/member'
import { useMemberStore } from '@/stores/member'

const memberStore = useMemberStore()
const memberInfo = reactive({ point: 0 })

const goodsDetail = ref<any>({})
const goodsId = ref(0)
const addressList = ref<any[]>([])

onMounted(() => {
    memberInfo.point = memberStore.info.point || 0

    const pages = getCurrentPages()
    const currentPage = pages[pages.length - 1]
    const options = (currentPage as any).options || {}
    goodsId.value = options.goods_id

    loadGoodsDetail()
    loadAddress()
})

const canExchange = computed(() => {
    return memberInfo.point >= (goodsDetail.value.point_price || 0) && (goodsDetail.value.stock || 0) > 0
})

const loadGoodsDetail = async () => {
    try {
        const res = await getPointGoodsDetail(goodsId.value)
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
    if (!canExchange.value) {
        uni.showToast({ title: '无法兑换', icon: 'none' })
        return
    }

    if (!addressList.value.length) {
        uni.showToast({ title: '请先添加收货地址', icon: 'none' })
        return
    }

    const defaultAddress = addressList.value.find((item: any) => item.is_default === 1) || addressList.value[0]

    uni.showModal({
        title: '确认兑换',
        content: `确认使用 ${goodsDetail.value.point_price} 积分兑换此商品？`,
        success: async (res) => {
            if (res.confirm) {
                try {
                    await pointExchange({
                        goods_id: goodsId.value,
                        address_id: defaultAddress.address_id,
                        num: 1
                    })
                    uni.showToast({ title: '兑换成功', icon: 'success' })
                    setTimeout(() => {
                        uni.navigateBack()
                    }, 1500)
                } catch (e: any) {
                    uni.showToast({ title: e.message || '兑换失败', icon: 'none' })
                }
            }
        }
    })
}
</script>

<style scoped lang="scss">
.page-container {
    min-height: 100vh;
    background: #f5f5f5;
    padding-bottom: 120rpx;
}

.goods-banner {
    .banner-image {
        width: 100%;
        height: 600rpx;
    }
}

.goods-info {
    background: #fff;
    padding: 30rpx;

    .price-row {
        display: flex;
        align-items: baseline;
        margin-bottom: 20rpx;

        .point-price {
            color: #ff6b6b;
            font-size: 48rpx;
            font-weight: bold;
        }

        .market-price {
            color: #999;
            font-size: 28rpx;
            text-decoration: line-through;
            margin-left: 20rpx;
        }
    }

    .goods-name {
        font-size: 32rpx;
        color: #333;
        line-height: 1.6;
        margin-bottom: 16rpx;
    }

    .stock-row {
        display: flex;
        gap: 30rpx;
        font-size: 26rpx;
        color: #999;
    }
}

.exchange-desc {
    background: #fff;
    margin-top: 20rpx;
    padding: 30rpx;

    .section-title {
        font-size: 30rpx;
        font-weight: bold;
        margin-bottom: 20rpx;
    }

    .desc-content {
        font-size: 28rpx;
        color: #666;
        line-height: 1.8;
    }
}

.bottom-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20rpx 30rpx;
    background: #fff;
    box-shadow: 0 -2rpx 20rpx rgba(0, 0, 0, 0.1);

    .my-point {
        font-size: 28rpx;
        color: #666;

        .point-num {
            color: #ff6b6b;
            font-weight: bold;
        }
    }

    .exchange-btn {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: #fff;
        padding: 24rpx 60rpx;
        border-radius: 50rpx;
        font-size: 30rpx;

        &.disabled {
            background: #ccc;
        }
    }
}
</style>
