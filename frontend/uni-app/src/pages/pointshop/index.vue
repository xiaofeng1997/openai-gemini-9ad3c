<template>
    <view class="page-container">
        <view class="header">
            <view class="title">积分商城</view>
            <view class="my-point" @click="goMyPoint">
                <text class="point-icon">⭐</text>
                <text class="point-text">{{ memberInfo.point || 0 }} 积分</text>
            </view>
        </view>

        <view class="category-tabs" v-if="indexData.category && indexData.category.length">
            <view class="tab-item" :class="{ active: categoryId === 0 }" @click="changeCategory(0)">
                全部
            </view>
            <view class="tab-item" :class="{ active: categoryId === item.category_id }" v-for="item in indexData.category" :key="item.category_id" @click="changeCategory(item.category_id)">
                {{ item.category_name }}
            </view>
        </view>

        <view class="goods-list" v-if="goodsList.length">
            <view class="goods-item" v-for="item in goodsList" :key="item.goods_id" @click="goDetail(item.goods_id)">
                <image class="goods-image" :src="item.goods_image" mode="aspectFill"></image>
                <view class="goods-info">
                    <view class="goods-name">{{ item.goods_name }}</view>
                    <view class="goods-price">
                        <text class="point">{{ item.point_price }} 积分</text>
                        <text class="market">¥{{ item.price }}</text>
                    </view>
                    <view class="goods-stock">库存: {{ item.stock }}</view>
                </view>
            </view>
        </view>

        <view class="empty" v-else-if="!loading">
            <text>暂无商品</text>
        </view>

        <view class="loading" v-if="loading">
            <text>加载中...</text>
        </view>

        <view class="order-btn" @click="goOrderList">
            <text>我的订单</text>
        </view>
    </view>
</template>

<script setup lang="ts">
import { ref, onMounted, reactive } from 'vue'
import { getPointShopIndex, getPointGoodsList } from '@/api/pointshop'
import { useMemberStore } from '@/stores/member'

const memberStore = useMemberStore()
const memberInfo = reactive({ point: 0 })

const indexData = ref<any>({ category: [], goods_list: [] })
const categoryId = ref(0)
const goodsList = ref<any[]>([])
const page = ref(1)
const loading = ref(false)

onMounted(() => {
    memberInfo.point = memberStore.info.point || 0
    loadIndex()
    loadGoods()
})

const loadIndex = async () => {
    try {
        const res = await getPointShopIndex()
        indexData.value = res.data
    } catch (e) {
        console.error(e)
    }
}

const changeCategory = (id: number) => {
    categoryId.value = id
    page.value = 1
    goodsList.value = []
    loadGoods()
}

const loadGoods = async () => {
    loading.value = true
    try {
        const res = await getPointGoodsList({
            category_id: categoryId.value,
            page: page.value,
            limit: 20
        })
        if (page.value === 1) {
            goodsList.value = res.data.data || []
        } else {
            goodsList.value = [...goodsList.value, ...(res.data.data || [])]
        }
    } catch (e) {
        console.error(e)
    } finally {
        loading.value = false
    }
}

const goDetail = (goods_id: number) => {
    uni.navigateTo({
        url: `/pages/pointshop/detail?goods_id=${goods_id}`
    })
}

const goMyPoint = () => {
    uni.switchTab({
        url: '/pages/member/index'
    })
}

const goOrderList = () => {
    uni.navigateTo({
        url: '/pages/pointshop/order-list'
    })
}
</script>

<style scoped lang="scss">
.page-container {
    min-height: 100vh;
    background: #f5f5f5;
    padding-bottom: 120rpx;
}

.header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 40rpx 30rpx;
    color: #fff;

    .title {
        font-size: 40rpx;
        font-weight: bold;
        margin-bottom: 20rpx;
    }

    .my-point {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.2);
        padding: 16rpx 24rpx;
        border-radius: 30rpx;
        font-size: 28rpx;

        .point-icon {
            margin-right: 10rpx;
        }
    }
}

.category-tabs {
    display: flex;
    padding: 24rpx 20rpx;
    background: #fff;
    overflow-x: auto;
    white-space: nowrap;

    .tab-item {
        padding: 12rpx 30rpx;
        margin-right: 20rpx;
        border-radius: 30rpx;
        font-size: 28rpx;
        background: #f5f5f5;
        color: #666;

        &.active {
            background: #667eea;
            color: #fff;
        }
    }
}

.goods-list {
    padding: 20rpx;
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20rpx;

    .goods-item {
        background: #fff;
        border-radius: 16rpx;
        overflow: hidden;

        .goods-image {
            width: 100%;
            height: 340rpx;
        }

        .goods-info {
            padding: 20rpx;

            .goods-name {
                font-size: 28rpx;
                color: #333;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
                margin-bottom: 16rpx;
            }

            .goods-price {
                display: flex;
                align-items: center;
                margin-bottom: 10rpx;

                .point {
                    color: #ff6b6b;
                    font-size: 32rpx;
                    font-weight: bold;
                }

                .market {
                    color: #999;
                    font-size: 24rpx;
                    text-decoration: line-through;
                    margin-left: 16rpx;
                }
            }

            .goods-stock {
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

.order-btn {
    position: fixed;
    bottom: 40rpx;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
    padding: 24rpx 60rpx;
    border-radius: 50rpx;
    font-size: 30rpx;
    box-shadow: 0 10rpx 30rpx rgba(102, 126, 234, 0.4);
}
</style>
