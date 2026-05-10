<template>
    <view class="page-container">
        <view class="tabs">
            <view class="tab-item" :class="{ active: status === '' }" @click="changeStatus('')">全部</view>
            <view class="tab-item" :class="{ active: status === '1' }" @click="changeStatus('1')">待发货</view>
            <view class="tab-item" :class="{ active: status === '2' }" @click="changeStatus('2')">已发货</view>
            <view class="tab-item" :class="{ active: status === '3' }" @click="changeStatus('3')">已完成</view>
        </view>

        <view class="order-list">
            <view class="order-item" v-for="item in orderList" :key="item.order_id" @click="goDetail(item.order_id)">
                <view class="order-header">
                    <text class="order-no">{{ item.order_no }}</text>
                    <text class="order-status" :class="'status-' + item.status">{{ item.status_name }}</text>
                </view>
                <view class="goods-info" v-if="item.goods">
                    <image class="goods-image" :src="item.goods.goods_image" mode="aspectFill"></image>
                    <view class="goods-detail">
                        <view class="goods-name">{{ item.goods.goods_name }}</view>
                        <view class="goods-price">{{ item.goods.point_price }} 积分 × {{ item.num }}</view>
                    </view>
                </view>
                <view class="order-footer">
                    <text class="total-point">{{ item.point_num }} 积分</text>
                    <text class="create-time">{{ formatTime(item.create_time) }}</text>
                </view>
            </view>
        </view>

        <view class="empty" v-if="!loading && !orderList.length">
            <text>暂无订单</text>
        </view>

        <view class="loading" v-if="loading">
            <text>加载中...</text>
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { getPointOrderList } from '@/api/pointshop'

const status = ref('')
const orderList = ref<any[]>([])
const page = ref(1)
const loading = ref(false)

onMounted(() => {
    loadOrders()
})

const changeStatus = (s: string) => {
    status.value = s
    page.value = 1
    orderList.value = []
    loadOrders()
}

const loadOrders = async () => {
    loading.value = true
    try {
        const res = await getPointOrderList({
            status: status.value,
            page: page.value,
            limit: 20
        })
        orderList.value = res.data.data || []
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const goDetail = (order_id: number) => {
    uni.navigateTo({
        url: `/pages/pointshop/order-detail?order_id=${order_id}`
    })
}

const formatTime = (timestamp: number) => {
    if (!timestamp) return ''
    const date = new Date(timestamp * 1000)
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`
}
</script>

<style scoped lang="scss">
.page-container {
    min-height: 100vh;
    background: #f5f5f5;
}

.tabs {
    display: flex;
    background: #fff;
    padding: 20rpx 0;

    .tab-item {
        flex: 1;
        text-align: center;
        padding: 20rpx 0;
        font-size: 28rpx;
        color: #666;
        position: relative;

        &.active {
            color: #667eea;
            font-weight: bold;

            &::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 50%;
                transform: translateX(-50%);
                width: 60rpx;
                height: 4rpx;
                background: #667eea;
                border-radius: 2rpx;
            }
        }
    }
}

.order-list {
    padding: 20rpx;

    .order-item {
        background: #fff;
        border-radius: 16rpx;
        padding: 24rpx;
        margin-bottom: 20rpx;

        .order-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20rpx;

            .order-no {
                font-size: 26rpx;
                color: #999;
            }

            .order-status {
                font-size: 26rpx;

                &.status-1 { color: #ff9800; }
                &.status-2 { color: #667eea; }
                &.status-3 { color: #4caf50; }
                &.status--1 { color: #999; }
            }
        }

        .goods-info {
            display: flex;
            margin-bottom: 20rpx;

            .goods-image {
                width: 140rpx;
                height: 140rpx;
                border-radius: 8rpx;
            }

            .goods-detail {
                flex: 1;
                margin-left: 20rpx;

                .goods-name {
                    font-size: 28rpx;
                    color: #333;
                    display: -webkit-box;
                    -webkit-line-clamp: 2;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    margin-bottom: 10rpx;
                }

                .goods-price {
                    font-size: 26rpx;
                    color: #ff6b6b;
                }
            }
        }

        .order-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 20rpx;
            border-top: 1rpx solid #f0f0f0;

            .total-point {
                font-size: 30rpx;
                color: #ff6b6b;
                font-weight: bold;
            }

            .create-time {
                font-size: 24rpx;
                color: #999;
            }
        }
    }
}

.empty, .loading {
    text-align: center;
    padding: 100rpx;
    color: #999;
    font-size: 28rpx;
}
</style>
